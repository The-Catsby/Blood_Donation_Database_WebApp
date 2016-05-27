<?php
//turn on error reporting
ini_set('display_errors', 'On');
//Connect to my ONID database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "rappab-db", "wrimAu98inCzPSYR", "rappab-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}	
	
//add post data
if(!$stmt = $mysqli->prepare("INSERT INTO clinics (name, location) VALUES (?,?)")){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ss", $_POST["name"], $_POST["location"]))){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
} 
else {
	echo "Added " . $stmt->affected_rows . " rows to clinics.";
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Add Clinic</title>
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