<?php
	require "php_db_query.php";
	$host="localhost:3306";//数据库地址
	$db_user="root";//用户名
	$db_pwd="";//用户密码
	$db_name="php_db";//数据库名
	$db_table="users";//表名
	$aTest1=array(
		"uname"=>"小明"
	);//测试数组
	$aTest2=array(["0","小明","男","20"],
		["1","小明","男","21"],
		["2","小红","女","20"]
	);//测试数组

	$bar = "php_db_query";
	$test = new $bar($host, $db_user, $db_pwd, $db_name);
	var_dump($test->select($db_table,$aTest1));
	//var_dump($test->insert($db_table,$aTest2));
?>