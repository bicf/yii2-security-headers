<?php

namespace bicf\securityheaders\behavior;

/**
 * Class HeaderContentSecurityPolicyAcl
 * @package bicf\securityheaders\modules
 */
class ContentSecurityPolicyDummyBehavior extends ContentSecurityPolicy
{
    public function getContentSecurityPolicyTokenValue()
    {
        return "";
    }


    public function getContentSecurityPolicyTokenAttribute()
    {
        return "";

    }

    public function getContentSecurityPolicyTokenHeader()
    {
        return "";

    }

    public function getContentSecurityPolicyTokenArray()
    {
        return [];
    }


}