<?php
// page version: 1.1
//wowza version: minimal 4.0.0
require("../../../inc/general_conf.inc.php");
if(empty($_SESSION['user'])){
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
}
include ("../../../header.php"); 
$xml = simplexml_load_file("http://$WowzaUserName:$WowzaUserPassw@$WowzaHostUrl:$WowzaHostPort/serverinfo");

//Get All Applications (loaded or unloaded)
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'><b>All Applications on the Wowza Server: " . $ApplicationName . "</b></div>";
echo "<table class='table table-bordered'>";
echo "<tr><td><b>Application</b></td><td><b>Status</b></td></tr>";

$application = $xml->xpath('/WowzaStreamingEngine/VHost/Application');
foreach($application as $App) {
	$AppName = "{$App->Name}";
	$AppStatus = "{$App->Status}";
	 
	echo "<tr>";
	echo "<td>" . $AppName . "</td>";
	
	if ($AppStatus == 'loaded'){
		echo "<td><img src='". $DOCUMENT_ROOT . "/img/online-16.png' alt='Online' title='Online'> Loaded</td>";
	}
	else if ($AppStatus == 'unloaded'){
		echo "<td><img src='". $DOCUMENT_ROOT . "/img/offline-16.png' alt='Offline' title='Offline'> Unloaded</td>";
	}

	echo "</tr>";
}
echo "</table>";	
echo "</div>";

echo "<a href='../running_apps.php'class='btn btn-info btn-xs'>Back to Overview</a><br><br>";
include("../../../footer.php"); 
 ?>