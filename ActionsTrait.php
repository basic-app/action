<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Action;

use Closure;
use CodeIgniter\Exceptions\PageNotFoundException;

trait ActionsTrait
{

    // protected $defaultActions = [];
    
    // protected $actions = [];

    public function _remap($method, ...$params)
    {
        if (method_exists($this, $method))
        {
            return $this->$method(...$params);
        }

        return $this->remapAction($method, ...$params);
    }

    protected function getActions() : array
    {
        return array_merge(
            property_exists($this, 'defaultActions') ? $this->defaultActions : [], 
            property_exists($this, 'actions') ? $this->actions : []
        );
    }

    protected function remapAction($method, ...$params)
    {
        $actions = $this->getActions();

        if (array_key_exists($method, $actions) && $actions[$method])
        {
            if (is_array($actions[$method]))
            {
                $action = call_user_func_array([$this, 'createAction'], $actions[$method]);
            }
            else
            {
                $action = $this->createAction($actions[$method]);
            }

            $return = $action->_remap($method, ...$params);

            if ($return instanceof Closure)
            {
                $return = $return->bindTo($this, $this);

                assert($return ? true : false, '$return::bindTo');

                return $return($method, $params);
            }

            return $return;
        }

        throw PageNotFoundException::forPageNotFound();        
    }

    protected function createAction($actionClass, ...$params) : ActionInterface
    {
        $action = new $actionClass($this, ...$params);

        $action->initController($this->request, $this->response, $this->logger);

        return $action;
    }

}