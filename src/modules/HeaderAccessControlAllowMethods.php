<?php

namespace bicf\securityheaders\modules;
use yii\base\BaseObject;

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

    public function run()
    {
        if(!$this->enabled){
            return;
        }
        \Yii::$app->response->headers->set('Access-Control-Allow-Methods',$this->value);
    }
}