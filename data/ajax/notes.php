<?php
/**
*
*/
class notesAjax extends notes {

  public function render() {

    $this->dbInstance = $this->getInstance();

    $message = 'Nie wykonano żadnej operacji.';

    if (isset($_POST['operation']) && $_POST['operation'] === 'getData') {

      $limit = $_POST['limit'];

      return $this->getData($limit);

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
