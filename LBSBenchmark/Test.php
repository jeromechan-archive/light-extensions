<?php
/**
 * Copyright © 2013 Neilsen Chan. All rights reserved.
 * 
 * @author chenjinlong
 * @date 7/8/13
 * @time 4:21 PM
 * @description Test.php
 */
$LBSBenchmarkObject = new Core();
// Start tracing
$LBSBenchmarkObject->mark('start_tag');

// Do something
sleep(60);

// Stop tracing
$LBSBenchmarkObject->mark('stop_tag');

// Statistic data for benchmark module
$result = $LBSBenchmarkObject->elapsed_time('start_tag', 'stop_tag');

var_dump($result);

