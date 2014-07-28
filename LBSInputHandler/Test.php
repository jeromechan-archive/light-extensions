<?php
/**
 * Coypright © 2013 Neilsen Chan. All rights reserved.
 * 
 * @author chenjinlong
 * @date 6/17/13
 * @time 9:53 AM
 * @description Test.php
 */
require_once dirname(__FILE__) . '/Core.php';
$validationObject = new Core();
$params = array(
    'key1' => 123,
    'key2' => null,
);
$validationObject->set_lang_setting('en');
$validationObject->set_validation_data($params);
//$validationObject->set_rules('key1', 'key1key1', 'required');
//$validationObject->set_rules('key2', 'key2key2', 'required');

//$validationObject->set_rules($config);

$result = $validationObject->run('demo');
$errorMsg = $validationObject->error_string();

var_dump($validationObject, $result, $errorMsg);

$arr = array(
    'key1' => array('key2-1'=>'','key2-2'=>''),
);
var_dump(array_keys($arr));
var_dump(array_key_exists('key2-1', $arr));