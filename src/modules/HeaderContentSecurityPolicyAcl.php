<?php

namespace bicf\securityheaders\modules;

/**
 * Class HeaderContentSecurityPolicyAcl
 * @package bicf\securityheaders\modules
 */
class HeaderContentSecurityPolicyAcl extends HeaderContentSecurityPolicyBase
{
    protected $headerName='Content-Security-Policy';
    public function init()
    {
    }

}