<?php

namespace bicf\securityheaders\modules;


/**
 * Class HeaderModuleBase
 * @package bicf\securityheaders\modules
 * @property boolean $enabled
 */
abstract class HeaderModuleSimple extends HeaderModuleBase
{

    public function init()
    {
        parent::init();
    }

    // in HeaderModuleSimple ther's no behavior
    public function injectBehavior(\yii\web\Response $response)
    {
        return;
    }
}
