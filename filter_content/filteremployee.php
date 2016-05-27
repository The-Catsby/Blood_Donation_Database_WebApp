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
	<title>DB: Employees</title>
</head>
<body>
<div>
	<h2>Database: Employees</h2>
	<table>
		<tr>
			<td><b>ID</b></td>
			<td><b>First Name</b></td>
			<td><b>Last Name</b></td>
			<td><b>Sex</b></td>
			<td><b>Clinic ID</b></td>
			<td><b>Clinic Name</b></td>
		</tr>
<?php
//declare myquery statement based on how user chose to filter

//SEX
if($_POST["submit"] == "Filter by Sex")
{
	$myquery = "SELECT e.id, e.fname, e.lname, e.sex, c.id, c.name FROM employees AS e
							INNER JOIN clinics AS c ON e.clinic_id=c.id
							WHERE sex='" . $_POST["sex"] . "'";
}
//AGE
elseif($_POST["submit"] == "Filter by Clinic")
{
	$myquery = "SELECT e.id, e.fname, e.lname, e.sex, c.id, c.name FROM employees AS e
							INNER JOIN clinics AS c ON e.clinic_id=c.id
							WHERE e.clinic_id='" . $_POST["clinic_id"] . "'";
}
//DEFAULT
else
{
	echo "<br>" . "Error: Could not filter database from submitted form" . "<br>";
	$myquery = "SELECT e.id, e.fname, e.lname, e.sex, c.id, c.name FROM employees AS e
							INNER JOIN clinics AS c ON e.clinic_id=c.id";
}

//DEBUGGING
echo "<fieldset><legend>Your Query</legend>" 
		. "<p>". $myquery . "</fieldset></br>";

//select all employees
if(!$stmt = $mysqli->prepare($myquery)){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
//bind results to variables
if(!$stmt->bind_result($id, $fname, $lname, $sex, $cid, $cname)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

}
//print out information
while($stmt->fetch()){
	echo "<tr>\n"
		. "<td>" . $id . "</td>\n"
		. "<td>" . $fname . "</td>\n" 
		. "<td>" . $lname . "</td>\n" 
		. "<td>" . $sex . "</td>\n" 
		. "<td>" . $cid . "</td>\n"
		. "<td>" . $cname . "</td>\n"
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