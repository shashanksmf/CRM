<?php

require_once("../Models/Class_Campaign.php");
require_once("../Controller/StaticDBCon.php");

require_once("../Controller/EmailMgr.php");
header("Access-Control-Allow-Origin: *");
class CampaignController{

        public function getCampaignList($id){
                $resp = "";
                $emailList = array();
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                } 
                if($id==''){
                        $sql = "SELECT * FROM campaign;";
                }else{
                        $sql = "SELECT * FROM campaign where id='".$id."';";
                }
                $result = $conn->query($sql);
                //echo $sql.' id : '.$id;
                if ($result->num_rows > 0) {
                        $i = 0;
                        while($row = $result->fetch_assoc()) {
                            //echo $row['name'];
                                $mail = new Campaign($row['id'], $row['name'], $row['createdBy'], $row['emails'], $row['subject'], $row['body'], $row['recievedBy'], $row['dates'], $row['replacingContent'],$row['templateId'],$row['groupId']);
                                $mailList[$i]=$mail;
                                //echo $compList[$i]->getName();
                                $i++;

                        }
                } else {
                        //echo "0 results";
                }
                $conn->close();
                //$resp = json_encode($mailList);
                return $mailList;
        }	



        public function getCampaignJson($id){
                //echo "id : ".$id;
            $List = $this->getCampaignList($id);

            $jsonStr = '{"camp":[';
            $i=count($List);
            foreach($List as $grp){
                $jsonStr.='{';
                $jsonStr.='"id":"'.$grp->id.'",';
                $jsonStr.='"name":"'.$grp->name.'",';
                $jsonStr.='"createdBy":"'.$grp->createdBy.'",';
                $jsonStr.='"emails":"'.$grp->emails.'",';
                $jsonStr.='"subject":"'.$grp->subject.'",';
                $jsonStr.='"html":"'.urlencode ($grp->body).'",';
                $jsonStr.='"recievedBy":"'.$grp->recievedBy.'",';
                $jsonStr.='"groupId":"'.$grp->groupId.'",';
                $jsonStr.='"tempId":"'.$grp->tempId.'",';
                $jsonStr.='"createdOn":"'.$grp->dates.'"}';
                $i--;
                if($i!=0){
                    $jsonStr.=',';
                }
            }
            $jsonStr.=']}';

            return $jsonStr;

        }




            public function addNewCampaign($name,$createdBy,$emails,$subject,$body,$recievedBy,$dates,$templateId,$groupId){
                    $date = new DateTime();
                    $time = $date->getTimestamp();
                    
	            
                    $membersCount="";
                    $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                    $msg = new Campaign("", "", "", "", "", "", "", "", "", "", "");
                    if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                    }
                            $read = 0;
                            $sql = "INSERT INTO ".StaticDBCon::$dbname.".campaign(name,createdBy,emails,subject,body,recievedBy,dates,replacingContent,templateId,groupId)
                            VALUES ('".$name."','".$createdBy."','".$emails."','".$subject."','".$body."','".$recievedBy."','".$dates."','','".$templateId."','".$groupId."')";
                            //echo 'Query : '.$sql;
                            if ($conn->query($sql) === TRUE) {
                                    $msg->isAdded = TRUE;
                                    $msg->id = mysqli_insert_id($conn);
                                    $msg->msg = "Added Successfully!";
                            } else {
                                    //echo "Error: " . $sql . "<br>" . $conn->error;
                                    $msg->isAdded = FALSE;
                                    $msg->msg ="Something went wrong";
                            }

                    $conn->close();
                    return $msg;
            }	

            public function addNewCampaignJson($name,$createdBy,$emails,$subject,$body,$recievedBy,$dates,$templateId,$groupId){
                $msg  = $this->addNewCampaign($name,$createdBy,$emails,$subject,$body,$recievedBy,$dates,$templateId,$groupId);
                if ($msg->isAdded) {
                    $jsonStr = '{"responce":true,'
                            . '"id":'.$msg->id
                            . '}';
                }  else {
                    $jsonStr = '{"responce":false,';
                    $jsonStr.='"message":"'.$msg->msg.'"}';
                }
                return $jsonStr;	
            }


}




?>