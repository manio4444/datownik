<?php

$config['ini_folder'] = "data/config";

define("FOLDER_PLUGINS", "plugins");
define("FOLDER_INI", "data/config");
define("FOLDER_CLASSES", "data/class");
define("FOLDER_APPS", "data/app");


/*
* Table of views (took form url) corresponding to them controllers filenames
*
*/


$kontroller_tab = array(
  'kalendarz' => array(
    'viewFileName' => 'kalendarz.php',
    'classFileName' => '',
  ),
  'zakladki' => array(
    'viewFileName' => 'urladd.php',
    'classFileName' => 'bookmarks.php',
  ),
  'kontakty' => array(
    'viewFileName' => 'contactsvcf.php',
    'classFileName' => '',
  ),
  'ustawienia' => array(
    'viewFileName' => 'settings.php',
    'classFileName' => '',
  ),
  'pliki' => array(
    'viewFileName' => 'upload.php',
    'classFileName' => '',
  ),
  'notatki' => array(
    'viewFileName' => 'notepad.php',
    'classFileName' => '',
  ),
  'do-zrobienia' => array(
    'viewFileName' => 'tasks.php',
    'classFileName' => 'tasks.php',
  ),
  'dokumenty' => array(
    'viewFileName' => 'docs.php',
    'classFileName' => 'docs.php',
  ),
);


$list_ini_files = array(
  'plugins',
  'config',
  'db',
  'lockscreen',
);

foreach ($list_ini_files as $value) {
	$ini_filename = $config['ini_folder'] . "/$value.ini";
	if (file_exists($ini_filename)) $ini[$value] = parse_ini_file($config['ini_folder'] . "/$value.ini");
	else $error[] = "Problem z załadowaniem pliku konfiguracyjnego:  /$value.ini";
}
// echo "<pre>";var_dump($ini);die();

 ?>
