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

      try {
        $return = $this->saveTask();
        System::headerBack();
      } catch (Exception $e) {
        System::error($e->getMessage());
      }
    }

  }

  public function getData() {

    $sqlLimit = (
      $this->getParam('limit')
      && is_numeric($this->getParam('limit'))
      && $this->getParam('limit') !== 0
      ) ? " LIMIT " . $this->getParam('limit') : "";

    $sqlFinished = $this->getParam('getFinishedOnly')
    ? ' WHERE `finished` = 1'
    : $this->getParam('getFinished')
      ? ''
      : ' WHERE `finished` = 0';

    $sqlReturn = $this->getInstance()->query('SELECT * FROM `tasks`'. $sqlFinished .' ORDER BY `id` DESC'.$sqlLimit);

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }

  protected function saveTask() {
    if (
      !$this->getParam('txt')
      || !$this->getParam('deadline')
      || !$this->getParam('no_deadline')
    ) {
      return $this->error404('Nie wprowadzono wymaganych danych');
    }
    if (empty($this->requestData['txt'])) {
      return $this->error404('Pole tekst nie może być puste');
    }
    if (
      empty($this->requestData['deadline'])
      && $this->requestData['no_deadline'] !== '1'
    ) {
      return $this->error404('Pole deadline nie może być puste');
    }

    $sqlObj = $this->dbInstance->prepare( 'INSERT INTO `tasks` (`txt`, `no_deadline`, `deadline`) VALUES (:txt, :no_deadline, :deadline)' );
    $sqlObj->bindValue(':txt', $this->requestData['txt'], PDO::PARAM_STR);
    $sqlObj->bindValue(':no_deadline', $this->requestData['no_deadline'], PDO::PARAM_INT);
    $sqlObj->bindValue(':deadline', $this->requestData['deadline'], PDO::PARAM_STR);
    $sqlObj->execute();
    $TaskId = $this->dbInstance->lastInsertId();
    $sqlReturn = $this->getInstance()->query('SELECT * FROM `tasks` WHERE `id` = ' . $TaskId);
    $lastInsertElement = $sqlReturn->fetch(PDO::FETCH_ASSOC);

    return array(
      'message' => 'Utworzono nowe zadanie',
      'newElement' => $lastInsertElement,
    );

  }

  protected function doneTask() {

    if (
      !$this->getParam('id')
      || empty($this->getParam('id'))
      || !is_numeric($this->getParam('id'))
    ) {
      return $this->error404('Nie podano ID.');
    }

    $sqlObj = $this->getDbInstance()->prepare( 'UPDATE `tasks` SET `finished` = 1 WHERE `id` = :id' );
    $sqlObj->bindValue(':id', $this->getParam('id'), PDO::PARAM_INT);
    $sqlObj->execute();
    return array(
      'message' => "Status ustawiony na: zakończone",
      'id' => $this->getParam('id'),
    );

  }

  protected function unDoneTask() {

    if (
      !$this->getParam('id')
      || empty($this->getParam('id'))
      || !is_numeric($this->getParam('id'))
    ) {
      return $this->error404('Nie podano ID.');
    }

    $sqlObj = $this->getDbInstance()->prepare( 'UPDATE `tasks` SET `finished` = 0 WHERE `id` = :id' );
    $sqlObj->bindValue(':id', $this->getParam('id'), PDO::PARAM_INT);
    $sqlObj->execute();
    return array(
      'message' => "Status ustawiony na: NIEukończone",
      'id' => $this->getParam('id'),
    );

  }

  protected function deleteTask() {

    if (
      !$this->getParam('id')
      || empty($this->getParam('id'))
      || !is_numeric($this->getParam('id'))
    ) {
      return $this->error404('Nie podano ID.');
    }

    $sqlObj = $this->getDbInstance()->prepare( 'UPDATE `tasks` SET `deleted` = 1 WHERE `id` = :id' );
    $sqlObj->bindValue(':id', $this->getParam('id'), PDO::PARAM_INT);
    $sqlObj->execute();
    return array(
      'message' => "Status ustawiony na: usunięte",
      'id' => $this->getParam('id'),
    );

  }

  protected function unDeleteTask() {

    if (
      !$this->getParam('id')
      || empty($this->getParam('id'))
      || !is_numeric($this->getParam('id'))
    ) {
      return $this->error404('Nie podano ID.');
    }

    $sqlObj = $this->getDbInstance()->prepare( 'UPDATE `tasks` SET `deleted` = 0 WHERE `id` = :id' );
    $sqlObj->bindValue(':id', $this->getParam('id'), PDO::PARAM_INT);
    $sqlObj->execute();
    return array(
      'message' => "Status ustawiony na: NIEusunięte",
      'id' => $this->getParam('id'),
    );

  }

}

?>
