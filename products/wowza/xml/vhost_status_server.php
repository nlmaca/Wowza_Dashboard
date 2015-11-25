<?php
// page version: 1.1
require("../../../inc/general_conf.inc.php");
if(empty($_SESSION['user'])) {
	header("Location: ". $DOCUMENT_ROOT . "/index.php");
    die("Redirecting to ". $DOCUMENT_ROOT . "/index.php"); 
}

// Create connection
$connect = mysqli_connect($dbHost, $dbUserName, $dbUserPasswd, $dbName);
// Check connection
if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}
			
$wowza= mysqli_query($connect,"SELECT * FROM `wow_connections`");
while($row=mysqli_fetch_array($wowza)){ 
	$WowzaUserName = $row['server_username'];
	$WowzaUserPassw = $row['server_password'];
	$WowzaHostUrl = $row['server_url'];
	$WowzaHostPort = $row['server_port'];
	
	//echo $WowzaUserName . "<br><br>";
}
$fp = fsockopen($WowzaHostUrl, 1935, $errno, $errstr, 30);
if (!$fp) {
    echo "Wowza is offline<br><br>";
	echo "$errstr ($errno)<br />\n";
} 
else {
	echo "Wowza is online";
	fclose($fp);
}		
?>