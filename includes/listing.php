<?php

require('heading.php');
displayList();
require('footing.php');

function displayList() {
    $background = 0;
    echo <<< BLOCK
    <table style="margin-left: auto; margin-right: auto; width: 50%">
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Expiration Date</th>
      </tr>
BLOCK;

    require('credentials.php');
    $db = mysqli_connect($hostname, $username, $password, $database);

    if ($db === false) {
        die("Unable to connect: " . mysqli_connect_error());
    }

    $useDB = mysqli_select_db($db, $database);
    if (!$useDB) {
        die("Unable to select db: " . mysqli_error($db));
        echo "            \r</table>";
    }

    $members = mysqli_query($db, "SELECT name, email, expires FROM members ORDER BY name");
    if ($members === false) {
        die("Query failed: " . mysqli_error($db));
    }

    while ($row = mysqli_fetch_array($members)) {
        $name = $row['name'];
        $email = $row['email'];
        $expires = $row['expires'];

        if ($background++ % 2 == 0) {
            echo "        <tr style=\"background-color: white\">\n";
        } else {
            echo "        <tr style=\"background-color: lightgrey\">\n";
        }

        echo <<< TABLE
        <td>$name</td>
        <td>$email</td>
        <td>$expires</td>
      </tr>
TABLE;
    }

    echo "</table>\n";
    mysqli_close($db);
}
?>
