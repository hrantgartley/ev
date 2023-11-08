<?php

require('heading.php');
echo <<< BLOCKY
	<table>
	  <tr>
	<td> &bullet; <a href="listing.php">Display EV list</a></td>
	</tr>
	  <tr>
	<td> &bullet; <a href="add.php">Add Ev</a></td>
	</tr>
	  <tr>
	<td> &bullet; <a href="update.php">Update EV List</a></td>
	</tr>
	  <tr>
	<td> &bullet; <a href="delete.php">Delete EV</a></td>
	</tr>
</table>
BLOCKY;

require('footing.php');
