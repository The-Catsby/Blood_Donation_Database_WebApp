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
	<title>Employee-Certifications</title>
</head>
<body>
<div>
	<h2>Many-to-Many Relationship</h2>
    <h3>Employee-Certifications</h3>
	<table>
		<tr>
			<td><b>Emp_ID</b></td>
			<td><b>Full Name</b></td>
			<td><b>Cert_ID</b></td>
			<td><b>Title</b></td>
			<td><b>Date of Cert</b></td>
			<td><b>Clinic ID</b></td>
			<td><b>Clinic Name</b></td>
		</tr>
<?php
//declare myquery statement based on how user chose to filter

$noCert=0; //flag for filtering employees with no certification (determines param binding)

//EMPLOYEE
if($_POST["submit"] == "Filter by Employee")
{
	$myquery = "SELECT e.id, e.fname, e.lname, cert.id, cert.title, ca.dateOfCert, c.id, c.name
                            FROM employees AS e
                            INNER JOIN certified_as AS ca ON e.id=ca.emp_id
                            INNER JOIN certifications AS cert ON ca.cert_id=cert.id
                            INNER JOIN clinics AS c ON e.clinic_id=c.id"
							. " WHERE e.id='" . $_POST["employee_id"] . "'"
							. " ORDER BY e.id";
}
//TITLE
elseif($_POST["submit"] == "Filter by Title")
{
	$myquery = "SELECT e.id, e.fname, e.lname, cert.id, cert.title, ca.dateOfCert, c.id, c.name
                            FROM employees AS e
                            INNER JOIN certified_as AS ca ON e.id=ca.emp_id
                            INNER JOIN certifications AS cert ON ca.cert_id=cert.id
                            INNER JOIN clinics AS c ON e.clinic_id=c.id"
							. " WHERE cert.id='" . $_POST["cert_id"] . "'"
							. " ORDER BY e.id";
}
//CLINIC
elseif($_POST["submit"] == "Filter by Clinic")
{
	$myquery = "SELECT e.id, e.fname, e.lname, cert.id, cert.title, ca.dateOfCert, c.id, c.name
                            FROM employees AS e
                            INNER JOIN certified_as AS ca ON e.id=ca.emp_id
                            INNER JOIN certifications AS cert ON ca.cert_id=cert.id
                            INNER JOIN clinics AS c ON e.clinic_id=c.id"
							. " WHERE c.id='" . $_POST["clinic_id"] . "'"
							. " ORDER BY e.id";
}
//NO Cert
elseif($_POST["submit"] == "Filter by NO Certifications")
{
	$myquery = "SELECT e1.id, e1.fname, e1.lname, c1.id, c1.name
                            FROM employees AS e1
                            INNER JOIN clinics AS c1 ON e1.clinic_id=c1.id
                            WHERE e1.id NOT IN
                            (SELECT e.id
                            FROM employees AS e
                            INNER JOIN certified_as AS ca ON e.id=ca.emp_id
                            INNER JOIN certifications AS cert ON ca.cert_id=cert.id
                            INNER JOIN clinics AS c ON e.clinic_id=c.id)";
    $noCert = 1;
}
//DEFAULT
else
{
	echo "<br>" . "***Error: Could not filter database from submitted form***" . "<br></br>";
	$myquery = "SELECT e.id, e.fname, e.lname, cert.id, cert.title, ca.dateOfCert, c.id, c.name
                            FROM employees AS e
                            INNER JOIN certified_as AS ca ON e.id=ca.emp_id
                            INNER JOIN certifications AS cert ON ca.cert_id=cert.id
                            INNER JOIN clinics AS c ON e.clinic_id=c.id
                            ORDER BY e.id";
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

//if we are not filtering employees with no certifications
if(!$noCert)
{
    //bind  info to variables
    if(!$stmt->bind_result($id, $fname, $lname, $cid, $title, $ddate, $cid, $cname)){
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

    }
    //print out information
    while($stmt->fetch()){
        echo "<tr>\n"
            . "<td>" . $id . "</td>\n"
            . "<td>" . $fname . " " . $lname . "</td>\n" 
            . "<td>" . $cid . "</td>\n"
            . "<td>" . $title . "</td>\n"
            . "<td>" . $ddate . "</td>\n"
            . "<td>" . $cid . "</td>\n"
            . "<td>" . $cname . "</td>\n"
            . "</tr>\n";
    }
}
//else we are filtering by employees with no certifications (number of params and table contents change)
else{
    //bind  info to variables
    if(!$stmt->bind_result($id, $fname, $lname, $cid, $cname)){
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

    }
    //print out information
    while($stmt->fetch()){
        echo "<tr>\n"
            . "<td>" . $id . "</td>\n"
            . "<td>" . $fname . " " . $lname . "</td>\n" 
            . "<td>" . " " . "</td>\n"
            . "<td>" . " " . "</td>\n"
            . "<td>" . " " . "</td>\n"
            . "<td>" . $cid . "</td>\n"
            . "<td>" . $cname . "</td>\n"
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