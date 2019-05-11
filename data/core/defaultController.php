<?php

/**
 * defaultController
 */
class defaultController extends database {

  public $dbInstance;
  protected $requestData = [];

  public function getViewTitle() {
    return DEFAULT_TITLE . get_class($this);
  }

  public function futureRender($requestData) {

    $this->dbInstance = $this->getInstance();
    $this->requestData = $requestData;

    if (!array_key_exists('operation', $requestData)) {
      return $this->error404('Nie wprowadzono operacji.');
    } else {
      $operation = $requestData['operation'];
    }
    if (!method_exists($this, $operation)) {
      return $this->error404('Podana operacja nie istnieje.');
    }

    try {
      $result = $this->{$operation}($requestData);
      return array(
        'status' => 200,
        'result' =>  $result,
      );
    } catch (Exception $e) {
      return array(
        'status' => 404,
        'message' =>  $e->getMessage(),
      );
    }

  }

  public function error404($message = '') {
    return array(
      'status' => 404,
      'message' => $message,
    );
  }

}

?>
