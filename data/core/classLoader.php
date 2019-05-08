<?php

/**
* Autoloader implementation
*/

spl_autoload_register(function ($class) {
  $ajaxSuffix = '/^.+Ajax$/';
  if (preg_match($ajaxSuffix, $class) === 1) {
    $fileName = str_replace('Ajax', '', $class);
    $classPath = FOLDER_AJAX . '/' . $fileName . '.php';
  } else {
    $classPath = FOLDER_CLASSES . '/' . $class . '.php';
  }
  if (file_exists($classPath) && is_readable($classPath)) {
  } else {
    throw new Exception('[AUTOLOADER] - Nie można załadować klasy: ' . $class  . ' - Ścieżka: ' . $classPath);
  }
  require $classPath;
});

?>
