<?php

require_once("../Models/Class_Company.php");
require_once("../Controller/StaticDBCon.php");

class CompanyController{
	
	public function getCompanyList($id){
		
		$compList = array();
		$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		if($id==''){
			$sql = "SELECT * FROM company;";
		}else{
			$sql = "SELECT * FROM company where id='".$id."';";
		}
		$result = $conn->query($sql);
		//echo $sql.' id : '.$id;
		if ($result->num_rows > 0) {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$comp = new Company($row["name"],$row["areaOfWork"],$row["establised"],$row["employees"],$row["revenue"],$row["ofcAddress"],$row["email"],$row["phone"],$row["logo"]);
				$compList[$i]=$comp;
				//echo $compList[$i]->getName();
				$i++;
			}
		} else {
			//echo "0 results";
		}
		$conn->close();
		return $compList;
	}	
	
	
	
	public function getCompanyJson($id){
		//echo "id : ".$id;
		$CompList = $this->getCompanyList($id);
		$jsonStr = '{"Users":[';
		$i=count($CompList);
		foreach($CompList as $comp){
			$jsonStr.='{';
			$jsonStr.='"name":"'.$comp->getName().'",';
			$jsonStr.='"areaOfWork":"'.$comp->getAreaOfWork().'",';
			$jsonStr.='"establised":"'.$comp->getEstablised().'",';
			$jsonStr.='"employees":"'.$comp->getEmployees().'",';
			$jsonStr.='"revenue":"'.$comp->getRevenue().'",';
			$jsonStr.='"ofcAddress":"'.$comp->getOfcAddress().'",';
			$jsonStr.='"email":"'.$comp->getEmail().'",';
			$jsonStr.='"phone":"'.$comp->getPhone().'",';
			$jsonStr.='"logo":"'.$comp->getLogo().'"}';
			$i--;
			if($i!=0){
				$jsonStr.=',';
			}
		}
		$jsonStr.=']}';
		
		return $jsonStr;
		
	}
	
	
	
	public function getCompanyJsonForEmpl($id){
		//echo "id : ".$id;
		$CompList = $this->getCompanyList($id);
		$jsonStr = '';
		$i=count($CompList);
		foreach($CompList as $comp){
			$jsonStr.='{';
			$jsonStr.='"name":"'.$comp->getName().'",';
			$jsonStr.='"areaOfWork":"'.$comp->getAreaOfWork().'",';
			$jsonStr.='"establised":"'.$comp->getEstablised().'",';
			$jsonStr.='"employees":"'.$comp->getEmployees().'",';
			$jsonStr.='"revenue":"'.$comp->getRevenue().'",';
			$jsonStr.='"ofcAddress":"'.$comp->getOfcAddress().'",';
			$jsonStr.='"email":"'.$comp->getEmail().'",';
			$jsonStr.='"phone":"'.$comp->getPhone().'",';
			$jsonStr.='"logo":"'.$comp->getLogo().'"}';
			$i--;
			
		}
		
		
		return $jsonStr;
		
	}
}




?>