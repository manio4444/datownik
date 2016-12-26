<?php

$sql_host = $ini['important']['sql_host'];
$sql_user = $ini['important']['sql_user'];
$sql_password = $ini['important']['sql_password'];
$sql_database = $ini['important']['sql_database'];
$sql_encoding = $ini['important']['sql_encoding'];

//PDO
try {
	$sql_pdo = new PDO('mysql:host=' . $sql_host . ';dbname=' . $sql_database . ';encoding= ' . $sql_encoding . '', $sql_user, $sql_password);
	$sql_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql_pdo -> query ('SET NAMES utf8');

	//$sql_pdo->exec("set names utf8"); //bo jebane home.pl ma stare php. Jak będzie miało co najmniej 5.3.6 to można zakomentować.
	//http://stackoverflow.com/questions/4361459/php-pdo-charset-set-names


	/*
	PDO::ATTR_ERRMODE: Error reporting.
	PDO::ERRMODE_EXCEPTION: Throw exceptions.
	*/
	//$pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
	/*
	PDO::ATTR_DEFAULT_FETCH_MODE: Set default fetch mode
	PDO::FETCH_ASSOC: returns an array indexed by column name as returned in your result set
	*/

}

catch(PDOException $e) {
	$error[] = 'Połączenie mysql przy pomocy PDO nie mogło zostać utworzone: ' . $e->getMessage();
}

?>
