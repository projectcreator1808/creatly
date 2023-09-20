<?php 

define("ROOTPATH", dirname(__FILE__) . '/../..');

require_once ROOTPATH . '/includes/config.php';
require_once ROOTPATH."/install/app/helpers/common.helper.php";

class ExtraHelper
{
    private $config;

    public function __construct()
    {
        global $config;

        $this->config = $config;   
    }

    function getDbConnect()
    {
        $db_hostname = $this->config['db']['host'];
        $db_name     = $this->config['db']['name'];
        $db_username = $this->config['db']['user'];
        $db_password = $this->config['db']['pass'];
        
        $dsn = 'mysql:host='
            . $db_hostname
            . ';dbname=' . $db_name
            . ';charset=utf8';
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        
        try {
            $con = new PDO($dsn, $db_username, $db_password, $options);
        } catch (\Exception $e) {
            throw new Exception("Couldn't connect to the database!");
        }

        return $con;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getDbPrefix()
    {
        return $this->config['db']['pre'];
    }

}

abstract class ExtraManager
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new ExtraHelper();
    }
}




