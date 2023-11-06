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
	<form action="add.php" method="post"></form>
	<table>
	<tr>
		<th><label for="name">Model: </label></th>
		<th><label for="year">Years: </label></th>
		<th><label for="miles">Miles: </label></th>
	</tr>
	<tr>
		<td><input type="text" name="name" id="name" required maxlength="64" placeholder="name of EV" autocomplete="off"></td>
		<td><input type="text" name="year" id="year" required maxlength="9" placeholder="1970-2000" pattern="/d{4}-$|^\d{4}-\d{4}$" autocomplete="off"></td>
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
}
