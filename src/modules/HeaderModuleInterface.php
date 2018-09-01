<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 9/1/18
 * Time: 12:21 AM
 */

namespace bicf\securityheaders\modules;


interface HeaderModuleInterface
{
    public function init();
    public function run();
}