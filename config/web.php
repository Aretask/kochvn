<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'layout'=>'main.php',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'urlManager'=>array(
           // 'baseUrl'=>'http://kochevnik.com.ua',
            'baseUrl'=>'http://kochevn',
            'enablePrettyUrl' => true,
            'showScriptName'=>false, 
            'rules'=>array(
             'admink32/?' => 'admin/default/login',
             'admink32/logout/?' => 'admin/default/logout',
             'admink32/main/?' => '/admin/default/main',
             'admink32/orders/<action:[\w-]+>/?' => 'admin/orders/<action>',
             'POST admink32/products/add-gallery/?' => 'admin/products/add-gallery',
             'POST,GET admink32/products/<action:[\w-]+>/?' => 'admin/products/<action>',
             'admink32/parse/<action:[\w-]+>/?' => 'admin/parse/<action>',
             'admink32/different/<action:[\w-]+>/?' => 'admin/different/<action>',
                 [
                    'pattern' => 'item/<product:[\w-]+>',
                    'route' => '/product/show',
                    'suffix' => '.html',
                ],
                 'empty/?' => 'site/empty',
                 'contact/?' => 'site/contact',
                 'cart/?' => 'site/cart',
                 'POST product/set-order/?' => 'product/set-order',
                 'product/count-orders/?' => 'product/count-orders',
                 'POST product/del-order/?' => 'product/del-order',
                 'POST product/comfirm-order/?' => 'product/comfirm-order',
                 'brand/<brand:[\w-]+>/?'=>'/categories/main',
                 '<rubric:[\w-]+>/<category:[\w-]+>/brand/<brand:[\w-]+>/?' => '/categories/category',
                 '<rubric:[\w-]+>/brand/<brand:[\w-]+>/?' => '/categories/main',
                 '<rubric:[\w-]+>/<category:[\w-]+>/?' => '/categories/category',
                 '<rubric:[\w-]+>/?' => '/categories/main',
                 'ajax/<rubric:[\w-]+>/<category:[\w-]+>/?' => '/categories/category-ajax',
                 'ajax/<rubric:[\w-]+>/<category:[\w-]+>/brand/<brand:[\w-]+>/?' => '/categories/category-ajax',
        
                 
            ),
        ),
        'request' => [
            'baseUrl'=>'',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'j',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\admin\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
         //   'viewPath' => '@backend/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
             'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.kochevnik.com.ua',
            'username' => 'info@kochevnik.com.ua',
            'password' => 'mailkochevn777',
            'port' => '587',
            'encryption' => 'tls',
                        ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
  
    ],
   'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
      
        ],
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module'
        
    ];
}

return $config;
