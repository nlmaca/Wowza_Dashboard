<?php
// page version: 1.0
require("../inc/general_conf.inc.php");
if(empty($_SESSION['user'])) {
	header("Location: ". $DOCUMENT_ROOT . "/index.php");
    die("Redirecting to ". $DOCUMENT_ROOT . "/index.php"); 
}
?>

<?php include ("../header.php");?>

<script type="text/javascript">
 <!--
function ShowHide() {
 	if (document.getElementById('radio1').checked) {
    	document.getElementById('secret').type = 'text';
    } 
	else {
         document.getElementById('secret').type = 'password';
    }
}
//-->
</script>

<?php
$id = $_POST['id'];


// Create connection
$connect = mysqli_connect($dbHost, $dbUserName, $dbUserPasswd, $dbName);
// Check connection
if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}	

echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Application information</div>";
echo "<table class='table table-bordered'>";


$server = mysqli_query($connect, "select server_name, server_url, server_username, server_password, server_port from wow_connections where data_id= $id");

while($row = mysqli_fetch_array($server)){
	echo "<form name='wowza_edit' action='wowza_update.php' autocomplete='off'' method='POST'>";
	echo "<tr><td>ServerName:</td><td><input type='text' name='servername' value='". $row['server_name']. "'></td></tr>";
	echo "<tr><td>Url(no http): </td><td><input type='text' name='serverurl' value='". $row['server_url']. "'></td></tr>";
	echo "<tr><td>UserName: </td><td><input type='text' name='serverusername' value='". $row['server_username']."'></td></tr>";
	echo "<tr><td>ServerPass: </td><td><input type='password' id='secret' name='serverpassword' value='". $row['server_password']."'><br><br>
	 		<label><input type='radio' id='radio1' name='radio1' value='on' onchange='ShowHide();'>Show</label>
	  		<label><input type='radio' id='radio2' name='radio1' value='off' onchange='ShowHide();'>Hide</label>
		</td></tr>";
	echo "<tr><td>ServerPort: </td><td><input type='text' name='serverport' value='". $row['server_port']."'></td></tr>";
	echo "</table></div>";
	echo "<input type='submit' value='Save settings' class='btn btn-success'>  <a href='wowza_overview.php'class='btn btn-info'>Cancel</a>";
	echo "<input type='hidden' name='id' value='$id'>";
	echo "</form>";
}	


mysqli_close($connect);


?>
<?php include ("../footer.php");?>
