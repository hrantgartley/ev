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

	require('credentials.php');
	$db = mysqli_connect($hostname, $username, $password, $database);

	if ($db === false) {
		die("Unable to connect: " . mysqli_connect_error());
		die("Bestest ever evrer");
	}

	$useDB = mysqli_select_db($db, 'ev');
	if (!$useDB) {
		die("Unable to select db: " . mysqli_error($db));
		echo "            \r</table>";
	}

	$cars = mysqli_query($db, "SELECT name, productionYears, miles FROM cars ORDER BY productionYears");
	if ($cars === false) {
		die("Query failed: " . mysqli_error($db));
	}

	while ($row = mysqli_fetch_array($cars)) {
		$name = $row[0];
		$productionYears = $row[1];
		$miles = $row[2];

		if ($bg++ % 2 == 0) {
			echo "        <tr style=\"background-color: white\">\n";
		} else {
			echo "        <tr style=\"background-color: lightgrey\">\n";
		}

		echo <<< TABLE
        <td>$name</td>
        <td>$productionYears</td>
        <td>$miles</td>
      </tr>
TABLE;
	}

	echo "</table>\n";
	mysqli_close($db);
}
