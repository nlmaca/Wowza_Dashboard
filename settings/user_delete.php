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

// Create connection
$connect = mysqli_connect($dbHost, $dbUserName, $dbUserPasswd, $dbName);
// Check connection
if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}	

$userDelete = mysqli_query($connect, "DELETE FROM wow_users where id = $id");

echo "Succesfully removed user<br><br>";
echo "<a href='user_overview.php' class='btn btn-info'>Return Home</a>";

mysqli_close($connect);

?>
<?php include ("../footer.php");?>
