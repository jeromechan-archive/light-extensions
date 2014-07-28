<?php
/**
 * Copyright © 2013 NEILSEN·CHAN. All rights reserved.
 * Date: 2/11/13
 * Description: test.php
 */
echo 1;
require_once 'config.php';

/*$reqArray = array(
    'helYuHel' => 1,
    'HelowdDs' => 2,
    'weAreTheChapter',
    array(1,2,3,array(1,2)),
);*/
$reqArray = array(
//    array(
//        'id' => 1,
//        'name' => 'lbsname1',
//    ),
//    array(
//        'id' => 101,
//        'name' => 'lbsname101',
//    ),
);

$repArray = LBSArray::doCustomKeyForArray($reqArray);

var_dump($reqArray, $repArray);