<?php ;
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, token, Host, Content-Type');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Content-Type: application/json; charset=utf-8');
header('content-type: application/json; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', '1');
// require_once "./phpHeader/getHeader.php";
// $headers = apache_request_headers();
// require_once "./token/validateToken.php";

//$userId = $tokenUserId;
$userId = 4;
// echo $userId;

require_once "../Controller/EmailMgr.php";
$c2 = new EmailMgr();

require_once "./BulkImport/objectToArray.php";
require_once "./BulkImport/checkDupEmail.php";
require_once "./BulkImport/insertInTransactionTable.php";
require_once "./BulkImport/insertInTransactionDetails.php";

$objectToArray = new objectToArray();
$checkDupEmail = new checkDupEmail();
$transactionTable = new transactionTable();
$transactionDetails = new transactionDetails();

$data = $_POST['data'];
$userId =$_POST['userId'];
print_r($data);
// exit();

require_once "../Controller/StaticDBCon.php";

$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);

if (!$conn) {
    $responseArr["result"] = false;
    $responseArr["details"] =  mysqli_connect_error();
    die($responseArr);
}

$resultInTrTable = $transactionTable->insert($conn, $userId);
// print_r($resultInTrTable);
if (array_key_exists('last_id', $resultInTrTable)) {
	$tId = $resultInTrTable['last_id'];
	// echo $tId;
}
else{
	exit(json_encode($resultInTrTable));
}


$encodedData =  $data;
// print_r($encodedData[0]);
// $properData = $objectToArray->convert($encodedData[0]);
// print_r($properData);
// exit("exit");

$responseArr["result"] = true;
$responseArr["details"] = array();
$totalrecords = count($data['bulkData']);
// echo $totalrecords;
$totalinserted = 0;
$totalfailed = 0;
$status = "";
$insertResArr = array();

for($i=0;$i<sizeof($encodedData);$i++) {
//echo"heloo";
	$properData = $encodedData[$i];
	//print_r($properData[$i]);
	//exit("exit");
	//echo "</br>";
	$name = @mysqli_real_escape_string($conn,($properData["Firstname"])." ".($properData["Surname"]));
	$email =  @mysqli_real_escape_string($conn,($properData["E-mail address"]));
	$companyName = @mysqli_real_escape_string($conn,($properData["Company"]));
	$jobRole = @mysqli_real_escape_string($conn,($properData["Job Role"]));
	$ofcAddress =  @mysqli_real_escape_string($conn,($properData["Office Address"]));
	$website =  @mysqli_real_escape_string($conn,($properData["Company Website"]));
	$industry =  @mysqli_real_escape_string($conn,($properData["Industry"]));
	$country  = @mysqli_real_escape_string($conn,($properData["Country"]));
	//echo $name."-".$companyName."-".$jobRole."-".$ofcAddress."-".$website."-".$industry."-".$country;
	//echo "<br/>";
	//check if company already exists into the database

	$responseArr["details"][$i] = array();

	if(isset($companyName) && !empty($companyName)) {

		$sql = 'SELECT id,name FROM company WHERE name="'.$companyName.'"';
		//echo $sql."</br>";
		$result = mysqli_query($conn, $sql);
		$companyFound = false;
		if (@mysqli_num_rows($result) > 0) {
			// output data of each row
			//	echo "no of row";
			$foundCompnayId = null;
			$foundCompanyName = null;
			while($row = mysqli_fetch_assoc($result)) {
				$foundCompnayId = $row["id"];
				$foundCompanyName = $row["name"];
			}

			//check if email Id already exists
			$emailFound = $checkDupEmail->check($conn, $email);
			if($emailFound["result"] == false) {
				//insert query
				$comNameSql = "INSERT INTO employee (name,companyName,jobRole,industry,location,website,companyId,email) VALUES('".$name."','".$companyName."','".$jobRole."','".$industry."','".$country."','".$website."','".$foundCompnayId."','".$email."')";
				$operationPerform = "Inserted";
				$reason = '';
				$compReason = '';
			}
			else {
				// update query
				$comNameSql = 'UPDATE employee SET name = "'.$name.'" , companyName = "'.$companyName.'" , jobRole = "'.$jobRole.'" ,industry = "'.$industry.'" , location = "'.$country.'" , website = "'.$website.'" , companyId = "'.$foundCompnayId.'" WHERE email = "'.$email.'" ';
				$operationPerform = "Updated";
				$reason = 'Email already exists';
				$compReason = 'Company already exists';
			}

			$responseArr["details"][$i]["loopNo"] = $i;
			if (mysqli_query($conn, $comNameSql)) {
				$c2->addMebmberToList($email,'d0a4dda674',$name,'','');
				$responseArr["details"][$i]["listResponse"] = json_encode($c2);
				$responseArr["details"][$i]["inserted"] = true;
				$responseArr["details"][$i]["name"] = $name;
				$totalinserted++;
				//echo "if New record with found company Inserted successfully".$i."</br>";
			} else {
				$responseArr["details"][$i]["inserted"] = false;
				$responseArr["details"][$i]["name"] = $name;
				$responseArr["details"][$i]["reason"] = mysqli_error($conn);
				$reason = mysqli_error($conn);
				$totalfailed++;
				$operationPerform = "Failed";
				//echo "</br>Error: ".$sql."<br>" . mysqli_error($conn);
			}

			$insertStatus = $responseArr["details"][$i]["inserted"];

			$resultInTrDetails = $transactionDetails->insert($conn, $tId, $email, '', $companyName, $insertStatus, $operationPerform, $reason, $compReason);
			// print_r($resultInTrDetails);


		} else {

			$insertNewCmpySql = "INSERT INTO company(name,ofcAddress) VALUES('".trim($companyName)."','".$ofcAddress."')";
			$operationPerform = "Inserted";
			if (mysqli_query($conn, $insertNewCmpySql)) {
				$companyId = mysqli_insert_id($conn);

				//check if email Id already exists
				$emailFound = $checkDupEmail->check($conn, $email);
				if($emailFound["result"] == false) {
					//insert query
					$newCompSql = "INSERT INTO employee (name,companyName,jobRole,industry,location,website,companyId,email) VALUES('".$name."','".$companyName."','".$jobRole."','".$industry."','".$country."','".$website."','".$companyId."','".$email."')";
					$operationPerform = "Inserted";
					$reason = '';
					$compReason = '';
				}
				else {
					// update query
					$newCompSql = 'UPDATE employee SET name = "'.$name.'" , companyName = "'.$companyName.'" , jobRole = "'.$jobRole.'" ,industry = "'.$industry.'" , location = "'.$country.'" , website = "'.$website.'" , companyId = "'.$foundCompnayId.'" WHERE email = "'.$email.'" ';
					$operationPerform = "Updated";
					$reason = 'Email already exists';
					$compReason = 'Company already exists';
				}


				$responseArr["details"][$i]["loopNo"] = $i;
				if (mysqli_query($conn, $newCompSql)) {
					$c2->addMebmberToList($email,'d0a4dda674',$name,'','');
					$responseArr["details"][$i]["inserted"] = true;
					$responseArr["details"][$i]["name"] = $name;
					$responseArr["details"][$i]["listResponse"] = json_encode($c2);
					$totalinserted++;
					//echo "else if New Empl with new inserted company name Inserted successfully".$i."</br>";
				} else {
					//echo "</br>Error: " . $sql . "<br>" . mysqli_error($conn);
					$responseArr["details"][$i]["inserted"] = false;
					$responseArr["details"][$i]["name"] = $name;
					$responseArr["details"][$i]["reason"] = mysqli_error($conn);
					$reason = mysqli_error($conn);
					$totalfailed++;
					$operationPerform = "Failed";
				}

				$insertStatus = $responseArr["details"][$i]["inserted"];

				$resultInTrDetails = $transactionDetails->insert($conn, $tId, $email, $companyId, $companyName, $insertStatus, $operationPerform, $reason, $compReason);
				// echo "insert_resultInTrDetails".$resultInTrDetails;


				//echo "New record created successfully".$i."</br>";
			} else {
				$responseArr["details"][$i]["inserted"] = false;
				$responseArr["details"][$i]["name"] = $name;
				$responseArr["details"][$i]["reason"] = mysqli_error($conn);
				$compReason = mysqli_error($conn);
				//echo "</br>Error: " . $sql . "<br>" . mysqli_error($conn);
				$totalfailed++;
				$operationPerform = "Failed";
				$insertStatus = $responseArr["details"][$i]["inserted"];

				$resultInTrDetails = $transactionDetails->insert($conn, $tId, '', '', $companyName, $insertStatus, $operationPerform, '',$compReason);
			}

		}

	}
	else {

		$insertEmplSql = "INSERT INTO employee (name,companyName,jobRole,industry,location,website,email) VALUES('".$name."','".$companyName."','".$jobRole."','".$industry."','".$country."','".$website."','".$email."')";
		$operationPerform = "Inserted";
		$emailFound = $checkDupEmail->check($conn, $email);
		if($emailFound["result"] == false) {
			//insert query
			$insertEmplSql = "INSERT INTO employee (name,companyName,jobRole,industry,location,website,email) VALUES('".$name."','".$companyName."','".$jobRole."','".$industry."','".$country."','".$website."','".$email."')";
			$operationPerform = "Inserted";
			$reason = '';
			$compReason = '';
		}
		else {
			// update query
			$insertEmplSql = 'UPDATE employee SET name = "'.$name.'" , companyName = "'.$companyName.'" , jobRole = "'.$jobRole.'" ,industry = "'.$industry.'" , location = "'.$country.'" , website = "'.$website.'" WHERE email = "'.$email.'" ';
			$operationPerform = "Updated";
			$reason = 'Email already exists';
			$compReason = 'Company already exists';
		}

		$responseArr["details"][$i]["loopNo"] = $i;
		if (mysqli_query($conn, $insertEmplSql)) {
			$c2->addMebmberToList($email,'d0a4dda674',$name,'','');
			$responseArr["details"][$i]["listResponse"] = json_encode($c2);
			$responseArr["details"][$i]["inserted"] = true;
			$responseArr["details"][$i]["name"] = $name;
			$totalinserted++;
			//echo "outer New Empl with new inserted company name Inserted successfully".$i."</br>";
		} else {
			$responseArr["details"][$i]["inserted"] = false;
			$responseArr["details"][$i]["name"] = $name;
			$responseArr["details"][$i]["reason"] = mysqli_error($conn);
			$reason = mysqli_error($conn);
			$totalfailed++;
			$operationPerform = "Failed";
			//echo "</br>Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		$insertStatus = $responseArr["details"][$i]["inserted"];

		$resultInTrDetails = $transactionDetails->insert($conn, $tId, $email, '', $companyName, $insertStatus, $operationPerform, $reason, $compReason);
		// echo "insert_resultInTrDetails".$resultInTrDetails;

	}

}

// echo json_encode($responseArr, true);

$resultInTrTable = $transactionTable->update($conn, $tId, $userId, $status, $totalrecords, $totalinserted, $totalfailed);
// echo "resultInTrTable2=".$resultInTrTable;
$insertResArr['result'] = $resultInTrTable['result'];
$insertResArr['tId'] = $tId;
// echo json_encode($insertResArr);



echo json_encode($insertResArr);
?>
