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



    $this->sqlReturn = $this->getInstance()->query('SELECT * FROM `tasks` ORDER BY `id` DESC'); //TODO make it to another function
  }

  public function getTemplate($data = array()) {
  }

  private function saveTask($data) {
    // var_dump($data['no_deadline'] !== '1');
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
    $DocId = $this->dbInstance->lastInsertId();
    $message = "Utworzono nowy dokument";
    return array(
      'status' => 200,
      'message' => $message,
      'id' => $DocId,
      // 'text' => $_POST['text'],
      // 'query' => $_POST,
    );


  }

  public function getTasksWidget($limit = 10) {

    $query = $this->getInstance()->query('SELECT * FROM `tasks` WHERE `finished` = 0 ORDER BY `id` DESC LIMIT '.$limit.'');

    return $query;

  }

}

?>
