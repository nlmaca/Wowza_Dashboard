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
$output= mysqli_query($connect,"SELECT vhost_timerunning FROM wow_vhost_status");
while($row=mysqli_fetch_array($output)){ 
	$VhostTime = $row['vhost_timerunning'];
	
}
//convert string to number (get part of the string befor the dot)
$str = $VhostTime;

$Seconds = substr($str,0,strrpos($str,'.'));

//convert number to days, hours, minutes
function secondsToTime($seconds) {
    $dtF = new DateTime("@0");
    $dtT = new DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %hh %imin');
}
echo secondsToTime($Seconds);
			
?>