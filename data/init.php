<?php

$config['ini_folder'] = "data/config";

define("FOLDER_PLUGINS", "plugins");
define("FOLDER_INI", "data/config");
define("FOLDER_CLASSES", "data/class");
define("FOLDER_APPS", "data/app");


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
