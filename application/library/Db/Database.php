<?php
/**
 * Class Database, 数据库模型类
 * @author wangshun@diditaxi.com.cn
 */


class Db_Database extends PDO
{
    /**
     * 构造器
     * @param $dsn
     * @param $username
     * @param $password
     * @param array $options
     * @throws Exception
     */
    public function __construct(
        $dsn = "",
        $username = "",
        $password = "",
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8',
        )
    )
    {
        try {
            parent::__construct($dsn, $username, $password, $options);
        } catch (Exception $e) {
            util_log::monitor()->error(array('MONITOR_KEY'=>"database_failed","dsn"=>$dsn,"username"=>$username,"passward"=>$password));
            $url = AppConfig::ERROT_PAGE . $e->getCode();
            header('Location:'.$url);
            throw $e;
        }
    }

    /**
     * 选择数据库
     * @param string $dbname 数据库名
     */
    public function selectDB($dbname) {
        if ($this->exec("use $dbname") === false) {
            throw new Exception("use DB $dbname failed.");
        }
    }

    /**
     * 开始一个事务
     * @throws Exception
     */
    public function beginTransaction()
    {
        if (parent::beginTransaction() === false) {
            throw new Exception("start transaction failed.");
        }
    }

    /**
     * 提交一个事务
     * @throws Exception
     */
    public function commit()
    {
        if (parent::commit() === false) {
            throw new Exception("commit failed.");
        }
    }

    /**
     * 回滚一个事务
     * @throws Exception
     */
    public function rollBack()
    {
        if (parent::rollBack() === false) {
            throw new Exception("rollback failed.");
        }
    }
}
