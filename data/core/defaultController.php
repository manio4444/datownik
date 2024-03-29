<?php

/**
 * defaultController
 */
class defaultController extends database {

  private $dbInstance;
  protected $requestData = [];

  public function getViewTitle() {
    return DEFAULT_TITLE . get_class($this);
  }

  protected function getDbInstance() {
    //TODO: in future remote extending database class
    $db = new database;
    if (!isset($this->dbInstance)) {
      $db->startPDO();
      $this->dbInstance = $db->getInstance();
    }

    return $this->dbInstance;
  }

  public function render($requestData) {

    $this->requestData = $requestData;

    try {

      if (!array_key_exists('operation', $requestData)) {
        return $this->error404('Nie wprowadzono operacji.');
      } else {
        $operation = $requestData['operation'];
      }
      if (!method_exists($this, $operation)) {
        return $this->error404('Podana operacja nie istnieje.');
      }

      $result = $this->{$operation}($requestData);
      return array(
        'status' => 200,
        'result' =>  $result,
        'request' => $this->requestData,
      );
    } catch (Exception $e) {
      return array(
        'status' => 404,
        'message' =>  $e->getMessage(),
        'request' => $this->requestData,
      );
    }

  }

  public function error404($message = '') {
    throw new Exception($message);
  }

  public function addParam($name, $value) {
    $this->requestData[$name] = $value;
  }

  public function existsParam($name) {
    return array_key_exists($name, $this->requestData);
  }

  public function getParam($name) {
    return $this->existsParam($name)
    ? $this->requestData[$name]
    : false;
  }

}

?>
