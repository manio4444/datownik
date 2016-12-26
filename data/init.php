<?php
// echo "<pre>";
// var_dump( read_folder($config['plugins_folder']) );
// echo "</pre>";

$config['plugins_folder'] = "data/plugins";
$config['ini_folder'] = "data/config";

$list_ini_files = array(
  plugins,
  config,
  db
);

foreach ($list_ini_files as $value) {
  $ini[$value] = parse_ini_file($config['ini_folder'] . "/$value.ini");

}
// echo "<pre>";var_dump($ini);

 ?>
