<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Action;

abstract class Action extends BaseAction
{

    abstract public function run($method, ...$params);

}