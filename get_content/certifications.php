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
	<title>DB: Certifications</title>
</head>
<body>
<div>
	<h2>Database: Certifications</h2>
	<table>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td><b>ID</b></td>
			<td><b>Title</b></td>
		</tr>
<?php
//select
if(!$stmt = $mysqli->prepare("SELECT id, title  FROM certifications")){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
//bind results to variables
if(!$stmt->bind_result($id, $title)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;

}
//print out information
while($stmt->fetch()){
	echo "<tr>\n"
		. "<td>" . $id . "</td>\n"
		. "<td>" . $title . "</td>\n"
		. "</tr>\n";
}

$stmt->close();
?>			
	</table>
</div>

</br>

<div>
	<h3>Modify Contents of Database: </h3>
	<form method='POST' action='../update_content/deletecert.php'>
        <p>Delete Row: ID
                <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM certifications"))){
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

<!--------Update Certification-----!-->
<div>
	<form method="POST" action="../update_content/updatecert.php">

		<fieldset>
			<legend>Update Certification</legend>
            <p><font color="FF0000">*</font>ID: 
            <select type="number" name="id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id FROM certifications"))){
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
                </select></p>		
            <p><font color="FF0000">*</font>Certification Title: <input type="text" name="title" required/></p>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
</div>

</br>

<!--------Add Certification-----!-->
<div>
	<form method="POST" action="../add_content/addcertification.php">

		<fieldset>
			<legend>Add New Certification</legend>
			<p><font color="FF0000">*</font>Certification Title: <input type="text" name="title" required/></p>
            <p><font color="FF0000">*Requird Fields</font></p>
			<p><input type="submit"/></p>
		</fieldset>
	</form>
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