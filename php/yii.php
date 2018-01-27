<?php
/**
 * 1.json :
 */
$response = Yii::$app->response;
$response->format=\yii\web\Response::FORMAT_JSON;
$response->data = [
'code' => 123,
'message' => 'haha,test'
];
$response->send();

/**
 * 2.table prefix:
 */
$arr = [
    'tablePrefix' => 'm_', //db.php配置
    '{{%room}}', //models中的tableName
];

/**
 * 3.alias effect
 */
$arr = [
    'include file quickly',
    'config method' => [
        'config.php' => '\'@test\' => \'@vendor/../test\',',
        'bootstrap.php' => 'Yii::setAlias(\'test\', FILEPATH)'
    ]
];
