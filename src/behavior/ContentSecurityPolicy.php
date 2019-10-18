<?php

namespace bicf\securityheaders\behavior;
use yii\base\Behavior;

/**
 * Class HeaderContentSecurityPolicyAcl
 * @package bicf\securityheaders\modules
 */
abstract class ContentSecurityPolicy extends Behavior
{
    protected static $token;

    /**
     * @param string $token
     */
    public static function setContentSecurityPolicyToken($token)
    {
        if(self::$token === null){
            self::$token= $token;
        } else {
            throw new \UnexpectedValueException("Token already set!");
        }
    }

    public static function getContentSecurityPolicyToken()
    {
        if(self::$token === null){
            self::$token= \Yii::$app->security->generateRandomString();
        }
        return self::$token;
    }

    abstract public function getContentSecurityPolicyTokenValue();
    abstract public function getContentSecurityPolicyTokenAttribute();
    abstract public function getContentSecurityPolicyTokenHeader();
    abstract public function getContentSecurityPolicyTokenArray();
}