<?php
// page version: 1.0
require("../inc/general_conf.inc.php");
if(empty($_SESSION['user'])) {
	header("Location: ". $DOCUMENT_ROOT . "/index.php");
    die("Redirecting to ". $DOCUMENT_ROOT . "/index.php"); 
}
?>

<?php include ("../header.php");?>
<div class="jumbotron">
	<div class="container">
    	<h3>Wowza Streaming Engine</h3>
        <p>These settings have to be set on the Wowza server in the streaming manager.<br>
		</p>
    </div>
</div>

<?php
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Wowza Streaming Engine settings</div>";
echo "<table class='table table-bordered'>";
//echo "<tr><td><b>Id</b></td><td><b>ServerName</b></td><td><b>Url</b></td><td><b>username</b></td><td><b>password</b></td><td><b>port</b></td></tr>";

// Create connection
$connect = mysqli_connect($dbHost, $dbUserName, $dbUserPasswd, $dbName);
// Check connection
if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}	

$output= mysqli_query($connect,"select data_id, server_name, server_url, server_username, server_password, server_port from wow_connections");
while($row=mysqli_fetch_array($output)){ 
	if ($row['data_id'] > 0) {
		echo "<tr><td class='col-md-4'>#: </td><td>" . $row['data_id'] . "</td></tr>";
		echo "<tr><td class='col-md-4'>ServerName: </td><td>" . $row['server_name'] .  "</td></tr>";
		echo "<tr><td class='col-md-4'>URL: </td><td>" . $row['server_url'] .  "</td></tr>";
		echo "<tr><td class='col-md-4'>Username: </td><td>" . $row['server_username'] .  "</td></tr>";
		echo "<tr><td class='col-md-4'>Password: </td><td>" . $row['server_password'] .  "</td></tr>";
		echo "<tr><td class='col-md-4'>Port: </td><td>" . $row['server_port'] .  "</td></tr>";
		echo "</table></div>";
		echo "<form action='wowza_edit.php' method='POST'>";
		echo "<input type='submit' value='Edit' class='btn btn-info'>";
		echo "<input type='hidden' name='id' value='" . $row['data_id'] . "'>";
		echo "</form>";

	}
	else {
		//input page
		echo "no data";
	}
}


mysqli_close($connect);
		
?>
<?php include ("../footer.php");?>
