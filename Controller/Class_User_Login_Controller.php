<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("../Models/Class_User.php");
require_once("StaticDBCon.php");
require_once("../Service/token/getNewtoken.php");

header("Access-Control-Allow-Origin: *");

class UserLoginController{

    public function getUser($userName,$password){
        $nowTime = date("Y-m-d H:i:s");
        $usr = new User("0","","","","","","","","","");
        $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM user where email='".$userName."' and password='".md5($password)."' limit 1;";
        $result = $conn->query($sql);
        if (@mysqli_num_rows($result) > 0) {
           $userId = '';
           while($row = $result->fetch_assoc()) {
            $usr = new User($row["id"],$row["name"],$row["department"],$row["hireDate"],$row["dob"],$row["gender"],$row["homeAddress"],$row["email"],$row["phone"],$row["profilePic"]);
            $usr->isSignedIn = TRUE;
            $usr->message = "Signin Success!";
            $userId = $row['id'];
        }

        $insertTimeSql = "UPDATE user SET lastactive = '".$nowTime."' WHERE id=".$userId;
        $conn->query($insertTimeSql);


        } else {
            $usr = new User("","","","","","","","","","");
            $usr->isSignedIn = FALSE;
            $usr->message = "Signin Failed!";
        }
        $conn->close();
        return $usr;
    }

    public function getUserJson($userName,$password){
        // echo $token['token'];

        $usr = $this->getUser($userName,$password);
        $jsonStr = "";
        $getNewtoken = new getNewtoken();
        $token = $getNewtoken->getToken($usr->getId());

        if ($usr->isSignedIn) {
            $jsonStr = '{"responce":true,';
            $jsonStr.='"name":"'.$usr->getName().'",';
            $jsonStr.='"id":"'.$usr->getId().'",';
            $jsonStr.='"department":"'.$usr->getDepartment().'",';
            $jsonStr.='"hireDate":"'.$usr->getHireDate().'",';
            $jsonStr.='"dob":"'.$usr->getDob().'",';
            $jsonStr.='"gender":"'.$usr->getGender().'",';
            $jsonStr.='"homeAddress":"'.$usr->getHomeAddress().'",';
            $jsonStr.='"email":"'.$usr->getEmail().'",';
            $jsonStr.='"profilePic":"'.$usr->getProfilePic().'",';
            $jsonStr.='"token":"'.$token['token'].'",';
            $jsonStr.='"phone":"'.$usr->getPhone().'"}';
        }  else {
            $jsonStr = '{"responce":false,';
            $jsonStr.='"message":"'.$usr->getMessage().'"}';
        }
        return $jsonStr;

    }


    public function addUser($name, $department, $hireDate, $dob, $gender, $homeAddress, $email, $phone, $profilePic, $password){

       $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
       $usr = new User("","","","","","","","","","");

       if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM user where email='".$email."' limit 1;";

        $result = $conn->query($sql);
        if (@mysqli_num_rows($result) > 0) {
            $usr->isSignedUp = FALSE;
            $usr->message=$email." is already used!";

        } else {

        $sql = "INSERT INTO user (name, department, hireDate, dob, gender, homeAddress, email, phone, profilePic, password)
        VALUES ('".$name."','".$department."','".$hireDate."','".$dob."','".$gender."','".$homeAddress."','".$email."','".$phone."','".$profilePic."','".md5($password)."')";
                    //echo 'Query : '.$sql;
            if ($conn->query($sql) === TRUE) {
                $usr->isSignedUp = TRUE;
            } else {
                            //echo "Error: " . $sql . "<br>" . $conn->error;
                $usr->isSignedUp = FALSE;
                $usr->message="Signup Failed!";
            }
        }
        $conn->close();
        return $usr;
    }

    public function addUserJson($name, $department, $hireDate, $dob, $gender, $homeAddress, $email, $phone, $profilePic, $password){

      $usr  = $this->addUser($name, $department, $hireDate, $dob, $gender, $homeAddress, $email, $phone, $profilePic, $password);

      if ($usr->isSignedUp) {
            $jsonStr = '{"responce":true}';
        }  else {
            $jsonStr = '{"responce":false,';
            $jsonStr.='"message":"'.$usr->getMessage().'"}';
        }

        return $jsonStr;
    }

    public function checkUserEmail($email){
        $nowTime = date("Y-m-d H:i:s");
        $usr = new User("0","","","","","","","","","");
        $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM user where email='".$email."' limit 1;";
        $result = $conn->query($sql);
        // $resultArr = array();
        if (@mysqli_num_rows($result) > 0) {
           $userId = '';
           $usr = '';
           while($row = $result->fetch_assoc()) {
                $usr = new User($row["id"],$row["name"],$row["department"],$row["hireDate"],$row["dob"],$row["gender"],$row["homeAddress"],$row["email"],$row["phone"],$row["profilePic"]);
                $usr->isSignedIn = TRUE;
                $usr->message = "Signin Success!";
                $userId = $row['id'];
            }
            // $resultArr["result"] = TRUE;
            // $resultArr["details"] = "Signin Success!";
            // $resultArr["user"] = $usr;
            // $resultArr["userId"] = $userId;
            // echo json_encode($responseArr);

        } else {
            $usr = new User("","","","","","","","","","");
            $usr->isSignedIn = FALSE;
            $usr->message = "Signin Failed!";
            // $resultArr["result"] = FALSE;
            // $resultArr["details"] = "Signin Failed!";
            // $resultArr["user"] = $usr;
            // echo json_encode($responseArr);
        }
        $conn->close();
        return $usr;
    }

    public function addSocialUser($name, $gender, $email, $profilePic, $isSocial, $socialType){

       $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
       $usr = new User("","","","","","","","","","");

       if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM user where email='".$email."' limit 1;";

        $result = $conn->query($sql);
        if (@mysqli_num_rows($result) > 0) {
            $usr->isSignedUp = FALSE;
            $usr->message=$email." is already used!";

        } else {

        $sql = "INSERT INTO user (name, department, hireDate, dob, gender, homeAddress, email, phone, profilePic, password, isSocial, socialType)
        VALUES ('".$name."','','','','".$gender."','','".$email."','','".$profilePic."','','".$isSocial."','".$socialType."')";
                    //echo 'Query : '.$sql;
            if ($conn->query($sql) === TRUE) {
                $usr->isSignedUp = TRUE;
                $usr->message = "Signin Success!";
            } else {
                            //echo "Error: " . $sql . "<br>" . $conn->error;
                $usr->isSignedUp = FALSE;
                $usr->message="Signup Failed!";
            }
        }
        $conn->close();
        return $usr;
    }

}




?>
