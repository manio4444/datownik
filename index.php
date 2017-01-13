<?php
// setcookie( "admin", 1, strtotime( '+30 days' ) );
if (isset($_GET['code']) && $_GET['code']==1234) setcookie( "admin", 1, strtotime( '+30 days' ) );
//print_r ($_GET);
if (!include("data/init.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku inicjującego.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/functions.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z funkcjami.</p><p>[!] die();</p>"; die();  } //pobiera funkcje
if (!include("data/db.php")) { echo "<p>[!] Błąd krytyczny systemu - nie można zaimplementować pliku z połączeniem SQL.</p><p>[!] die();</p>"; die();  } //pobiera funkcje





include('data/operations.php');




include('data/header.php');



//pierwszy to nazwa url, drugi to nazwa pliku BEZ KOŃCÓWKI PHP.
$kontroller_tab['kalendarz'] = 'kalendarz';
$kontroller_tab['zakladki'] = 'urladd';
$kontroller_tab['kontakty'] = 'contactsvcf';
$kontroller_tab['ustawienia'] = 'settings';
$kontroller_tab['pliki'] = 'upload';
$kontroller_tab['notatki'] = 'notepad';

//w przyszłości zabezpieczyć operacje przed zalogowaniem
if (@$_COOKIE['admin']!=1) {
  include('data/lockscreen.php');
}

// MINI VIEV MODULE
else if (isset($_GET['page'])) {
  $path_start = 'data/app';
  $path_end = '.php';
  $filename = "$path_start/" . $kontroller_tab[$_GET['page']] . $path_end;
  if (file_exists($filename)) include($filename);
  else echo "nie ma pliku $filename <br>";

/*
  foreach (array_diff(scandir('data/app'), array('..', '.')) as $key => $value) {
    if(is_dir($value)) echo "<img src='../icons/folder.gif'>&nbsp;";
    else echo "<img src='../icons/text.gif'>&nbsp;";
    echo "<a href='$value'>$value</a><br>";
  }*/
}
else include('data/app/start.php');
// MINI VIEV MODULE - END












include('data/footer.php');












?>
