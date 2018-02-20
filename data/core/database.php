<?php

/**
* Database PDO class
*/
class database {

  private $dbInstance;

  function startPDO() {

    global $ini; //TODO - make configuration class
    global $error; //TODO - make errors class

    if (
      !isset($ini['db']['sql_host'])
      || !isset($ini['db']['sql_user'])
      || !isset($ini['db']['sql_password'])
      || !isset($ini['db']['sql_database'])
      || !isset($ini['db']['sql_encoding'])
    ) {

      System::error("Problem z załadowaniem konfiguracji do połączenia bazy danych");

      return false;
    }

    $sql_host = $ini['db']['sql_host'];
    $sql_user = $ini['db']['sql_user'];
    $sql_password = $ini['db']['sql_password'];
    $sql_database = $ini['db']['sql_database'];
    $sql_encoding = $ini['db']['sql_encoding'];

    try {

      $this->dbInstance = new PDO('mysql:host=' . $sql_host . ';dbname=' . $sql_database . ';encoding= ' . $sql_encoding . '', $sql_user, $sql_password);
      $this->dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->dbInstance -> query ('SET NAMES utf8');

    } catch(PDOException $e) {

      System::error('Połączenie z bazą danch nie mogło zostać utworzone: ' . $e->getMessage());

    }

  }

  public function getInstance() {

    if (!isset($this->dbInstance)) {
      $this->startPDO();
    }

    return $this->dbInstance;

  }

}

?>
