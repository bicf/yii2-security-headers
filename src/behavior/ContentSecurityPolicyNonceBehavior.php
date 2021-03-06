<?php

namespace bicf\securityheaders\behavior;
use yii\base\Behavior;

/**
 * Class HeaderContentSecurityPolicyAcl
 * @package bicf\securityheaders\modules
 */
class ContentSecurityPolicyNonceBehavior extends ContentSecurityPolicy
{
    public function getContentSecurityPolicyTokenValue()
    {
        return self::getContentSecurityPolicyToken();
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