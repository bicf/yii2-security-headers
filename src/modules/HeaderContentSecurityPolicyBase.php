<?php

namespace bicf\securityheaders\modules;
use yii\base\BaseObject;

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

    private static $token;
    protected $headerName;

    public  $policies = array();

    public $nonceEnabled = true;

    public static function getToken()
    {
        if(self::$token === null){
            self::$token= \Yii::$app->security->generateRandomString();
        }
        return self::$token;
    }

    /**
     * add the security header
     */
    public function run(){
        if(!$this->enabled){
            return;
        }
        if($this->nonceEnabled){
            $scriptSrc = isset($this->policies[self::SCRIPT_SRC])?$this->policies[self::SCRIPT_SRC]:'';
            $this->policies[self::SCRIPT_SRC] = "$scriptSrc 'nonce-".self::getToken()."'";
        }

        $sep=$value='';
        foreach ($this->policies as $k => $v){
            $value .="$sep$k $v";
            $sep ="; ";
        }
        \Yii::$app->response->headers->set($this->headerName,$value);
    }
}