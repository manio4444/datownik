<?php
/**
*
*/
class tasks extends defaultController {

  public $sqlReturn;

  public function __construct() {

    $this->dbInstance = $this->getInstance();
    if (null === $this->dbInstance) {
      System::error('Klasa "' . get_class() . '" Nie ma dostępu do połączenia SQL');
      return false;
    }
    if (
      isset($_POST['task_id']) &&
      isset($_POST['txt']) &&
      isset($_POST['deadline']) &&
      isset($_POST['no_deadline'])
    ) {
      $this->addParam('txt', $_POST['txt']);
      $this->addParam('deadline', $_POST['deadline']);
      $this->addParam('no_deadline', $_POST['no_deadline']);

      $return = $this->saveTask();
      System::headerBack();
    }

  }

  public function getData() {

    $sqlLimit = (
      array_key_exists('limit', $this->requestData)
      && is_numeric($this->requestData['limit'])
      && $this->requestData['limit'] !== 0
      ) ? " LIMIT " . $this->requestData['limit'] : "";

    $sqlFinished = (
      array_key_exists('getFinished', $this->requestData)
      && $this->requestData['getFinished'] === true
      ) ? $sqlFinished = '' : ' WHERE `finished` = 0';

    $sqlFinished = (
      array_key_exists('getFinishedOnly', $this->requestData)
      && $this->requestData['getFinishedOnly'] === true
      ) ? ' WHERE `finished` = 1' : $sqlFinished;

    $sqlReturn = $this->getInstance()->query('SELECT * FROM `tasks`'. $sqlFinished .' ORDER BY `id` DESC'.$sqlLimit);

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }

  protected function saveTask() {
    if (
      !array_key_exists('txt', $this->requestData)
      || !array_key_exists('deadline', $this->requestData)
      || !array_key_exists('no_deadline', $this->requestData)
      || empty($this->requestData['txt'])
      || (empty($this->requestData['deadline']) && $this->requestData['no_deadline'] !== '1')
    ) {
      System::error('Błąd, złe dane');
      return;
    }
    $sqlObj = $this->dbInstance->prepare( 'INSERT INTO `tasks` (`txt`, `no_deadline`, `deadline`) VALUES (:txt, :no_deadline, :deadline)' );
    $sqlObj->bindValue(':txt', $this->requestData['txt'], PDO::PARAM_STR);
    $sqlObj->bindValue(':no_deadline', $this->requestData['no_deadline'], PDO::PARAM_STR);
    $sqlObj->bindValue(':deadline', $this->requestData['deadline'], PDO::PARAM_STR);
    $sqlObj->execute();
    $TaskId = $this->dbInstance->lastInsertId();
    $sqlReturn = $this->getInstance()->query('SELECT * FROM `tasks` WHERE `id` = ' . $TaskId);
    $lastInsertElement = $sqlReturn->fetch(PDO::FETCH_ASSOC);

    return array(
      'message' => 'Utworzono nowy dokument',
      'id' => $lastInsertElement,
    );

  }

  protected function doneTask() {

    if (
      !array_key_exists('id', $this->requestData)
      || empty($this->requestData['id'])
      || !is_numeric($this->requestData['id'])
    ) {
      return $this->error404('Nie podano ID.');
    }

    $sqlObj = $this->getDbInstance()->prepare( 'UPDATE `tasks` SET `finished` = 1 WHERE `id` = :id' );
    $sqlObj->bindValue(':id', $this->requestData['id'], PDO::PARAM_INT);
    $sqlObj->execute();
    return array(
      'message' => "Status ustawiony na: zakończone",
      'id' => $this->requestData['id'],
    );

  }

  protected function unDoneTask() {

    if (
      !array_key_exists('id', $this->requestData)
      || empty($this->requestData['id'])
      || !is_numeric($this->requestData['id'])
    ) {
      return $this->error404('Nie podano ID.');
    }

    $sqlObj = $this->getDbInstance()->prepare( 'UPDATE `tasks` SET `finished` = 0 WHERE `id` = :id' );
    $sqlObj->bindValue(':id', $this->requestData['id'], PDO::PARAM_INT);
    $sqlObj->execute();
    return array(
      'message' => "Status ustawiony na: NIEukończone",
      'id' => $this->requestData['id'],
    );

  }

}

?>
