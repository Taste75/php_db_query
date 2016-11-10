<?php
	header("Content-type: text/html; charset=utf-8");
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
				查找字段名 => 查找键值
				$key => $value,
				...
			)
			return:
			success : 返回一个数组
			fail    : 0
		**/
		public function select($table, $arr){
			$db=self::connect();
			if(!$db){
				exit;
			}
			if(count($arr)){
				$selectQuery = "Select * from ".$table." where ";
				foreach($arr as $key => $value){
					$selectQuery .= (string)$key." like '".(string)$value."' and ";
				}
				$selectQuery = substr($selectQuery, 0, -5);
			}else{
				return "数组为空";
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
				[数值1,数值2,数值3,..],
				[数值1,数值2,数值3,..],
				...
				(按照表的字段顺序，多个数组为更新多条数据)
			)
			return:
			success : 1
			fail    : 0

			EX:
			数组中有错误信息时，会忽略，继续插入
		**/
		public function insert($table, $arr){
			$db=self::connect();
			if(!$db){
				exit;
			}

			if(count($arr)){
				foreach($arr as $key => $value){
					$insertQuery = "insert into ".$table." values(";
					for($i=0,$len=count($value);$i<$len;$i++){
						$insertQuery .= "'".$value[$i]."',";
					}
					$insertQuery = substr($insertQuery, 0, -1).")";
					//echo $insertQuery;

					$result = $db->query($insertQuery);
					if($result){
						echo "插入成功！";
					}else{
						echo "插入失败！具体信息如下：";
						var_dump($value);
					}

				}
			}else{
				return "数组为空";
			}

			$db->close();

			return $result;
		}

		/***
			更新数据
			param:
			$table : 表名
			$arr(
				[修改字段1,修改后的数值1,查找字段11,查找数值1,查找字段12,查找数值12,...],
				[修改字段2,修改后的数值2,查找字段21,查找数值22,查找字段22,查找数值22,...],
				...
				(按照该顺序建立数组,查找字段和数值可以有多个,多个数组为更新多条数据)
			)
			return:
			success : 1
			fail    : 0

			EX:
			数组中有错误信息时，会忽略，继续更新
			数据库中没有的数据不会更新，也不会报错，显示更新成功
			只有字段不存在才会报错
		**/
		public function update($table, $arr){
			$db=self::connect();
			if(!$db){
				exit;
			}

			if(count($arr)){
				foreach($arr as $key => $value){
					$updateQuery = "update ".$table." set ".$value[0]." = '".$value[1]."' where ";
					for($i=2,$len=count($value);$i<$len;$i=$i+2){
						$updateQuery .=(string)$value[$i]." like '".(string)$value[$i+1]."' and ";
					}
					$updateQuery = substr($updateQuery, 0, -5);
					//echo $updateQuery;

					$result=$db->query($updateQuery);
					if($result){
						echo "更新成功！";
					}else{
						echo "更新失败！具体信息如下：";
						var_dump($value);
					}
				}
			}else{
				return "数组为空";
			}

			$db->close();

			return $result;
		}

		/***
			删除数据
			param:
			$table : 表名
			$arr(
				[查找字段11 => 查找数值11,
				 查找字段12 => 查找数值1,
				 ...],
				[$key11 => $value11,
				 $key12 => $value12,
				 ...],
				[$key21 => $value21,
				 $key21 => $value21,
				 ...],
				...
				(查找字段和数值可以有多个,多个数组为更新多条数据)
			)
			return:
			success : 1
			fail    : 0

			EX:
			数组中有错误信息时，会忽略，继续更新
			数据库中没有的数据不会删除，也不会报错，显示删除成功
			只有字段不存在才会报错
		**/
		public function delete($table, $arr){
			$db=self::connect();
			if(!$db){
				exit;
			}

			if(count($arr)){
				foreach($arr as $key => $value){
					$deleteQuery = "delete from ".$table." where ";
					foreach($value as $elem => $val){
						$deleteQuery .=(string)$elem." like '".(string)$val."' and ";
					}
					$deleteQuery = substr($deleteQuery, 0, -5);
					//echo $deleteQuery;

					$result=$db->query($deleteQuery);
					if($result){
						echo "删除成功！";
					}else{
						echo "删除失败！具体信息如下：";
						var_dump($value);
					}
				}
			}else{
				return "数组为空";
			}

			$db->close();

			return $result;
		}

	}

?>