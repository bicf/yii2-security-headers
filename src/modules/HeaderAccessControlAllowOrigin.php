<?php

namespace bicf\securityheaders\modules;

/**
 * Class HeaderAccessControlAllowOrigin
 * @package bicf\securityheaders\modules
 */
class HeaderAccessControlAllowOrigin extends HeaderModuleBase
{
    public $value;

    public function send()
    {
        if(!$this->enabled){
            return;
        }
        if($this->value === null){
            return;
        }
        \Yii::$app->response->headers->set('Access-Control-Allow-Origin',$this->value);
    }
}