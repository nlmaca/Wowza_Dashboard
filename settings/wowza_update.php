<?php
// page version: 1.0
require("../inc/general_conf.inc.php");
if(empty($_SESSION['user'])) {
	header("Location: ". $DOCUMENT_ROOT . "/index.php");
    die("Redirecting to ". $DOCUMENT_ROOT . "/index.php"); 
}
?>

<?php include ("../header.php");?>


<?php
$id = $_POST['id'];
$server_name = $_POST['servername'];
$server_url = $_POST['serverurl'];
$server_username = $_POST['serverusername'];
$server_password = $_POST['serverpassword'];
$server_port = $_POST['serverport'];

// Create connection
$connect = mysqli_connect($dbHost, $dbUserName, $dbUserPasswd, $dbName);
// Check connection
if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}	

echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Application information</div>";
echo "<table class='table table-bordered'>";

//$ServerUpdate = mysqli_query($connect, "select server_name, server_url, server_username, server_password, server_port from wow_connections where data_id=$id");

$ServerUpdate = mysqli_query($connect, "UPDATE `wow_connections` SET server_name= '$server_name', server_url = '$server_url', server_username = '$server_username', server_password = '$server_password', server_port = '$server_port' where data_id= '$id'");

echo "Succesfully edited settings<br>";
echo "<a href='wowza_overview.php' class='btn btn-info'>Return Home</a>";


mysqli_close($connect);
echo "</table></div>";

?>
<?php include ("../footer.php");?>
