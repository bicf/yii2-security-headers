<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 9/1/18
 * Time: 12:21 AM
 */

namespace bicf\securityheaders\modules;


use yii\base\BaseObject;
use yii\web\Response;

/**
 * Class HeaderModuleBase
 * @package bicf\securityheaders\modules
 * @property boolean $enabled 
 */
abstract class HeaderModuleBase extends BaseObject implements HeaderModuleInterface
{
    /**
     * @var bool whether to enabled the module or not. Allows to turn the module header
     * on and off according to specific conditions.
     */
     public $enabled=true;

    public function injectBehavior(Response $response)
    {
    }
}