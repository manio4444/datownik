<?php

/**
* defaultController
*/

class ajaxRouter extends database {

  private static $routingArray = array(

    'docsAjax' => array(
      'ajaxControllerFileName' => 'docs.php',
    ),

    'lockscreenAjax' => array(
      'ajaxControllerFileName' => 'lockscreen.php',
    ),

    'tasksAjax' => array(
      'ajaxControllerFileName' => 'tasks.php',
    ),

    'notesAjax' => array(
      'ajaxControllerFileName' => 'notes.php',
    ),
  );

  public static function detectAjax() {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest') {
      return true;
    } else {
      return false;
    }
  }

  public static function tryAjax() {
    // if (static::detectAjax() === false) {
    //   return null;
    // }

    // static::startAjaxOutput();

    $existsAjaxController = static::existsAjaxController();
    if ($existsAjaxController === false) {
      return null; //temporarily must do nothing, because of lots of functionality doing ajax calls in operations.php
      // $data = array(
      //   'status' => 404,
      //   'message' => 'Nie podano parametru ajax_action.',
      // );
    } else {
      static::startAjaxOutput();
      $data = static::doAjax($existsAjaxController);
      static::endAjaxOutput($data);
    }

    // static::endAjaxOutput($data);
  }

  private static function existsAjaxController() {
    if (isset($_GET['ajax_action']) && !empty($_GET['ajax_action'])) {
      return $_GET['ajax_action'];
    } elseif (isset($_POST['ajax_action']) && !empty($_POST['ajax_action'])) {
      return $_POST['ajax_action'];
    } else {
      return false;
    }
  }

  private static function getAjaxController($ajaxController) {
    if (
      !array_key_exists($ajaxController, self::$routingArray)
      || !array_key_exists('ajaxControllerFileName', self::$routingArray[$ajaxController])
      || empty(self::$routingArray[$ajaxController]['ajaxControllerFileName'])
      || !file_exists(FOLDER_AJAX . '/' . self::$routingArray[$ajaxController]['ajaxControllerFileName'])
    ) {
      return false;
    }

    include(FOLDER_AJAX . '/' . self::$routingArray[$ajaxController]['ajaxControllerFileName']);
    return $ajaxController;
  }

  private static function doAjax($ajaxControllerName) {
    $ajaxController = static::getAjaxController($ajaxControllerName);
    if ($ajaxController === false) {
      return array(
        'status' => 404,
        'message' => 'Nie można załadować klasy: ' . $ajaxControllerName,
      );
    } else {
      $controller = new $ajaxController;
      return $controller->render();
    }
  }

  public static function startAjaxOutput() {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    ob_start();
  }

  public static function endAjaxOutput($data) {
    $content = ob_get_contents();
    ob_end_clean();

    if ($data['status'] === 404) {
      //status should be always returned
      header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
    }

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
