<?php
/**
 * Class YourDB, DB模型类
 * @author wangshun@diditaxi.com.cn
 */


class Db_YourDB extends Db_Database
{
    /**
     * 单例对象实例
     * @var object
     */
    private static $instance;

    /**
     * 构造器
     * @param string $dbname 数据库名
     * @throws Exception
     */
    public function __construct($config)
    {

        try {
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8');
            $dbname = SysConfig::$db_config[$config]['dbname'];
            $host   = SysConfig::$db_config[$config]['host'];
            $port   = SysConfig::$db_config[$config]['port'];
            $password = SysConfig::$db_config[$config]['password'];
            $username = SysConfig::$db_config[$config]['username'];
            parent::__construct(
                "mysql:dbname=$dbname;host=".$host.";port=".$port,
                $username,
                $password,
                $options
            );
        } catch (Exception $e) {
            util_log::monitor()->error('ERROR_DB_ORDERS: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * 获取对象实例
     * @param string $dbname
     * @return YourDB
     * @throws Exception
     */
    public static function getInstance($config = '')
    {
        if (!(self::$instance instanceof self)) {
            try {
                self::$instance = new self($config);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return self::$instance;
    }

    /**
     * 获取新的对象实例
     * @param string $dbname
     * @return YourDB
     * @throws Exception
     */
    public static function getNewInstance($config = '')
    {
        try {
            self::$instance = new self($config);
        } catch (Exception $e) {
            throw $e;
        }

        return self::$instance;
    }
}
