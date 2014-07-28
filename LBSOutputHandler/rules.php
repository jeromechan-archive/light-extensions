<?php
/**
 * Coypright © 2013 Neilsen Chan All rights reserved.
 * 
 * @author chenjinlong
 * @date 6/17/13
 * @time 4:14 PM
 * @description rules.php
 */
$config = array(
    'demo' => array(
        array(
            'field' => 'key1',
            'rules' => 'required'
        ),
        array(
            'field' => 'key2',
            'rules' => 'required|object|array|int|string|bool|numeric'
        ),
        array(
            'field' => 'key3.key3-1.key3-2',
            'rules' => 'required'
        ),
        array(
            'field' => 'ALL.key4-1.key4-2',
            'rules' => 'required'
        ),
    ),
);