<?php
namespace bicf\securityheaders\modules;

/**
 * Class HeaderXContentTypeOptions
 * @package bicf\securityheaders\modules
 */
class HeaderXFrameOptions extends HeaderModuleSimpleKeyVal
{
    protected $header='X-Frame-Options';
    protected $defaultValue='SAMEORIGIN';
}
