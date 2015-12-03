<?php

/**
 * @encoding UTF-8
 * @copyright (c) 2015 滴滴打车-运营支持
 * @license http://pay.xiaojukeji.com/
 * @version V1.0.0
 */

class util_log {
	
	//log路径
	const LOG_PATH = '/home/xiaoju/webroot/app/log/driver_task/';
	
	//public日志路径
	const PUBLIC_LOG_PATH = '/home/xiaoju/webroot/app/log/driver_task/';
	
	/**
	 * @brief public log
	 * @return obj
	 */
	public static function publicLog() {
		$logFile = self::PUBLIC_LOG_PATH . 'public.log';
		$objLogger = util_logger::pubLog($logFile);
		$objLogger->setAppName('driver_task');
		return $objLogger;
	}
	
	/**
	 * @brief 应用日志
	 * @return obj
	 */
	public static function appLog() {
		$logFile = self::LOG_PATH . date('Ymd') . '/driver_task.log';
		$objLogger = util_logger::appLog($logFile,  util_logger::DEBUG, 
						util_logger::WEB_TRACE_ON, util_logger::BACK_TRACE_ON);
		return $objLogger;
	}
	
	/**
	 * @brief 监控日志
	 * @return type
	 */
	public static function monitor() {
		$logFile = self::LOG_PATH . 'driver_task_monitor.log';
		$objLogger = util_logger::monitorLog($logFile,  util_logger::ERROR, 
						util_logger::WEB_TRACE_ON, util_logger::BACK_TRACE_ON);
		return $objLogger;
	}

}
