<?php

namespace bicf\securityheaders\modules;
use yii\base\BaseObject;

/**
 * Class HeaderAccessControlAllowOrigin
 * @package bicf\securityheaders\modules
 */
class HeaderAccessControlAllowOrigin extends HeaderModuleBase
{
    public $value;

    public function run()
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