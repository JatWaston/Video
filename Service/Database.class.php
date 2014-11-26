<?php

require_once("./database.config.php");

/**
* 
*/
class Database
{
	private $host;
	private $database;
	private $user;
	private $pwd;
	private $charset;

	private static $_instance = null;

	public static function getInstance()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __clone() {} //禁止clone
	
	private function __construct()
	{
		$connect = mysql_connect(DBHOST . ":" . DBPORT,DBUSER,DBPWD) or die('connect error:'. mysql_error());
		mysql_select_db(DBNAME,$connect) or die('select db error:'. mysql_error());
		$sql = "set names " . DBCHARSET;
		mysql_query($sql) or die('set charset error:'. mysql_error());
		//echo "mysql_connect success!" . '<br />';
	}

	public function query($sql)
	{
		$result = mysql_query($sql);// or die('query error:' . mysql_error());
		return $result;
	}

	public function fetch_array($sql)
	{
		$result = mysql_query($sql) or die('fetch_array error:' . mysql_error());
		$result_array = mysql_fetch_array($result);
		return $result_array;
	}

	public function fetch_obj_arr($sql)
	{
		$obj_arr = array();
		$result = $this->query($sql);
		//@用来屏蔽错误信息
		//mysql_fetch_object() 与 mysql_fetch_array() 类似，
		//只有一点区别 - 返回的是对象而不是数组。间接地，也意味着只能通过字段名来访问数组，而不是偏移量。
		while ($row = mysql_fetch_object($result)) 
		{
			$obj_arr[] = $row;
		}
		return $obj_arr;
	}

	public function fetch_obj($result)
	{
		return mysql_fetch_object($result);
	}
}

?>