<?php
/**
 * Class Table, 表模型父类
 * @author wangshun@diditaxi.com.cn
 */


class Db_Table
{
    /**
     * DB模型对象
     * @var object
     */
    private $db;

    /**
     * 构造器
     */
    public function __construct($databese)
    {
        $this->db = $databese;
    }

    /**
     * 执行SQL语句并返回影响的行数
     * @param string $sql
     * @return int
     * @throws Exception
     */
    public function exec($sql)
    {
        util_log::appLog()->info(__CLASS__.'::'.__FUNCTION__."(): SQL: $sql");
        $affectedRows = $this->db->exec($sql);
        //数据库错误抛出异常就好，暂时不重连
        if ($affectedRows === false) {
            $errorInfo = $this->errorInfo();
            $errorCode = $this->errorCode();
            util_log::monitor()->error(array('MONITOR_KEY'=>"database_failed",'errorCode'=>$errorCode ,'errorInfo'=>$errorInfo, 'sql'=>$sql));
            throw new Exception($errorInfo, $errorCode);
        }
        return $affectedRows;
    }

    /**
     * 执行SQL语句并返回结果集
     * @param string $sql
     * @return mixed
     * @throws Exception
     */
    public function query($sql)
    {
        util_log::appLog()->info(__CLASS__.'::'.__FUNCTION__."(): SQL: $sql");
        $statement = $this->db->query($sql);
        if (!$statement) {
            $errorInfo = $this->errorInfo();
            $errorCode = $this->errorCode();
            util_log::monitor()->error(array('MONITOR_KEY'=>"database_failed",'errorCode'=>$errorCode ,'errorInfo'=>$errorInfo, 'sql'=>$sql));

            throw new Exception($errorInfo, $errorCode);
        }

        return $statement;
    }

    /**
     * 执行SQL语句并返回已转为$class对象的所有行的数组
     * @param string $sql
     * @param string $class
     * @return mixed
     * @throws Exception
     */
    public function fetchAllObjects($sql, $class)
    {
        try {
            $statement = $this->query($sql);
        } catch (Exception $e) {
            throw $e;
        }

        $rows = $statement->fetchAll(PDO::FETCH_CLASS, $class); //如果没有记录，返回array()
        if ($rows === false) {
            $errorInfo = $this->errorInfo();
            $errorCode = $this->errorCode();
            util_log::monitor()->error(array('MONITOR_KEY'=>"database_failed",'errorCode'=>$errorCode ,'errorInfo'=>$errorInfo, 'sql'=>$sql));
            throw new Exception($errorInfo, $errorCode);
        }

        return $rows;
    }

    /**
     * 执行SQL语句并返回已转为$class对象的一行
     * @param string $sql
     * @param string $class
     * @return mixed
     * @throws Exception
     */
    public function fetchObject($sql, $class)
    {
        try {
            $statement = $this->query($sql);
        } catch (Exception $e) {
            throw $e;
        }

        return $statement->fetchObject($class);  //如果没有记录，返回false
    }

    /**
     * 执行SQL语句并获取结果集中所有行（数组）的数组
     * @param string $sql
     * @return mixed
     * @throws Exception
     */
    public function fetchAll($sql)
    {
        util_log::appLog()->info("SQL: $sql");
        try {
            $statement = $this->query($sql);
        } catch (Exception $e) {
            throw $e;
        }

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC); //如果没有记录，返回array()
        if ($rows === false) {
            $errorInfo = $this->errorInfo();
            $errorCode = $this->errorCode();
            util_log::monitor()->error(array('MONITOR_KEY'=>"database_failed",'errorCode'=>$errorCode ,'errorInfo'=>$errorInfo, 'sql'=>$sql));
            throw new Exception($errorInfo, $errorCode);
        }

        return $rows;
    }

    /**
     * 执行SQL语句并获取结果集中一行（数组）
     * @param string $sql
     * @return mixed
     * @throws Exception
     */
    public function fetch($sql)
    {
        util_log::appLog()->info("SQL: $sql");
        try {
            $statement = $this->query($sql);
        } catch (Exception $e) {
            throw $e;
        }

        return $statement->fetch(PDO::FETCH_ASSOC); //如果没有记录，返回false
    }

    /**
     * 执行SQL语句并返回结果集中一行的某一列
     * @param string $sql
     * @param int $column
     * @return mixed
     * @throws Exception
     */
    public function fetchColumn($sql, $column = 0)
    {
        util_log::appLog()->info("SQL: $sql");
        try {
            $statement = $this->query($sql);
        } catch (Exception $e) {
            throw $e;
        }

        return $statement->fetchColumn($column);  //如果没有记录，返回false
    }

    /**
     * 返回最后插入行的行ID
     * @return string
     */
    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * 获取错误码
     * @return string
     */
    public function errorCode()
    {
        $errorInfo = $this->db->errorInfo();
        return $errorInfo[1];
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function errorInfo()
    {
        return json_encode($this->db->errorInfo());
    }

    /**
     * 是否丢失连接
     * @param $errcode
     * @return bool
     */
    public function isConnectionLost()
    {
        return in_array($this->errorCode(), array(2006, 2013));
    }

}
