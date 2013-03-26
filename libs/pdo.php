<?php
/*=============================================================================
#     FileName: pdo.php
#   CreateTime: 2013-03-25 13:53:53 
#       Author: yifeng@leju.com
#   LastChange: 2013-03-25 13:53:53
=============================================================================*/
class pdomysql
{
    public static $dbtype  = 'mysql';
    public static $dbhost  = '';
    public static $dbport  = '';
    public static $dbname  = '';
    public static $dbuser  = '';
    public static $dbpass  = '';
    public static $charset = '';
    public static $dblink  = null;

    /**
     * 构造函数
     */
    public function __construct() 
    {
        self::$dbtype = 'mysql';
        self::$dbhost = 'localhost';
        self::$dbport = '3306';
        self::$dbname = 'NetCircle';
        self::$dbuser = 'root';
        self::$dbpass = '123456';
        self::$charset = 'utf8';
        self::connect ();
    }

    /**
     * 作用:连結数据库
     */
    public function connect() 
    {
        try
        {
           self::$dblink = new PDO( self::$dbtype.':host='.self::$dbhost.';port='. self::$dbport.';dbname='.self::$dbname,self::$dbuser,self::$dbpass);
        }
        catch(PDOException $e)
        {
            die( "Error Message:" . $e->getMessage ());
        }
    }

    /**
     * 关闭数据连接
     */
    public function close() 
    {
        self::$link= null;
    }
}

$pdo = new pdomysql();

var_dump($pdo);

?>
