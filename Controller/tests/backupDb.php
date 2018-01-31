<?php
  header("Access-Control-Allow-Origin: *");
    require_once("./../StaticDBCon.php");
	
	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
    $dbhost = StaticDBCon::$servername;
    $dbuser = StaticDBCon::$username;
    $dbpass = StaticDBCon::$password;
    $dbname = StaticDBCon::$dbname;

    if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	} 
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
    
   
  
   $backup_file = "dbBackup" . '.gz';
   $command = "mysqldump --opt -h $dbhost -u $dbuser -p $dbpass ". "$dbname | gzip > $backup_file";
   
   system($command);
?>