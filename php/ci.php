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

/**
 * 7. 钩子的使用
 */
$config['enable_hooks'] = TRUE; //开启钩子
$hook['pre_controller'] = array(
    'class'    => 'MyClass',
    'function' => 'Myfunction',
    'filename' => 'Myclass.php',
    'filepath' => 'hooks',
    'params'   => array('beer', 'wine', 'snacks')
); //定义钩子,application/config/hooks.php

/**
 * 8.错误处理
 */
$arr = [
    "show_error()", //显示错误
    "show_404()", //显示404
    "log_message",//日志记录,需配置$config['log_threshold'];
];

/**
 * 9.分析器(调试)
 */
$arr = [
    "$this->output->enable_profiler(TRUE/FALSE)", //打开和关闭分析器
    "$this->input->is_cli_request()", //判断是否是命令行访问
];

/**
 * 10.表单
 */
$arr = [
    "$this->form_validation->set_message('rule', 'Error Message');", //设置自己的表单错误信息,也可在lang中设置
    "<?php echo validation_error();?>",//输出控制器中验证失败的信息(全部表单域)
    "<?php echo form_error();?>",//输出控制器中验证失败的信息(单个表单域)
];

/**
 * 11.配置加载与读取
 */

$arr = [
    "$this->config->load('testconfig', false, true);
        echo $this->config->item('my_test');",
];

/**
 * 12.activeRecord查询
 */
$arr = [
    "$this->db->where('id=5'); //where查询
        $this->db->select('title,id');
        $query = $this->db->get('news');
        $query->num_rows(); //行数
        $query->num_fields(); //列数
        $this->db->count_all_results('myTable'); //前面加条件,统计条数,返回证书
        
        $this->db->select_max('age');
        $this->db->select_min('age'); //最大与最小
        $this->db->select_avg('age');
        $this->db->select_max('age');
        $this->db->from('mytable'); //有此后$this->db->get()内不用写参数
        $this->db->join('comments', 'comments.id = blogs.id', 'left'); //join部分
        $this->db->where('name', $name); // where使用1
        $this->db->where('name !=', $name);
        $this->db->where('id <', $id); //生成WHERE name != 'Joe' AND id < 45 //where2

        $array = array('name !=' => $name, 'id <' => $id, 'date >' => $date);
        $this->db->where($array); //where3数组方式
        $where = \"name='Joe' AND status='boss' OR status='active'\"; //where4自定义
        $this->db->where('name !=', $name);
        $this->db->or_where('id >', $id); //WHERE name != 'Joe' OR id > 50 //orWhere使用
        
        $names = array('Frank', 'Todd', 'James');
        $this->db->where_in('username', $names); //whereIn:生成WHERE username IN ('Frank', 'Todd', 'James')
        
        $names = array('Frank', 'Todd', 'James');
        $this->db->or_where_in('username', $names); //orWhereIn
        // 生成: OR username IN ('Frank', 'Todd', 'James');
        
        $names = array('Frank', 'Todd', 'James');
        $this->db->where_not_in('username', $names); //whereNotIn
        // 生成: WHERE username NOT IN ('Frank', 'Todd', 'James');
        
        $names = array('Frank', 'Todd', 'James');
        $this->db->or_where_not_in('username', $names); //orNotIn
        // 生成: OR username NOT IN ('Frank', 'Todd', 'James')
        
        $this->db->like('title', 'match');
        $this->db->like('body', 'match'); //like使用
        // WHERE title LIKE '%match%' AND body LIKE '%match%'
        $this->db->like('title', 'match', 'before'); 
        // 生成: WHERE title LIKE '%match' 
        $this->db->like('title', 'match', 'after'); 
        // 生成: WHERE title LIKE 'match%' 
        $this->db->like('title', 'match', 'both'); 
        // 生成: WHERE title LIKE '%match%'
        $this->db->like('title', 'match', 'none'); 
        // Produces: WHERE title LIKE 'match'
        $array = array('title' => $match, 'page1' => $match, 'page2' => $match);
        $this->db->like($array); 
        // WHERE title LIKE '%match%' AND page1 LIKE '%match%' AND page2 LIKE '%match%'
        
        $this->db->group_by(\"title\");
        // 生成: GROUP BY title
        $this->db->group_by(array(\"title\", \"date\")); 
        // 生成: GROUP BY title, date
        
        
        "
];






































