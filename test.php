<?php
	require "db_query.php";
	$host="localhost:3306";//数据库地址
	$db_user="root";//用户名
	$db_pwd="";//用户密码
	$db_name="php_db";//数据库名
	$db_table="users";//表名
	$aTest1=array(
		"uname"=>"小明"
	);//测试数组

	$aTest2=array(
		["3","小李","男","20"],
		["4","小工","男","21"],
		["7","小红"]
	);//测试数组

	$aTest3=array(
		["uage","40","uname","小明","uage","30"],
		["uadge","40","uid","4"],
		["uname","小明","uage","21"]
	);//测试数组

	$aTest4=array(
		["uage"=>"40","uname"=>"小蓝"],
		["uid"=>"4"],
		["ufaame"=>"小夏","uid"=>"2"]
	);//测试数组

	$bar = "php_db_query";
	$test = new $bar($host, $db_user, $db_pwd, $db_name);
	//取消一下注释，可以进行测试
	//var_dump($test->select($db_table,$aTest1));
	//var_dump($test->insert($db_table,$aTest2));
	//var_dump($test->update($db_table,$aTest3));
	//var_dump($test->delete($db_table,$aTest4));
?>