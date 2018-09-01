<?php
namespace bicf\securityheaders\modules;

use yii\base\BaseObject;

/**
 * Class HeaderXContentTypeOptions
 * @package bicf\securityheaders\modules
 */
class HeaderXContentTypeOptions extends HeaderModuleBase
{
    private $defaultValue='nosniff';
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
        \Yii::$app->response->headers->set('X-Content-Type-Options',$this->value);
    }
}