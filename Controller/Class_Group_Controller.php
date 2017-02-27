<?php

require_once("../Models/Class_Group.php");
require_once("../Controller/StaticDBCon.php");

require_once("../Models/Class_User.php");

class GroupController{
	
	public function getGroupList($id){
		
            $groupList = array();
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
            } 
            if($id==''){
                $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group;";
            }else{
                $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group where id='".$id."';";
            }
            $result = $conn->query($sql);
            //echo $sql.' id : '.$id;
            if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    $group = new Group($row["id"], $row["name"], $row["details"], $row["admin"], $row["members"], $row["membersCount"], $row["createdOn"]);
                    $groupList[$i]=$group;
                    $i++;
                }
            } else {
                    //echo "0 results";
            }
            $conn->close();
            return $groupList;
	}	
	
	
	
	public function getGroupJson($id){
            //echo "id : ".$id;
            $GroupList = $this->getGroupList($id);
            $jsonStr = '{"Groups":[';
            $i=count($GroupList);
            foreach($GroupList as $grp){
                $jsonStr.='{';
                $jsonStr.='"id":"'.$grp->getId().'",';
                $jsonStr.='"name":"'.$grp->getName().'",';
                $jsonStr.='"details":"'.$grp->getDetails().'",';
                $jsonStr.='"admin":"'.$grp->getAdmin().'",';
                $jsonStr.=$this->getUserJson($grp->getMembers()).',';
                $jsonStr.='"membersCount":"'.$grp->getMembersCount().'",';
                $jsonStr.='"createdOn":"'.$grp->getCreatedOn().'"}';
                $i--;
                if($i!=0){
                    $jsonStr.=',';
                }
            }
            $jsonStr.=']}';

            return $jsonStr;
		
	}
	
	        
	public function getUserList($ids){
		
            $usrlList = array();
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
            } 

            $sql = "SELECT * FROM ".StaticDBCon::$dbname.".user where id in(".$ids.");";
            //echo 'Query: '.$sql;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    $usr = new User($row["name"],$row["department"],$row["hireDate"],$row["dob"],$row["gender"],$row["homeAddress"],$row["email"],$row["phone"],$row["profilePic"]);
                    $usrlList[$i]=$usr;
                    //echo $usrlList[$i]->getName();
                    $i++;
                }
            } else {
                    echo "0 results";
            }
            $conn->close();
            return $usrlList;
	}	
	
	public function getUserJson($id){
            $UserList = $this->getUserList($id);
            $jsonStr = '"Members":[';
            $i=count($UserList);
            foreach($UserList as $usr){
                $jsonStr.='{';
                $jsonStr.='"name":"'.$usr->getName().'",';
                $jsonStr.='"department":"'.$usr->getDepartment().'",';
                $jsonStr.='"hireDate":"'.$usr->getHireDate().'",';
                $jsonStr.='"dob":"'.$usr->getDob().'",';
                $jsonStr.='"gender":"'.$usr->getGender().'",';
                $jsonStr.='"homeAddress":"'.$usr->getHomeAddress().'",';
                $jsonStr.='"email":"'.$usr->getEmail().'",';
                $jsonStr.='"profilePic":"'.$usr->getProfilePic().'",';
                $jsonStr.='"phone":"'.$usr->getPhone().'"}';
                $i--;
                if($i!=0){
                    $jsonStr.=',';
                }
            }
            $jsonStr.=']';

            return $jsonStr;
		
	}
        
        
        
        public function addNewGroup($name,$details,$admin,$members,$createdOn){
            $membersCount="";
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            $grp = new Group("","","","","","","");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group where admin='".$admin."' AND name='".$name."' limit 1;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $grp->isGroupAdded = FALSE;
                $grp->message=$name." is already present with the same admin!";
            } else {
                $sql = "INSERT INTO groups (name, details, admin, members, membersCount, createdOn)
                VALUES ('".$name."','".$details."','".$admin."','".$members."','".$membersCount."','".$createdOn."')";
                //echo 'Query : '.$sql;
                if ($conn->query($sql) === TRUE) {
                    $grp->isGroupAdded = TRUE;
                } else {
                    //echo "Error: " . $sql . "<br>" . $conn->error;
                    $grp->isGroupAdded = FALSE;
                    $grp->message ="Something went wrong";
                }
            }
            $conn->close();
            return $usr;
	}	
	
	public function addGroupJson($name,$details,$admin,$members,$createdOn){
            $grp  = $this->addNewGroup($name,$details,$admin,$members,$createdOn);
            if ($grp->isGroupAdded) {
                $jsonStr = '{"responce":true}';
            }  else {
                $jsonStr = '{"responce":false,';
                $jsonStr.='"message":"'.$usr->getMessage().'"}';
            }
            return $jsonStr;	
	}
        
        
        
}




?>