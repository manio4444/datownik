<?php

define("FOLDER_PLUGINS", "plugins");
define("FOLDER_INI", "data/config");
define("FOLDER_CLASSES", "data/class");
define("FOLDER_APPS", "data/app");
define("FOLDER_AJAX", "data/ajax");
define("FOLDER_CONTROLLERS", "data/controllers");

define("DEFAULT_VIEW", "start");
define("DEFAULT_TITLE", "Datownik");

$list_ini_files = array(
  'plugins',
  'config',
  'db',
  'lockscreen',
);

foreach ($list_ini_files as $value) {
  $ini_filename = FOLDER_INI . "/$value.ini";
  if (file_exists($ini_filename)) {
    $ini[$value] = parse_ini_file(FOLDER_INI . "/$value.ini");
  } else {
    $error[] = "Problem z załadowaniem pliku konfiguracyjnego:  /$value.ini";
  }
}
// echo "<pre>";var_dump($ini);die();

 ?>
