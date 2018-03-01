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

      if (isset($_POST['id']) && isset($_POST['text']) && !empty($_POST['id'])) {
        $sqlObj = $this->dbInstance->prepare( 'UPDATE `docs` SET `txt` = :txt WHERE `id` = :id' );
        $sqlObj->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $sqlObj->bindValue(':txt', $_POST['text'], PDO::PARAM_STR);
        $sqlObj->execute();
        $message = "Edytowano poprawnie";
      }

    }

    return array(
      'status' => 200,
      'message' => $message,
      // 'query' => $_POST,
    );
  }

}

?>
