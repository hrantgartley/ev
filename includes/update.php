<?php
require('heading.php');

// Check if the form for updating the member is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateButton'])) {
    handleUpdate();
}

// Check if the select menu for choosing the member is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_member'])) {
    $selectedMemberId = $_POST['selected_member'];
    displayUpdateForm($selectedMemberId);
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
    $email = mysqli_real_escape_string($db, $_POST['email_var']);
    $expires = mysqli_real_escape_string($db, $_POST['expires_var']);

    $query = "UPDATE members SET name='$name', email='$email', expires='$expires' WHERE ID='$id'";
    $result = mysqli_query($db, $query);

    if ($result === false) {
        die("Update query failed: " . mysqli_error($db));
    }

    mysqli_close($db);
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

    $members = mysqli_query($db, "SELECT ID, name FROM members ORDER BY name");
    if ($members === false) {
        die("Query failed: " . mysqli_error($db));
    }

    echo '<form method="post" action=""><label for="selected_member">Select a member to update:</label><br />';
    echo '<select name="selected_member" id="selected_member">';

    while ($row = mysqli_fetch_array($members)) {
        $id = $row['ID'];
        $name = $row['name'];
        echo "<option value='$id'>$name</option>";
    }

    echo '</select><br /><input type="submit" value="Update Member"></form>';

    mysqli_close($db);
}

function displayUpdateForm($selectedMemberId) {
    require('credentials.php');
    $db = mysqli_connect($hostname, $username, $password, $database);

    if ($db === false) {
        die("Unable to connect: " . mysqli_connect_error());
    }

    $useDB = mysqli_select_db($db, 'namb');
    if (!$useDB) {
        die("Unable to select db: " . mysqli_error($db));
    }

    $query = "SELECT name, email, expires FROM members WHERE ID=?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $selectedMemberId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $email, $expires);
    mysqli_stmt_fetch($stmt);

    echo '<form method="post" action="" class="center"><input type="hidden" name="update_id" value="' . $selectedMemberId . '">';
    echo 'Name: <input type="text" name="name_var" value="' . $name . '"><br />';
    echo 'Email: <input type="text" name="email_var" value="' . $email . '"><br />';
    echo 'Expires: <input type="text" name="expires_var" value="' . $expires . '"><br />';
    echo '<input type="submit" name="updateButton" value="Update"></form>';

    mysqli_stmt_close($stmt);
    mysqli_close($db);
}
?>

