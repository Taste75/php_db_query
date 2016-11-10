<?php
	require "php_db_query.php";
	$host="localhost:3306";//数据库地址
	$db_user="root";//用户名
	$db_pwd="";//用户密码
	$db_name="aihua";//数据库名
	$db_table="usersinfo";//表名
	$aTest=array(
		"uName"=>"小明"
	);//测试数组

	$bar = "php_db_query";
	$test = new $bar($host, $db_user, $db_pwd, $db_name);
	var_dump($test->select($db_table,$aTest));
?>