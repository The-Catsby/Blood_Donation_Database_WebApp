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
if(!$stmt = $mysqli->prepare("SELECT e.id, e.fname, e.lname, cert.id, cert.title, ca.dateOfCert, c.id, c.name
                            FROM employees AS e
                            INNER JOIN certified_as AS ca ON e.id=ca.emp_id
                            INNER JOIN certifications AS cert ON ca.cert_id=cert.id
                            INNER JOIN clinics AS c ON e.clinic_id=c.id
                            ORDER BY e.id")){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
//bind  info to variables
if(!$stmt->bind_result($id, $fname, $lname, $cid, $title, $ddate, $cid, $cname)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

}
//print information
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

$stmt->close();
?>			
	</table>
</div>

</br>

<div>
	<h3>Modify Contents of Database: </h3>
	<form method='POST' action='../update_content/deleteempcert.php'>
        <p>Delete Row: Emp_ID 
                <select type="number" name="emp_id">
<?php
if(!($stmt = $mysqli->prepare("SELECT emp_id FROM certified_as"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($emp_id)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $emp_id . '"> ' . $emp_id . '</option>\n';
}
$stmt->close();
?>
                </select>
                Cert_ID
                <select type="number" name="cert_id">
<?php
if(!($stmt = $mysqli->prepare("SELECT cert_id FROM certified_as"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($cert_id)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $cert_id . '"> ' . $cert_id . '</option>\n';
}
$stmt->close();
?>
                </select>
                <input type="submit" value="DELETE"/></p>
    </form>
</div>

</br>

<!--------Update Employee Certification-----!-->
<div>
	<form method="POST" action="../update_content/updateempcert.php">
		<fieldset>
			<legend>Update Employee Certification</legend>
            <p><font color="FF0000">*</font>Select Row: Emp_ID 
                <select type="number" name="emp_id_x" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT emp_id FROM certified_as"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($emp_id_x)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $emp_id_x . '"> ' . $emp_id_x . '</option>\n';
}
$stmt->close();
?>
                </select>
                Cert_ID
                <select type="number" name="cert_id_x" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT cert_id FROM certified_as"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($cert_id_x)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $cert_id_x . '"> ' . $cert_id_x . '</option>\n';
}
$stmt->close();
?>
            </select></p>

			<p><font color="FF0000">*</font>Employee: 
                <select name="emp_id" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM employees"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($emp_id, $fname, $lname)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $emp_id . '"> ' . $fname . " " . $lname . '</option>\n';
}
$stmt->close();
?>
                </select>
            </p>            
            <p><font color="FF0000">*</font>Certification: 
                <select name="cert_id" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT id, title FROM certifications"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($cert_id, $title)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $cert_id . '"> ' . $title . '</option>\n';
}
$stmt->close();
?>
                </select>
            </p>
            <p><font color="FF0000">*</font>Certification Date: <input type="date" name="DateOfCert" required/></p>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

</br>

<!--------Add Employee Certification-----!-->
<div>
	<form method="POST" action="../add_content/addempcert.php">
		<fieldset>
			<legend>Add New Employee Certification</legend>
			<p><font color="FF0000">*</font>Employee: 
                <select name="emp_id" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM employees"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $id . '"> ' . $fname . " " . $lname . '</option>\n';
}
$stmt->close();
?>
                </select>
            </p>            
            <p><font color="FF0000">*</font>Certification: 
                <select name="cert_id" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT id, title FROM certifications"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $title)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $id . '"> ' . $title . '</option>\n';
}
$stmt->close();
?>
                </select>
            </p>
            <p><font color="FF0000">*</font>Certification Date: <input type="date" name="dateOfCert" required/></p>
			</form>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

<!-- Filter Content !-->
<div>
	<h3>Filter Contents of Database: </h3>
	<fieldset>
		<legend>Filter Employee-Certifications By</legend>

		<!-- Filter by Employee -->
		<form method="POST" action="../filter_content/filterempcert.php">
			<p>Employee: 
                <select name="employee_id" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM employees"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $id . '"> ' . $fname . " " . $lname . '</option>\n';
}
$stmt->close();
?>
                </select>
				<input type="submit" name="submit" value="Filter by Employee"/>
            </p>           
		</form>
		
		<!-- Filter by Title -->
		<form method="POST" action="../filter_content/filterempcert.php">
			<p>Title: 
                <select name="cert_id" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT id, title FROM certifications"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $title)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $id . '"> ' . $title . '</option>\n';
}
$stmt->close();
?>
                </select>
				<input type="submit" name="submit" value="Filter by Title"/>
            </p>           
		</form>
		
        <!-- Filter by Clinic -->
		<form method="POST" action="../filter_content/filterempcert.php">
			<p>Clinic: 
                <select name="clinic_id" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM clinics"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $id . '"> ' . $name . '</option>\n';
}
$stmt->close();
?>
                </select>
				<input type="submit" name="submit" value="Filter by Clinic"/>
            </p>  
            
        <!-- Filter by No Certifiation -->
		<form method="POST" action="../filter_content/filterempcert.php">
            <p>Employees with NO certifications <input type="submit" name="submit" value="Filter by NO Certifications"/>
        <form>
        
        </form>
        
	</fieldset>
</div>

<!-- Navigation Links !-->
<div>
<h2><a href="../home.php">Return to Home Page</a></h2>
	<h3>See Contents of Database: </h3>
	<ol>
		<li><p><a href="donors.php">Donors</a></p>
		<li><p><a href="employees.php">Employees</a></p>
		<li><p><a href="clinics.php">Clinics</a></p>
		<li><p><a href="blood.php">Blood</a></p>
		<li><p><a href="certifications.php">Certifications</a></p>
        <li><p><a href="empcert.php">Employee-Certifications</a></p>
	<ol>
</div>

</body>
</html>