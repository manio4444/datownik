<?php
/**
*
*/
// class docsAjax extends docs {
class docsAjax extends defaultController {

  private $dbInstance;

  public function render() {

    // var_dump($this->getInstance()); die();

    $this->dbInstance = $this->getInstance();

    $message = 'Nie wykonano żadnej operacji.';

    if (isset($_POST['operation']) && $_POST['operation'] === 'editText') {

      return $this->editText($_POST['id'], $_POST['text']);

    } elseif (isset($_POST['operation']) && $_POST['operation'] === 'newDoc') {

      return $this->newDoc($_POST['text']);

    } else {

      $message = 'Nie wprowadzono lub brak operacji.';
      return array(
        'status' => 404,
        'message' => $message,
      );

    }

  }

  private function editText($DocId, $DocText) {

    if (isset($DocId) && isset($DocText) && !empty($DocId)) {
      $sqlObj = $this->dbInstance->prepare( 'UPDATE `docs` SET `txt` = :txt WHERE `id` = :id' );
      $sqlObj->bindValue(':id', $DocId, PDO::PARAM_INT);
      $sqlObj->bindValue(':txt', $DocText, PDO::PARAM_STR);
      $sqlObj->execute();
      $message = "Edytowano poprawnie";
      return array(
        'status' => 200,
        'message' => $message,
        'id' => $DocId,
        // 'text' => $_POST['text'],
        // 'query' => $_POST,
      );
    }

  }

  private function newDoc($DocText) {

    if (isset($DocText)) {
      $sqlObj = $this->dbInstance->prepare( 'INSERT INTO `docs` (`txt`) VALUES (:txt)' );
      $sqlObj->bindValue(':txt', $DocText, PDO::PARAM_STR);
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

  }



}

?>
