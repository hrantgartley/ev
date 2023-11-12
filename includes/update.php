<?php
require('heading.php');

function updateVehicle() {
	echo "updateVehicle";
}
if (isset($_POST['updateButton'])) {
	updateVehicle();
} else {
	echo "";
}
?>
<div class="center">
	<table>
		<tr>
			<th><label for="updateButton">Update Vehicle</label></th>
		</tr>
		<tr>
			<td><input type="text" name="updateButton" id="updateButton" autocomplete="off" maxlength="64"
					pattern="^\d{4}(-\.)$" autofocus required width="100px"></td>
		</tr>
		<tr>
			<td>&nbsp</td>
			<td>&nbsp</td>
			<td>&nbsp</td>
			<td style="margin-left: auto; margin-right: auto; width: 50%;"><input type="submit" name="updateButton"
					value="Update Ev"></td>
		</tr>
	</table>
</div>

<?php require('footing.php'); ?>
