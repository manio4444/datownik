<?php

$baseIncludes[] = "data/init.php";
$baseIncludes[] = "data/functions.php";
$baseIncludes[] = "data/db.php";
$baseIncludes[] = 'data/core/classLoader.php';
$baseIncludes[] = 'data/core/router.php';
$baseIncludes[] = "data/core/system.php";
$baseIncludes[] = "data/core/database.php";
$baseIncludes[] = "data/core/defaultController.php";

try {
  foreach ($baseIncludes as $key => $value) {
    if (file_exists($value) && is_readable($value)) {
      include_once($value);
    } else {
      throw new Exception('[BASE] - Nie można załadować pliku: ' . $value);
    }
  }
} catch (Exception $e) {
  echo 'Błąd krytyczny systemu: '.$e->getMessage();
  die;
}

// TODO docelowo pozbyć się oddzielnego routera do ajaxa ???
include_once('data/core/ajaxRouter.php');
ajaxRouter::tryAjax();

// TODO docelowo poprzenosić operacje do konkretnych modelów
include_once('data/operations.php');


// setcookie( "admin", 1, strtotime( '+30 days' ) );

/*
* TEMPLATE PART
* in future move to layout.php views controller
*/

ob_start();
include('data/view/head.php'); //template up to body tag

// TODO dodać zamiast tego poniżej klasę do sprawdzania uprawnień
if (@$_COOKIE['admin']!=1) {
  include('data/view/lockscreen.php');
} else {
  include('data/view/header.php');

  echo Router::prepareView();

} // koniec else w ktory jest wszystko poza lockscreenem

$tempateOutput = ob_get_contents();
ob_end_clean();
echo $tempateOutput;

include('data/view/footer.php');
/*
* TEMPLATE PART END
*/

?>
