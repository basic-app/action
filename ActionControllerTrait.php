<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Action;

use Closure;
use CodeIgniter\Exceptions\PageNotFoundException;
use BasicApp\Action\ActionInterface;

trait ActionControllerTrait
{

    protected $actions = [];

    protected $defaultActions = [];

    protected $allowedActions = [];

    protected function getActions() : array
    {
        return array_merge($this->defaultActions, $this->actions);
    }

    protected function remapAction($method, ...$params)
    {
        $actions = $this->getActions();

        if (array_key_exists($method, $actions) && $actions[$method] && $this->isActionAllowed($method))
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

                assert($return ? true : false);

                return $return($method, ...$params);
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

    protected function isActionAllowed(string $action) : bool
    {
        if ($this->allowedActions)
        {
            if (array_search($action, $this->allowedActions) !== false)
            {
                return true;
            }
        }

        return true;
    }

}