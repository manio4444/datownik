<?php

if (!include_once("data/init.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku inicjującego.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include_once("data/functions.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z funkcjami.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include_once("data/db.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z połączeniem SQL.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include_once('data/core/router.php')) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z routingiem.</p><p>[!] die();</p>"; die();  } //pobiera funkcje

if (!include_once("data/core/system.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z klasą obsługi systemu.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include_once("data/core/database.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z połączeniem SQL.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include_once("data/core/defaultController.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z klasą dla kontrolerów.</p><p>[!] die();</p>"; die();  } //pobiera funkcje

include_once('data/operations.php');


// setcookie( "admin", 1, strtotime( '+30 days' ) );

/*
* TEMPLATE PART
* in future move to layout.php views controller
*/
include('data/view/head.php'); //początek kodu do otwarcia znacznika body

// TODO dodać zamiast tego poniżej klasę do sprawdzania uprawnień
if (@$_COOKIE['admin']!=1) {
  include('data/view/lockscreen.php');
} else {
  include('data/view/header.php');


   Router::prepareView();


} // koniec else w ktory jest wszystko poza lockscreenem

include('data/view/footer.php');
/*
* TEMPLATE PART END
*/

?>
