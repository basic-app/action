<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Action;

use Closure;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface as Request;
use CodeIgniter\HTTP\ResponseInterface as Response;
use Psr\Log\LoggerInterface as Logger;

abstract class BaseAction extends \CodeIgniter\Controller implements ActionInterface
{

    protected $controller;

    abstract public function _remap($method, ...$params);

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function initController(Request $request, Response $response, Logger $logger)
    {
        parent::initController($request, $response, $logger);
    }

}