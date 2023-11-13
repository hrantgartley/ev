<?php

if (isset($_POST['deleteButton'])) {
	deleteEV();
} else {
	displayForm();
}

function displayForm() {
	echo <<< FORM
	<form action="delete.php" method="post">
	  <table style="margin-right: auto; margin-left: auto; width: 50%"; id="deleteTable">
	    <tr>
		  <th><label for="name">Model: </label></th>
	  </tr>
	  <tr>
		  <td><input type="text" name="name" id="name" required maxlength="64" placeholder="name of EV" autocomplete="off" ></td>
	  </tr>
	  <tr>
		  <td style="float:right;"> <input type="submit" name="deleteButton" value="Delete EV"></td>
	  </tr>
	  </table>
    </form>
FORM;
}

function deleteEV() {
	$name = $_POST['name'];
	$name = trim($name);
	$name = filter_var($name, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[0-9a-zA-Z !-\.]{1,64}$/")));
	if ($name != false) {
		// connect to database
		require("credentials.php");
		$db = mysqli_connect($hostname, $username, $password, $database);
		if (mysqli_connect_errno()) {
			die("unable to connect to databse" . mysqli_connect_error());
		}
		$query = "DELETE FROM cars WHERE name = '" . $name . "'";
		if (mysqli_query($db, $query)) {
			echo <<< SUCCESS
			<div class="center">
			  <h2> Success! Record deleted from database. </h2>
			</div>
SUCCESS;
		}
	} else {
		echo <<< FAILURE
	<div class="center">
	  <h2> Failure! Record not deleted from database. </h2>
    </div>
}
FAILURE;
	}
	mysqli_close($db);
}
