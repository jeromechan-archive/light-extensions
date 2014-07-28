<?php
/**
 * Copyright © 2013 NEILSEN·CHAN. All rights reserved.
 * Date: 2/11/13
 * Description: LBSUnitTest.php
 */
require_once 'config.php';
require_once __FILE__;

$LBSSuiteTestObject = new LBSSuiteTest();
$LBSSuiteTestObject->process();

class LBSSuiteTest
{
    private $_suiteArray = array();

    function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->_suiteArray['LBSArrayTest'] = array(
            //'testArrayKeysToCamelCase',
            //'testArrayKeysToUnderlineCase',
            'testDoCustomKeyForArray',
        );
        $this->_suiteArray['LBSStringTest'] = array(
            //'testUcFirstWord',
            //'testLcFirstWord',
        );
    }

    public function process()
    {
        if(!empty($this->_suiteArray) && is_array($this->_suiteArray)){
            foreach($this->_suiteArray as $className => $functionSet)
            {
                if(!empty($functionSet) && is_array($functionSet)){
                    foreach($functionSet as $functionName)
                    {
                        $response = $className::$functionName();
                        var_dump($className.'::'.$functionName, $response);
                    }
                }
            }
        }
    }

}

class LBSArrayTest
{
    public static function testArrayKeysToCamelCase()
    {
        $reqArray = array(
            'hel_YuHel' => 1,
            'Helowd_ds' => 2,
            'weAreThe_cHapter',
        );
        $respArray = LBSArray::arrayKeysToCamelCase($reqArray);
        return $respArray;
    }

    public static function testArrayKeysToUnderlineCase()
    {
        $reqArray = array(
            'helYuHel' => 1,
            'HelowdDs' => 2,
            'weAreTheChapter',
        );
        $respArray = LBSArray::arrayKeysToUnderlineCase($reqArray);
        return $respArray;
    }

    public static function testDoCustomKeyForArray()
    {
        $reqArray = array(
            array(
                1,3,5,7,9,
            ),
            array(
                array(
                    'uniqueKey' => 1,
                    'name' => 'lbsext1',
                ),
                array(
                    'uniqueKey' => 3,
                    'name' => 'lbsext3'
                ),
            ),
            array(
                array(
                    'uniqueKey' => 1,
                    'name' => 'lbsext1',
                ),
                array(
                    'uniqueKey-2' => 3,
                    'name' => 'lbsext3'
                ),
            ),
            array(
                array(
                    'uniqueKey' => 'uk1',
                    'name' => 'lbsext1',
                ),
                array(
                    'uniqueKey' => 'uk2',
                    'name' => 'lbsext3'
                ),
            ),
            array(
                array(
                    'uniqueKey' => 'uk',
                    'name' => 'lbsext1',
                ),
                array(
                    'uniqueKey' => 'uk',
                    'name' => 'lbsext3'
                ),
            ),
        );
        foreach($reqArray as $subArray)
        {
            $respArray = LBSArray::doCustomKeyForArray($subArray, 'uniqueKey');
            var_dump($respArray);
        }
    }
}

class LBSStringTest
{
    public static function testUcFirstWord()
    {
        $reqString = 'hello_worLd';
        $respArray = LBSString::ucFirstWord($reqString);
        return $respArray;
    }

    public static function testLcFirstWord()
    {
        $reqString = 'helloWorLd';
        $respArray = LBSString::lcFirstWord($reqString);
        return $respArray;
    }
}