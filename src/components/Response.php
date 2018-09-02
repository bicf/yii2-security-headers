<?php
namespace bicf\securityheaders\components;
use bicf\securityheaders\modules\HeaderModuleBase;
use Yii;

/**
 * Class Response
 * ```php
 * [
 *     'components' => [
 *         'response' => [
 *             'class' => 'bicf\securityheaders\Response',
 *             'on afterPrepare' => ['bicf\securityheaders\Response','modulesInit'],
 *             'on afterSend' => ['bicf\securityheaders\Response','modulesSendHeaders'],
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
 * ]
 *
 * ```
 */
class Response extends \yii\web\Response
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        foreach ($this->modules as $name => $module) {
            if (!$module instanceof HeaderModuleBase) {
                $this->modules[$name] = Yii::createObject($module);
            }
        }
    }

    /** @var array of header modules default is empty
     *   use the configuration to populate the array
     */
    public $modules=array();

    /**
     *
     */
    public static function modulesInit($event)
    {
        /** @var $event->sender \bicf\securityheaders\components\Response */
        foreach ($event->sender->modules as $key => $module){
            $module->init();
        }
    }

    /**
     *
     */
    public static function modulesSendHeaders($event)
    {
        /** @var $event->sender \bicf\securityheaders\components\Response */
        foreach ($event->sender->modules as $module){
            $module->run();
        }
    }
}