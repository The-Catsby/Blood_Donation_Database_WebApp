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
	<title>Database Implementation</title>
</head>
<body>

<h1>Database Implementation</h1>
<h2><i>Totally Not Vampires: A Non-Profit Blood Donation Organization</i></h2>
<p>by Alex Rappa</p>

<div>
	<h3>See Contents of Database: </h3>
	<ol>
		<li><p><a href="get_content/donors.php">Donors</a></p>
		<li><p><a href="get_content/employees.php">Employees</a></p>
		<li><p><a href="get_content/clinics.php">Clinics</a></p>
		<li><p><a href="get_content/blood.php">Blood</a></p>
		<li><p><a href="get_content/certifications.php">Certifications</a></p>
        <li><p><a href="get_content/empcert.php">Employee-Certifications</a></p>
	<ol>
</div>

</br>

<h3>Add Content to Database: </h3>
    
<!--------Add Donor-----!-->
<div>
	<form method="POST" action="add_content/adddonor.php">

		<fieldset>
			<legend>Add New Donor</legend>
			<p><font color="FF0000">*</font>First Name: <input type="text" name="fname" required/> 
			<font color="FF0000">*</font>Last Name: <input type="text" name="lname" required/></p>
			<p><font color="FF0000">*</font>Age: <input type="number" name="age" min="17" required/></p>
			<p>Sex: 
			<form>
				<input type="radio" name="sex" value="Male"> Male
				<input type="radio" name="sex" value="Female"> Female
				<input type="radio" name="sex" value="Other"> Other
			</form>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

</br>

<!--------Add Blood-----!-->
<div>
	<form method="POST" action="add_content/addblood.php">

		<fieldset>
			<legend>Add New Blood Specimen</legend>
            <p>Blood Type:
                <input type="radio" name="bloodtype" value="A+">A+</input>
                <input type="radio" name="bloodtype" value="A-">A-</input>
                <input type="radio" name="bloodtype" value="B+">B+</input>
                <input type="radio" name="bloodtype" value="B-">B-</input>
                <input type="radio" name="bloodtype" value="O+">O+</input>
                <input type="radio" name="bloodtype" value="O-">O-</input>
                <input type="radio" name="bloodtype" value="N/A" checked>Unkown</input>
            </p>
            <p>Blood Status: 
				<input type="radio" name="status" value="Pure"> Pure
				<input type="radio" name="status" value="N/A" checked> Unknown
				<input type="radio" name="status" value="Impure"> Impure 
            </p>
			<p><font color="FF0000">*</font>Donor: 
                <select name="donor_id" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM donors"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($eid, $fname, $lname)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $eid . '"> ' . $fname . " " . $lname . '</option>\n';
}
$stmt->close();
?>
                </select>
            </p>            
            <p><font color="FF0000">*</font>Clinic: 
                <select name="clinic_id" required>
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM clinics"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($cid, $name)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $cid . '"> ' . $name . '</option>\n';
}
$stmt->close();
?>
                </select>
            </p>
            <p><font color="FF0000">*</font>Donation Date: <input type="date" name="ddate" required/></p>
			</form>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

</br>

<!--       Add Employee          !-->
<div>
	<form method="POST" action="add_content/addemployee.php">

		<fieldset>
			<legend>Add New Employee</legend>
			<p><font color="FF0000">*</font>First Name: <input type="text" name="fname" required/></p>
			<p><font color="FF0000">*</font>Last Name: <input type="text" name="lname" required/></p>
			<p>Sex: 
				<input type="radio" name="sex" value="Male"> Male
				<input type="radio" name="sex" value="Female"> Female
				<input type="radio" name="sex" value="Other" checked> Other	
			<p><font color="FF0000">*</font>Clinic: <select name="clinic_id" required> 
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
			</p>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

</br>

<!--------Add Employee Certification-----!-->
<div>
	<form method="POST" action="add_content/addempcert.php">
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

</br>

<!--------Add Clinic-----!-->
<div>
	<form method="POST" action="add_content/addclinic.php">
		<fieldset>
			<legend>Add New Clinic</legend>
			<p><font color="FF0000">*</font>Name: <input type="text" name="name" required/></p>
			<p><font color="FF0000">*</font>Location: <input type="text" name="location" required/></p>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

</br>

<!--------Add Certification-----!-->
<div>
	<form method="POST" action="add_content/addcertification.php">

		<fieldset>
			<legend>Add New Certification</legend>
			<p><font color="FF0000">*</font>Certification Title: <input type="text" name="title" required/></p>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

</body>
</html>