<?php
/**
*
*/
class notes extends defaultController {

  public $sqlReturn;

  public function __construct() {
    global $sql_pdo; //TODO try not to do like that, maybe extedns from pdo?
    $this->sqlReturn = $sql_pdo->query('SELECT * FROM `notes` ORDER BY `id` DESC'); //TODO make it to another function
  }

  public function getTemplate($data = array()) {

    $id = (isset($data['id'])) ? $data['id'] : NULL;
    $text = (isset($data['txt'])) ? $data['txt'] : NULL;

    return '
    <div class="note_element">
      <textarea
        placeholder="Zacznij wpisywać tekst aby dodać nową notatkę"
        data-placeholder="Kliknięcie poza notatką spowoduje usunięcie"
        data-note="' . $id . '"
      >' . $text . '</textarea>
    </div>
    ';

  }
}

?>
