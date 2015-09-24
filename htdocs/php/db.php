<?php

$dbuser		= "gtools";
$dbpass		= "af67a3300209eae4441b7086";
$dbname		= "gtools";
$dbhost		= "localhost";


try {

	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

	echo $e->getMessage();

}

?>
