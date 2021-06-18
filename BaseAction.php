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

    public function execute(string $method = null, array $params = [])
    {
        $return = $this->run($method, ...$params);

        if ($return instanceof Closure)
        {
            Assert::notEmpty($this->controller, 'Controller is required.');

            $return = $return->bindTo($this->controller, $this->controller);

            Assert::notEmpty($return, 'Bind failed.');

            return $return($method, ...$params);
        }

        return $return;
    }

}