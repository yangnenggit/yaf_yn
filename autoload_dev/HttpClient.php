<?php
/*
 * curl 访问类
 */

class HttpClient
{
    private $url = null;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($params)
    {
        $url = $this->url . "?";
        foreach ($params as $key => $value) {
            $url .= "$key=$value&";
        }
        $ch = curl_init($this->_cutTail($url, '&'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 3000);
        curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 3000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $ret = curl_exec($ch);
        $info= curl_getinfo($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        if(!$ret){
            util_log::monitor()->error(array('MONITOR_KEY'=>"CURL_FAILED","url"=>$url,"errno"=>$errno,"error"=>$error));
        }
        curl_close($ch);
        return $ret;
    }

    public function post($post_params, $get_params = array())
    {
        $url = $this->url . "?";
        foreach ($get_params as $key => $value) {
            $url .= "$key=$value&";
        }
        $ch = curl_init($this->_cutTail($url, '&'));
        curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
        $ret = curl_exec($ch);
        $info= curl_getinfo($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        if(!$ret){
            util_log::monitor()->error(array('MONITOR_KEY'=>"CURL_FAILED","url"=>$url,"errno"=>$errno,"error"=>$error));
        }
        curl_close($ch);
        return $ret;
    }

    private function _cutTail($string, $mark)
    {
        $ret = trim($string, $mark);
        return $ret;
    }
}
