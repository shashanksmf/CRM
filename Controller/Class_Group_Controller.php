<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("../Models/Class_Group.php");
require_once("../Controller/StaticDBCon.php");

require_once("../Models/Class_User.php");

require_once("../Models/Class_Employees.php");
require_once("../Controller/EmailMgr.php");

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

            $sql = "SELECT * FROM employee where id in(".$ids.");";
            //echo 'Query: '.$sql;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    //$usr = new User($row["id"],$row["name"],$row["department"],$row["hireDate"],$row["dob"],$row["gender"],$row["homeAddress"],$row["email"],$row["phone"],$row["profilePic"]);
                    $empl = new Employees($row["id"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],"",$row["companyId"],$row["skype"],$row["age"],$row["gender"],$row["officePhone"],$row["jobRole"],$row["phone"],$row["email"],$row["linkedin"],$row["twitter"],$row["facebook"],$row["notes"],$row["imgUrl"]);
                     
                    $usrlList[$i]=$empl;
                    //echo $usrlList[$i]->getName();
                    $i++;
                }
            } else {
                   // echo "0 results";
            }
            $conn->close();
            return $usrlList;
	}	
	
	public function getUserJson($id){
            $UserList = $this->getUserList($id);
            $jsonStr = '"Members":[';
            $i=count($UserList);
            foreach($UserList as $empl){
                $jsonStr.='{';
                $jsonStr.='"id":"'.$empl->getId().'",';
                $jsonStr.='"CompanyId":"'.$empl->getCompanyId().'",';
                $jsonStr.='"name":"'.$empl->getName().'",';
                $jsonStr.='"title":"'.$empl->getTitle().'",';
                $jsonStr.='"email":"'.$empl->getEmail().'",';
                $jsonStr.='"industry":"'.$empl->getIndustry().'",';
                $jsonStr.='"location":"'.$empl->getLocation().'",';
				$jsonStr.='"phone":"'.$empl->getPhone().'",';
                $jsonStr.='"ratings":"'.$empl->getRatings().'"}';
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
            $emailMgr = new EmailMgr();
            $emailMgr->apiKey = getenv("mailChimpApiKey");
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
                $sql = "INSERT INTO ".StaticDBCon::$dbname.".group (name, details, admin, members, membersCount, createdOn)
                VALUES ('".$name."','".$details."','".$admin."','".$members."','".$membersCount."','".$createdOn."')";
                //echo 'Query : '.$sql;
                if ($conn->query($sql) === TRUE) {
                    $grp->isGroupAdded = TRUE;
                    $res = $emailMgr->addSegment($name);
                    $re = json_encode($res);
                    $segId = $re->id;
                    $grp->id = mysql_insert_id();
                    $this->updateGroup2($grp->id, $segId);
                } else {
                    //echo "Error: " . $sql . "<br>" . $conn->error;
                    $grp->isGroupAdded = FALSE;
                    $grp->message ="Something went wrong";
                }
            }
            $conn->close();
            return $grp;
	}	
	
	public function addGroupJson($name,$details,$admin,$members,$createdOn){
            $grp  = $this->addNewGroup($name,$details,$admin,$members,$createdOn);
            if ($grp->isGroupAdded) {
                $jsonStr = '{"responce":true}';
            }  else {
                $jsonStr = '{"responce":false,';
                $jsonStr.='"message":"'.$grp->message.'"}';
            }
            return $jsonStr;	
	}
        
        
        public function updateGroup($id,$members){
            $membersCount="";
            $emailMgr = new EmailMgr();
            $emailMgr->apiKey = getenv("mailChimpApiKey");
                    
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            $grp = new Group("","","","","","","");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group where admin='".$admin."' AND name='".$name."' limit 1;";
            $result = $conn->query($sql);
            
                $sql = "UPDATE `group` SET `members` = '".$members."' WHERE `group`.`id` = ".$id.";";
                $membersArr = explode(",",$members);
                for($i=0;$i<sizeof($membersArr);$i++) {
                   $memberSql = "SELECT * from employee WHERE id=".trim($membersArr[$i]);
                 //  echo "sql".$memberSql;
                   $selctResult = $conn->query($memberSql);
                   if ($selctResult->num_rows > 0) {
                         while($emplRow = $selctResult->fetch_assoc()) {
                         	$emplEmail = $emplRow["email"]; 
                         	$emplName = $emplRow["name"];
                         	$resEmail = $emailMgr->addMebmberToList($emplEmail,'d0a4dda674',$emplName,'','');
 			      //print_r($resEmail);
    			}
                   }
                }
                
                //echo 'Query : '.$sql;
                if ($conn->query($sql) === TRUE) {
                    $grp->isGroupAdded = TRUE;
                    $segId = $this->getGroup($id);
                    $usList = $this->getUserList($members);
                    foreach($UserList as $empl){
                        $emailMgr->updateSegment($empl->getEmail(), $segId);
                    }
                    
                } else {
                    //echo "Error: " . $sql . "<br>" . $conn->error;
                    $grp->isGroupAdded = FALSE;
                    $grp->message ="Something went wrong";
                }
            
            $conn->close();
            return $grp;
	}	
	
        
        
        
        
	public function updateGroupJson($id,$members){
            $grp  = $this->updateGroup($id,$members);
            if ($grp->isGroupAdded) {
                $jsonStr = '{"responce":true}';
            }  else {
                $jsonStr = '{"responce":false,';
                $jsonStr.='"message":"'.$grp->message.'"}';
            }
            return $jsonStr;	
	}
        
        
        
        
        
        
        
        
        public function updateGroup2($id,$segId){
            $membersCount="";
            $emailMgr = new EmailMgr();
            $emailMgr->apiKey = getenv("mailChimpApiKey");
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            $grp = new Group("","","","","","","");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
           
            
                $sql = "UPDATE `group` SET `segId` = '".$segId."' WHERE `group`.`id` = ".$id.";";
                //echo 'Query : '.$sql;
                if ($conn->query($sql) === TRUE) {
                    $grp->isGroupAdded = TRUE;
                } else {
                    //echo "Error: " . $sql . "<br>" . $conn->error;
                    $grp->isGroupAdded = FALSE;
                    $grp->message ="Something went wrong";
                }
            
            $conn->close();
            return $grp;
	}	
	
        
        
        
	public function getGroup($id){
		
            $grp = "";
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
            } 
           
            $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group where id='".$id."';";
          
            $result = $conn->query($sql);
            //echo $sql.' id : '.$id;
            if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    //$group = new Group($row["id"], $row["name"], $row["details"], $row["admin"], $row["members"], $row["membersCount"], $row["createdOn"]);
                    $grp = $row["segId"];
                }
            } else {
                    
            }
            $conn->close();
            return $grp;
	}	
	
        
        
        
}




?>