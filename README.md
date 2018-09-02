Yii2 headers security
================

Installation <a name="installation"></a>
------------


Installation is recommended to be done via [composer][] by running:

	composer require bicf/yii2-security-headers "*"

Alternatively you can add the following to the `require` section in your `composer.json` manually:

```json
"bicf/yii2-security-headers": "*"
```

Run `composer update` afterwards.

[composer]: https://getcomposer.org/ "The PHP package manager"

Then proceed to configuration.

Configuration <a name="configuration"></a>
------------


> **IMPORTANT:** If you don't setup your configuration no header will be sent.


An example of configuration:


```PHP
[                                                                                                                                      
    'components' => [                                                                                                                  
        'response' => [                                                                                                                
            'class' => 'bicf\securityheaders\Response',                                                                                
            'on afterPrepare' => ['bicf\securityheaders\Response','modulesInit'],                                                      
            'on afterSend' => ['bicf\securityheaders\Response','modulesSendHeaders'],                                                  
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
                   'enabled' => false,                                                                                                 
               ],                                                                                                                      
               'ContentSecurityPolicyAcl'=>[                                                                                           
                   'class' => 'bicf\securityheaders\modules\HeaderContentSecurityPolicyAcl',                                           
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