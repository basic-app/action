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
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

abstract class BaseAction implements ActionInterface
{

    /**
     * Instance of the main Controller object.
     *
     * @var Controller
     */
    protected $controller;

    /**
     * Instance of the main Request object.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * Instance of the main response object.
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Instance of logger to use.
     *
     * @var LoggerInterface
     */
    protected $logger;

    abstract public function run(...$params);

    public function __construct(Controller $controller, array $params = [])
    {
        $this->controller = $controller;

        foreach($params as $key => $value)
        {
            $error = lang('Property does not exist: {property}', ['property' => $key]);

            Assert::propertyExists($this, $key, $error);

            $this->$key = $value;
        }
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function execute(...$params)
    {
        $return = $this->run(...$params);

        if ($return instanceof Closure)
        {
            $return = $return->bindTo($this->controller, $this->controller);

            Assert::notEmpty($return, lang('Bind failed.'));

            return $return(...$params);
        }

        return $return;
    }

    public function initialize()
    {
    }

}   