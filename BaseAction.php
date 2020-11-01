<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Action;

use CodeIgniter\Controller;

abstract class BaseAction extends Controller implements ActionInterface
{

    protected $controller;

    abstract public function _remap($method, ...$params);

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

}