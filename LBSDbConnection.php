<?php
/**
 * Copyright © 2013 NEILSEN·CHAN. All rights reserved.
 * Date: 2/27/13
 * Description: LBSDbConnection.php
 * 备注：适合当前php中常用的PDO访问持久层方式
 */
class LBSDbConnection
{
    private $_pdoClass;

    private $_connectionString;

    private $_username;

    private $_password;

    private $_attributes = array();

    private $_pdo;

    private $_active;

    private $_emulatePrepare;

    private $_charset;

    public function __construct($dsn='',$username='',$password='')
    {
        $this->_connectionString=$dsn;
        $this->_username=$username;
        $this->_password=$password;
    }

    public function getServerVersion()
    {
        return $this->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    public function getAttribute($name)
    {
        $this->setActive(true);
        return $this->_pdo->getAttribute($name);
    }

    public function setAttribute($name,$value)
    {
        if($this->_pdo instanceof PDO)
            $this->_pdo->setAttribute($name,$value);
        else
            $this->_attributes[$name]=$value;
    }

    public function getAttributes()
    {
        return $this->_attributes;
    }

    public function getActive()
    {
        return $this->_active;
    }

    public function setActive($value)
    {
        if($value!=$this->_active)
        {
            if($value)
                $this->open();
            else
                $this->close();
        }
    }

    public function open()
    {
        if($this->_pdo === null){
            $this->getPDOInstance();
        }
    }

    public function close()
    {
        $this->_pdo=null;
        $this->_active=false;
    }

    protected function getPDOInstance()
    {
        if(empty($this->_connectionString)){
            throw new PDOException('connectionString cannot be empty.');
        }else{
            if($this->_pdo instanceof PDO){
                return $this->_pdo;
            }else{
                $this->_pdo = $this->_createPDOInstance();
                $this->_initConnection();
                $this->_active=true;

                return $this->_pdo;
            }
        }
    }

    protected function _createPDOInstance()
    {
        $pos = strpos($this->_connectionString, ':');
        if($pos > 0){
            $driverStr = substr($this->_connectionString, 0, $pos);
            if($driverStr == 'mysql' || $driverStr == 'dblib' || $driverStr == 'sqlsrv')
                $this->_pdoClass = 'PDO';
            else
                throw new PDOException('Incorrect driver exists.');
        }
        return new $this->_pdoClass($this->_connectionString, $this->_username, $this->_password, $this->_attributes);
    }

    protected function _initConnection()
    {
        if(!$this->_pdo instanceof PDO){
            $this->_pdo = $this->_createPDOInstance();
            $this->_initConnection();
        }else{
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($this->_emulatePrepare!==null && constant('PDO::ATTR_EMULATE_PREPARES'))
                $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,$this->_emulatePrepare);
            if($this->_charset!==null)
            {
                $driver=strtolower($this->_pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
                if(in_array($driver,array('pgsql','mysql','mysqli')))
                    $this->_pdo->exec('SET NAMES '.$this->_pdo->quote($this->_charset));
            }
        }
    }

}
