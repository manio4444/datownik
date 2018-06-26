<?php

/**
* Autoloader implementation
*/

spl_autoload_register(function ($class) {
  $classPath = FOLDER_CONTROLLERS . '/' . $class;
  if (file_exists($classPath) && is_readable($classPath)) {
  } else {
    throw new Exception('[AUTOLOADER] - Nie można załadować klasy: ' . $class);
  }
  include $classPath;
});

?>
