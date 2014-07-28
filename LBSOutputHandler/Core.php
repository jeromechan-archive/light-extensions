<?php
/**
 * LBSOutputHandler
 *
 * An open source extension library for PHP 5.1.6 or newer
 *
 * Copyright © 2013 Neilsen Chan All rights reserved.
 *
 * @package	LBS-EXT
 * @author  chenjinlong
 * @date    June 17, 2013
 * @link    https://github.com/neilsenchan/lbs-ext
 * @license	http://www.gnu.org/licenses/gpl.html
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

//--------------------------------------------------------------
class Core 
{
    protected $_field_data			= array();
    protected $_config_rules		= array();
    protected $_format_data         = array();
    public $_finalize_data       = array();

    public function __construct($rules = array())
    {
        $this->_config_rules = $rules;

        // Set the character encoding in MB.
        if (function_exists('mb_internal_encoding'))
        {
            mb_internal_encoding('UTF-8');
        }
    }

    /**
     * Set format Data
     *
     * @access public
     * @param  mixed
     * @return void
     */
    public function set_format_data($params)
    {
        $this->_format_data = $params;
    }

    /**
     * Set Config Rules Group
     *
     * @access protected
     * @return void
     */
    protected function _set_config_rules()
    {
        if(count($this->_config_rules) == 0)
        {
            require_once dirname(__FILE__) . '/rules.php';
            $this->_config_rules = $config;
        }
    }

    /**
     * Set Rules
     *
     * This function takes an array of field names and validation
     * rules as input, validates the info, and stores it
     *
     * @access	public
     * @param	mixed
     * @param   string
     * @return	void
     */
    public function set_rules($field, $rules = '')
    {
        if(count($this->_format_data) == 0)
        {
            return $this;
        }
        if(is_array($field))
        {
            foreach($field as $row)
            {
                if ( ! isset($row['field']) OR ! isset($row['rules']))
                {
                    continue;
                }
                $this->set_rules($row['field'], $row['rules']);
            }
            return $this;
        }
        if ( ! is_string($field) OR  ! is_string($rules) OR $field == '')
        {
            return $this;
        }

        //按序切分规则字段
        $fieldsSplit = explode('.', $field);

        $this->_field_data[$field] = array(
            'field'				=> $field,
            'rules'				=> $rules,
            'dimensions'        => count($fieldsSplit),
            'fields_split'      => $fieldsSplit,
        );
    }

    /**
     * Run the Validator
     *
     * This function does all the work.
     *
     * @access	public
     * @param   mixed
     * @return	bool
     */
    public function run($group = '')
    {
        if (count($this->_format_data) == 0)
        {
            return FALSE;
        }
        if (count($this->_field_data) == 0)
        {
            // Run the Setter for Config Rules
            $this->_set_config_rules();

            // No validation rules?  We're done...
            if (count($this->_config_rules) == 0)
            {
                return FALSE;
            }

            $uri = $group;

            if ($uri != '' AND isset($this->_config_rules[$uri]))
            {
                $this->set_rules($this->_config_rules[$uri]);
            }
            else
            {
                $this->set_rules($this->_config_rules);
            }

            // We're we able to set the rules correctly?
            if (count($this->_field_data) == 0)
            {
                //log_message('debug', "Unable to find validation rules");
                return FALSE;
            }
        }
        foreach ($this->_field_data as $field => $row)
        {
            $this->_execute($row, $this->_format_data);
        }

        return $this->_finalize_data;
    }

    //$row = array('fields'=>'key1.ALL.key1-3','rules'=>'int','dimensions'=>3,'fiels_split'=>array('key1','ALL','key1-3'),)
    //$format_data = array(...)
    public function _execute(& $row, & $format_data)
    {
        $fields = $row['fields'];
        $rules = 'to_' . strtolower($row['rules']);
        $dimensions = $row['dimensions'];
        $fieldsSplit = $row['fields_split'];

        if($row['dimensions'] == 0 || (count($fieldsSplit) == 0))
        {
            return;
        }
        $row['dimensions'] -= 1;

        foreach($fieldsSplit as $key => $val)
        {
            $row['fields_split'] = array_slice($row['fields_split'], $key+1);

            if($val == 'ALL')
            {
                // Store temp row currently
                $row_for_all = $row;

                foreach($format_data as $fkey => & $fval)
                {
                    $this->_execute($row, $fval);

                    //Restore temp row when the loop returns
                    $row = $row_for_all;
                }
            }
            else
            {
                if(!is_array($format_data[$val]))
                {
                    $format_data[$val] = $this->$rules($format_data[$val]);
                }
                else
                {
                    $this->_execute($row, $format_data[$val]);
                }
            }
            break;
        }
        $this->_finalize_data = $format_data;
    }

    /**
     * Returns an Integer Digit
     *
     * @param $digit
     * @return int
     */
    public function to_int($digit)
    {
        return intval($digit);
    }

    /**
     * Returns a Boolean
     *
     * @param $param
     * @return bool
     */
    public function to_bool($param)
    {
        if(intval($param) > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Returns an Array
     *
     * @param $param
     * @return array
     */
    public function to_array($param)
    {
        return (array)$param;
    }

    /**
     * Returns a String
     *
     * @param $param
     * @return string
     */
    public function to_string($param)
    {
        return strval($param);
    }

    /**
     * Returns a Float Digit
     *
     * @param $param
     * @return float
     */
    public function to_float($param)
    {
        return floatval($param);
    }

    /**
     * Returns a Json String
     *
     * @param $param
     * @return string
     */
    public function to_json($param)
    {
        return json_encode($param);
    }

}
