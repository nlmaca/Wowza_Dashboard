<?php
// page version: 1.0
require("../../../inc/general_conf.inc.php");
    if(empty($_SESSION['user'])) 
    {
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

// extract xml
//date based on date_default_timezone_set('Europe/Amsterdam'); setting can be found in general config. later on in settings page.
$date = date('Y-m-d H:i:s');
echo "Last Update: " .  $date; 
$xml = simplexml_load_file("http://$WowzaUserName:$WowzaUserPassw@$WowzaHostUrl:$WowzaHostPort/connectioncounts");

$clean1= "TRUNCATE wow_vhost_status";		
	if (mysqli_query($connect, $clean1)) {
		//only enable for debugging
		//echo  ": Table wow_vhost_status: <img src='". $DOCUMENT_ROOT . "/img/online.png'>";
	}	
	else {
		echo "Error: " . $clean1. "<br>" . mysqli_error($connect);
	}	


// Server Level
$server = $xml->xpath('/WowzaStreamingEngine/VHost');
	foreach($server as $serv) {
		$VHostName = "{$serv->Name}";
		$VHostTimeRunning = "{$serv->TimeRunning}";
		$VHostConnectionsLimit = "{$serv->ConnectionsLimit}";		
		$VHostConnectionsCurrent = "{$serv->ConnectionsCurrent}";
		$VHostConnectionsTotal = "{$serv->ConnectionsTotal}";
		$VHostConnectionsTotalAccepted = "{$serv->ConnectionsTotalAccepted}";
		$VHostConnectionsTotalRejected = "{$serv->ConnectionsTotalRejected}";
		$VHostMessagesInBytesRate = "{$serv->MessagesInBytesRate}";
		$VHostMessagesOutBytesRate = "{$serv->MessagesOutBytesRate}";
	
		$vhost_update= "INSERT INTO wow_vhost_status (session_time, vhost_name, vhost_timerunning, vhost_conn_limit, vhost_conn_current, vhost_conn_total, vhost_conn_accepted, vhost_conn_rejected, vhost_bytes_in, vhost_bytes_out) 
		VALUES (CURRENT_TIMESTAMP, '$VHostName', '$VHostTimeRunning', '$VHostConnectionsLimit', '$VHostConnectionsCurrent', '$VHostConnectionsTotal', '$VHostConnectionsTotalAccepted', '$VHostConnectionsTotalRejected', '$VHostMessagesInBytesRate' , '$VHostMessagesOutBytesRate ')";

 		if (mysqli_query($connect, $vhost_update)) {
			//only enable for debugging
			//echo " | Added new Data: <img src='". $DOCUMENT_ROOT . "/img/online.png'>";
		}	
		else {
			echo "Error: " . $vhost_update . "<br>" . mysqli_error($connect);
		}
	
	}

// Application Level

$clean1= "TRUNCATE wow_app_status";		
	if (mysqli_query($connect, $clean1)) {
		//only enable for debugging
		//echo  " | Table wow_app_status: <img src='". $DOCUMENT_ROOT . "/img/online.png'>";
	}	
	else {
		echo "Error: " . $clean1. "<br>" . mysqli_error($connect);
	}	
	$application = $xml->xpath('/WowzaStreamingEngine/VHost/Application');
 	foreach($application as $app) {
		$AppName =  "{$app->Name}";
		$AppStatus =  "{$app->Status}";
		$AppMessagesInBytesRate = "{$app->MessagesInBytesRate}";                           
		$AppMessagesOutBytesRate = "{$app->MessagesOutBytesRate}";   
		$AppInstStreamName = "{$app->ApplicationInstance->Stream->Name}";

//might strip this in newer release.		
		if ($AppMessagesInBytesRate > 100) {
			$online = 1;
			//echo  "<tr><td><img src='online.png'></td>";
		}
		else if ($AppMessagesOutBytesRate > 300) {
			$online = 1;
			//echo  "<tr><td><img src='online.png'></td>";
		}
		else {
			$online = 0;
			//echo  "<tr><td><img src='offline.png'></td>";
		}
	
		//update wow_app_status	
		$app_update = "INSERT INTO wow_app_status (session_time, app_name, app_online, app_bytes_in, app_bytes_out, app_stream_name) 
		VALUES (CURRENT_TIMESTAMP, '$AppName', '$online', '$AppMessagesInBytesRate', '$AppMessagesOutBytesRate', '$AppInstStreamName')";
		
		if (mysqli_query($connect, $app_update)) {
		//	echo " | Added new App Data <img src='../img/online.png'>";
		}	
		else {
			echo "Error: " . $app_update . "<br>" . mysqli_error($connect);
		}	
    }
mysqli_close($connect);
?>
 