<?php

if (!include("data/init.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku inicjującego.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/functions.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z funkcjami.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/db.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z połączeniem SQL.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include('data/core/router.php')) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z routingiem.</p><p>[!] die();</p>"; die();  } //pobiera funkcje

if (!include("data/core/system.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z klasą obsługi systemu.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/core/database.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z połączeniem SQL.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/core/defaultController.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z klasą dla kontrolerów.</p><p>[!] die();</p>"; die();  } //pobiera funkcje

// setcookie( "admin", 1, strtotime( '+30 days' ) );


include('data/operations.php');

include('data/head.php'); //początek kodu do otwarcia znacznika body

// TODO dodać zamiast tego poniżej klasę do sprawdzania uprawnień
if (@$_COOKIE['admin']!=1) {
  include('data/lockscreen.php');
} else {
  include('data/header.php');


   Router::prepareView();


} // koniec else w ktory jest wszystko poza lockscreenem

include('data/footer.php');

?>
