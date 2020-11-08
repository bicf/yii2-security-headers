<?php

namespace bicf\securityheaders\modules;


/**
 * Class HeaderModuleBase
 * @package bicf\securityheaders\modules
 * @property boolean $enabled 
 */
abstract class HeaderModuleBase extends \yii\base\Module implements HeaderModuleInterface
{
    /**
     * @var bool whether to enabled the module or not. Allows to turn the module header
     * on and off according to specific conditions.
     */
     public $enabled=true;

    /**
     * Enable the module
     */
    public function enable()
    {
        $this->enabled=true;
    }

    /**
     * Disable the module
     */
    public function disable()
    {
        $this->enabled=false;
    }

    /**
     * now implemented in the child
     * @param \yii\web\Response $response
     * @return mixed
     */
    public abstract function injectBehavior(\yii\web\Response $response);

}