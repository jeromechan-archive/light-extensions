<?php
/**
 * LBSBenchmark
 *
 * An open source extension library for PHP 5.2.1 or newer
 *
 * @package		LBS-EXT
 * @author		Neilsen Chan
 * @date        July 6, 2013
 * @link        https://github.com/neilsenchan/lbs-ext
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc. Modified by N.Chan
 * @srcpackage	CodeIgniter.Libraries
 * @srccategory Libraries
 * @owner       ExpressionEngine Dev Team
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @link		http://codeigniter.com/user_guide/libraries/benchmark.html
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

class Core {

    /**
     * List of all benchmark markers and when they were added
     *
     * @var array
     */
    var $marker = array();

    /**
     * Whether using db storage module.
     * TRUE=using, FALSE=n/a
     *
     * @var bool
     */
    var $log_to_db = FALSE;

    /**
     * List of all database configuration info and when they were used
     *
     * @var array
     */
    var $db_config = array();

    /**
     * Initial Core Object and configuration info
     */
    function __construct()
    {
        $this->loading_config();
    }

    // --------------------------------------------------------------------

    /**
     * Set a benchmark marker
     *
     * Multiple calls to this function can be made so that several
     * execution points can be timed
     *
     * @access	public
     * @param	string	$name	name of the marker
     * @return	void
     */
    function mark($name)
    {
        $this->marker[$name] = microtime();
    }

    // --------------------------------------------------------------------

    /**
     * Calculates the time difference between two marked points.
     *
     * If the first parameter is empty this function instead returns the
     * {elapsed_time} pseudo-variable. This permits the full system
     * execution time to be shown in a template. The output class will
     * swap the real value for this variable.
     * The output time unit is second.
     *
     * @access	public
     * @param	string	a particular marked point
     * @param	string	a particular marked point
     * @param	integer	the number of decimal places
     * @return	mixed
     */
    // 剔除元支持的伪变量{elapsed_time}的使用
    // 添加入参约束，$point1与$point2为必填项目
    function elapsed_time($point1, $point2, $decimals = 4)
    {
        /*if ($point1 == '')
        {
            return '{elapsed_time}';
        }*/
        if(empty($point1) || empty($point2))
        {
            return '';
        }

        if ( ! isset($this->marker[$point1]))
        {
            return '';
        }

        if ( ! isset($this->marker[$point2]))
        {
            $this->marker[$point2] = microtime();
        }

        list($sm, $ss) = explode(' ', $this->marker[$point1]);
        list($em, $es) = explode(' ', $this->marker[$point2]);

        $time = number_format(($em + $es) - ($sm + $ss), $decimals);

        if($this->log_to_db)
        {
            $this->store_to_db($point1, $point2, $time);
        }
        else
        {
            return $time;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Memory Usage
     *
     * This function returns the {memory_usage} pseudo-variable.
     * This permits it to be put it anywhere in a template
     * without the memory being calculated until the end.
     * The output class will swap the real value for this variable.
     *
     * @access	public
     * @return	string
     */
    // 剔除元支持的伪变量{memory_usage}的使用
    function memory_usage()
    {
        //return '{memory_usage}';
        if(function_exists('memory_get_usage') && ($usage = memory_get_usage(FALSE)) != '')
        {
            return $usage . 'Bytes';
        }
        else
        {
            return 'No memory. Be sure enabling "--enable-memory-limit" option and php version is 5.2.1 or above.';
        }
    }

    function loading_config()
    {
        require_once './rules.php';
        $this->log_to_db = $db_storage;
        $this->db_config = $db_config_info;
    }

    /**
     * Benchmark Logging
     *
     * @access private
     * @param string
     * @param string
     * @param float
     * @return mixed
     *
     * @database_ref_SQL
     * CREATE TABLE `lbs_benchmark`(
     *      `id` UNSIGNED INT(10) NOT NULL AUTO_INCREMENT COMMENT 'index seq id',
     *      `start_marker` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'start marker',
     *      `end_marker` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'end marker',
     *      `elapsed_time` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'elapsed time as string format',
     *      `add_time` TIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'logging time',
     *      PRIMARY KEY (`id`)
     * ) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Benchmark logging table';
     */
    private function store_to_db($point1, $point2, $elapsedTime)
    {
        $sql = "INSERT INTO lbs_benchmark(start_marker,end_marker,elapsed_time) VALUES ('$point1','$point2','$elapsedTime')";
        return $this->mysql_insert($sql);
    }

    /**
     * 辅助函数，用于数据库连接与执行插入。
     * 亦可修订以提高sql执行效率，修订成mysqli的prepare形式
     *
     * @param string
     * @return resource
     */
    private function mysql_insert($sql)
    {
        $host_port = $this->db_config['host'] . ':' . $this->db_config['port'];
        $username = $this->db_config['username'];
        $password = $this->db_config['password'];

        $link = mysql_connect(strval($host_port), $username, $password)
                or die ('Not connected : ' . mysql_error());
        mysql_select_db('database', $link)
                or die ('Can\'t use foo : ' . mysql_error());
        return mysql_query($sql);
    }

}

// END Core class

/* End of file Core.php */
/* Location: ./LBSBenchmark/Core.php */