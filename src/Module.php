<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace bicf\securityheaders;

use bicf\securityheaders\modules\HeaderModuleBase;
use bicf\securityheaders\modules\HeaderModuleInterface;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\web\Response;

/**
 * The Yii Debug Module provides the debug toolbar and debugger
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{

    public function __construct($id, $parent = null, $config = [])
    {
        parent::__construct($id, $parent, $config);
    }

    /**
     * @param Application $app
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        // delay attaching event handler to the view component after it is fully configured
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
            foreach ($this->modules as $id => $config){
                /** @var HeaderModuleBase $headerModule */
                $headerModule = $this->getModule($id);
                $headerModule->injectBehavior($app->getResponse());
            }
            $app->getResponse()->on(Response::EVENT_AFTER_PREPARE, [$this, 'addSecurityHeaders']);
        });

    }

    /**
     * @param Event $event
     */
    public function addSecurityHeaders($event)
    {
        /** @var $event->sender \bicf\securityheaders\components\Response */
        foreach ($this->modules as $module){
            /** @var HeaderModuleInterface $module */
            $module->run();
        }
    }

}
