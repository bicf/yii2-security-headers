<?php
namespace bicf\securityheaders\modules;

/**
 * Class HeaderXContentTypeOptions
 * @package bicf\securityheaders\modules
 */
class HeaderAccessControlAllowMethods extends HeaderModuleSimpleKeyVal
{
    protected $header='Access-Control-Allow-Methods';
    protected $defaultValue='GET';
}
