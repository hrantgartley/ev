<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('heading.php');

if (isset($_POST['addButton'])) {
    addMember();
} else {
    displayForm();
}

function displayForm() {
    echo <<< FORM
    <form action="add.php" method="post">
    <table style="margin-right: auto; margin-left: auto; width: 50%" id="addTable">
    <tr>
        <th><label for="name">Name: </label></th>
        <th><label for="email">Email: </label></th>
        <th><label for="expires">Expiration Date: </label></th>
    </tr>
    <tr>
        <td><input type="text" name="name" id="name" required maxlength="64" placeholder="Name" autocomplete="off"></td>
        <td><input type="email" name="email" id="email" required placeholder="Email" autocomplete="off"></td>
        <td><input type="date" name="expires" id="expires" required></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="float:right;"> <input type="submit" name="addButton" value="Add Member"></td>
    </tr>
    </table>
    </form>
FORM;
}

function addMember() {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $expires = $_POST['expires'];

    $name = trim($name);
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $expires = date('Y-m-d', strtotime($expires));

    if ($name && $email && $expires) {
        require("credentials.php");
        $db = mysqli_connect($hostname, $username, $password, $database);

        if (mysqli_connect_errno()) {
            die("Unable to connect to database: " . mysqli_connect_error());
        }

        $query = "INSERT INTO members (name, email, expires) VALUES(?,?,?)";
        $stmt = mysqli_prepare($db, $query);

        mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $expires);

        if (mysqli_stmt_execute($stmt)) {
            echo <<< SUCCESS
            <div class="center">
                <h2>Success! Record added to database.</h2>
            </div>
            SUCCESS;
        } else {
            echo <<< FAIL
            <div class="center">
                <h2>An error occurred. Unable to add record.</h2>
            </div>
            FAIL;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($db);
    } else {
        die("Invalid input data");
    }
}

require 'footing.php';
