<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Action;

use Closure;
use CodeIgniter\Controller;
use Webmozart\Assert\Assert;

abstract class BaseAction implements ActionInterface
{

    protected $controller;

    abstract public function run($method, ...$params);

    public function __construct(Controller $controller, array $params = [])
    {
        $this->controller = $controller;

        foreach($params as $key => $value)
        {
            Assert::propertyExists($this, $key);

            $this->$key = $value;
        }
    }

}