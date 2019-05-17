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
      $return = $this->saveTask($_POST);

      if (ajaxRouter::detectAjax() === true) {
        ajaxRouter::endAjaxOutput();
        ajaxRouter::endAjaxOutput($return);
      } else {
        System::headerBack();
      }

    }



    $this->sqlReturn = $this->getInstance()->query('SELECT * FROM `tasks` WHERE `finished` = 0 ORDER BY `id` DESC'); //TODO make it to another function
  }

  private function saveTask($data) {
    if (
      !isset($data['task_id'])
      || !isset($data['txt'])
      || !isset($data['deadline'])
      || !isset($data['no_deadline'])
      || empty($data['txt'])
      || (empty($data['deadline']) && $data['no_deadline'] !== '1')
    ) {
      System::error('Błąd, złe dane');
      return;
    }
    $sqlObj = $this->dbInstance->prepare( 'INSERT INTO `tasks` (`txt`, `no_deadline`, `deadline`) VALUES (:txt, :no_deadline, :deadline)' );
    $sqlObj->bindValue(':txt', $data['txt'], PDO::PARAM_STR);
    $sqlObj->bindValue(':no_deadline', $data['no_deadline'], PDO::PARAM_STR);
    $sqlObj->bindValue(':deadline', $data['deadline'], PDO::PARAM_STR);
    $sqlObj->execute();
    $TaskId = $this->dbInstance->lastInsertId();
    $message = "Utworzono nowy dokument";
    return array(
      'status' => 200,
      'message' => $message,
      'id' => $TaskId,
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

  public function getTasksWidget($limit = 10) {

    $query = $this->getInstance()->query('SELECT * FROM `tasks` WHERE `finished` = 0 ORDER BY `id` DESC LIMIT '.$limit.'');

    return $query;

  }

}

?>
