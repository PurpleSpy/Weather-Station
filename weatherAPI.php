<?php
	
		$un = "your username";
		$up = "your password";
		$u="weatherinfo";
		$webserv=@connectTODataBase($u,$un,$up);
		
	if(isset($_GET["uid"])){
		
		if(!$webserv){
			echo 0;
			exit;
		}
		
		if(!isset($_GET["temp"])){
			$_GET["temp"]=-255;
		}
		
		if(!isset($_GET["humid"])){
			$_GET["humid"] =-255;
		}
		
		if(!isset($_GET["baro"])){
			$_GET["baro"] =-255;
		}
		
		if (!isset($_GET["head"])){
			$_GET["head"]=0;
		}
			print "baro : " . $_GET["baro"] . "\nTemp : " . $_GET["temp"] ."\nhumid : " . $_GET["humid"] . "\nuid :" .$_GET["uid"];
				$statement= "INSERT INTO weather(tempF,humid,baro,uid,headache) VALUES(" .$_GET["temp"]."," . $_GET["humid"]. ",".$_GET["baro"].",'" . $_GET["uid"]. "'," . $_GET["head"] .");";
			print $statement;
				$prep=$webserv->prepare($statement);
				$prep->execute();
			
		if($prep->errorinfo()==0){
			echo 1;	
		}
		
		else{
			print($prep->errorinfo());
		}
		
	}
	else{
		if(isset($_GET["status"])){
			$statement = "SELECT DISTINCT uid FROM weather";
			$prep=$webserv->prepare($statement);
			$prep->execute();
			$retarray = array();
			
			$uids = $prep->fetchAll(PDO::FETCH_COLUMN);
			
			
			$SampleStatement="select * from weather where uid='%uid' order by dt desc limit 1";
				
		
			foreach($uids as &$itm){
				$itm = str_replace("%uid",$itm,$SampleStatement);
				$prep=$webserv->prepare($itm);
				$prep->execute();
				$searchval=$prep->fetchAll();
				
				
				foreach($searchval as $val){
					array_push($retarray,$val);
				}
				
				
			}
			header("content-type: application/json");
			echo json_encode($retarray);
			
			
			
			
		}
		else{
			
			echo 0;
		}
	}
	
	
	
	function connectTODataBase($dbname,$uname,$upass){
		
			$un = $uname;
			$up = $upass;
			$u="mysql:host=localhost;dbname=".$dbname .";";
			$webserv=@new PDO($u,$un,$up);
			return $webserv;
	}
	
?>