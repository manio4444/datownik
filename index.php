<?php
//print_r ($_GET);
if (!include("data/init.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku inicjującego.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/functions.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z funkcjami.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/db.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z połączeniem SQL.</p><p>[!] die();</p>"; die();  } //pobiera funkcje

// setcookie( "admin", 1, strtotime( '+30 days' ) );
if (isset($_GET['code']) && $_GET['code']==1234) {
  setcookie( "admin", 1, strtotime( '+30 days' ) );
  header("Location: " . get_url('clean'));
}




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
    $appFilename = $config['app_path_start'] . "/" . $kontroller_tab[$_GET['page']]['appFileName'];
    $classFilename = $config['class_path_start'] . "/" . $kontroller_tab[$_GET['page']]['classFileName'];
    
    if (isset($kontroller_tab[$_GET['page']]['classFileName']) && file_exists($classFilename)) {
      include($classFilename);
    } else {
      echo "nie ma pliku $classFilename <br>";
    }

    if (file_exists($appFilename)) {
      include($appFilename);
    } else {
      echo "nie ma pliku $appFilename <br>";
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
