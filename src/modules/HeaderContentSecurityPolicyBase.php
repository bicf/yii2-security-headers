<?php

namespace bicf\securityheaders\modules;
use bicf\securityheaders\behavior\ContentSecurityPolicyNonceBehavior;
use bicf\securityheaders\components\SecureRequestInterface;
use yii\web\Response;

/**
 * Class HeaderContentSecurityPolicyBase
 * @package bicf\securityheaders\modules
 */
abstract class HeaderContentSecurityPolicyBase extends HeaderModuleBase
{
    const DEFAULT_SRC = 'default-src';
    const FRAME_SRC = 'frame-src';
    const IMG_SRC = 'img-src';
    const FONT_SRC = 'font-src';
    const MEDIA_SRC = 'media-src';
    const SCRIPT_SRC = 'script-src';
    const STYLE_SRC = 'style-src';
    const CONNECT_SRC = 'connect-src';
    const REPORT_URI = 'report-uri';

    /**
     * @var string contain the name of the header sent
     */
    protected $headerName;

    public  $policies = array();

    /**
     * @var bool
     */
    public $nonceEnabled = true;

    /**
     * add the security header
     */
    public function send(){
        if(!$this->enabled){
            return;
        }
        if($this->nonceEnabled){
            $scriptSrc = isset($this->policies[self::SCRIPT_SRC])?$this->policies[self::SCRIPT_SRC]:'';
            $this->policies[self::SCRIPT_SRC] = "$scriptSrc ".\Yii::$app->response->getContentSecurityPolicyTokenHeader();
        }

        $sep=$value='';
        foreach ($this->policies as $k => $v){
            $value .="$sep$k $v";
            $sep ="; ";
        }
        \Yii::$app->response->headers->set($this->headerName,$value);
    }

    public function injectBehavior(Response $response)
    {
        // Avoid double attach
        if($this->nonceEnabled && $response->getBehavior(SecureRequestInterface::CSP_NONCE_BEHAVIOR) === null){
            $rv = $response->attachBehavior(SecureRequestInterface::CSP_NONCE_BEHAVIOR,new ContentSecurityPolicyNonceBehavior() );
        }
    }

}