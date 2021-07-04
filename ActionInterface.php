<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Action;

use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

interface ActionInterface
{

    public function initialize(?string $method = null);

    public function execute(...$params);

    public function run(...$params);

    public function setLogger(LoggerInterface $logger);

    public function setRequest(RequestInterface $request);

    public function setResponse(ResponseInterface $response);

    public function isMethod(?string $method) : bool;

}