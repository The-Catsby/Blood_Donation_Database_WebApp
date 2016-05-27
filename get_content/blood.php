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
	<table>
		<tr>
			<td><b>ID</b></td>
			<td><b>Blood Type</b></td>
			<td><b>Status</b></td>
			<td><b>Donor ID</b></td>
			<td><b>Donor Name</b></td>
            <td><b>Clinic ID</b></td>
            <td><b>Clinic Name</b></td>
			<td><b>Donation Date</b></td>
		</tr>
<?php
//select
if(!$stmt = $mysqli->prepare("SELECT b.id, bloodtype, status, donor_id, fname, lname, clinic_id, name, ddate 
                                FROM blood AS b
                                INNER JOIN donors AS d ON b.donor_id=d.id
                                INNER JOIN clinics AS c ON b.clinic_id=c.id
                                ORDER BY d.id")){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
//bind results to variables
if(!$stmt->bind_result($id, $bloodtype, $status, $donor_id, $fname, $lname, $clinic_id, $name, $ddate)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

}
//print out information
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

$stmt->close();
?>			
	</table>
</div>

</br>


<div>
	<h3>Modify Contents of Database: </h3>
	<form method='POST' action='../update_content/deleteblood.php'>
        <p>Delete Row: ID
                <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM blood"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $id . '"> ' . $id . '</option>\n';
}
$stmt->close();
?>
                </select>
                <input type="submit" value="DELETE"/></p>
    </form>
</div>

<!--       Update blood          !-->
<div>
	<form method="POST" action="../update_content/updateblood.php">

		<fieldset>
			<legend>Update Blood Specimen</legend>
            <p><font color="FF0000">*</font>ID: 
            <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM blood"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="' . $id . '"> ' . $id . '</option>\n';
}
$stmt->close();
?>
                </select>
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

<!--------Add Blood-----!-->
<div>
	<form method="POST" action="../add_content/addblood.php">

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

<!-- Filter Content !-->
<div>
	<h3>Filter Contents of Database: </h3>
	<fieldset>
		<legend>Filter Blood By</legend>

		<!-- Filter by Blood Type -->
		<form method="POST" action="../filter_content/filterblood.php">
			<p>Blood Type:
                <input type="radio" name="bloodtype" value="A+">A+</input>
                <input type="radio" name="bloodtype" value="A-">A-</input>
                <input type="radio" name="bloodtype" value="B+">B+</input>
                <input type="radio" name="bloodtype" value="B-">B-</input>
                <input type="radio" name="bloodtype" value="O+">O+</input>
                <input type="radio" name="bloodtype" value="O-">O-</input>
                <input type="radio" name="bloodtype" value="N/A" checked>Unkown</input>
				
				<input type="submit" name="submit" value="Filter by Blood Type"/>
			</p>
		</form>
		
		<!-- Filter by Status -->
		<form method="POST" action="../filter_content/filterblood.php">
            <p>Blood Status: 
				<input type="radio" name="status" value="Pure"> Pure
				<input type="radio" name="status" value="N/A" checked> Unknown
				<input type="radio" name="status" value="Impure"> Impure 
				
				<input type="submit" name="submit" value="Filter by Blood Status"/>
			</p>
		</form>
		
		<!-- Filter by Donor -->
		<form method="POST" action="../filter_content/filterblood.php">
			<p>Donor: 
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
				<input type="submit" name="submit" value="Filter by Donor"/>
            </p>           
		</form>
		
		<!-- Filter by Clinic -->
		<form method="POST" action="../filter_content/filterblood.php">
			<p>Clinic: 
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
				<input type="submit" name="submit" value="Filter by Clinic"/>
            </p>           
		</form>
		
		<!-- Filter by Date -->
		<form method="POST" action="../filter_content/filterblood.php">
			<p>Date: 
				<select name="operator">
					<option value="<=">Before</option>
					<option value="=">On</option>
					<option value=">=">After</option>
				</select>
				<input type="date" name="date">
			<input type="submit" name="submit" value="Filter by Date"/>
		</form>	
		
		<!-- Filter by Blood Type Count -->
		<form method="POST" action="../filter_content/filterblood.php">
			<p>Count by Blood Type: 
				<input type="submit" name="submit" value="Filter by Count"/>
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