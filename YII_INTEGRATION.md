Yii2 integration of headers security
================

Framework integrations
----------------

Some integration shold be done at framework level

**Tag script helper**

To support in a transparent way the nonce parameter in script tags a modify to  *\yii\helpers\BaseHtml::script()*  should be necessary:
                                                                                                                
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

**Tag script inside the assets**

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