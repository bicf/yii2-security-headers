<?php

namespace bicf\securityheaders\behavior;
use yii\base\Behavior;

/**
 * Class HeaderContentSecurityPolicyAcl
 * @package bicf\securityheaders\modules
 */
class ContentSecurityPolicyNonceBehavior extends Behavior
{
    private static $token;

    public static function setContentSecurityPolicyToken($token)
    {
        if(self::$token === null){
            self::$token= $token;
        } else {
            throw new \UnexpectedValueException("Token already setted!");
        }
    }

    public static function getContentSecurityPolicyToken()
    {
        if(self::$token === null){
            self::$token= \Yii::$app->security->generateRandomString();
        }
        return self::$token;
    }

    public function getContentSecurityPolicyTokenAttribute()
    {
        return 'nonce="'.self::getContentSecurityPolicyToken().'"';

    }

    public function getContentSecurityPolicyTokenHeader()
    {
        return "'nonce-".self::getContentSecurityPolicyToken()."'";

    }

    public function getContentSecurityPolicyTokenArray()
    {
        return array('nonce'=>self::getContentSecurityPolicyToken());

    }


}