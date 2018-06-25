<?php

/**
 * Router managing views (took form url) corresponding to them controllers filenames
 */
class Router {

  private static $routingArray = array(

    'start' => array(
      'viewFileName' => 'start.php',
      // 'classFileName' => 'start.php',
    ),
    'kalendarz' => array(
      'viewFileName' => 'kalendarz.php',
      'classFileName' => 'calendar.php',
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
    'debug' => array(
      'viewFileName' => 'debug.php',
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
    if (!array_key_exists('viewFileName', self::$routingArray[$name])) {
      return false;
    }
    return self::$routingArray[$name]['viewFileName'];
  }

    public static function getClassFileName($name) {
      if (!array_key_exists('classFileName', self::$routingArray[$name])) {
        return false;
      }
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

      if (isset($_GET['page']) && !Router::isViewExists($_GET['page'])) {
        System::error("Błąd - nie ma widoku o nazwie: " . $_GET['page']);
        $viewName = DEFAULT_VIEW;
      } elseif (isset($_GET['page']) && Router::isViewExists($_GET['page'])) {
        $viewName = $_GET['page'];
      } elseif (!Router::isViewExists(DEFAULT_VIEW)) {
        System::error("Błąd - nie ma widoku domyślnego: " . DEFAULT_VIEW);
        return false;
      } else {
        $viewName = DEFAULT_VIEW;
      }

      $viewFileName = FOLDER_APPS . "/" . Router::getViewFileName($viewName);
      $classFileName = FOLDER_CLASSES . "/" . Router::getClassFileName($viewName);

      if (!Router::getViewFileName($viewName)) {
        System::error("Błąd - nieznana ścieżka widoku: " . $viewName);
      } elseif (!file_exists($viewFileName)) {
        System::error("Błąd - nie znaleziono pliku widoku: " . $viewName);
      }

      if (Router::isClassExists($viewName) && !file_exists($classFileName)) {
        System::error("Błąd - nie znaleziono pliku kontrolera: " . $viewName);
      } elseif (Router::isClassExists($viewName)) {
          include($classFileName);
      }

      ob_start();
      include($viewFileName);
      $viewOutput = ob_get_contents();
      ob_end_clean();
      return $viewOutput;


    }

    public function importViewClass($viewName) {

      $classFileName = FOLDER_CLASSES . "/" . Router::getClassFileName($viewName);
      if (!Router::isClassExists($viewName)) {
        System::error("Błąd - nie ma kontrolera do widoku: " . $viewName);
      } elseif (Router::isClassExists($viewName) && !file_exists($classFileName)) {
        System::error("Błąd - nie znaleziono pliku kontrolera do widoku: " . $viewName);
      } elseif (Router::isClassExists($viewName)) {
          include($classFileName);
          return true;
      } else {
        return false;
      }

    }

}

?>
