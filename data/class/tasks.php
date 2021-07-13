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
      $this->existsParam('limit')
      && is_numeric($this->requestData['limit'])
      && $this->requestData['limit'] !== 0
      ) ? " LIMIT " . $this->requestData['limit'] : "";

    $sqlWhere = 'WHERE `deleted` = 0';

    $sqlFinished = $this->getParam('getFinishedOnly')
    ? ' AND `finished` = 1'
    : $this->getParam('getFinished')
      ? ''
      : ' AND `finished` = 0';

    $sqlWhere .= $sqlFinished;

    $sqlReturn = $this->getInstance()->query('SELECT * FROM `tasks`'. $sqlWhere .' ORDER BY `id` DESC'.$sqlLimit);

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }

  protected function saveTask() {
    if (
      !$this->existsParam('txt')
      || !$this->existsParam('deadline')
      || !$this->existsParam('no_deadline')
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
      !$this->existsParam('id')
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
      !$this->existsParam('id')
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

  protected function deleteTask() {

    if (
      !$this->existsParam('id')
      || empty($this->requestData['id'])
      || !is_numeric($this->requestData['id'])
    ) {
      return $this->error404('Nie podano ID.');
    }

    $sqlObj = $this->getDbInstance()->prepare( 'UPDATE `tasks` SET `deleted` = 1 WHERE `id` = :id' );
    $sqlObj->bindValue(':id', $this->requestData['id'], PDO::PARAM_INT);
    $sqlObj->execute();
    return array(
      'message' => "Status ustawiony na: usunięte",
      'id' => $this->requestData['id'],
    );

  }

  protected function unDeleteTask() {

    if (
      !$this->existsParam('id')
      || empty($this->requestData['id'])
      || !is_numeric($this->requestData['id'])
    ) {
      return $this->error404('Nie podano ID.');
    }

    $sqlObj = $this->getDbInstance()->prepare( 'UPDATE `tasks` SET `deleted` = 0 WHERE `id` = :id' );
    $sqlObj->bindValue(':id', $this->requestData['id'], PDO::PARAM_INT);
    $sqlObj->execute();
    return array(
      'message' => "Status ustawiony na: NIEusunięte",
      'id' => $this->requestData['id'],
    );

  }

}

?>
