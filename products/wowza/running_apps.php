<?php
// page version: 1.0
require("../../inc/general_conf.inc.php");
if(empty($_SESSION['user'])) {
	header("Location: ". $DOCUMENT_ROOT . "/index.php");
    die("Redirecting to ". $DOCUMENT_ROOT . "/index.php"); 
}

/*
status overview
online = 0 (everything is oflline)
online = 1 app_bytes_in > 0 and app_bytes_out = 0 (only upload is active)
online = 2 app_bytes_in < 100 and app_bytes_out > 0 (only download is active)
online = 3 app_bytes_in > 1 and app_bytes_out > 1 (upload is active and download is active)
*/

$page = $_SERVER['PHP_SELF'];
$sec = "65";
header("Refresh: $sec; url=$page");

// loading of extract_connectioncounts only necessary when not using cronjob
?>
<script type="text/javascript">
	function updateXML(){
    	$('#updateXMLfile').load('xml/extract_connectioncounts.php');
	}
	setInterval( "updateXML()", 30000 );
</script>

<?php 
include ("../../header.php"); 
// Create connection
$connect = mysqli_connect($dbHost, $dbUserName, $dbUserPasswd, $dbName);

// Check connection
if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}	

echo "<div class='panel panel-default'>";
echo "<div class='panel-heading' id='updateXMLfile'>All (running) applications: Update every 30 seconds</div>";
echo "<table class='table table-bordered'>";
echo "<tr><td><b>Status</b></td><td><b>Date</b></td><td><b>Application</b></td><td><b>kbpsIN</b></td><td><b>kbpsOUT</b></td><td><b>Details</b></td></tr>";
			
$output= mysqli_query($connect,"SELECT * FROM `wow_app_status` group by app_name order by session_time desc");
while($row=mysqli_fetch_array($output)){ 
	if ($row['app_bytes_in'] > 1 AND $row['app_bytes_out'] > 1){
		$online = 3;
		echo  "<tr><td><img src='". $DOCUMENT_ROOT . "/img/online-16.png' alt='Online' title='Online'>&nbsp;
		<img src='". $DOCUMENT_ROOT . "/img/arrow-upload-16.png' alt='Incoming' title='Incoming'>&nbsp;
		<img src='". $DOCUMENT_ROOT . "/img/arrow-download-16.png' alt='Outgoing' title='Outgoing'></td>";
	}
	else if ($row['app_bytes_in'] < 100 AND $row['app_bytes_out'] > 0){
		$online = 2;
		echo  "<tr><td><img src='". $DOCUMENT_ROOT . "/img/online-16.png' alt='Online' title='Online'>&nbsp;
		<img src='". $DOCUMENT_ROOT . "/img/arrow-download-16.png' alt='Outgoing' title='Outgoing'></td>";
	}
	else if ($row['app_bytes_in']> 0 AND $row['app_bytes_out'] = 0) {
		$online = 1;
		echo  "<tr><td><img src='". $DOCUMENT_ROOT . "/img/online-16.png' alt='Online' title='Online'></td>";
	}
	else  {
		$online = 0;
		echo  "<tr><td><img src='". $DOCUMENT_ROOT . "/img/offline-16.png' alt='Offline' title='Offline'></td>";
	}
	echo "<td>" . $row['session_time']. "</td>";
	echo "<td>" . $row['app_name'] . "</td>";
	
	$bandWithIn = $row['app_bytes_in'] * 8 / 1024;
	$bandwithIncoming = number_format($bandWithIn, 1, '.', '');
	echo "<td>" . $bandwithIncoming . "</td>";
	
	$bandWithOut = $row['app_bytes_out'] * 8 / 1024;
	$bandwithOutgoing = number_format($bandWithOut, 2, '.', '');	
	echo "<td>" . $bandwithOutgoing . "</td>";
	
	
	//echo "<td>" . $row['app_stream_name']  . "</td>";	
	echo "<td><a href='xml/extract_serverinfo.php?AppName=" . $row['app_name']  . "'><button type='button' class='btn btn-success'><i class='fa fa-random'></i>
    </button></a></td>";
	echo "</tr>";
}

mysqli_close($connect);
echo "</table></div>";

include("../../footer.php"); 
?>

