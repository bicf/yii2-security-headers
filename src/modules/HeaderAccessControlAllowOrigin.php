<?php

namespace bicf\securityheaders\modules;

/**
 * Class HeaderAccessControlAllowOrigin
 * @package bicf\securityheaders\modules
 */
class HeaderAccessControlAllowOrigin extends HeaderModuleBase
{
    public $value;

    public function init()
    {
    }

    public function run()
    {
        if(!$this->enabled){
            return;
        }
        if($this->value === null){
            return;
        }
        \Yii::$app->response->headers->add('Access-Control-Allow-Origin',$this->value);
    }
}