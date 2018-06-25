<?php
  header("Access-Control-Allow-Origin: *");
    require_once "./../StaticDBCon.php";

	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
    $dbhost = StaticDBCon::$servername;
    $dbuser = StaticDBCon::$username;
    $dbpass = StaticDBCon::$password;
    $dbname = "heroku_f1331253e1e8450";

    if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["reason"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }



   $backup_file = "dbBackup" . '.sql';
   $command = "mysqldump -u $dbuser -p $dbpass ". "$dbname > $backup_file";
   echo  $command."/n";
   system($command);
   echo "done->".$backup_file;
?>
