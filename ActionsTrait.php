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

    protected $actions = [];

    public function _remap($method, ...$params)
    {
        if (method_exists($this, $method))
        {
            return $this->$method(...$params);
        }

        return $this->remapAction($method, ...$params);
    }

    protected function remapAction($method, ...$params)
    {
        if (array_key_exists($method, $this->actions))
        {
            if (is_array($this->actions))
            {
                $action = call_user_func_array([$this, 'createAction'], $this->actions);
            }
            else
            {
                $action = $this->createAction($this->actions);
            }

            $return = $action->_remap($method, ...$params);

            if ($return instanceof Closure)
            {
                $return = $return->bindTo($this, get_class($this));

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