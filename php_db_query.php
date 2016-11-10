<?php
	class php_db_query{
		private $host="";//数据库地址
		private $db_user="";//用户名
		private $db_pwd="";//用户密码
		private $db_name="";//数据库名

		private $table="";//表名

		// 构造函数
		public function __construct($host, $db_user, $db_pwd, $db_name){
			$this->host = $host;
	        $this->db_user = $db_user;
			$this->db_pwd = $db_pwd;
			$this->db_name = $db_name;
		}

		// 创建连接
		private function connect(){
			@ $db = new mysqli($this->host, $this->db_user, $this->db_pwd, $this->db_name);
			if(mysqli_connect_errno()){
				echo 'Error: Could not connect to database, Please try again later!';
				return 0;
			}else{
				//echo "You are successful to connect to the ".$this->db_name." database!";
				return $db;
			}
		}

		/***
			查询数据
			param:
			$table : 表名
			$arr(
				键名 : 键值
				$key : $value,
				...
			)
			return:
			返回一个数组
		**/
		public function select($table, $arr){
			$db=self::connect();
			if(!$db){
				exit;
			}
			$selectQuery = "";
			if(count($arr)){
				$selectQuery .= "Select * from ".$table." where ";
				foreach($arr as $key => $value){
					$selectQuery .= (string)$key." like '".(string)$value."' and ";
				}
				$selectQuery = substr($selectQuery, 0, -5);
			}
			$result = $db->query($selectQuery);
			$num_results = $result->num_rows;
			$resArr = null;
			for($i=0;$i<$num_results;$i++){
				$row = $result->fetch_assoc();
				$res = null;
				foreach($row as $key => $value){
					$res[$key]=$value;
				}
				//var_dump($res);
				$resArr[$i]=$res;
			};

			$result->free();
			$db->close();

			return $resArr;

		}

		/***
			插入数据
			param:
			$table : 表名
			$arr(
				键名 : 键值
				$key : $value,
				...
			)
			return:
			success : 1
			fail    : 0
		**/
		public function insert($table, $arr){
			$db=self::connect();
			if(!$db){
				exit;
			}

			$insertQuery = "";
			$result->free();
			$db->close();
		}

	}


	// //查询
	// $userQuery = "select * from users where uInviCode like '".$inviCode."'";

	// $result = $db->query($userQuery);
	// $num_results = $result->num_rows;
	// for($i=0;$i<$num_results;$i++){
	// 	$row = $result->fetch_assoc();
	// };
	// $state = 0;
	// //返回值
	// if($num_results){
	// 	$state = 1;
	// 	$res=array(
	// 		"state" => $state,
	// 		"uInviCode" => $row["uInviCode"],
	// 		"uName" => $row["uName"],
	// 		"uDorm" => $row["uDorm"],
	// 	);
	// }else{
	// 	$res=array(
	// 		"state" => $state,
	// 	);
	// };

	// $result->free();
	// $db->close();

	// echo json_encode($res);

?>