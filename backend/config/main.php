<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' => ['class' => 'kartik\grid\Module'],

        'db-manager' => [
            'class' => 'bs\dbManager\Module',
            // path to directory for the dumps
            'path' => '@backend/backups',
            // list of registerd db-components
            'dbList' => ['db'],
            'customDumpOptions' => [
                'mysqlForce' => '--force',
                'somepreset' => '--triggers --single-transaction',
                'pgCompress' => '-Z2 -Fc',
            ],
            'customRestoreOptions' => [
                'mysqlForce' => '--force',
                'pgForce' => '-f -d',
            ],
//            // options for full customizing default command generation
//            'mysqlManagerClass' => 'CustomClass',
//            'postgresManagerClass' => 'CustomClass',
//            // option for add additional DumpManagers
//            'createManagerCallback' => function($dbInfo) {
//                if ($dbInfo['dbName'] == 'coltd') {
//                    return true; //new MyExclusiveManager;
//                } else {
//                    return false;
//                }
//            },
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                       // 'roles' => ['admin'],
                    ],
                ],
            ],
        ],
    ],
    'aliases'=>[
        '@klolofil' => '@backend/themes/klolofil',

    ],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@backend/views' => '@klolofil/views'
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
