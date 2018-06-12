<?php

/**
* defaultController
*/

class ajaxRouter extends database {

  private static $routingArray = array(

    'docsAjax' => array(
      'ajaxControllerFileName' => 'docs.php',
    ),
  );

  public function detectAjax() {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest') {
      return true;
    } else {
      return false;
    }
  }

  public function tryAjax() {
    if (static::detectAjax() === false) {
      return null;
    }
    if (static::existsAjaxController() === false) {
      return null;
    }

    static::startAjaxOutput();
    $data = static::doAjax();
    static::endAjaxOutput($data);
  }

  private function existsAjaxController() {
    if (isset($_GET['ajax_action']) && !empty($_GET['ajax_action'])) {
      return true;
    } else {
      return false;
    }
  }

  private function getAjaxController() {
    if (
      !array_key_exists($_GET['ajax_action'], self::$routingArray)
      || !array_key_exists('ajaxControllerFileName', self::$routingArray[$_GET['ajax_action']])
      || empty(self::$routingArray[$_GET['ajax_action']]['ajaxControllerFileName'])
      || !file_exists(FOLDER_AJAX . '/' . self::$routingArray[$_GET['ajax_action']]['ajaxControllerFileName'])
    ) {
      return false;
    }

    include(FOLDER_AJAX . '/' . self::$routingArray[$_GET['ajax_action']]['ajaxControllerFileName']);
    return $_GET['ajax_action'];
  }

  private function doAjax() {
    $ajaxController = static::getAjaxController();
    if ($ajaxController === false) {
      return array(
        'status' => 404,
        'message' => 'Nie można załadować klasy: ' . $_GET['ajax_action'],
      );
    } else {
      // echo 'ajax' . $ajaxController;
      $controller = new $ajaxController;
      return $controller->render();
    }
    if (isset($ajaxController) && class_exists($ajaxController)) {
      $controller = new $ajaxController;
    }
  }

  public function startAjaxOutput() {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    ob_start();
  }

  public function endAjaxOutput($data) {
    $content = ob_get_contents();
    ob_end_clean();

    echo json_encode(
      array(
        'data' => $data,
        'content' => $content,
      )
    );
    die();
  }

}

?>
