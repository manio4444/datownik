<?php

/**
* Class for handling ajax queries & data fetch endpoint
*/

class ajaxRouter extends database {

  private $requestData;
  private $requestType;
  private $apiV2Compatible = false;

  public static function detectAjax() {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest') {
      return true;
    } else {
      return false;
    }
  }

  public static function detectJson() {
    if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
      return false;
    }
    if (strpos($_SERVER["CONTENT_TYPE"], 'application/json') === false) {
      return false;
    }
    if (System::isJson(file_get_contents("php://input")) === false) {
      return false;
    }
    return true;
  }

  public static function detectOptions() {
    //used by axios on React
    return (strcasecmp($_SERVER['REQUEST_METHOD'], 'OPTIONS') === 0);
  }

  public function requestType() {
    if (static::detectAjax() === true) {
      return 'ajax';
    }
    if (static::detectJson() === true) {
      return 'json';
    }
    if (static::detectOptions() === true) {
      return 'options';
    }
    return false;
  }

  public function tryAjax() {
    $this->requestType = $this->requestType();

    if ($this->requestType === false) {
      return null;
    }

    if ($this->requestType === 'ajax') {
      $this->requestData = $_POST;
    }
    if ($this->requestType === 'json') {
      $this->requestData = json_decode(file_get_contents("php://input"), true);
    }
    if ($this->requestType === 'options') {
      static::startAjaxOutput();
      $this->endAjaxOutput(array('status' => 200, 'message' => 'OPTIONS request'));
    }

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
      $data = $this->doAjax($existsAjaxController);
      $this->endAjaxOutput($data);
    }

    // $this->endAjaxOutput($data);
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

  private function doAjax($ajaxControllerName) {
    try {
      $controller = new $ajaxControllerName;
    } catch (Exception $e) {
      return array(
        'status' => 404,
        // 'message' => 'Nie można załadować klasy: ' . $ajaxControllerName,
        'message' =>  $e->getMessage(),
      );
    }
    if ($controller->apiV2Compatible === true) {
      $this->apiV2Compatible = true;
      return $controller->futureRender($this->requestData);
    }
    return $controller->render();
  }

  public static function startAjaxOutput() {
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

    if ($data['status'] === 404) {
      //status should be always returned
      header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
    }

    if ($this->apiV2Compatible === true) {
      echo json_encode($data);
      die();
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
