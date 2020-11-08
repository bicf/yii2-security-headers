<?php
namespace bicf\securityheaders\components;
use bicf\securityheaders\modules\HeaderModuleBase;
use bicf\securityheaders\modules\HeaderModuleInterface;
use Yii;

/**
 * Class Response
 *
 * ```php
 * [
 *     'components' => [
 *         'response' => [
 *             'class' => 'bicf\securityheaders\Response',
 *             'on afterPrepare' => ['bicf\securityheaders\Response','addSecurityHeaders'],
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
class Response extends \yii\web\Response implements SecureRequestInterface
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        foreach ($this->modules as $name => $module) {
            if ($module instanceof HeaderModuleBase) {
                continue;
            }
            if (isset($module['enabled']) && $module['enabled'] == false) {
                // is not enable will be removed from list
                unset($this->modules[$name]);
                continue;
            }
            /** @var HeaderModuleBase $headerModule */
            $headerModule = Yii::createObject($module, [$name, $this]);
            $this->modules[$name]  = $headerModule;
            $headerModule->injectBehavior($this);
        }
    }

    /** @var array of header modules default is empty
     *   use the configuration to populate the array
     */
    public $modules=array();

    /**
     * @param $event
     */
    public static function addSecurityHeaders($event)
    {
        /** @var $event->sender \bicf\securityheaders\components\Response */
        foreach ($event->sender->modules as $module){
            /** @var HeaderModuleInterface $module */
            $module->run();
        }
    }
}