<?php
// page version: 1.0
require("../../../inc/general_conf.inc.php");
if(empty($_SESSION['user'])) {
	header("Location: ". $DOCUMENT_ROOT . "/index.php");
    die("Redirecting to ". $DOCUMENT_ROOT . "/index.php"); 
}
?>

<?php

// Create connection
$connect = mysqli_connect($dbHost, $dbUserName, $dbUserPasswd, $dbName);
// Check connection
if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}

$output= mysqli_query($connect,"SELECT vhost_bytes_out FROM wow_vhost_status");
while($row=mysqli_fetch_array($output)){ 
	//$VhostBytesIn = $row['vhost_bytes_in'];
	$VhostBytesOut = $row['vhost_bytes_out'];
}

// source = bytes. convert to bits and convert again to kbps
$bandWithOut = $VhostBytesOut * 8 / 1024;

//convert to 2 numbers behind the dot result:  157.56

$bandwithOutgoing = number_format($bandWithOut, 1, '.', '');		
			
//	echo $bandwithIncoming;
echo $bandwithOutgoing;
			
//convert to 2 numbers behind the dot result:  157.56
//$bandwith_kbps = number_format($bandwithOut, 2, '.', '');
			
?>