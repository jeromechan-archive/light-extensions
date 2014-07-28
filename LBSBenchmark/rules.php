<?php
/**
 * Copyright © 2013 Neilsen Chan. All rights reserved.
 * 
 * @author chenjinlong
 * @date 7/8/13
 * @time 4:21 PM
 * @description rules.php
 */

/**
 * Logging into database.
 * This is the open flag for module,
 * TRUE=database, FALSE=output stream by return.
 */
$db_storage = FALSE;

/**
 * List of database configuration info
 */
$db_config_info = array(
    'host' => '',
    'port' => '',
    'database' => '',

    'username' => '',
    'password' => '',
);