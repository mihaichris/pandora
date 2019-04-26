<?php
return [
    'modules' => [
        'debug' => [
            'class' => 'yii\\debug\\Module',
            'panels' => [
                'httpclient' => [
                    'class' => 'yii\\httpclient\\debug\\HttpClientPanel',
                ],
            ],
        ],
        'datecontrol' => [
            'class' => kartik\datecontrol\Module::class,
        ],
        'dynagrid' => [
            'class' => kartik\dynagrid\Module::class,
        ],
        'dynagridCustom' => [
            'class' => kartik\dynagrid\Module::class,
        ],
        'gridview' => [
            'class' => kartik\grid\Module::class,
        ],
        'gridviewKrajee' => [
            'class' => kartik\grid\Module::class,
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableConfirmation' => false,
            'enableFlashMessages' => false,
            'emailChangeStrategy' => dektrium\user\Module::STRATEGY_SECURE,
            // 'enableAccountDelete'=> true,

//            'mailer' => [
//                'sender' => 'no-reply@myhost.com', // or ['no-reply@myhost.com' => 'Sender name']
//                'welcomeSubject' => 'Welcome subject',
//                'confirmationSubject' => 'Confirmation subject',
//                'reconfirmationSubject' => 'Email change subject',
//                'recoverySubject' => 'Recovery subject',
//            ],
            'modelMap' => [
                'RegistrationForm' => 'common\models\RegistrationForm',
                //'Profile' => 'common\models\Profile',
                'User' => 'common\models\User',
                //'LoginForm' => 'common\models\LoginForm',
            ],
            'controllerMap' => [
                'registration' => 'frontend\controllers\RegistrationController',
                'admin' => 'frontend\controllers\AdminController',
            ],
            'admins' => ['admin'],
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'pandora' => [
            'class' => 'common\components\Pandora',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'gridview' => [
            'class' => kartik\grid\Module::class,
            'downloadAction' => '/gridview/export/download',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=blockchain_db',
            'username' => 'root',
            'password' => '',
            'enableSchemaCache' => true,

            // Duration of schema cache.
            'schemaCacheDuration' => 3600,

            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class, // or use yii\rbac\PhpManager::class
        ],
        'keyStorage' => [
            'class' => common\components\keyStorage\KeyStorage::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db' => [
                    'class' => yii\log\DbTarget::class,
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logTable' => '{{%system_log}}',
                    'logVars' => [],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/messages',
                ],
                '*' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'common' => 'common.php',
                        'backend' => 'backend.php',
                        'frontend' => 'frontend.php',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            'transport' => [
                'class' => Swift_SmtpTransport::class,
                'host' => 'smtp.gmail.com',
                'username' => 'dynet.intellisoftware@gmail.com',
                'password' => 'user_dynet',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
    /**
     * TODO:
     * This should be uncommented when in production
     */
    // 'as access' => [
    //      'class' => mdm\admin\components\AccessControl::class,
    //      'allowActions' => [
    // //         /**
    // //          * The actions listed here will be allowed to everyone including guests.
    // //          * So, 'admin/*' should not appear here in the production, of course.
    // //          * But in the earlier stages of your development, you may probably want to
    // //          * add a lot of actions here until you finally completed setting up rbac,
    // //          * otherwise you may not even take a first step.
    // //          */
    //      ]
    //  ],
];
