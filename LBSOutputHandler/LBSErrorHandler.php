<?php
//WARNING: You can use the recommend class named LBSOutputHandler
/**
 * Copyright © 2013 NEILSEN·CHAN. All rights reserved.
 * Date: 2/27/13
 * Description: LBSErrorHandler.php
 */
class LBSErrorHandler
{
    /**
     * 错误码映射字典
     *
     * @var array
     */
    private $_errCodeDict = array(
        'Module-01' => array(
            '10001' => '执行成功',
            '10002' => '执行失败',
        ),
    );

    /**
     * 查询错误码匹对的错误说明详情
     *
     * @param $errorCode
     * @param $moduleKey
     * @return mixed
     * @throws ErrorException
     */
    public function queryErrorMessage($moduleKey, $errorCode)
    {
        if(!empty($errorCode) && !empty($moduleKey)){
            if(!empty($this->_errCodeDict[$moduleKey])){
                if(array_key_exists($errorCode, $this->_errCodeDict[$moduleKey])){
                    return $this->_errCodeDict[$moduleKey][$errorCode];
                }else{
                    throw new ErrorException('错误码信息未设定');
                }
            }else{
                throw new ErrorException('错误码映射字典设定不正确');
            }
        }else{
            throw new ErrorException('输入参数缺失');
        }
    }

    /**
     * 查询预设错误码的模块序列
     *
     * @return array
     */
    public function queryPresetModuleList()
    {
        return array_keys($this->_errCodeDict);
    }

    /**
     * 查询自定义预设模块的错误码序列
     *
     * @param bool $moduleKey
     * @return array
     * @throws ErrorException
     */
    public function queryPresetErrorCodeList($moduleKey = false)
    {
        if(!$moduleKey){
            return $this->_errCodeDict;
        }else{
            if(!empty($this->_errCodeDict[$moduleKey])){
                return $this->_errCodeDict[$moduleKey];
            }else{
                throw new ErrorException('指定模块不存在');
            }
        }
    }

}
