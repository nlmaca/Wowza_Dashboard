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
/* check OUTPUT */
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>User information</div>";
echo "<table class='table'>";
echo "<tr><td><b>#</b></td><td><b>Username</b></td><td><b>Email</b></td><td><b>Delete</b></td></tr>";

// Create connection
$connect = mysqli_connect($dbHost, $dbUserName, $dbUserPasswd, $dbName);
// Check connection
if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}	
	
$output= mysqli_query($connect,"select id, username, email from wow_users");
while($row=mysqli_fetch_array($output)){ 
	
	if ($row['id'] > 0) {
		echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] .  "</td>";
		echo "<td>" . $row['email'] .  "</td>";
		
		//delete user
		echo "<form action='user_delete.php' method='POST'>";
		echo "<td><input type='submit' value='Delete' class='btn btn-info btn-xs'></td>";
		echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
		echo "</form>";

		echo "</tr>";
	}
	else {
		echo "No users found";
	}
}

mysqli_close($connect);
echo "</table></div>";
echo "<a href='user_create.php' class='btn btn-info btn-xs'>Create User</a>";
?>
<?php include ("../footer.php");?>