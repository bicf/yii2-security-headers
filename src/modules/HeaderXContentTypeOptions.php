<?php
namespace bicf\securityheaders\modules;

/**
 * Class HeaderXContentTypeOptions
 * @package bicf\securityheaders\modules
 */
class HeaderXContentTypeOptions extends HeaderModuleSimpleKeyVal
{
    protected $defaultValue='nosniff';
    protected $header='X-Content-Type-Options';
}
