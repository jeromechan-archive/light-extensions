<?php
/**
 * Coypright © 2013 Neilsen Chan. All rights reserved.
 * Author: chenjinlong
 * Date: 4/8/13
 * Time: 6:24 PM
 * Description: LBSOutputHandler.php
 * Reference Link: http://neilsenchan.github.io@2/28/13
 * @see LBSOutputFormatter.php LBSErrorHandler.php
 * @desc An optimize class for integrating errorHandler and outputFormatter
 */
//@TODO 待修缮关于ErrorCode的跨文件管理的问题
class LBSOutputHandler
{
    private static $_outputFormat = array(
        'success' => false,
        'errorCode' => 0,
        'errorMsg' => '',
        'data' => array(),
    );

    private static function init()
    {
        self::$_outputFormat = array(
            'success' => false,
            'errorCode' => 0,
            'errorMsg' => '',
            'data' => array(),
        );
    }

    public static function renderOutput($moduleKey, $errorCode, $responseData, $successFlag = true, $errorMsg = '')
    {
        if(!in_array($moduleKey, self::queryPresetModuleList())){
            throw new ErrorException('指定错误码模块不存在');
        }else{
            self::init();
            self::$_outputFormat['success'] = $successFlag;
            self::$_outputFormat['errorCode'] = $errorCode;
            self::$_outputFormat['errorMsg'] = self::queryErrorMessage($moduleKey, $errorCode);
            if(!empty($errorMsg)){
                self::$_outputFormat['errorMsg'] = $errorMsg;
            }/*else{
                //REF: 可以考虑引入CLASS::LBSErrorHandler
                self::$_outputFormat['errorMsg'] = self::queryErrorMessage($moduleKey, $errorCode);
            }*/
            self::$_outputFormat['data'] = $responseData;
            return self::$_outputFormat;
        }
    }

    /**
     * 查询错误码匹对的错误说明详情
     *
     * @param $errorCode
     * @param $moduleKey
     * @return mixed
     * @throws ErrorException
     */
    private static function queryErrorMessage($moduleKey, $errorCode)
    {
        if(!empty($errorCode) && !empty($moduleKey)){
            if(!empty(ErrorHandler::$_errCodeDict[$moduleKey])){
                if(array_key_exists($errorCode, ErrorHandler::$_errCodeDict[$moduleKey])){
                    return ErrorHandler::$_errCodeDict[$moduleKey][$errorCode];
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
    private static function queryPresetModuleList()
    {
        return array_keys(ErrorHandler::$_errCodeDict);
    }

    /**
     * 查询自定义预设模块的错误码序列
     *
     * @param bool $moduleKey
     * @return array
     * @throws ErrorException
     */
    private static function queryPresetErrorCodeList($moduleKey = false)
    {
        if(!$moduleKey){
            return ErrorHandler::$_errCodeDict;
        }else{
            if(!empty(ErrorHandler::$_errCodeDict[$moduleKey])){
                return ErrorHandler::$_errCodeDict[$moduleKey];
            }else{
                throw new ErrorException('指定模块不存在');
            }
        }
    }
}

/**
 * Coypright © 2013 Neilsen Chan. All rights reserved.
 * Author: chenjinlong
 * Date: 4/8/13
 * Time: 6:23 PM
 * Description: ErrorHandler.php
 * Reference Link: http://neilsenchan.github.io@2/27/13
 */
class ErrorHandler
{
    /**
     * 错误码映射字典
     *
     * @var array
     */
    public static $_errCodeDict = array(
        'MODEL-01' => array(
            '100000' => '请求正常',
            '100001' => '请求参数错误',
        ),
    );


}

