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
	<title>DB: Blood</title>
</head>
<body>
<div>
	<h2>Database: Blood</h2>

<?php
//declare myquery statement based on how user chose to filter

$isCount=0; //flag used for aggregate function 

//BLOODTYPE
if($_POST["submit"] == "Filter by Blood Type")
{
	$myquery = "SELECT b.id, bloodtype, status, donor_id, fname, lname, clinic_id, name, ddate 
                                FROM blood AS b
                                INNER JOIN donors AS d ON b.donor_id=d.id
                                INNER JOIN clinics AS c ON b.clinic_id=c.id"
								. " WHERE bloodtype='" . $_POST["bloodtype"] . "'";
}
//STATUS
elseif($_POST["submit"] == "Filter by Blood Status")
{
	$myquery = "SELECT b.id, bloodtype, status, donor_id, fname, lname, clinic_id, name, ddate 
                                FROM blood AS b
                                INNER JOIN donors AS d ON b.donor_id=d.id
                                INNER JOIN clinics AS c ON b.clinic_id=c.id"
								. " WHERE status='" . $_POST["status"] . "'";
}
//DONOR
elseif($_POST["submit"] == "Filter by Donor")
{
	$myquery = "SELECT b.id, bloodtype, status, donor_id, fname, lname, clinic_id, name, ddate 
                                FROM blood AS b
                                INNER JOIN donors AS d ON b.donor_id=d.id
                                INNER JOIN clinics AS c ON b.clinic_id=c.id"
								. " WHERE b.donor_id='" . $_POST["donor_id"] . "'";
}
//CLINIC
elseif($_POST["submit"] == "Filter by Clinic")
{
	$myquery = "SELECT b.id, bloodtype, status, donor_id, fname, lname, clinic_id, name, ddate 
                                FROM blood AS b
                                INNER JOIN donors AS d ON b.donor_id=d.id
                                INNER JOIN clinics AS c ON b.clinic_id=c.id"
								. " WHERE c.id='" . $_POST["clinic_id"] . "'";
}
//DATE
elseif($_POST["submit"] == "Filter by Date")
{
	$myquery = "SELECT b.id, bloodtype, status, donor_id, fname, lname, clinic_id, name, ddate 
                                FROM blood AS b
                                INNER JOIN donors AS d ON b.donor_id=d.id
                                INNER JOIN clinics AS c ON b.clinic_id=c.id"
								. " WHERE ddate" .$_POST["operator"] . "'" . $_POST["date"] . "'";
}
//COUNT
elseif($_POST["submit"] == "Filter by Count")
{
	$myquery = "SELECT bloodtype, COUNT(bloodtype) AS 'Total' 
				FROM blood AS b1
				GROUP BY bloodtype";
	$isCount=1;
}
//DEFAULT
else
{
	echo "<br>" . "***Error: Could not filter database from submitted form***" . "<br></br>";
	$myquery = "SELECT b.id, bloodtype, status, donor_id, fname, lname, clinic_id, name, ddate 
                                FROM blood AS b
                                INNER JOIN donors AS d ON b.donor_id=d.id
                                INNER JOIN clinics AS c ON b.clinic_id=c.id";
}

//DEBUGGING
echo "<fieldset><legend>Your Query</legend>" 
		. "<p>". $myquery . "</fieldset></br>";
		
//select blood
if(!$stmt = $mysqli->prepare($myquery)){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
//if we are not filtering by Aggregate functions
if(!$isCount)
{
	//bind donor info to variables
	if(!$stmt->bind_result($id, $bloodtype, $status, $donor_id, $fname, $lname, $clinic_id, $name, $ddate)){
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
	}
	//print table header row
	echo "	<table>
		<tr>
			<td><b>ID</b></td>
			<td><b>Blood Type</b></td>
			<td><b>Status</b></td>
			<td><b>Donor ID</b></td>
			<td><b>Donor Name</b></td>
            <td><b>Clinic ID</b></td>
            <td><b>Clinic Name</b></td>
			<td><b>Donation Date</b></td>
		</tr>";
	//print out donor information
	while($stmt->fetch()){
		echo "<tr>\n"
			. "<td>" . $id . "</td>\n"
			. "<td>" . $bloodtype . "</td>\n"
			. "<td>" . $status . "</td>\n"
			. "<td>" . $donor_id . "</td>\n"
			. "<td>" . $fname . " " . $lname . "</td>\n"
			. "<td>" . $clinic_id . "</td>\n"
			. "<td>" . $name . "</td>\n"
			. "<td>" . $ddate . "</td>\n"
			. "</tr>\n";
	}
}
//else filter by aggregate functions (the number of params & table layout change)
else{
	//bind donor info to variables
	if(!$stmt->bind_result($bloodtype, $count)){
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
	}
	//print table header row
	echo "	<table>
		<tr>
			<td><b>Blood Type</b></td>
			<td><b>Count</b></td>
		</tr>";
	//print out donor information
	while($stmt->fetch()){
		echo "<tr>\n"
			. "<td>" . $bloodtype . "</td>\n"
			. "<td>" . $count . "</td>\n"
			. "</tr>\n";
	}
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