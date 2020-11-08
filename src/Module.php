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
 * Class Module
 * @package bicf\securityheaders
 *
 * ```php
 * [
 *     'bootstrap'=>[
 *         'securityHeader',
 *     ],
 *     'modules' => [
 *         'securityHeader' => [
 *             'class' => bicf\securityheaders\Module::class,
 *             'modules' => [
 *                'XContentTypeOptions'=>[
 *                    'class' => 'bicf\securityheaders\modules\HeaderXContentTypeOptions',
 *                    'value' => 'nosniff',
 *                ],
 *                'AccessControlAllowMethods'=>[
 *                    'class' => 'bicf\securityheaders\modules\HeaderAccessControlAllowMethods',
 *                    'value' => 'GET',
 *                ],
 *                'AccessControlAllowOrigin'=>[
 *                    'class' => 'bicf\securityheaders\modules\HeaderAccessControlAllowOrigin',
 *                    'value' => 'https://api.example.com',
 *                ],
 *                'ContentSecurityPolicyAcl'=>[
 *                    'class' => 'bicf\securityheaders\modules\HeaderContentSecurityPolicyAcl',
 *                    'enabled' => false,
 *                    'policies' => [
 *                        'default-src' => "'self'",
 *                        'frame-src'   => "'self' www.facebook.com www.youtube.com www.google.com",
 *                        'img-src'     => "'self' www.google-analytics.com",
 *                        'font-src'    => "'self' fonts.gstatic.com maxcdn.bootstrapcdn.com",
 *                        'media-src'   => "'self'",
 *                        'script-src'  => "'self' www.google-analytics.com",
 *                        'style-src'   => "'self' maxcdn.bootstrapcdn.com",
 *                         'connect-src' => "'self'",
 *                         'report-uri'  => "/report-csp-acl",
 *                     ],
 *                 ],
 *                 'ContentSecurityPolicyMonitor'=>[
 *                     'class' => 'bicf\securityheaders\modules\HeaderContentSecurityPolicyMonitor',
 *                     'policies' => [
 *                         'default-src' => "'self'",
 *                         'frame-src'   => "'self' www.facebook.com www.youtube.com www.google.com",
 *                         'img-src'     => "'self' www.google-analytics.com",
 *                         'font-src'    => "'self' fonts.gstatic.com maxcdn.bootstrapcdn.com",
 *                         'media-src'   => "'self'",
 *                         'script-src'  => "'self' www.google-analytics.com",
 *                         'style-src'   => "'self' maxcdn.bootstrapcdn.com",
 *                         'connect-src' => "'self'",
 *                         'report-uri'  => "/report-csp-acl",
 *                     ],
 *                 ],
 *             ],
 *         ],
 *     ],
 *
 *     'components' => [
 *         // components stuff
 *         // no need to add anything
 *     ],
 * ]
 *
 * ```
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
