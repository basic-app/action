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
     * Method name.
     *
     * @var string
     */
    protected $method;

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
            Assert::propertyExists($this, $key, lang('Property does not exist: "{property}".', ['property' => $key]));

            $this->$key = $value;
        }
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $this->logger;
    }

    public function setRequest(RequestInterface $request)
    {
        $this->request = $this->request;
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $this->response;
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

    public function initialize(?string $method = null)
    {
        $this->method = $method;
    }

    public function isMethod(?string $method) : bool
    {
        return $this->method == $method;
    }

}   