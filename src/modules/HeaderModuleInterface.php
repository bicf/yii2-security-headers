<?php

namespace bicf\securityheaders\modules;


interface HeaderModuleInterface
{
    public function init();
    public function injectBehavior(\yii\web\Response $response);
    public function run();
}