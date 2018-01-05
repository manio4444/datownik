<?php
//print_r ($_GET);
if (!include("data/init.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku inicjującego.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/functions.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z funkcjami.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/db.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z połączeniem SQL.</p><p>[!] die();</p>"; die();  } //pobiera funkcje

// setcookie( "admin", 1, strtotime( '+30 days' ) );


include('data/operations.php');

include('data/head.php'); //początek kodu do otwarcia znacznika body

//w przyszłości zabezpieczyć operacje przed zalogowaniem
if (@$_COOKIE['admin']!=1) {
  include('data/lockscreen.php');
} else {
  include('data/header.php');

  /**
   * Mini Viev Module
   * TODO in future move to other file, maybe make class for this
   */

   $defaultView = 'data/app/start.php';

  if (isset($_GET['page'])) {
    $viewName = $_GET['page'];
    if (!array_key_exists($viewName, $kontroller_tab)) {
      echo "<pre>nie ma widoku o nazwie " . $viewName . "</pre>";
      include($defaultView);
    } else {
      $viewFileName = FOLDER_APPS . "/" . $kontroller_tab[$viewName]['viewFileName'];
      $classFileName = FOLDER_CLASSES . "/" . $kontroller_tab[$viewName]['classFileName'];
      if (!empty($kontroller_tab[$viewName]['classFileName'])) {
        if (file_exists($classFileName)) {
          include($classFileName);
        } else {
          echo "<pre>nie ma pliku $classFileName</pre>";
        }
      }

      if (file_exists($viewFileName)) {
        include($viewFileName);
      } else {
        echo "<pre>nie ma pliku $viewFileName</pre>";
      }
    }
  } else {
    include($defaultView);
  }

  /**
   * Mini Viev Module - END
   */


} // koniec else w ktory jest wszystko poza lockscreenem

include('data/footer.php');

?>
