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
//select all employees
if(!$stmt = $mysqli->prepare("SELECT e.id, e.fname, e.lname, e.sex, c.id, c.name FROM employees AS e
							INNER JOIN clinics AS c ON e.clinic_id=c.id
                            ORDER BY e.id")){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
//bind results to variables
if(!$stmt->bind_result($id, $fname, $lname, $sex, $cid, $cname)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

}
//print out donor information
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

<div>
	<h3>Modify Contents of Database: </h3>
	<form method='POST' action='../update_content/deleteemployee.php'>
        <p>Delete Row: ID
                <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM employees"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($eid)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $eid . '"> ' . $eid . '</option>\n';
}
$stmt->close();
?>
                </select>
                <input type="submit" value="DELETE"/></p>
    </form>
</div>

<!--       Update Employee          !-->
<div>
	<form method="POST" action="../update_content/updateemployee.php">
		<fieldset>
			<legend>Update Employee</legend>
            <p><font color="FF0000">*</font>ID: 
             <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM employees"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($eid)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $eid . '"> ' . $eid . '</option>\n';
}
$stmt->close();
?>
                </select></p>
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
			<p><font color="FF0000">*</font>First Name: <input type="text" name="fname" required/> 
			<font color="FF0000">*</font>Last Name: <input type="text" name="lname" required/></p>
			<p>Sex: 
				<input type="radio" name="sex" value="Male"> Male
				<input type="radio" name="sex" value="Female"> Female
				<input type="radio" name="sex" value="Other" checked> Other
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

</br>

<!--       Add Employee          !-->
<div>
	<form method="POST" action="../add_content/addemployee.php">

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

<!-- Filter Content !-->
<div>
	<h3>Filter Contents of Database: </h3>
	<fieldset>
		<legend>Filter Employees By</legend>
		
		<!-- Filter by Sex -->
		<form method="POST" action="../filter_content/filteremployee.php">
			<p>Sex: 
				<select name="sex">
					<option name="sex" value="Male"> Male</option>
					<option name="sex" value="Female"> Female</option>
					<option name="sex" value="Other"> Other</option>
				</select>
				<input type="submit" name="submit" value="Filter by Sex">
			</p>
		</form>
		
		<!-- Filter by Clinic -->
		<form method="POST" action="../filter_content/filteremployee.php">
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
		</form>
	</fieldset>
</div>

</br>

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