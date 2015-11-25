<?php
// page version: 1.1
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

// extract xml
//date based on date_default_timezone_set('Europe/Amsterdam'); setting can be found in general config.
$date = date('Y-m-d H:i:s');
echo "Last Update: " .  $date; 
$xml = simplexml_load_file("http://$WowzaUserName:$WowzaUserPassw@$WowzaHostUrl:$WowzaHostPort/connectioncounts");

//server level
$serverRoot = $xml->xpath('/WowzaStreamingEngine');
foreach($serverRoot as $root) {
	$RootConnectionsCurrent = "{$root->ConnectionsCurrent}";
	$RootConnectionsTotal = "{$root->ConnectionsTotal}";
	$RootConnectionsTotalAccepted = "{$root->ConnectionsTotalAccepted}";
	$RootConnectionsTotalRejected = "{$root->ConnectionsTotalRejected}";
	$RootMessagesInBytesRate = "{$root->MessagesInBytesRate}";
	$RootMessagesOutBytesRate = "{$root->MessagesOutBytesRate}";
	
	echo "<table border=1><th>Server level</th>
	<tr><td>Conn Current</td><td>Conn total</td><td>Conn Accepted</td><td>Conn Rejected</td><td>BytesIn</td><td>BytesOut</td></tr>";
	echo "<tr>";
	echo "<td>" . $RootConnectionsCurrent . "</td>";
	echo "<td>" . $RootConnectionsTotal . "</td>";
	echo "<td>" . $RootConnectionsTotalAccepted . "</td>";
	echo "<td>" . $RootConnectionsTotalRejected . "</td>";
	echo "<td>" . $RootMessagesInBytesRate . "</td>";
	echo "<td>" . $RootMessagesOutBytesRate . "</td>";
	echo "</tr></table>";
	echo "<br><br>";
}

// Vhost Level
$serverVhost = $xml->xpath('/WowzaStreamingEngine/VHost');
foreach($serverVhost as $vhost) {
	$VHostName = "{$vhost->Name}";
	$VHostTimeRunning = "{$vhost->TimeRunning}";
	$VHostConnectionsLimit = "{$vhost->ConnectionsLimit}";		
	$VHostConnectionsCurrent = "{$vhost->ConnectionsCurrent}";
	$VHostConnectionsTotal = "{$vhost->ConnectionsTotal}";
	$VHostConnectionsTotalAccepted = "{$vhost->ConnectionsTotalAccepted}";
	$VHostConnectionsTotalRejected = "{$vhost->ConnectionsTotalRejected}";
	$VHostMessagesInBytesRate = "{$vhost->MessagesInBytesRate}";
	$VHostMessagesOutBytesRate = "{$vhost->MessagesOutBytesRate}";
	
	echo "<table border=1><th>VHost level</th>
	<tr><td>Name</td><td>Timerunning</td><td>Conn limit</td><td>Conn Curr</td><td>Conn total</td><td>Conn tot acc</td><td>Conn total Rej</td><td>BytesIn</td><td>BytesOut</td></tr>";
	echo "<tr>";
	echo "<td>" . $VHostName . "</td>";
	echo "<td>" . $VHostTimeRunning . "</td>";
	echo "<td>" . $VHostConnectionsLimit . "</td>";
	echo "<td>" . $VHostConnectionsCurrent . "</td>";
	echo "<td>" . $VHostConnectionsTotal . "</td>";
	echo "<td>" . $VHostConnectionsTotalAccepted . "</td>";
	echo "<td>" . $VHostConnectionsTotalRejected . "</td>";
	echo "<td>" . $VHostMessagesInBytesRate . "</td>";
	echo "<td>" . $VHostMessagesOutBytesRate . "</td>";
	echo "</tr></table>";
	echo "<br><br>";
	echo "<hr>";
}

//application level
$application = $xml->xpath('/WowzaStreamingEngine/VHost/Application');
foreach($application as $app) {
	$AppName =  "{$app->Name}";
	$AppStatus =  "{$app->Status}";
	$AppTimeRunning = "{$app->TimeRunning}";
	$AppConnectionsCurrent =  "{$app->ConnectionsCurrent}";
	$AppConnectionsTotal =  "{$app->ConnetionsTotal}";
	$AppConnectionsTotalAccepted =  "{$app->ConnectionsTotalAccepted}";
	$AppConnectionsTotalRejected =  "{$app->ConnetionsTotalRejected}";
	$AppMessagesInBytesRate = "{$app->MessagesInBytesRate}";                           
	$AppMessagesOutBytesRate = "{$app->MessagesOutBytesRate}";   
	
	echo "<table border=1><th>Application level</th>
	<tr><td>App Name</td><td>Status</td><td>Timerunning</td><td>Conn Curr</td><td>Conn total</td><td>Conn tot acc</td><td>Conn total Rej</td><td>BytesIn</td><td>BytesOut</td></tr>";
	echo "<tr>";
	echo "<td>" . $AppName . "</td>";
	echo "<td>" . $AppStatus . "</td>";
	echo "<td>" . $AppTimeRunning . "</td>";
	echo "<td>" . $AppConnectionsCurrent . "</td>";
	echo "<td>" . $AppConnectionsTotal . "</td>";
	echo "<td>" . $AppConnectionsTotalAccepted . "</td>";
	echo "<td>" . $AppConnectionsTotalRejected . "</td>";
	echo "<td>" . $AppMessagesInBytesRate . "</td>";
	echo "<td>" . $AppMessagesOutBytesRate . "</td>";
	echo "</tr></table>";
	echo "<br><br>";
		
	//ApplciationInstance
	$AppInstName = "{$app->ApplicationInstance->Name}";
	$AppInstTimeRunning = "{$app->ApplicationInstance->TimeRunning}";
	$AppInstConnectionsCurrent = "{$app->ApplicationInstance->ConnectionsCurrent}";
	$AppInstConnectionsTotal = "{$app->ApplicationInstance->ConnectionsTotal}";
	$AppInstConnectionsTotalAccepted = "{$app->ApplicationInstance->ConnectionsTotalAccepted}";
	$AppInstConnectionsTotalRejected = "{$app->ApplicationInstance->ConnectionsTotalRejected}";
	$AppInstMessagesInBytesRate = "{$app->ApplicationInstance->MessagesInBytesRate}";
	$AppInstMessagesOutBytesRate = "{$app->ApplicationInstance->MessagesOutBytesRate}";
	
	echo "<table border=1><th>ApplicationInstance level</th>
	<tr><td>App Inst Name</td><td>Timerunning</td><td>Conn Curr</td><td>Conn total</td><td>Conn tot acc</td><td>Conn total Rej</td><td>BytesIn</td><td>BytesOut</td></tr>";
	echo "<tr>";
	echo "<td>" . $AppInstName . "</td>";
	echo "<td>" . $AppInstTimeRunning . "</td>";
	echo "<td>" . $AppInstConnectionsCurrent . "</td>";
	echo "<td>" . $AppInstConnectionsTotal . "</td>";
	echo "<td>" . $AppInstConnectionsTotalAccepted . "</td>";
	echo "<td>" . $AppInstConnectionsTotalRejected . "</td>";
	echo "<td>" . $AppInstMessagesInBytesRate . "</td>";
	echo "<td>" . $AppInstMessagesOutBytesRate . "</td>";
	echo "</tr></table>";	
	echo "<br><br>";
	
	//stream
	$AppInstStreamName = "{$app->ApplicationInstance->Stream->Name}";
	$AppInstStreamSessionsFlash = "{$app->ApplicationInstance->Stream->SessionsFlash}";
	$AppInstStreamSessionsCupertino = "{$app->ApplicationInstance->Stream->SessionsCupertino}";
	$AppInstStreamSessionsSanJose = "{$app->ApplicationInstance->Stream->SessionsSanJose}";
	$AppInstStreamSessionsSmooth = "{$app->ApplicationInstance->Stream->SessionsSmooth}";
	$AppInstStreamSessionsRTSP = "{$app->ApplicationInstance->Stream->SessionsRTSP}";
	$AppInstStreamSessionsTotal = "{$app->ApplicationInstance->Stream->SessionsTotal}";
	
	echo "<table border=1><th>ApplicationInstance Stream level</th>
	<tr><td>Stream Name</td><td>Flash</td><td>Cupertino</td><td>SanJose</td><td>Smooth</td><td>RTSP</td><td>Total</td></tr>";
	echo "<tr>";
	echo "<td>" . $AppInstStreamName . "</td>";
	echo "<td>" . $AppInstStreamSessionsFlash . "</td>";
	echo "<td>" . $AppInstStreamSessionsCupertino . "</td>";
	echo "<td>" . $AppInstStreamSessionsSanJose . "</td>";
	echo "<td>" . $AppInstStreamSessionsSmooth . "</td>";
	echo "<td>" . $AppInstStreamSessionsRTSP . "</td>";
	echo "<td>" . $AppInstStreamSessionsTotal . "</td>";
	echo "</tr></table>";
	echo "<br><br>";	
	echo "<hr>";
}

?>
 