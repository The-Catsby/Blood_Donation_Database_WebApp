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
//select
if(!$stmt = $mysqli->prepare("SELECT id, name, location  FROM clinics")){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
//bind results to variables
if(!$stmt->bind_result($id, $name, $location)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

}
//print out information
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

<div>
	<h3>Modify Contents of Database: </h3>
	<form method='POST' action='../update_content/deleteclinic.php'>
        <p>Delete Row: ID
                <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM clinics"))){
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

<!--------Update Clinic-----!-->
<div>
	<form method="POST" action="../update_content/updateclinic.php">
		<fieldset>
			<legend>Update Clinic</legend>
            <p><font color="FF0000">*</font>ID: 
            <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM clinics"))){
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
			<p><font color="FF0000">*</font>Name: <input type="text" name="name" required/></p>
			<p><font color="FF0000">*</font>Location: <input type="text" name="location" required/></p>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

</br>

<!--------Add Clinic-----!-->
<div>
	<form method="POST" action="../add_content/addclinic.php">
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

<!-- Filter Content !-->
<div>
	<h3>Filter Contents of Database: </h3>
	<fieldset>
		<legend>Filter Clinics By</legend>

		<!-- Filter by Location -->
		<form method="POST" action="../filter_content/filterclinic.php">
			<p>Location: 
				<select name="location" required> 
					<?php
					if(!($stmt = $mysqli->prepare("SELECT location FROM clinics"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->bind_result($location)){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}
					while($stmt->fetch()){
						echo '<option value="' . $location . '"> ' . $location . '</option>\n';
					}
					$stmt->close();
					?>
					</select>
				<input type="submit" name="submit" value="Filter by Location"/>
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