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

/**
 * 4.function
 */
$this->goHome(); //回到首页
$this->goBack(); //回到上一级
$this->redirect(['site/index']); //重定向
$model->findOne($id = 12); //查找一条数据

/**
 * 5.request property and method
 */
\Yii::$app->request->isAjax;
\Yii::$app->request->isPost;
\Yii::$app->request->userAgent;
\Yii::$app->request->userIP;
\Yii::$app->request->get(); //获取get全部数据
\Yii::$app->request->get('username'); //读取get数据



/**
 * 6.model
 */
$arr = [
    'extend' => '\'yii\db\ActiveRecord\', \'yii\base\Model\''
];

/**
 * 7.table form
 */
use yii\helpers\Html;
Html::beginForm(
    '', //提交到的方法
    'post', //传递方式
    [
        'id' => 'addFrom',
        'class' => 'form',
        'data' => 'fm'
    ] //define class and id,(options)
); //begin form
Html::endForm(); //end form
Html::input(
    'text', //type:text/password/hidden
    'name', //name value
    'sister', //default value
    ['class' => 'input password'] //options
); //input label
Html::passwordInput( //类似的还有textInput/hiddenInput
    'pwd', //name
    '', //default value
    ['id' => 'password'] //options
);

/**
 * 8.
 */