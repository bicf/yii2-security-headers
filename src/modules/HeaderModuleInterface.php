<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 9/1/18
 * Time: 12:21 AM
 */

namespace bicf\securityheaders\modules;


use bicf\securityheaders\components\Response;

interface HeaderModuleInterface
{
    public function init();
    public function injectBehavior(Response $response);
    public function run();
}