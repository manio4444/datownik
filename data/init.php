<?php
// echo "<pre>";
// var_dump( read_folder($config['plugins_folder']) );
// echo "</pre>";

$config['plugins_folder'] = "plugins";
$config['ini_folder'] = "data/config";

$config['app_path_start'] = 'data/app';
$config['app_path_end'] = '.php';


//identyfikator tablicy to nazwa url, wartość to nazwa pliku BEZ KOŃCÓWKI PHP.
$kontroller_tab['kalendarz'] = 'kalendarz';
$kontroller_tab['zakladki'] = 'urladd';
$kontroller_tab['kontakty'] = 'contactsvcf';
$kontroller_tab['ustawienia'] = 'settings';
$kontroller_tab['pliki'] = 'upload';
$kontroller_tab['notatki'] = 'notepad';
$kontroller_tab['do-zrobienia'] = 'tasks';


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
