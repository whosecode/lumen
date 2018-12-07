<?php

/**
 * 字符串助手类
 *
 * @author cuijiji
 * @date 2018/10/17
 */

namespace Services\Helper;

class StringHelper
{
    /**
     * 加密手机，将手机中间4位替换为****
     *
     * @param $phone 11位手机号
     *
     * @return mixed
     */
    public static function encryptPhone($phone)
    {
        return substr_replace($phone, '****', 3, 4);
    }


    /**
     * php防注入函数,字符过滤函数
     * @author cuijiji
     * @param $str
     * @return mixed|void
     */
    public static function htmldecode($str)
    {
        if(empty($str)) return $str;
        if($str==="") return $str;
        $str=str_replace("select","select",$str);
        $str=str_replace("join","join",$str);
        $str=str_replace("union","union",$str);
        $str=str_replace("where","where",$str);
        $str=str_replace("insert","insert",$str);
        $str=str_replace("delete","delete",$str);
        $str=str_replace("update","update",$str);
        $str=str_replace("like","like",$str);
        $str=str_replace("drop","drop",$str);
        $str=str_replace("create","create",$str);
        $str=str_replace("modify","modify",$str);
        $str=str_replace("rename","rename",$str);
        $str=str_replace("alter","alter",$str);
        $str=str_replace("cas","cast",$str);
        $str=str_replace("&","&",$str);
        $str=str_replace(">",">",$str);
        $str=str_replace("<","<",$str);
        $str=str_replace(" ",chr(32),$str);
        $str=str_replace(" ",chr(9),$str);
        $str=str_replace("&",chr(34),$str);
        $str=str_replace("'",chr(39),$str);
        $str=str_replace("<br />",chr(13),$str);
        $str=str_replace("''","'",$str);
        return $str;
    }

    /**
     * 从 UTF-8 转化为 GB18030 编码
     *
     * @return string
     */
    public static function convert2GB18030($sIn)
    {
        $sRet = iconv('UTF-8', 'GB18030//IGNORE', $sIn);
        if (false === $sRet) {
            $sRet = iconv('UTF-8', 'GB18030//IGNORE', self::filterErrorCode($sIn, 'UTF-8'));
        }
        return $sRet;
    }

    private static function convertCharset($sCharset)
    {
        if (in_array(strtolower($sCharset), ['gb18030', 'gb2312', 'gbk'], true)) {
            return 'GB18030';
        }
        return 'UTF8';
    }

    /**
     * 过滤掉不符合 utf-8/gb18030 规范的字符
     *
     * @return string
     */
    public static function filterErrorCode($sIn, $sCharset = '', $sMode = '')
    {
        $charset = self::convertCharset($sCharset);
        if ('UTF8' === $charset) {
            $sMode = strtolower($sMode);
            switch ($sMode) {
                case 'strict':
                case 'xml':
                    $charset = ucfirst($charset);
                    break;
                default:
                    break;
            }
        }
        $fn = 'SFilterErrorCode_'.$charset;
        return self::$fn($sIn);
    }

    /**
     * 无论输入是utf-8还是gb18030，都返回utf8
     * 由于要进行字符检查，在已知输入的字符集的时候，应该使用 SConvert2UTF8
     *
     * @return string
     */
    public static function force2UTF8($sIn)
    {
        return self::isUtf8($sIn)
            ? $sIn
            : self::convert2UTF8($sIn);
    }

    /**
     * 从 GB18030 转化为 UTF-8 编码
     *
     * @return string
     */
    public static function convert2UTF8($sIn)
    {
        $sRet = iconv('GB18030', 'UTF-8//IGNORE', $sIn);
        if (false === $sRet) {
            $sRet = iconv('GB18030', 'UTF-8//IGNORE', self::filterErrorCode($sIn, 'GB18030'));
        }
        return $sRet;
    }

    /**
     * 判断字符串是utf-8编码还是gb18030编码
     *
     * @return boolean
     */
    public static function isUtf8($sIn)
    {
        $onlyAscii = true;
        $onlyUtf8 = false;
        $iLen = strlen($sIn);
        for ($i=0; $i<$iLen; $i++) {
            $c0 = ord($sIn[$i]);
            if ($c0 < 0x80) {
                continue;
            } else if (self::checkMultiByteUTF8($sIn, $i, $c0, $iLen, $j)) {
                $i += $j - 1;
                $onlyAscii = false;
                if ($j > 2) {
                    $onlyUtf8 = true;
                }
                continue;
            }
            return false;
        }

        if ($onlyAscii) {
            return false;
        }
        if ($onlyUtf8) {
            return true;
        }

        for ($i=0; $i<$iLen; $i++) {
            $c0 = ord($sIn[$i]);
            if ($c0 >= 0x80) {
                $j = 2;
                if (self::checkSecondByteGB18030($sIn, $i, $iLen, $j)) {
                    if ($j != 2) {
                        return false;
                    }
                    $i += $j - 1;
                    continue;
                }
                return true;
            }
        }
        return false;
    }


    private static function checkMultiByteUTF8($sIn, $i, $c0, $iLen, &$j)
    {
        if (0xC0 <= $c0 && $c0 <= 0xFD) {
            if ($c0 >= 0xFC)       $j = 6;
            else if ($c0 >= 0xF8)  $j = 5;
            else if ($c0 >= 0xF0)  $j = 4;
            else if ($c0 >= 0xE0)  $j = 3;
            else                   $j = 2;
            if ($i + $j <= $iLen) {
                return self::checkSecondByteUTF8($sIn, $i, $iLen, $j);
            }
        }
        return false;
    }

    private static function checkSecondByteGB18030($sIn, $i, $iLen, &$j)
    {
        $c1 = ord($sIn[$i+1]);
        if ((0x40 <= $c1 && $c1 <= 0x7E) || (0x80 <= $c1 && $c1 <= 0xFE)) {
            return true;
        }
        else if (0x30 <= $c1 && $c1 <= 0x39) {
            $j = 4;
            if ($i + $j <= $iLen) {
                $c2 = ord($sIn[$i+2]);
                $c3 = ord($sIn[$i+3]);
                if (0x81 <= $c2 && $c2 <= 0xFE && 0x30 <= $c3 && $c3 <= 0x39) {
                    return true;
                }
            }
        }
        return false;
    }

    private static function checkSecondByteUTF8($sIn, $i, $iLen, &$j)
    {
        for ($k=1; $k<$j; $k++) {
            $ck = ord($sIn[$i + $k]);
            if (0x80 <= $ck && $ck <= 0xBF) {
                continue;
            }
            break;
        }
        if ($k === $j) {
            return true;
        }
        return false;
    }

    public static function wordReplace($content)
    {
        $content = self::force2UTF8($content);
        $fliter = array('[',']','【','】');
        $to = array('(',')','(',')');
        $content = str_replace($fliter, $to, $content);
        return $content;
    }

}