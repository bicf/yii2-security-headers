<?php
namespace bicf\securityheaders\modules;

/**
 * Class HeaderXContentTypeOptions
 * @package bicf\securityheaders\modules
 */
abstract class HeaderModuleSimpleKeyVal extends HeaderModuleSimple
{
    protected $defaultValue=null;
    protected $header=null;
    public $value;

    public function init()
    {
        parent::init();
        if($this->value === null){
            $this->value =$this->defaultValue;
        }
    }


    public function run()
    {
        if(!$this->enabled){
            return;
        }
        if($this->header === null){
            return;
        }
        \Yii::$app->response->headers->add($this->header,$this->value);
    }
}
