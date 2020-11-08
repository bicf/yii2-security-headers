<?php

namespace bicf\securityheaders\modules;


/**
 * Class HeaderModuleBase
 * @package bicf\securityheaders\modules
 * @property boolean $enabled 
 */
abstract class HeaderModuleSimple extends HeaderModuleBase
{

    // in HeaderModuleSimple ther's no behavior
    public function injectBehavior(\yii\web\Response $response)
    {
        return;
    }
}