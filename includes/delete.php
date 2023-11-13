<?php
require_once('heading.php');

require_once('footing.php');

if (isset($_POST['deleteButton'])) {
	deleteVehicle();
} else {
	deleteForm();
}


function deleteVehicle() {
	$name = trim($_POST['name']);
	$year = trim($_POST['year']);
	$range = trim($_POST['range']);
	if ($name != false || $year != false || $range != false) {
		die("<h1 style=\"text-align: center;\"> INVALID INPUTS </h1>");
	} else {
		require("credentials.php");
		$db = mysqli_connect($hostname, $username, $password, $database);

		if (mysqli_connect_errno()) {
			die("Error connecting to the database" . mysqli_connect_error());
		}
		$query = "DELETE FROM cars (name, productionYears, miles)
		    VALUES('" . $name . "','" . $year . "','" . $range . "')";
		if (mysqli_query($db, $query)) {
			echo <<< SUCCESS
			<div class="center">
				<h2>SUCCESS! Record deleted from database</h2>
			</div>
SUCCESS;
		} else {
			echo <<< FAIL
			<div class="center">
				<h2>FAIL ): could not delete record</h2>
			</div>
FAIL;
		}
	}
}

function deleteForm() {
	echo <<< DELETETABlE
	<form action="delete.php" method="post">
		<table>
			<tr>
				<td>Name: </td>
				<td><input type="text" name="name" /></td>
			</tr>
			<tr>
				<td>Production Years: </td>
				<td><input type="text" name="year" /></td>
			</tr>
			<tr>
				<td>Miles: </td>
				<td><input type="text" name="range" /></td>
			</tr>
			<tr>
				<td><input type="submit" name="deleteButton" value="Delete" /></td>
			</tr>
		</table>

DELETETABlE;
}
