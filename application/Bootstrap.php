<?php

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf\Bootstrap_Abstract{

    /*
     * 加载配置文件
     */
    public function _initConfig()
    {
        Yaf\Dispatcher::getInstance()->autoRender(FALSE);  // 关闭自动加载模板
    }

    /*
     *  注册本地命名空间
     */
    public function _ininLoader()
    {
        Yaf\Loader::getInstance()->registerLocalNamespace(array("Db", "App"));
    }

    /*
     * 自动加载类 包括 log config curl sign
     *
     */
    public function _initAddConfig()
    {
        if('development' == ENVIRONMENT){
            require_once __DIR__ . '/../autoload_dev/autoload_real.php';
        }else{
            require_once __DIR__ . '/../autoload/autoload_real.php';
        }
        ComposerAutoloaderInitWrapper::getLoader();

    }

    /*
     *  注册表 注意要先加载
     */
    public function _initRegistry()
    {

        $dsn = "mysql:dbname=".SysConfig::$db_config['default']['dbname'].";host=".SysConfig::$db_config['default']['host'].";port=".SysConfig::$db_config['default']['port'];
        $username = SysConfig::$db_config['default']['username'];
        $password = SysConfig::$db_config['default']['password'];
        $db = new Db_Database($dsn, $username, $password);
        Yaf\Registry::set('db', $db);

        $dsn = "mysql:dbname=".SysConfig::$db_config['driver_task_pool']['dbname'].";host=".SysConfig::$db_config['driver_task_pool']['host'].";port=".SysConfig::$db_config['driver_task_pool']['port'];
        $username = SysConfig::$db_config['driver_task_pool']['username'];
        $password = SysConfig::$db_config['driver_task_pool']['password'];
        $driver_task_pool = new Db_Database($dsn, $username, $password);
        Yaf\Registry::set('driver_task_pool', $driver_task_pool);


    }






}
