<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

class checkDupEmail {

  public function check($conn, $email) {

		$DupEmailRes = array();
		$searchDuplicateEmail = "SELECT * FROM employee WHERE email='".$email."'";
		$searchDuplicateEmailResult = mysqli_query($conn, $searchDuplicateEmail);
		if (mysqli_num_rows($searchDuplicateEmailResult) > 0) {
			while($emailResultRow = mysqli_fetch_assoc($searchDuplicateEmailResult)) { 
				
				$DupEmailRes["result"] = true;
				$DupEmailRes["userId"] = $emailResultRow["id"];
				return $DupEmailRes;
				
			}
		}
		else {
			$DupEmailRes["result"] = false;
			return $DupEmailRes;
		}
	}
}

?>
