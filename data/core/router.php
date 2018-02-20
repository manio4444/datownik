<?php

/**
 * Router managing views (took form url) corresponding to them controllers filenames
 */
class Router {

  private static $routingArray = array(

    'start' => array(
      'viewFileName' => 'data/app/start.php',
      // '' => 'data/app/start.php',
    ),
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

  public static function getGetParams($name) {
    if (isset($_GET[$name])) {
      return $_GET[$name];
    } else {
      return false;
    }
  }

  public static function getViewFileName($name) {
    return self::$routingArray[$name]['viewFileName'];
  }

    public static function getClassFileName($name) {
      return self::$routingArray[$name]['classFileName'];
    }

    public static function isViewExists($viewName) {
      return array_key_exists($viewName, self::$routingArray);
    }

    public static function isClassExists($viewName) {
      if (!empty(self::$routingArray[$viewName]['classFileName'])) return true;
      return false;
    }

    public static function prepareView() {

      $defaultView = 'data/app/start.php';

      if (isset($_GET['page'])) {
        $viewName = $_GET['page'];
        if (!Router::isViewExists($viewName)) {
          echo "<pre>nie ma widoku o nazwie " . $viewName . "</pre>";
          global $sql_pdo;    //TEMP - for views which doesn't use their own classes yet
          include($defaultView);
        } else {
          $viewFileName = FOLDER_APPS . "/" . Router::getViewFileName($viewName);
          $classFileName = FOLDER_CLASSES . "/" . Router::getClassFileName($viewName);

          if (Router::isClassExists($viewName)) {
            if (file_exists($classFileName)) {
              include($classFileName);
            } else {
              echo "<pre>nie ma pliku $classFileName</pre>";
              echo "<pre>nie można załadowac klasy do widoku: $viewName</pre>";
            }
          }

          if (file_exists($viewFileName)) {
            include($viewFileName);
          } else {
            echo "<pre>nie ma pliku $viewFileName</pre>";
          }
        }
      } else {
        include($defaultView);
      }

    }

    public function importViewClass($viewName) {
      if (!empty(self::$routingArray[$viewName]['classFileName'])) {
        include_once(FOLDER_CLASSES . "/" . self::$routingArray[$viewName]['classFileName']);
      }
      return false;
    }

}

?>
