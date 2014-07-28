<?php
/**
 * Copyright © 2013 NEILSEN·CHAN. All rights reserved.
 * Date: 2/11/13
 * Description: LBSArray.php
 */
class LBSArray
{
    /**
     * 数组键名翻译成驼峰写法
     * @author chenjinlong 20120822
     * @param $in 源数组
     * @return array 输出数组
     */
    public function arrayKeysToCamelCase($in)
    {
        if(empty($in)||!is_array($in))
            return $in;
        $reCopyRes = array();
        foreach($in as $key=>$val)
        {
            $reKey = LBSString::ucFirstWord($key);
            if(!is_array($val)){
                $reCopyRes[$reKey] = $val;
            }else{
                $reCopyRes[$reKey] = self::arrayKeysToCamelCase($val);
            }
        }
        return $reCopyRes;
    }

    /**
     * 数组键名翻译成下划线写法
     * @author chenjinlong 20120822
     * @param $in 源数组
     * @return array 输出数组
     */
    public function arrayKeysToUnderlineCase($in)
    {
        if(empty($in)||!is_array($in))
            return $in;
        $reCopyRes = array();
        foreach($in as $key=>$val)
        {
            $reKey = LBSString::lcFirstWord($key);
            if(!is_array($val)){
                $reCopyRes[$reKey] = $val;
            }else{
                $reCopyRes[$reKey] = self::arrayKeysToUnderlineCase($val);
            }
        }
        return $reCopyRes;
    }

    /**
     * 自定义数组键值为指定唯一键的数值(暂仅支持二维数组)
     * @author chenjinlong 20130211
     * @param $srcArray
     * @param string $keyStr
     * @return array
     * @throws ErrorException
     */
    public function doCustomKeyForArray($srcArray, $keyStr = 'id')
    {
        $keyStr = strval($keyStr);
        if(!empty($srcArray) && is_array($srcArray) && !empty($keyStr)){
            $respArray = array();
            foreach($srcArray as $item)
            {
                $respArray[$item[$keyStr]] = $item;
            }
            return $respArray;
        }else{
            throw new ErrorException('input parameter must be a not-empty array, and key string can not be empty value', 500);
        }
    }

    /**
     * @TODO 计算数组维数
     * @author chenjinlong 20130211
     * @param $srcArray
     * @return int
     * @throws ErrorException
     */
    public function countArrayAxis($srcArray)
    {
        //if(is_array($srcArray)){
        //    if(!empty($srcArray)){
        //        if(count($srcArray, COUNT_RECURSIVE) > count($srcArray, 0)){
        //
        //        }return true;
        //    }else{
        //        return 1;
        //    }
        //}else{
        //    throw new ErrorException('input parameter must be an not-empty array with 2-axises',000000);
        //}
        if(count($srcArray) == count($srcArray, COUNT_RECURSIVE)){
            return 1;
        }else{
            return 'multidimensions';
        }
    }

    /**
     * 按照键值映射关系过滤二维数组数据
     *
     * @author chenjinlong 20130220
     * @param $srcArray
     * @param $mapping
     * @return array
     */
    public function filterFields($srcArray, $mapping)
    {
        if(!empty($srcArray) && is_array($srcArray) && is_array($mapping) && !empty($mapping)){
            $tgtArray = array();
            foreach($srcArray as $elem)
            {
                $tmpArr = array();
                foreach($mapping as $k => $v)
                {
                    $tmpArr[$v] = $elem[$k];
                }
                $tgtArray[] = $tmpArr;
            }
            return $tgtArray;
        }else{
            return array();
        }
    }

}
