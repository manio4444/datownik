<?php

/**
* Autoloader implementation
*/

spl_autoload_register(function ($class) {
  $ajaxSuffix = '/^.+Ajax$/';

  if (preg_match($ajaxSuffix, $class) === 1) {
    $class = str_replace('Ajax', '', $class);
  }

  $classPath = FOLDER_CLASSES . '/' . $class . '.php';

  if (!file_exists($classPath) || !is_readable($classPath)) {
    throw new Exception('[AUTOLOADER] - Nie można załadować klasy: ' . $class  . ' - Ścieżka: ' . $classPath);
  }

  require $classPath;
});

?>
