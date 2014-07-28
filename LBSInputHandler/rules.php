<?php
/**
 * Copyright © 2013 NEILSEN·CHAN. All rights reserved.
 * 
 * @date: 6/13/13
 * @description: rules.php
 */
$config = array(
    'signup' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required'
        ),
    ),
    'email' => array(
        array(
            'field' => 'emailaddress',
            'label' => 'EmailAddress',
            'rules' => 'required|valid_email'
        ),
    ),
    'demo' => array(
        array(
            'field' => 'key1',
            'label' => 'key1key1',
            'rules' => 'required'
        ),
        array(
            'field' => 'key2',
            'label' => 'key2key2',
            'rules' => 'required'
        ),
    ),
);