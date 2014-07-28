<?php
/**
 * Coypright © 2013 Neilsen Chan All rights reserved.
 * 
 * @author chenjinlong
 * @date 6/17/13
 * @time 4:13 PM
 * @description Test.php
 */
require_once dirname(__FILE__) . '/Core.php';

$coreObject = new Core();

$row = array(
    'fields' => 'key1-1.key1-2',
    'rules' => 'bool',
    'dimensions' => 2,
    'fields_split' => array(
        'key1-1',
        'key1-2',
    ),
);
$row2 = array(
    'fields' => 'key3-1.ALL.key2',
    'rules' => 'int',
    'dimensions' => 3,
    'fields_split' => array(
        'key3-1',
        'ALL',
        'key2',
    ),
);
$formatData = array(
    'key1-1' => array(
        'key1-2' => '1900',
        'key1-2-1' => 'demo1',
    ),
    'key2-1' => 39000,
    'key3-1' => array(
        array(
            'key1' => 1,
            'key2' => '2',
        ),
        array(
            'key1' => 3,
            'key2' => '0',
        ),
    ),
);
$coreObject->_execute($row2, $formatData);
$result = $coreObject->_finalize_data;
var_dump($result);
