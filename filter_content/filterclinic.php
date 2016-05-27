<?php
//turn on error reporting
ini_set('display_errors', 'On');
//Connect to my ONID database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "rappab-db", "wrimAu98inCzPSYR", "rappab-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>DB: Clinics</title>
</head>
<body>
<div>
	<h2>Database: Clinics</h2>
	<table>
		<tr>
			<td><b>ID</b></td>
			<td><b>Name</b></td>
			<td><b>Location</b></td>
		</tr>
<?php
//declare myquery statement based on how user chose to filter

//LOCATION
if($_POST["submit"] == "Filter by Location")
{
	$myquery = "SELECT id, name, location  FROM clinics "
				. "WHERE location='" . $_POST["location"] . "'";
}
//DEFAULT
else
{
	echo "<br>" . "Error: Could not filter database from submitted form" . "<br>";
	$myquery = "SELECT id, name, location  FROM clinics";
}

//DEBUGGING
echo "<fieldset><legend>Your Query</legend>" 
		. "<p>". $myquery . "</fieldset></br>";

if(!$stmt = $mysqli->prepare($myquery)){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name, $location)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

}
while($stmt->fetch()){
	echo "<tr>\n"
		. "<td>" . $id . "</td>\n"
		. "<td>" . $name . "</td>\n"
		. "<td>" . $location . "</td>\n"
		. "</tr>\n";
}

$stmt->close();
?>			
	</table>
</div>

</br>

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