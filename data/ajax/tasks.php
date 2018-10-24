<?php
/**
*
*/
class tasksAjax extends tasks {

  public function render() {

    $this->dbInstance = $this->getInstance();

    $message = 'Nie wykonano żadnej operacji.';

    if (isset($_POST['operation']) && $_POST['operation'] === 'doneTask') {

      return $this->doneTask($_POST['id']);

    } else {

      $message = 'Nie wprowadzono lub brak operacji.';
      return array(
        'status' => 404,
        'message' => $message,
      );

    }

  }



}

?>
