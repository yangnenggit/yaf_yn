<?php
/*
 *   错误信息类 所有错误信息全部收归到本类中
 *
 */

class Error
{
    /*****    错误码      *******/
    const OK                       = 0;
    const FAILED                   = -1;

    const  ACTIVITY_CLOSE          = 1000;
    const SIGN_VERIFICATION_FAILED = 1001;
    const PARAM_IS_NOT_COMPLETE    = 1002;

    /*
     * 错误code 解释
     */
    public static $hb_errmsg = array(
        self::OK                        => '成功',
        self::FAILED                    => '失败',

        self::ACTIVITY_CLOSE            => '系统关闭',

        self::PARAM_IS_NOT_COMPLETE     => '参数不全',
        self::SIGN_VERIFICATION_FAILED  => '签名验证失败',

    );

    /*
     * 返回错误代码＋错误信息 array
     * @params errno
     * @return array
     */
    public static function getErrorArray($errno)
    {
        return array('errno'=>$errno, 'errmsg'=>self::$hb_errmsg[$errno]);
    }
    /*
     * 返回错误代码＋错误信息 string
     * @params errno
     * @return string
     */
    public static function getErrorString($errno)
    {
        return json_encode(array('errno'=>$errno , 'errmsg'=>self::$hb_errmsg[$errno]));
    }
}
