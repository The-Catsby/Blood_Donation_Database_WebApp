<?php
//turn on error reporting
ini_set('display_errors', 'On');
//Connect to my ONID database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "rappab-db", "wrimAu98inCzPSYR", "rappab-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}	

//validate data
if($_POST["ddate"] == "")
{
	$_POST["ddate"] = NULL;	//if user didn't enter a date, set to NULL
}

//	add POST data
if(!$stmt = $mysqli->prepare("INSERT INTO blood (bloodtype, status, donor_id, clinic_id, ddate) VALUES (?,?,?,?,?)")){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ssiis", $_POST["bloodtype"], $_POST["status"], 
                        $_POST["donor_id"], $_POST["clinic_id"], $_POST["ddate"]))){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
} 
else {
	echo "Added " . $stmt->affected_rows . " rows to blood.";
}
$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Add Blood</title>
</head>
<body>

<!-- Navigation Links !-->
<div>
<h2><a href="../home.php">Return to Home Page</a></h2>
	<h3>See Contents of Database: </h3>
	<ol>
		<li><p><a href="../get_content/donors.php">Donors</a></p>
		<li><p><a href="../get_content/employees.php">Employees</a></p>
		<li><p><a href="../get_content/clinics.php">Clinics</a></p>
		<li><p><a href="../get_content/blood.php">Blood</a></p>
		<li><p><a href="../get_content/certifications.php">Certifications</a></p>
        <li><p><a href="../get_content/empcert.php">Employee-Certifications</a></p>
	<ol>
</div>

</body>
</html>