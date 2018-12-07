<?php

/**
 * 其他工具类
 *
 * @author cuijiji
 * @date 2018/10/17
 */

namespace Services\Helper;

class UtilHelper
{
    /**
     * Close the parent window
     *
     * @param string $msg
     *
     * @return string
     */
    public static function closeParentLayer($msg = '')
    {
        $script = '<script>';
        $script .= 'var index = parent.layer.getFrameIndex(window.name);';
        if (is_string($msg) && $msg !== '') {
            $script .= "parent.layer.msg('{$msg}');";
        }
        $script .= "parent.setTimeout(function(){parent.layer.close(index);}, 1000);";
        $script .= "parent.window.location.reload();";
        $script .= '</script>';
        return $script;
    }

    /*
   * 得到ip
   * @return ip
   */
    public static function getIp()
    {

        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
            $ip = getenv("REMOTE_ADDR");
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "0.0.0.0";
        }
        if ( $ip != "0.0.0.0") {
            $ipArr = explode(',', $ip);
            $ip = trim($ipArr[0]);
        }
        return $ip;
    }

    /**
     * 获取二维数组中的某一个字段数据(返回一位数组)
     *
     * @param Array $data 数据
     * @param String $fieldKey 字段名
     * @return Array
     */
    public static function getFieldData($data, $fieldKey)
    {
        return array_map(create_function('$v', 'return $v["' . $fieldKey . '"];'), $data);
    }

    /**
     * 检查手机号格式是否正确
     * @param int/str $intMobileNum 手机号
     * @return bool true-正确 / false-错误
     */
    public static function checkMobileNum($intMobileNum)
    {
        return (bool)preg_match('/^(13[0-9]|18[0-9]|15[0-3]|15[5-9]|14[57]|17[06-8])\d{8}$/', $intMobileNum);
    }

    /**
     * 检查电子邮件格式是否正确
     * @param str $str 邮件地址
     * @return bool true-正确 / false-错误
     */
    public static function checkEmailFormat($str)
    {
        $regExp = '/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i';
        return preg_match($regExp, $str);
    }

    /**
     * 生成表单签名
     * @param int $intUid
     * @return str 签名字符串
     */
    public static function genFormSign($intUid)
    {
        $str = 'v1I'.$intUid.'I'.(time()/3600);
        return string::encrypt($str, 'formsign');
    }

    /**
     * 验证表单签名
     * @param int $intUid
     * @param str 签名字符串
     * @return bool 是否正确
     */
    public static function checkFormSign($intUid, $strFormSign)
    {
        $str = string::decrypt($strFormSign, 'formsign');
        $arr = explode('I', $str);
        if ($arr && $arr[1] == $intUid && (time()/3600)-$arr[2]<168) {
            return true;
        }
        return false;
    }

    /**
     * 替换字符串数组中可能的sql
     * @param arr $arrStr
     * @return arr 替换后的数组
     */
    public static function replaceSql(array $arrStr)
    {
        if (!$arrStr) {
            return $arrStr;
        }
        $arrIsArrKey = array();
        foreach ($arrStr as $k => &$v) {
            if (!is_array($v)) {
                continue;
            }
            $arrIsArrKey[] = $k;
            $v = json_encode($v);
        }
        $pattern = array(
            '/select[\s]+(.+\s)?(from\s|sleep)/i',
            '/update[\s]+(.+\s)?[a-zA-Z0-9-_]+\s+set\s/i',
            '/insert[\s]+(.+\s)?[a-zA-Z0-9-_]+\s+set\s/i',
            '/insert[\s]+(.+\s)?[a-zA-Z0-9-_]+\s*(\(.+\))?\s+values\s/i',
            '/delete[\s]+(.+\s)?from\s+[a-zA-Z0-9-_]+/i',
        );
        $replace = array('_$0', '_$0', '_$0', '_$0', '_$0');
        $result = preg_replace($pattern, $replace, $arrStr);
        if ($arrIsArrKey) {
            foreach ($arrIsArrKey as $isArrKey) {
                $result[$isArrKey] = json_decode($result[$isArrKey], true);
            }
        }
        return $result;
    }
}