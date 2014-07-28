<?php
//WARNING: You can use the recommend class named LBSOutputHandler
/**
 * Copyright © 2013 NEILSEN·CHAN. All rights reserved.
 * Date: 2/28/13
 * Description: LBSOutputFormatter.php
 */
class LBSOutputFormatter
{
    private $_successFlag;

    private $_errorCode;

    private $_errorMessage;

    private $_responseData;

    private static $_outputFormat = array(
        'success' => false,
        'errorCode' => 10001,
        'errorMsg' => '执行成功',
        'responseData' => array(),
    );

    public static function renderOutput($successFlag, $errorCode, $responseData, $errorMsg = '')
    {
        self::$_outputFormat['success'] = $successFlag;
        self::$_outputFormat['errorCode'] = $errorCode;
        if(!empty($errorMsg)){
            self::$_outputFormat['errorMsg'] = $errorMsg;
        }else{
            //REF: 可以考虑引入CLASS::LBSErrorHandler
            self::$_outputFormat['errorMsg'] = '';
        }
        self::$_outputFormat['responseData'] = $responseData;
        return self::$_outputFormat;
    }

}
