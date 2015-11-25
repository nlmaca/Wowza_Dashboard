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

$ApplicationName = htmlspecialchars($_GET['AppName']);

//$application = $xml->xpath('/WowzaStreamingEngine/VHost/Application[Name="' . $ApplicationName . '"]/ApplicationInstance/HTTPSession');
//time to extract the complete xml output

//Application
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'><b>Application: " . $ApplicationName . "</div>";
echo "<table class='table table-bordered'>";
echo "<tr><td><b>Name</b></td><td><b>Status</b></td><td><b>Time</b></td><td><b>Current</b></td><td><b>Total</b></td><td><b>Accepted</b></td><td><b>Rejected</b></td><td><b>Name</b></td><td><b>Time</b></td>
<td><b>RTMP</b></td><td><b>RTP</b></td><td><b>Cupertino</b></td><td><b>Smooth</b></td></tr>";

$application = $xml->xpath('/WowzaStreamingEngine/VHost/Application[Name="' . $ApplicationName . '"]');
foreach($application as $App) {
	$AppName = "{$App->Name}";
	$AppStatus = "{$App->Status}";
	$AppTimeRunning = "{$App->TimeRunning}";	
	$AppConnectionsCurrent = "{$App->ConnectionsCurrent}";
	$AppConnectionsTotal = "{$App->ConnectionsTotal}";
	$AppConnectionsTotalAccepted = "{$App->ConnectionsTotalAccepted}";
	$AppConnectionsTotalRejected = "{$App->ConnectionsTotalRejected}";

	$AppNameInstName = "{$App->ApplicationInstance->Name}";
	$AppNameInstTimeRunning = "{$App->ApplicationInstance->TimeRunning}";
	$AppNameInstRTMP = "{$App->ApplicationInstance->RTMPConnectionCount}";
	$AppNameInstRTP = "{$App->ApplicationInstance->RTPConnectionCount}";
	$AppNameInstCupertino = "{$App->ApplicationInstance->CupertinoConnectionCount}";
	$AppNameInstSmooth = "{$App->ApplicationInstance->SmoothConnectionCount}";
	//$AppNameInstRTMPSession = "{$App->ApplicationInstance->RTMPSessionCount}";
	 
	echo "<tr>";
	echo "<td>" .  $AppName . "</td>";
	echo "<td>" .  $AppStatus . "</td>";
	echo "<td>" .  gmdate('H:i:s',$AppTimeRunning) . "</td>";
	echo "<td>" .  $AppConnectionsCurrent . "</td>";
	echo "<td>" .  $AppConnectionsTotal . "</td>";
	echo "<td>" .  $AppConnectionsTotalAccepted . "</td>";
	echo "<td>" .  $AppConnectionsTotalRejected . "</td>";
	echo "<td>" .  $AppNameInstName . "</td>";
	echo "<td>" .  gmdate('H:i:s',$AppNameInstTimeRunning) . "</td>";
	echo "<td>" .  $AppNameInstRTMP . "</td>";
	echo "<td>" .  $AppNameInstRTP . "</td>";
	echo "<td>" .  $AppNameInstCupertino . "</td>";
	echo "<td>" .  $AppNameInstSmooth . "</td>";
	//echo "<td>" .  $AppNameInstRTMPSession . "</td>";
	echo "</tr>";
}
echo "</table>";	
echo "</div>";

//Application Instance Client
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Application / ApplicationInstance / Client Session</div>";
echo "<table class='table table-bordered'>";
echo "<tr><td><b>Wowza Id</b></td><td><b>Client</b></td><td><b>Protocol</b></td><td><b>Ip Address</b></td><td><b>Referer</b></td><td><b>Playtime</b></td><td><b>Started</b></td>
<td><b>Port</b></td><td><b>Data Send Mbps</b></td><td><b>Data Received Mbps</b></td></tr>";

$Client = $xml->xpath('/WowzaStreamingEngine/VHost/Application[Name="' . $ApplicationName . '"]/ApplicationInstance/Client');
foreach($Client as $AppCL) {
	$AppClientId = "{$AppCL->ClientId}";
	$AppClientFlash = "{$AppCL->FlashVersion}";
	$AppClientIpAddress = "{$AppCL->IpAddress}";		
	$AppClientReferrer = "{$AppCL->Referrer}";
	$AppClientTimeRunning = "{$AppCL->TimeRunning}";
	$AppClientDateStarted = "{$AppCL->DateStarted}";
	$AppClientProtocol = "{$AppCL->Protocol}";
	$AppClientPort = "{$AppCL->Port}";
	$AppClientIoSessionBytesSent = "{$AppCL->IoSessionBytesSent}";		
	$AppClientIoSessionBytesReceived = "{$AppCL->IoSessionBytesReceived}";		
	$AppClientIoSessionLastlo = "{$AppCL->IoSessionLastIo}";		
	$AppClientIoBytesSent = "{$AppCL->IoBytesSent}";		
	$AppClientIoBytesReceived = "{$AppCL->IoBytesReceived}";
	//$AppClientQueryString = "{$AppCL->QueryString}";	
	//$AppClientURL = "{$AppCL->URI}";
	//$AppClientIsSSL = "{$AppCL->IsSSL}";
	//$AppClientIsEncrypted = "{$AppCL->IsEncrypted}";
	//$AppClientLastValidateTime = "{$AppCL->LastValidateTime}";	
				
	echo "<tr>";
	echo "<td>" .  $AppClientId . "</td>";
	
	$tooling = $AppClientFlash;
	if (preg_match('/FME/',$tooling)){
		echo  "<td><img src='". $DOCUMENT_ROOT . "/img/flash_icon.png' alt='" . $AppClientFlash . "' title='" . $AppClientFlash . "'></td>";
	}
	else if (preg_match('/FMLE/',$tooling)){
		echo  "<td><img src='". $DOCUMENT_ROOT . "/img/flash_icon.png' alt='" . $AppClientFlash . "' title='" . $AppClientFlash . "'></td>";
	}
	else if (preg_match('/WIN/',$tooling)){
		echo  "<td><img src='". $DOCUMENT_ROOT . "/img/windows_icon.png' alt='" . $AppClientFlash . "' title='" . $AppClientFlash . "'></td>";
	}
	else if (preg_match('/Unknown/',$tooling)){
		echo  "<td>?: " . $AppClientFlash . "</td>";
	}
	else {
		echo  "<td>" . $AppClientFlash . "</td>";
	}
	
	echo "<td>" .  $AppClientProtocol . "</td>";
	echo "<td>" .  $AppClientIpAddress . "</td>";
	echo "<td>" .  $AppClientReferrer . "</td>";
	echo "<td>" .  gmdate('H:i:s',$AppClientTimeRunning) . "</td>";
	echo "<td>" .  $AppClientDateStarted . "</td>";
	echo "<td>" .  $AppClientPort . "</td>";
	
	//echo "<td>" .  $AppClientIoSessionBytesSent . "</td>";
	$bandWithOut = number_format(($AppClientIoSessionBytesSent * 8 / 1000000), 2, '.','');
	echo "<td>" .  $bandWithOut . "</td>";
	$bandWithIn = number_format(($AppClientIoSessionBytesReceived * 8 / 1000000), 2, '.','');
	echo "<td>" .  $bandWithIn . "</td>";
	//echo "<td>" .  $AppClientIoSessionLastlo . "</td>";
	//echo "<td>" .  $AppClientIoBytesSent . "</td>";
	//echo "<td>" .  $AppClientIoBytesReceived . "</td>";			
	// echo "<td>" .  $AppClientQueryString . "</td>";
	//echo "<td>" .  $AppClientURL . "</td>";
	//echo "<td>" .  $AppClientIsSSL . "</td>";
	//echo "<td>" .  $AppClientIsEncrypted . "</td>";
	//echo "<td>" .  $AppClientLastValidateTime . "</td>";
	//echo "<td>" .  $AppClientIoSessionBytesSent . "</td>";
	echo "</tr>";
}
	  
echo "</table>";
echo "</div>";

//Application / ApplicationInstance / HTTP
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Application / ApplicationInstance / HTTPSession</div>";
echo "<table class='table table-bordered'>";
echo "<tr><td><b>Session Id</b></td><td><b>IP</b></td><td><b>Playtime</b></td><td><b>Started</b></td><td><b>url</b></td><td><b>Protocol</b></td>
<td><b>Type</b></td><td><b>Port</b></td><td><b>Data Send Mbps</b></td><td><b>Data Received Mbps</b></td></tr>";

$application2 = $xml->xpath('/WowzaStreamingEngine/VHost/Application[Name="' . $ApplicationName . '"]/ApplicationInstance/HTTPSession');
foreach($application2 as $App2) {
	$HTTPSessionId = "{$App2->SessionId}";
	$HTTPIpAddress = "{$App2->IpAddress}";	
	$HTTPReferrer = "{$App2->Referrer}";	
	//$HTTPQueryString = "{$App2->QueryString}";	
	$HTTPTimeRunning = "{$App2->TimeRunning}";	
	$HTTPDateStarted = "{$App2->DateStarted}";	
	$HTTPURI = "{$App2->URI}";	
	$HTTPProtocol = "{$App2->Protocol}";	
	$HTTPSessionType = "{$App2->SessionType}";	
	$HTTPPort = "{$App2->Port}";	
	$HTTPIoBytesSent = "{$App2->IoBytesSent}";
	$HTTPIoBytesReceived = "{$App2->IoBytesReceived}";	
	$HTTPIoLastRequest = "{$App2->IoLastRequest}";
		 
	echo "<tr>";	
	echo "<td>" .  $HTTPSessionId . "</td>";
	echo "<td>" .  $HTTPIpAddress . "</td>";
	//echo "<td>" .  $HTTPReferrer . "</td>";
	//echo "<td>" .  $HTTPQueryString . "</td>";
	echo "<td>" .  gmdate('H:i:s',$HTTPTimeRunning) . "</td>";
	echo "<td>" .  $HTTPDateStarted . "</td>";
	echo "<td>" .  $HTTPURI . "</td>";
	echo "<td>" .  $HTTPProtocol . "</td>";
	echo "<td>" .  $HTTPSessionType . "</td>";
	echo "<td>" .  $HTTPPort . "</td>";
	
	$bandWithOut2 = number_format(($HTTPIoBytesSent * 8 / 1000000), 2, '.','');
	echo "<td>" .  $bandWithOut2 . "</td>";
	
	$bandWithIn2 = number_format(($HTTPIoBytesReceived * 8 / 1000000), 2, '.','');
	echo "<td>" .  $bandWithIn2 . "</td>";
	//echo "<td>" .  $HTTPIoLastRequest . "</td>";
	echo "</tr>";		 
}
echo "</table>";
echo "</div>";

//Application / ApplicationInstance / RTSP
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Application / ApplicationInstance / RTPSession</div>";
echo "<table class='table table-bordered'>";
echo "<tr><td><b>Session Id</b></td><td><b>IP</b></td><td><b>Playtime</b></td><td><b>Started</b></td><td><b>url</b></td><td><b>Port</b></td>
<td><b>Data Send Mbps</b></td><td><b>Data Received Mbps</b></td></tr>";

$application3 = $xml->xpath('/WowzaStreamingEngine/VHost/Application[Name="' . $ApplicationName . '"]/ApplicationInstance/RTPSession');
foreach($application3 as $App3) {
	$RTPSessionId = "{$App3->SessionId}";
	$RTPIpAddress = "{$App3->IpAddress}";	
	$RTPReferrer = "{$App3->Referrer}";	
	//$RTPQueryString = "{$App3->QueryString}";	
	$RTPTimeRunning = "{$App3->TimeRunning}";	
	$RTPDateStarted = "{$App3->DateStarted}";	
	$RTPURI = "{$App3->URI}";	
	$RTPPort = "{$App3->Port}";	
	$RTPIoBytesSent = "{$App3->IoBytesSent}";	
	$RTPIoBytesReceived = "{$App3->IoBytesReceived}";	
		 
	echo "<tr>";	
	echo "<td>" .  $RTPSessionId . "</td>";
	echo "<td>" .  $RTPIpAddress . "</td>";		
	//echo "<td>" .  $RTPReferrer . "</td>";
	//echo "<td>" .  $RTPQueryString . "</td>";		
	echo "<td>" .  gmdate('H:i:s',$RTPTimeRunning) . "</td>";
	echo "<td>" .  $RTPDateStarted . "</td>";		
	echo "<td>" .  $RTPURI . "</td>";
	echo "<td>" .  $RTPPort . "</td>";		
	
	$bandWithOut3 = number_format(($RTPIoBytesSent * 8 / 1000000), 2, '.','');
	echo "<td>" .  $bandWithOut3 . "</td>";
	$bandWithIn3 = number_format(($RTPIoBytesReceived * 8 / 1000000), 2, '.','');
	echo "<td>" .  $bandWithIn3 . "</td>";		
	echo "</tr>";		 
}
echo "</table>"; 
echo "</div>";

echo "<a href='../running_apps.php'class='btn btn-info btn-xs'>Back to Overview</a><br><br>";
include("../../../footer.php"); 
 ?>