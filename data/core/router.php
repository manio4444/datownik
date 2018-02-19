<?php

/**
 * Router managing views (took form url) corresponding to them controllers filenames
 */
class Router {

  private static $routingArray = array(
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
      'classFileName' => 'notes.php',
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

  public function getGetParams($name) {
    if (isset($_GET[$name])) {
      return $_GET[$name];
    } else {
      return false;
    }
  }

  public function getViewFileName($name) {
    return self::$routingArray[$name]['viewFileName'];
  }

    public function getClassFileName($name) {
      return self::$routingArray[$name]['classFileName'];
    }

    public function isViewExists($viewName) {
      return array_key_exists($viewName, self::$routingArray);
    }

    public function isClassExists($viewName) {
      if (!empty(self::$routingArray[$viewName]['classFileName'])) return true;
      return false;
    }

}

?>
