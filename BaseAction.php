<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Action;

use CodeIgniter\Controller;

abstract class BaseAction implements ActionInterface
{

    protected $controller;

    abstract public function _remap($method, ...$params);

    public function __construct(Controller $controller, array $params = [])
    {
        $this->controller = $controller;

        foreach($params as $key => $value)
        {
            if (property_exists($this, $key))
            {
                $this->$key = $value;
            }
            else
            {
                throw new Exception('Unknown property: ' . $key);
            }
        }
    }

}