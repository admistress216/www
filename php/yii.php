<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * 1.json serialize:
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
Html::encode('<br>html</br>'); //转义
Html::decode('<br>html</br>'); //反转义
Html::error($model, 'title', ['class' => 'err']); //打印关联数据库的错误,第二个参数为数据库字段
//以http://localhost:8080/yii2-demo/web/index.php?r=article/index为例
Url::base(); //输出/yii2-demo/web
Url::base(true); //输出http://localhost:8080/yii2-demo/web
Url::home(); //首页,输出/yii2-demo/web/index.php
Url::home(true); //输出http://localhost:8080/yii2-demo/web/index.php
Url::current(); //当前url,输出/yii2-demo/web/index.php?r=article/index
Url::to(['article/add']); //输出/yii2-demo/web/index.php?r=article/add
Url::to(['article/add','id' => 1],true); //输出http://localhost:8080/yii2-demo/web/index.php?r=article/add&id=1
Url::toRoute(['article/add']); //输出/yii2-demo/web/index.php?r=article/add
Url::toRoute(['article/add','id' => 1],true); //输出http://localhost:8080/yii2-demo/web/index.php?r=article/add&id=1



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
Html::beginForm(
    '', //提交到的方法,什么都不填自动提交到自己
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
Html::textarea(
    'intro', //name
    'sister', //value
    ['class' => 'textarea'] //options
);
Html::radio(
    'name', //name
    true, //checked
    ['class' => ''] //options
); //单列列表
Html::radioList(
    'sex', //name
    1, //default selection
    [0 => 'man', 1=> 'female'], //item
    ['class' => 'radiolist'] //options
);//多列列表
Html::checkbox(
    'name', //name
    true, //checked
    ['class' => ''] //options
); //单列多选
Html::checkboxList(
    'sex', //name
    1, //default selection
    [0 => 'man', 1=> 'female'], //item
    ['class' => 'radiolist'] //options
);//多列多选
Html::dropDownList(
    'sex', //name
    1, //selection
    [0=> 'no', 1 => 'yes'], //item
    ['class' => 'dropdown']
);//下拉框
Html::label(
    '用户名:', //content
    'username', //for id
    ['class' => 'label', 'style' => 'color:#000'] //options
); //label
Html::fileInput(
    'image', //name
    null, //default value
    ['class' => 'uploads'] //options
); //上传
Html::button( //类似的还有submitButton(提交按钮),resetButton(重置按钮)
    '普通按钮', //content
    ['class' => 'btn'] //options
); //button
Html::activeInput( //类似的还有activeTextInput/activePasswordInput/activeHiddenInput/
//activeTextarea/activeRadio(List)/activeCheckbox(List)/activeDropList
    'text', //type,类似的text/password
    $model, //instance model
    'roomname', //attribute
    ['class' => 'input'] //options
); //生成与Model关联的组件,可以直接在控制器中用$model = \app\models\modelid::findOne($id),填充数据库中字段值

/**
 * 8.模型验证
 * load主要作用:给model内数据库字段赋值
 * load方法可以直接加载$_POST等数据,而Post的数据下标必须跟Model的
 * 类名一致,例如Article::load($_POST)等于加载$_POST['Article']
 * 里面的数据,另外可以load的字段必须出现在rules方法的数组中,不然也
 * 无法直接赋值.
 */
$model = new \app\models\Article();
$model->load(\Yii::$app->request->post()); //$_POST['Article']
if(!$model->validate()){ //用validate验证rules
    print_r($model->getErrors());
};
public function rules() {
    return [
        ['username', 'require', 'message'=>'用户名不能为空'], //safe:不验证,required:必须验证,compare:对比,
        //double:双精度验证,email:邮箱验证,in:范围验证,integer:数字验证,match:正则验证,string:字符串验证,
        //unique:唯一验证,capture:验证码(这两个都需要数据库)
        [['username', 'password'], 'safe'], //多个字段不验证
        [
            'username', //字段
            'compare', //功能选项
            'compareValue' => '对比的值', //对比选项,取值compareValue/compareAttribute
            'message' => '提示信息', //message,验证失败的提示
        ], //对比验证
    ];
}

/**
 * 9.1增删改查(以yii\db\ActiveRecord为基础)
 *
 */
\app\models\Article::findAll(['status' => 1]); //查询Article,status为1的所有数据
\app\models\Article::findOne('条件'); //条件为id或者arr
\app\models\Article::find()->where(['id'=>1])->one();
\app\models\Article::find()->where('status=:status', [':status' => 1])
    ->orderBy('date desc')->offset(5)->limit(3)->all(); //从第五条开始读,读取三条
\app\models\Article::find()->count(); //查询条数

$article = \app\models\Article::findOne(1);
$article->title = 'change title';
$article->save(); //更新一条数据,save函数第一个参数默认为true,就是更新或插入时启动验证,false为不启用(默认为true)
\app\models\Article::updateAll(['title' => 'change title'], ['id' => 1]); //更新所有id=1的title值

$article = new \app\models\Article();
$article->title = 'new one';
$article->content = 'this is new';
$article->save(); //添加一条新数据

\app\models\Article::findOne(1)->delete(); //删除一条数据
\app\models\Article::deleteAll(['id' => 2]); //删除指定条件的所有数据

/**
 * 9.2查(以\yii\db\Query为基础)
 */
$db = new \yii\db\Query;
//查询一条id等于2的数据
$db->select('id')->from('mrs_article')->where("id=:id",[':id' => 2])->one();
//查询多条
$db->select('id')->from('mrs_article')->where(['id' => 1])->all();
//in查询多条
$db->select('id')->from('mrs_article')->where(['id' => [1,2]])->all();
//排序并从第五条开始取三条
$db->select('id')->from('mrs_article')->orderBy('date desc')->offset(5)->limit(3)->all();
//查询数据总个数
$db->select("id")->from('mr_article')->count();

/**
 * 9.3增删改查(以Yii::$app->db为基础)
 */
$db = \Yii::$app->db;
$db->createCommand("select * from mrs_article")->queryOne(); //查询一条数据
$db->createCommand("select * from mrs_article where id=:id")->bindValue(":id",2)->queryOne(); //绑定参数
$db->createCommand("select * from mrs_article where id=:id and status=:status")->bindValues([":id" => 1,":status" => '1'])->queryOne(); //绑定多个参数
$db->createCommand("select * from mrs_article")-> queryAll(); //查询多条数据
$db->createCommand("select count(*) from mrs_article")->queryScalar(); //查询条数

$db->createCommand()->update('mrs_article',['status' => 0], "id=:id", [":id" => 1])->execute(); //更新数据
$db->createCommand()->insert('mrs_article', ['title' => 'new Record'])->execute(); //插入
$db->createCommand()->delete('mrs_article', "id=:id", [":id" => 1])->execute(); //删除

/**
 * 10.分页组件\yii\data\Pagination,而在view中直接调用\yii\widgets\LinkPager生成分页html
 * 地址栏用page传递参数
 */
$pagination = new \yii\data\Pagination(['totalCount' => 100, 'pageSize' => 5]); //$pagination->offset,$pagination->limit会自动求出
echo \yii\widgets\LinkPager::widget([
    'pagination' => $pagination,
    'options' => [
        'id' => 'page'
    ],
    'nextPageLabel' => '下一页',
    'lastPageLabel' => '最后一页'
]);

/**
 * 11.1表单例子(添加+上传表单)
 */

<?=Html::beginForm('', 'post', ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']); ?>
<div class="form-group">
    <?=Html::label('房间名: ','roomname', ['class' => 'control-label col-sm-2'])?>
    <div class="col-sm-5">
        <?=Html::activeInput('text', $model, 'roomname', ['class' => 'form-control'])?>
    </div>
</div>
<div class="form-group">
    <?=Html::label('上传语音: ','file', ['class' => 'control-label col-sm-2'])?>
    <div class="col-sm-5">
        <?=Html::fileInput('file','',['class' => 'uploads']);?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?=Html::submitButton('提交', ['class' => 'btn'])?>
    </div>
</div>
<?=Html::endForm();?>
<?php
    public function actionAdd() {
    $model = new Room();
    if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
    $path = Yii::getAlias('@app/vendor/ks3');
    include $path.'/Ks3Client.class.php';
    //是否使用VHOST
    //            define("KS3_API_VHOST",FALSE);
    //是否开启日志(写入日志文件)
    //            define("KS3_API_LOG",TRUE);
    //是否显示日志(直接输出日志)
    //            define("KS3_API_DISPLAY_LOG", TRUE);
    //定义日志目录(默认是该项目log下)
    //            define("KS3_API_LOG_PATH","");
    //是否使用HTTPS
    //            define("KS3_API_USE_HTTPS",FALSE);
    //是否开启curl debug模式
    //            define("KS3_API_DEBUG_MODE",FALSE);
    $client = new \Ks3Client("","","");
    var_dump($_FILES);
    $content = fopen($_FILES['file']['tmp_name'], "r");
    $args = array(
    "Bucket"=>"media-newscctv",
    "Key"=>$_FILES['file']['name'],
    "Content"=>array(//要上传的内容
    "content"=>$content,//可以是文件路径或者resource,如果文件大于2G，请提供文件路径
    "seek_position"=>0//跳过文件开头?个字节
    ),
    "ACL"=>"public-read",//可以设置访问权限,合法值,private、public-read
    "ObjectMeta"=>array(//设置object的元数据,可以设置"Cache-Control","Content-Disposition","Content-Encoding","Content-Length","Content-MD5","Content-Type","Expires"。当设置了Content-Length时，最后上传的为从seek_position开始向后Content-Length个字节的内容。当设置了Content-MD5时，系统会在服务端进行md5校验。
    "Content-Type"=>"binay/ocet-stream"
    //"Content-Length"=>4
    ),
    "UserMeta"=>array(//可以设置object的用户元数据，需要以x-kss-meta-开头
    "x-kss-meta-test"=>"test"
    )
    );
    $res = $client->putObjectByFile ($args);
    var_dump($res);
    } else {
    return $this->render('add', ['model' => $model]);
    }
}

/**
* 11.2表单例子(展示+分页)
*/
public function actionIndex($page = 0) {
    $db = new \yii\db\Query;
    $count = $db->select("id")->from('m_room')->count();
    $pagination = new \yii\data\Pagination(['totalCount' => $count, 'pageSize' => 15]);
    $res = $db->select('serial,roomname,userid,starttime,endtime')->from('m_room')->offset($pagination->offset)->limit($pagination->limit)->all();
    return $this->render('index', ['res' => $res, 'pagination' => $pagination]);
}

use \yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<p style="text-align:right;">
    <a href="<?=\yii\helpers\Url::to(['add']); ?>" class="btn btn-primary">添加</a>
</p>
<table class="table table-hover">
    <tr>
        <th>id</th><th>房间名</th><th>用户id</th><th>开始时间</th><th>结束时间</th>
    </tr>
    <?php foreach($res as $key):?>
        <tr>
            <td><?=Html::encode($key['serial'])?></td>
            <td><?=Html::encode($key['roomname'])?></td>
            <td><?=Html::encode($key['userid'])?></td>
            <td><?=Html::encode($key['starttime'])?></td>
            <td><?=Html::encode($key['endtime'])?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?= LinkPager::widget(['pagination' => $pagination]); ?>

<?php
/**
 * 12.别名
 *yii2系统定义的常用路径别名
 *@yii 表示Yii框架所在的目录，也是 yii\BaseYii 类文件所在的位置；
 *@app 表示正在运行的应用的根目录，一般是 digpage.com/frontend ；物理路径
 *@vendor 表示Composer第三方库所在目录，一般是 @app/vendor 或 @app/../vendor ；
 *@bower 表示Bower第三方库所在目录，一般是 @vendor/bower ；
 *@npm 表示NPM第三方库所在目录，一般是 @vendor/npm ；
 *@runtime 表示正在运行的应用的运行时用于存放运行时文件的目录，一般是 @app/runtime ；
 *@webroot 表示正在运行的应用的入口文件 index.php 所在的目录，一般是 @app/web；物理路径
 *@web URL别名，表示当前应用的根URL，主要用于前端。相对路径
 *@common 表示通用文件夹；
 *@frontend 表示前台应用所在的文件夹；
 *@backend 表示后台应用所在的文件夹；
 *@console 表示命令行应用所在的文件夹；
 *其他使用Composer安装的Yii扩展注册的二级别名
 *Yii使用 Yii::$aliases[] 来保存别名
 *
 *Yii::setAlias() 定义别名
 *
 *Yii::getAlias()获取别名
 *
 *例如：
 *
 *dirname(Yii::$app->request->getScriptFile())
 *Yii::getAlias("@webroot")
 *
 *这两个的返回值是一样的
 *
 *@webroot这个别名是在yiisoft/yii2/web/Application.php中定义的
 *
 *小结
 *别名需在使用前定义，因此通常来讲，定义别名应当在放在应用的初始化阶段。
 *别名必然以 @ 打头。
 *别名的定义可以使用之前已经定义过的别名。
 *别名在储存时，至多只分成两级，第一级的键是根别名。 第二级别名的键是完整的别名，而不是去除根别名后剩下的所谓的“二级”别名。
 *Yii通过分层的树结构来保存别名最主要是为高效检索作准备。
 *很多地方可以直接使用别名，而不用调用 Yii::getAlias() 转换成真实的路径或URL。如Yii::getAlias("@app")
 *别名解析时，优先匹配较长的别名。
 *Yii预定义了许多常用的别名供编程时使用。
 *使用别名时，要将别名放在最前面，不能放在中间。
 */




















































