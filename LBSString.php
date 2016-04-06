<?php
/**
 * Copyright © 2013 NEILSEN·CHAN. All rights reserved.
 * Date: 2/11/13
 * Description: LBSString.php
 */
class LBSString
{
    /**
     * @static 将单词的首字母转换成大写,剔除下划线词素(首单词除外)
     * @author chenjinlong 20120822
     * @param $word 源单词字符串
     * @return string 输出单词字符串
     * @see LBSArray::arrayKeysToCamelCase
     */
    public static function ucFirstWord($word)
    {
        if(!is_string($word)){
            return $word;
        }else{
            $wordArr = explode('_',$word);
            if(!empty($wordArr)){
                $index = 0;
                foreach($wordArr as &$wd)
                {
                    if($index==0){
                        $index++;
                        continue;
                    }
                    $wd = ucfirst($wd);
                }
                $outStr = implode('',$wordArr);
                return $outStr;
            }else{
                return $word;
            }
        }
    }

    /**
     * @static 将单词的首字母转换成小写,添加下划线分割词素
     * @author chenjinlong 20120822
     * @param $word 源单词字符串
     * @return string 输出单词字符串
     * @see LBSArray::arrayKeysToUnderlineCase
     */
    public static function lcFirstWord($word)
    {
        if(!is_string($word)){
            return $word;
        }else{
            preg_match_all('/([a-z0-9_]*)([A-Z][a-z0-9_]*)?/',$word,$matches,PREG_PATTERN_ORDER);
            if(!empty($matches)){
                $strPattern1 = !empty($matches[1][0])?trim($matches[1][0]):'';
                $subMatch = array_filter($matches[2]);
                $strPattern2 = !empty($subMatch)?trim(implode('_',$subMatch)):'';
                $strPattern2 = !empty($strPattern2) && !empty($strPattern1)?'_'.$strPattern2:$strPattern2;
                $outStr = strtolower($strPattern1.$strPattern2);
            }else{
                $outStr = $word;
            }
            return $outStr;
        }
    }

    //@TODO 函数3::截取指定长度像素px的字符串

    /**
     * 日期字符串格式转化
     * INPUT:2011-09-01~2011-09-02,2011-09-13~2011-09-15,2011-09-18,2011-09-20~2011-09-23,2011-09-30
     * OUT  :2011-09-01,2011-09-02,2011-09-13,2011-09-14,2011-09-15,2011-09-18,2011-09-20,2011-09-21,2011-09-22,2011-09-23,2011-09-30
     * @param string $d_str
     * @return string
     * @author huanleG 2011-9-19
     */
    function tranDateStr($d_str){
        $o_date_arr = array_filter(array_unique(explode(',', $d_str)));
        $n_date_arr = array();
        foreach ($o_date_arr as $val) {
            $val = trim($val);
            if(strlen($val)<11){
                $n_date_arr[] = $val;
            }else{
                $_date_arr = array_filter(array_unique(explode('~', $val)));
                $f_date = trim($_date_arr[0]);//起始日期
                $t_date = trim($_date_arr[1]);//结束日期
                $f_time = strtotime($f_date);
                $dif_times = (strtotime($t_date) - $f_time)/(24*60*60);
                $n_date_arr[] = $f_date;
                for ($j=1; $j<$dif_times; $j++){
                    $date = date("Y-m-d" ,$f_time + 24*60*60*$j);
                    $n_date_arr[] = $date;
                }
                $n_date_arr[] = $t_date;
            }
        }
        return implode(',', $n_date_arr);
    }

    /**
     * 字符串截取，支持中文和其他编码
     *
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $charset 编码格式
     * @param string $suffix 截断字符串后缀
     * @return string
     */
    function substrExt($str, $start=0, $length, $charset="utf-8", $suffix="")
    {
        if(function_exists("mb_substr")){
            return mb_substr($str, $start, $length, $charset).$suffix;
        }
        elseif(function_exists('iconv_substr')){
            return iconv_substr($str,$start,$length,$charset).$suffix;
        }
        $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
        return $slice.$suffix;
    }

}
