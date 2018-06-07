<section id="debug_page">
<?php

echo '<h1>Plugins read_folder</h1>';

foreach (read_folder(FOLDER_PLUGINS) as $value) {
  $read_folder[$value[0] . $value[1]] = '';   //tworzy tablice o id takim jak folder+nazwa pliku
}
echo '<pre style="white-space: pre;">';
var_dump($read_folder);
echo '</pre>';

echo '<h1>Database fields</h1>';

$tempTables = new database;

echo '<pre style="white-space: pre;">';
foreach ($tempTables->getInstance()->query('SHOW TABLES;') as $value) {
  // $tempTables->getInstance()->query('SHOW COLUMNS FROM bookmarks;');
  var_dump($value[0]);
}
echo '</pre>';


foreach ($tempTables->getInstance()->query('SHOW TABLES;') as $value) {
  echo '<pre style="white-space: pre;">';
  echo $value[0] . '<br />';
  foreach ($tempTables->getInstance()->query('SHOW COLUMNS FROM ' . $value[0] . ';') as $value) {
    // $tempTables->getInstance()->query('SHOW COLUMNS FROM bookmarks;');
    var_dump($value[0]);
  }
  echo '</pre>';
}

?>
</section>
