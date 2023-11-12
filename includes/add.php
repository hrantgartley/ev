<?php
require('heading.php');

require('footing.php');
if (isset($_POST['addButton'])) {
	addEV();
} else {
	displayForm();
}
function displayForm() {
	echo <<< FORM
	<form action="add.php" method="post">
	<table style="margin-right: auto; margin-left: auto; width: 50%"; id="addTable">
	<tr>
		<th><label for="name">Model: </label></th>
		<th><label for="year">Years: </label></th>
		<th><label for="range">Miles: </label></th>
	</tr>
	<tr>
		<td><input type="text" name="name" id="name" required maxlength="64" placeholder="name of EV" autocomplete="off" ></td>
		<td><input type="text" name="year" id="year" required maxlength="9" placeholder="1970-2000" autocomplete="off"></td>
		<td><input type="text" name="range" id="range" required maxlength="5" placeholder="999" pattern="^\d{1,5}$" autocomplete="off"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="float:right;"> <input type="submit" name="addButton" value="Add EV"></td>
	</tr>
	</table>
	</form>

FORM;
}

function addEV() {
	$name = $_POST['name'];
	$years = $_POST['year'];
	$range = $_POST['range'];
	$name = trim($name);
	$name = filter_var($name, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[0-9a-zA-Z !-\.]{1,64}$/")));
	$years = trim($years);
	$years = filter_var($years, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^\d{4}(-\d{4})?$/")));
	$range = trim($range);
	$range = filter_var($range, FILTER_VALIDATE_INT, array('options' => array('minval' => "1", "max_val" => "99999")));
	if ($name != false || $years != false || $range != false) {
		die("$name, $years, $range");
	} else {
		// connect to database
		require("credentials.php");
		$db = mysqli_connect($hostname, $username, $password, $database);

		if (mysqli_connect_errno()) {
			die("unable to connect to databse" . mysqli_connect_error());
		}
		$query = "INSERT INTO cars (name, productionYears, miles)
		    VALUES('" . $name . "','" . $years . "','" . $range . "')";
		if (mysqli_query($db, $query)) {
			echo <<< SUCCESS
			<div class="center">
			  <h2> Success! Record added to database. </h2>
			</div>
SUCCESS;
		} else {
			echo <<< FAIL
			<div class="center">
			  <h2> An error occured. Unable to add record </h2>
			</div>
FAIL;
		}
	}
}
