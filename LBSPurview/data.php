<?php
/**
 * Copyright © 2013 Neilsen-Chan. All rights reserved.
 * 
 * @author chenjinlong
 * @date 13-8-8
 * @time 下午12:08
 * @description 数据分离思路
 */

/**
 * visitor
 */
$tbl_user = array(
    array(
        'user_id' => 1,
        'username' => 'user_01',
        'group_id' => array(1,2,),
    ),
    array(
        'user_id' => 2,
        'username' => 'user_02',
        'group_id' => array(1,2,),
    ),
    array(
        'user_id' => 3,
        'username' => 'user_03',
        'group_id' => array(1,2,),
    ),
);

/**
 * group
 */
$tbl_group = array(
    array(
        'group_id' => 0,
        'groupname' => 'default',
    ),
    array(
        'group_id' => 1,
        'groupname' => 'root',
    ),
    array(
        'group_id' => 2,
        'groupname' => 'admin',
    ),
);

/**
 * action purview
 * @note r=4,w=2,x=1
 */
$tbl_action = array(
    array(
        'act_id' => 1,
        'act_path' => 'action/act_01',
        //'v_pur' => '7',
        'g_pur' => '7',
        'na_pur' => '0',
    ),
    array(
        'act_id' => 2,
        'act_path' => 'action/act_02',
        //'v_pur' => '6',
        'g_pur' => '6',
        'na_pur' => '2',
    ),
    array(
        'act_id' => 3,
        'act_path' => 'action/act_03',
        //'v_pur' => '3',
        'g_pur' => '3',
        'na_pur' => '1',
    ),
);

/**
 * rel bw action and group
 */
$tbl_act_rel_group = array(
    array(
        'act_id' => 1,
        'group_id' => '1',
    ),
    array(
        'act_id' => 2,
        'group_id' => '2',
    ),
    array(
        'act_id' => 3,
        'group_id' => '3',
    ),
);