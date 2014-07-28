<?php
/**
 * Coypright © 2013 Neilsen Chan. All rights reserved.
 * Author: chenjinlong
 * Date: 3/30/13
 * Time: 4:26 PM
 * Description: LBSJson.php
 */ 
class LBSJson 
{
    /**
     * 整理JSON字符串的呈现形式，使之可视化更佳
     *
     * @author chenjinlong 20130329
     * @param $json
     * @return string
     */
    public static function tidyJsonFormat($json)
    {
        $tab = "  ";
        $newJson = "";
        $indentLevel = 0;
        $inString = false;

        $len = strlen($json);

        for($c = 0; $c < $len; $c++) {
            $char = $json[$c];
            switch($char) {
                case '{':
                case '[':
                    if(!$inString) {
                        $newJson .= $char . "\n" . str_repeat($tab, $indentLevel+1);
                        $indentLevel++;
                    } else {
                        $newJson .= $char;
                    }
                    break;
                case '}':
                case ']':
                    if(!$inString) {
                        $indentLevel--;
                        $newJson .= "\n" . str_repeat($tab, $indentLevel) . $char;
                    } else {
                        $newJson .= $char;
                    }
                    break;
                case ',':
                    if(!$inString) {
                        $newJson .= ",\n" . str_repeat($tab, $indentLevel);
                    } else {
                        $newJson .= $char;
                    }
                    break;
                case ':':
                    if(!$inString) {
                        $newJson .= ": ";
                    } else {
                        $newJson .= $char;
                    }
                    break;
                case '"':
                    if($c > 0 && $json[$c-1] != '\\') {
                        $inString = !$inString;
                    }
                default:
                    $newJson .= $char;
                    break;
            }
        }

        return $newJson;
    }

}
