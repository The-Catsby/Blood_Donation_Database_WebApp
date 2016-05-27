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
	<title>DB: Donors</title>
</head>
<body>
<div>
	<h2>Database: Donors</h2>
	<table>
		<tr>
			<td><b>ID</b></td>  
			<td><b>First Name</b></td>
			<td><b>Last Name</b></td>
			<td><b>Age</b></td>
			<td><b>Sex</b></td>
		</tr>
<?php
//select all donors
if(!$stmt = $mysqli->prepare("SELECT id, fname, lname, age, sex FROM donors")){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
//bind donor info to variables
if(!$stmt->bind_result($id, $fname, $lname, $age, $sex)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

}
//print out donor information
while($stmt->fetch()){
	echo "<tr>\n"
		. "<td>" . $id . "</td>\n"
		. "<td>" . $fname . "</td>\n" 
		. "<td>" . $lname . "</td>\n" 
		. "<td>" . $age . "</td>\n" 
		. "<td>" . $sex . "</td>\n"
		. "</tr>\n";
}

$stmt->close();
?>			
	</table>
</div>

<div>
	<h3>Modify Contents of Database: </h3>
	<form method='POST' action='../update_content/deletedonor.php'>
        <p>Delete Row: ID
                <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM donors"))){
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

<!--       Update Donor          !-->
<div>
	<form method="POST" action="../update_content/updatedonor.php">
		<fieldset>
			<legend>Update Donor</legend>
            <p><font color="FF0000">*</font>ID: 
             <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM donors"))){
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
			<p><font color="FF0000">*</font>First Name: <input type="text" name="fname" required/> 
			<font color="FF0000">*</font>Last Name: <input type="text" name="lname" required/></p>
			<p><font color="FF0000">*</font>Age: <input type="number" name="age" min="17" required/></p>
			<p>Sex: 
				<input type="radio" name="sex" value="Male"> Male
				<input type="radio" name="sex" value="Female"> Female
				<input type="radio" name="sex" value="Other"> Other
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit" value="Update"/></p>
		</fieldset>
	</form>
</div>

</br>

<!--       Add Donor          !-->
<div>
	<form method="POST" action="../add_content/adddonor.php">

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

<!-- Filter Content !-->
<div>
	<h3>Filter Contents of Database: </h3>
	<fieldset>
		<legend>Filter Donors By</legend>
		
		<!-- Filter by Sex -->
		<form method="POST" action="../filter_content/filterdonor.php">
			<p>Sex: 
				<select name="sex">
					<option name="sex" value="IS NULL"></option>
					<option name="sex" value="='Male'"> Male</option>
					<option name="sex" value="='Female'"> Female</option>
					<option name="sex" value="='Other'"> Other</option>
				</select>
				<input type="submit" name="submit" value="Filter by Sex">
			</p>
		</form>
		
		<!-- Filter by Age -->
		<form method="POST" action="../filter_content/filterdonor.php">
			<p>Age: 
				<select name="operator">
					<option name="operator" value=">"> Greater Than</option>
					<option name="operator" value="="> Equal To</option>
					<option name="operator" value="<"> Less Than</option>
				</select>
				<input type="number" name="age" required>
				<input type="submit" name="submit" value="Filter by Age"/>
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