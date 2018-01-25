<?php
/**
 * 1.json化数据:
 */
$response = Yii::$app->response;
$response->format=\yii\web\Response::FORMAT_JSON;
$response->data = [
'code' => 123,
'message' => 'haha,test'
];
$response->send();

/**
 * 2.
 */