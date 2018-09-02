<?php

namespace bicf\securityheaders\modules;
use bicf\securityheaders\behavior\ContentSecurityPolicyBehavior;
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

    protected $headerName;

    public  $policies = array();

    public $nonceEnabled = true;

    /**
     * add the security header
     */
    public function run(){
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
        if($response->getBehavior('cspBehavior') === null){
            $rv = $response->attachBehavior('cspBehavior',new ContentSecurityPolicyBehavior() );
        }
    }

}