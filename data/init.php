<?php
// echo "<pre>";
// var_dump( read_folder($config['plugins_folder']) );
// echo "</pre>";

$config['plugins_folder'] = "plugins";
$config['ini_folder'] = "data/config";

$config['app_path_start'] = 'data/app';
$config['class_path_start'] = 'data/class';


/*
* 'GET name'
*
*
*
*
*
*/
$kontroller_tab = array(
  'kalendarz' => array(
    'appFileName' => 'kalendarz.php',
    'classFileName' => '',
  ),
  'zakladki' => array(
    'appFileName' => 'urladd.php',
    'classFileName' => 'bookmarks.php',
  ),
  'kontakty' => array(
    'appFileName' => 'contactsvcf.php',
    'classFileName' => '',
  ),
  'ustawienia' => array(
    'appFileName' => 'settings.php',
    'classFileName' => '',
  ),
  'pliki' => array(
    'appFileName' => 'upload.php',
    'classFileName' => '',
  ),
  'notatki' => array(
    'appFileName' => 'notepad.php',
    'classFileName' => '',
  ),
  'do-zrobienia' => array(
    'appFileName' => 'tasks.php',
    'classFileName' => 'tasks.php',
  ),
);


$list_ini_files = array(
  'plugins',
  'config',
  'db'
);

foreach ($list_ini_files as $value) {
	$ini_filename = $config['ini_folder'] . "/$value.ini";
	if (file_exists($ini_filename)) $ini[$value] = parse_ini_file($config['ini_folder'] . "/$value.ini");
	else $error[] = "Problem z załadowaniem pliku konfiguracyjnego:  /$value.ini";
}
// echo "<pre>";var_dump($ini);

 ?>
