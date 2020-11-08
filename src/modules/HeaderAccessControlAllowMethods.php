<?php

namespace bicf\securityheaders\modules;

/**
 * Class HeaderAccessControlAllowMethods
 * @package bicf\securityheaders\modules
 */
class HeaderAccessControlAllowMethods extends HeaderModuleSimple
{
    private $defaultValue='GET';
    public $value;

    public function init()
    {
        if($this->value === null){
            $this->value =$this->defaultValue;
        }
    }

    public function run()
    {
        if(!$this->enabled){
            return;
        }
//        new Header
        \Yii::$app->response->headers->add('Access-Control-Allow-Methods',$this->value);
    }
}