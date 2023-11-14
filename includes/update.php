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

    $useDB = mysqli_select_db($db, 'ev');
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

    $useDB = mysqli_select_db($db, 'ev');
    if (!$useDB) {
        die("Unable to select db: " . mysqli_error($db));
    }

    $cars = mysqli_query($db, "SELECT id, name FROM cars ORDER BY name");
    if ($cars === false) {
        die("Query failed: " . mysqli_error($db));
    }
    echo <<< BEFOREFORM
    <form method="post" action="" style="margin-left: auto; margin-right: auto; width: 50%; padding-left: 30%">
    <label for="selected_car">Select a car to update:</label><br>
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

function displayUpdateForm($selectedCarId) {
    require('credentials.php');
    $db = mysqli_connect($hostname, $username, $password, $database);

    if ($db === false) {
        die("Unable to connect: " . mysqli_connect_error());
    }

    $useDB = mysqli_select_db($db, 'ev');
    if (!$useDB) {
        die("Unable to select db: " . mysqli_error($db));
    }

    $car = mysqli_query($db, "SELECT name, productionYears, miles FROM cars WHERE id='$selectedCarId'");
    if ($car === false) {
        die("Query failed: " . mysqli_error($db));
    }

    $row = mysqli_fetch_assoc($car);
    $name = $row['name'];
    $productionYears = $row['productionYears'];
    $miles = $row['miles'];
echo <<< UPDATEFORM
    <div class="center" style="padding-left: 25%">
    <form method="post" action="" style="border: 1px solid #000; padding: 10px; display: inline-block;">
    <input type='hidden' name='update_id' value='$selectedCarId'>
    <table style="border: 1px solid #000; border-collapse: collapse;">
    <tr><th style="border: 1px solid #000;">Model</th><th style="border: 1px solid #000;">Years Produced</th><th style="border: 1px solid #000;">Range</th></tr>
    <tr><td style='border: 1px solid #000;'><input type='text' name='name_var' value='$name'></td>
    <td style='border: 1px solid #000;'><input type='text' name='year_var' value='$productionYears'></td>
    <td style='border: 1px solid #000;'><input type='text' name='range_var' value='$miles'></td></tr>
    </table>
    <br>
    <input type="submit" value="Update EV" style="border: 1px solid #000; margin-left=5em; margin-left: 80%;">
    </form>
    </div>
UPDATEFORM;

    mysqli_close($db);
}
?>
