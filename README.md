Yii2 headers security
================

Introduction <a name="introduction"></a>
------------
Yii2 implementation of [CSP - Content Security Policy](https://www.w3.org/TR/CSP1/) 

See also [MDN docs](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP)  



Installation <a name="installation"></a>
------------


Installation is recommended to be done via [composer][] by running:

	composer require bicf/yii2-security-headers "*"

Alternatively you can add the following to the `require` section in your `composer.json` manually:

```json
{
"bicf/yii2-security-headers": "*"
}
```

Run `composer update` afterwards.

[composer]: https://getcomposer.org/ "The PHP package manager"

Then proceed to configuration.

Configuration <a name="configuration"></a>
------------


> **IMPORTANT:** If you don't setup your configuration no header will be sent.


An example of configuration:



Class Response configuration in main.php

```php
[
    'components' => [
        'response' => [
            'class' => 'bicf\securityheaders\Response',
            'on afterPrepare' => ['bicf\securityheaders\Response','addSecurityHeaders'],
            'modules' => [
               'XContentTypeOptions'=>[
                   'class' => 'bicf\securityheaders\modules\HeaderXContentTypeOptions',
                   'value' => 'nosniff',
               ],
               'AccessControlAllowMethods'=>[
                   'class' => 'bicf\securityheaders\modules\HeaderAccessControlAllowMethods',
                   'value' => 'GET',
               ],
               'AccessControlAllowOrigin'=>[
                   'class' => 'bicf\securityheaders\modules\HeaderAccessControlAllowOrigin',
                   'value' => 'https://api.example.com',
               ],
               'ContentSecurityPolicyAcl'=>[
                   'class' => 'bicf\securityheaders\modules\HeaderContentSecurityPolicyAcl',
                   'enabled' => false,
                   'policies' => [
                       'default-src' => "'self'",
                       'frame-src'   => "'self' www.facebook.com www.youtube.com www.google.com",
                       'img-src'     => "'self' www.google-analytics.com",
                       'font-src'    => "'self' fonts.gstatic.com maxcdn.bootstrapcdn.com",
                       'media-src'   => "'self'",
                       'script-src'  => "'self' www.google-analytics.com",
                       'style-src'   => "'self' maxcdn.bootstrapcdn.com",
                        'connect-src' => "'self'",
                        'report-uri'  => "/report-csp-acl",
                    ],
                ],
                'ContentSecurityPolicyMonitor'=>[
                    'class' => 'bicf\securityheaders\modules\HeaderContentSecurityPolicyMonitor',
                    'policies' => [
                        'default-src' => "'self'",
                        'frame-src'   => "'self' www.facebook.com www.youtube.com www.google.com",
                        'img-src'     => "'self' www.google-analytics.com",
                        'font-src'    => "'self' fonts.gstatic.com maxcdn.bootstrapcdn.com",
                        'media-src'   => "'self'",
                        'script-src'  => "'self' www.google-analytics.com",
                        'style-src'   => "'self' maxcdn.bootstrapcdn.com",
                        'connect-src' => "'self'",
                        'report-uri'  => "/report-csp-acl",
                    ],
                ],
            ],
        ],
    ],
]

```


Yii2 integration of Content Security Policy Header
================

Possible integrations
----------------
CSP can work by **signature** or by **token** (*nonce*)
see:



Integration by signature
----------------
Done simply adding the signatures to CSP configuration 

Example:
```php
'style-src'   => "'sha256-aqNNdDLnnrDOnTNdkJpYlAxKVJtLt9CtFLklmInuUAE=' 'sha256-6fwFCXmgb6H4XQGajtDSVG3YuKmX3dT1NkX4+z510Og=' 'sha256-ZdHxw9eWtnxUb3mk6tBS+gIiVUPE3pGM470keHPDFlE='",
``` 
This kind of integration does not require patch to the framework code but it's space wasting and hard to mantain 
even with a small number of signatures.

Integration by token (nonce) 
----------------
This kind of integration require some (small) patch at framework (\yii\helpers\BaseHtml) level to take full advantage of nonce token.
The nonce feature (enabled by default) don't need maintenace once integrated and has reduced footprint on the header

Here follow the patched versions of BaseHtml functions to support the nonce parameter in a transparent way. 

**Patch to Html::script helper**

The pathced  *\yii\helpers\BaseHtml::script()* :
                                                                                                                
```php
    public static function script($content, $options = [])
    {
        if(Yii::$app->response instanceof SecureRequestInterface){
            $behavior = Yii::$app->response->getBehavior(SecureRequestInterface::CSP_NONCE_BEHAVIOR);
            if($behavior != null){
                $options = array_merge(Yii::$app->response->getContentSecurityPolicyTokenArray(),$options );
            }
        }
        return static::tag('script', $content, $options);
    }

```

**Tag script required by the project Assets**

The pathced  *\yii\helpers\BaseHtml::jsFile()* :

```php
    public static function jsFile($url, $options = [])
    {
        $options['src'] = Url::to($url);
        if (isset($options['condition'])) {
            $condition = $options['condition'];
            unset($options['condition']);
            return self::wrapIntoCondition(static::tag('script', '', $options), $condition);
        }

        if(Yii::$app->response instanceof SecureRequestInterface){
            $behavior = Yii::$app->response->getBehavior('cspBehavior');
            if($behavior != null){
                $options = array_merge(Yii::$app->response->getContentSecurityPolicyTokenArray(),$options );
            }
        }

        return static::tag('script', '', $options);
    }

``` 

or (better?) call *script* funtion inside *jsFile* function:

```php
    public static function jsFile($url, $options = [])
    {
        $options['src'] = Url::to($url);
        if (isset($options['condition'])) {
            $condition = $options['condition'];
            unset($options['condition']);
            return self::wrapIntoCondition(static::tag('script', '', $options), $condition);
        }

        return static::script('', $options);
    }


```

A different approach for `<script>` the views 
-----------

**Tag script inside the views**

When the `<script>` is explicit used in view or controllers the solution is to add the nonce parameter directly in the tag by:

`Yii::$app->response->getContentSecurityPolicyTokenAttribute()`


**Inside a view**

```html
<script <?= Yii::$app->response->getContentSecurityPolicyTokenAttribute();?> >
    alert("test");
</script>

```

**A patched** `\yii\debug\Module::renderToolbar` **function**


```php
    /**
     * Renders mini-toolbar at the end of page body.
     *
     * @param \yii\base\Event $event
     */
    public function renderToolbar($event)
    {
        if (!$this->checkAccess() || Yii::$app->getRequest()->getIsAjax()) {
            return;
        }

        /* @var $view View */
        $view = $event->sender;
        echo $view->renderDynamic('return Yii::$app->getModule("' . $this->id . '")->getToolbarHtml();');

        // echo is used in order to support cases where asset manager is not available
        echo '<style>' . $view->renderPhpFile(__DIR__ . '/assets/toolbar.css') . '</style>';
        echo '<script '.Yii::$app->response->getContentSecurityPolicyTokenAttribute().'>' . $view->renderPhpFile(__DIR__ . '/assets/toolbar.js') . '</script>';
    }
```

In detail the line: 
```php
echo '<script '.Yii::$app->response->getContentSecurityPolicyTokenAttribute().'>' . $view->renderPhpFile(__DIR__ . '/assets/toolbar.js') . '</script>';

```



