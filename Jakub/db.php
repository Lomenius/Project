<?php

$mysqli = new mysqli('localhost', 'root', '', 'lekaren');
if ($mysqli->connect_errno) {
	echo '<p class="chyba">NEpodarilo sa pripojiť!</p>';

} else {
	$mysqli->query("SET CHARACTER SET 'utf8'");
}

?>