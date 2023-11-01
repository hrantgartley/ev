<?php

require('heading.php');
displayList();
require('footing.php');

function displayList() {
	$bg = 0;
	echo <<< BLOCK
    <table>
      <tr>
        <th>Name</th>
        <th>Prod Years</th>
        <th>Range</th>
      </tr>
BLOCK;

	// connect to db

	$db = mysqli_connect("127.0.0.1", "webuser", "", "test", 3306);

	if ($db === false) {
		die("Unable to connect: " . mysqli_connect_error());
	}


	$useDB = mysqli_select_db($db, 'test');
	if (!$useDB) {
		die("Unable to select db: " . mysqli_error($db));
		echo "            \r</table>";
	}


	$cars = mysqli_query($db, "SELECT name, productionYears, range FROM cars ORDER BY productionYears");
	if ($cars === false) {
		die("Query failed: " . mysqli_error($db));
	}

	while ($row = mysqli_fetch_array($cars)) {
		$name = $row[0];
		$productionYears = $row[1];
		$range = $row[2];

		if ($bg++ % 2 == 0) {
			echo "      <tr style=\"background-color: white\">\n";
		} else {
			echo "      <tr style=\"background-color: lightgrey\">\n";
		}

		echo <<< TABLE
        <td>$name</td>
        <td>$productionYears</td>
        <td>$range</td>
      </tr>
TABLE;
	}

	echo "</table>";
	mysqli_close($db);
}
