<?php
//print_r ($_GET);
if (!include("data/init.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku inicjującego.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/functions.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z funkcjami.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/db.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z połączeniem SQL.</p><p>[!] die();</p>"; die();  } //pobiera funkcje

// setcookie( "admin", 1, strtotime( '+30 days' ) );





include('data/operations.php');




include('data/head.php'); //początek kodu do otwarcia znacznika body


// $kontroller_tab[] w init.php

//w przyszłości zabezpieczyć operacje przed zalogowaniem
if (@$_COOKIE['admin']!=1) {
  include('data/lockscreen.php');
} else {
  include('data/header.php');
  // MINI VIEV MODULE
  if (isset($_GET['page'])) {
    $appFilename = FOLDER_APPS . "/" . $kontroller_tab[$_GET['page']]['appFileName'];
    $classFilename = FOLDER_CLASSES . "/" . $kontroller_tab[$_GET['page']]['classFileName'];

    if (!empty($kontroller_tab[$_GET['page']]['classFileName'])) {
      if (file_exists($classFilename)) {
        include($classFilename);
      } else {
        echo "<pre>nie ma pliku $classFilename</pre>";
      }
    }

    if (file_exists($appFilename)) {
      include($appFilename);
    } else {
      echo "<pre>nie ma pliku $appFilename</pre>";
    }
  /*
    foreach (array_diff(scandir('data/app'), array('..', '.')) as $key => $value) {
      if(is_dir($value)) echo "<img src='../icons/folder.gif'>&nbsp;";
      else echo "<img src='../icons/text.gif'>&nbsp;";
      echo "<a href='$value'>$value</a><br>";
    }*/
  }
  else include('data/app/start.php');
  // MINI VIEV MODULE - END

} // koniec else w ktory jest wszystko poza lockscreenem











include('data/footer.php');












?>
