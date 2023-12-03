<?php

require('heading.php');

// Check if the form for updating the car is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
	handleUpdate();
}

// Check if the select menu for choosing the car is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_car'])) {
	$selectedCarId = $_POST['selected_car'];
	displayUpdateForm($selectedCarId);
} else {
	displaySelectMenu();
}

require('footing.php');

function handleUpdate() {
	require('credentials.php');
	$db = mysqli_connect($hostname, $username, $password, $database);

	if ($db === false) {
		die("Unable to connect: " . mysqli_connect_error());
	}

	$useDB = mysqli_select_db($db, 'namb');
	if (!$useDB) {
		die("Unable to select db: " . mysqli_error($db));
	}

	$id = $_POST['update_id'];
	$name = mysqli_real_escape_string($db, $_POST['name_var']);
	$productionYears = mysqli_real_escape_string($db, $_POST['year_var']);
	$miles = mysqli_real_escape_string($db, $_POST['range_var']);

	$result = mysqli_query($db, "UPDATE cars SET name='$name', productionYears='$productionYears', miles='$miles' WHERE id='$id'");

	if ($result === false) {
		die("Update query failed: " . mysqli_error($db));
	}

	mysqli_close($db);
	sleep(1);
	header("Location: listing.php");
	exit();
}

function displaySelectMenu() {
	require('credentials.php');
	$db = mysqli_connect($hostname, $username, $password, $database);

	if ($db === false) {
		die("Unable to connect: " . mysqli_connect_error());
	}

	$useDB = mysqli_select_db($db, 'namb');
	if (!$useDB) {
		die("Unable to select db: " . mysqli_error($db));
	}

	$cars = mysqli_query($db, "SELECT ID,name FROM members ORDER BY name");
	if ($cars === false) {
		die("Query failed: " . mysqli_error($db));
	}
	echo <<< BEFOREFORM
	<form
		method="post"
		action=""
		style="
			margin-left: auto;
			margin-right: auto;
			width: 50%;
			padding-left: 30%;
			font-size: 20px;
		"
	>
		<label for="selected_car" style="font-size: 20px"
			>Select a car to update:</label
		><br />
		<select name="selected_car" id="selected_car">
	
BEFOREFORM;
	while ($row = mysqli_fetch_array($cars)) {
		$id = $row['id'];
		$name = $row['name'];
		echo "<option value='$id'>$name</option>";
	}
	echo <<< AFTERFORM
    </select><br>
		<input type="submit" value="Update Car">
    </form>
AFTERFORM;

	mysqli_close($db);
}

function displayForm($cars)
{
    echo <<< FORM
    <form action="update.php" method="post">
    <table style="margin-right: auto; margin-left: auto; width: 50%" id="updateTable">
    <tr>
        <th><label for="car">Select Car: </label></th>
        <td>
            <select name="car" id="car" required>
                <option value="">Select a Car</option>
FORM;

    // Loop through the cars array to populate the options
    foreach ($cars as $car) {
        $name = $car['name'];
        $productionYears = $car['productionYears'];
        $miles = $car['miles'];

        echo "<option value=\"$name\">$name - $productionYears - $miles miles</option>";
    }

    echo <<< FORM
            </select>
        </td>
    </tr>
    <tr>
        <th><label for="newMiles">New Miles: </label></th>
        <td><input type="text" name="newMiles" id="newMiles" required maxlength="5" placeholder="New Miles" pattern="^\d{1,5}$" autocomplete="off"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td style="float:right;"> <input type="submit" name="updateButton" value="Update"></td>
    </tr>
    </table>
    </form>
FORM;
}

