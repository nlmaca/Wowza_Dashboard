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

$output= mysqli_query($connect,"SELECT * FROM wow_vhost_status");
while($row=mysqli_fetch_array($output)){ 
	$LatestUpdate = $row['session_time'];
	$VhostTimeRunning = $row['vhost_timerunning'];
	$VhostCurrentConnection = $row['vhost_conn_current'];
	$VhostConnectionsTotal = $row['vhost_conn_total'];
}
echo $VhostConnectionsTotal;
?>