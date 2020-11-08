<?php

namespace bicf\securityheaders\modules;

/**
 * Class HeaderAccessControlAllowOriginWhiteList
 *
 * Using a white list of hosts
 * if HTTP_ORIGIN is in WL the header is generated with matching host
 * @see https://stackoverflow.com/a/7454204/7002281
 * @package bicf\securityheaders\modules
 */
class HeaderAccessControlAllowOriginByWhiteList extends HeaderModuleSimple
{
    /**
     * @var string[] of hosts in white list
     */
    public $values=[];

    public function init()
    {
    }

    /**
     *
     */
    public function run()
    {
        if(!$this->enabled){
            return;
        }
        if($this->values === null){
            return;
        }
        if(!isset($_SERVER['HTTP_ORIGIN'])){
            return;
        }
        // HTTP_ORIGIN host is in white-list
        $_http_origin = $_SERVER['HTTP_ORIGIN'];
        if(!in_array($_http_origin,$this->values)){
            return;
        }

        \Yii::$app->response->headers->add('Access-Control-Allow-Origin',$_http_origin);
    }
}