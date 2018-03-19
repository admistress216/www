<?php
/**
 * 1.0单例模式
 * heredoc/nowdoc
 */
$str = <<<Single

class Instance { //单例模式
    public static function getInstance () {
        $class_name = get_called_class();
        if (!isset(self::$instance[$class_name])) {
            self::$instance[$class_name] = new $class_name;
        }
        return self::$instance[$class_name];
    }
}
Single;

/**
 * 2.0简单工厂模式
 *
 * 包括三部分:抽象基类,继承自抽象基类的自类,工厂类(用以实例化对象)
 */
$str = <<<Factory

abstract class Operation {
    abstract public function getValue($num1, $num2);
}

class OperationAdd extends Operation {
    public function getValue($num1, $num2)
    {
        // TODO: Implement getValue() method.
        return $num1 + $num2;
    }
}

class OperationDiv extends Operation {
    public function getValue($num1, $num2)
    {
        // TODO: Implement getValue() method.
        try {
            if ($num2 == 0) {
                throw new Exception("除数不能为0");
            } else {
                return $num1/$num2;
            }
        } catch (Exception $e) {
            echo '错误信息:'.$e->getMessage();
        }
    }
}

class Factory {
    public static function createObj($operate) {
        switch ($operate) {
            case '+':
                return new OperationAdd();
                break;
            case '/':
                return new OperationDiv();
                break;
        }
    }
}
$test = Factory::createObj('/');
$result = $test->getValue(23, 2);
echo $result;

Factory;
/**
 * 2.1数据库工厂模式
 */

$str = <<<Db
class DbFactory {
    static function factory($dbClassName) {
        $dbClassName = strtolower($dbClassName);
        if (include_once 'Drivers/'.$dbClassName.'.php') {
            $className = 'Driver_'.$dbClassName;
            return new $className;
        } else {
            throw new Exception("error");
        }
    }
}

DbFactory::factory('mysql');
Db;
