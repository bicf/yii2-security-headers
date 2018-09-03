<?php

namespace bicf\securityheaders\modules;

/**
 * Class HeaderAccessControlAllowMethods
 * @package bicf\securityheaders\modules
 */
class HeaderAccessControlAllowMethods extends HeaderModuleBase
{
    private $defaultValue='GET';
    public $value;

    public function init()
    {
        if($this->value === null){
            $this->value =$this->defaultValue;
        }
    }

    public function send()
    {
        if(!$this->enabled){
            return;
        }
        \Yii::$app->response->headers->set('Access-Control-Allow-Methods',$this->value);
    }
}