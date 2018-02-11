<?php
/**
 * 1.一些通用方法和函数
 *
 */
$arr = [
    "$this->load->view('home')", //加载模板
    "show_404()", //展示404错误
    "$this->input->post('title')", //用来接收post参数title

    "//更改方法规则
    public function _remap($method) {
        if ($method == 'view') {
            $this->$method();
        } else {
            $this->index();
        }
    }",
];

/**
 * 2.类的加载与使用
 */
$arr = [
    "$this->load->library('someclass')",
    "$this->load->library('someclass', ['type' => 'large', 'color' => 'red'])", //载入类时初始化参数
    "$this->someclass->some_function()",

    "$this->load->library('form_validation)",//加载form-validation类
    "$this->form_validation->set_rules('title', 'Title', 'required')",
    "$this->form_validation->run()",//调用form_validation的run方法
];

/**
 * 3.helper函数的加载与使用
 */
$arr = [
    "$this->load->helper('functionname')",

    "$this->load->helper('url')", //加载url辅助函数库
    "anchor('blog/comments', 'Click Here')", //加载完函数库直接调用内部的方法
    "url_title($this->input->post('title'), 'dash', true)", //作用:大写变小写,空格变横线
];

/**
 * 4.加载模型与使用
 */
$arr = [
    "$this->load->model('model_name')", //用来加载model
    "$this->model_name->somefunction()", //模型方法使用
];

/**
 * 5.数据库载入与使用
 */
$arr = [
    "$this->load->database()", //加载数据库连接
    "$this->db->insert($table, $data)", //插入数据,$table数据表,$data数据
];

/**
 * 6.为自定义类库和辅助函数设定前缀
 */
$config['subclass_prefix'] = 'MY_';
































