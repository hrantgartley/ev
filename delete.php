<?php

require('heading.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ids'])) {
    handleDelete();
}

displayList();
require('footing.php');

function handleDelete() {
    require('credentials.php');
    $db = mysqli_connect($hostname, $username, $password, $database);

    if ($db === false) {
        die("Unable to connect: " . mysqli_connect_error());
    }

    $useDB = mysqli_select_db($db, 'ev');
    if (!$useDB) {
        die("Unable to select db: " . mysqli_error($db));
    }

    foreach ($_POST['delete_ids'] as $id) {
        $id = mysqli_real_escape_string($db, $id);
        $result = mysqli_query($db, "DELETE FROM cars WHERE id = '$id'");

        if ($result === false) {
            die("Delete query failed: " . mysqli_error($db));
        }
    }

    mysqli_close($db);
}

function displayList() {
    $background = 0;
    echo <<< BLOCK
    <div style="text-align: center;">
        <form method="post" action="">
            <table style="margin-left: auto; margin-right: auto; width: 50%">
                <tr>
                    <th>Delete</th>
                    <th>Name</th>
                    <th>Production Years</th>
                    <th>Range</th>
                </tr>
BLOCK;

    require('credentials.php');
    $db = mysqli_connect($hostname, $username, $password, $database);

    if ($db === false) {
        die("Unable to connect: " . mysqli_connect_error());
    }

    $useDB = mysqli_select_db($db, 'ev');
    if (!$useDB) {
        die("Unable to select db: " . mysqli_error($db));
        echo "            \r</table>";
    }

    $cars = mysqli_query($db, "SELECT id, name, productionYears, miles FROM cars ORDER BY productionYears");
    if ($cars === false) {
        die("Query failed: " . mysqli_error($db));
    }

    while ($row = mysqli_fetch_array($cars)) {
        $id = $row[0];
        $name = $row[1];
        $productionYears = $row[2];
        $miles = $row[3];

        if ($background++ % 2 == 0) {
            echo "        <tr style=\"background-color: white\">\n";
        } else {
            echo "        <tr style=\"background-color: lightgrey\">\n";
        }

        echo <<< TABLE
        <td><input type="checkbox" name="delete_ids[]" value="$id"></td>
        <td>$name</td>
        <td>$productionYears</td>
        <td>$miles</td>
      </tr>
TABLE;
    }

    echo <<< BUTTON
            </table>
            <button type="submit" style="margin-right: 43%">Delete Selected</button>
        </form>
    </div>
BUTTON;

    mysqli_close($db);
}
?>
