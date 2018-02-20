<?php
/**
*
*/
class notes extends defaultController {

  public $sqlReturn;

  public function __construct() {
    if (null === $this->getInstance()) {
      System::error('Klasa "' . get_class() . '" Nie ma dostępu do połączenia SQL');
      return false;
    }
    $this->sqlReturn = $this->getInstance()->query('SELECT * FROM `notes` ORDER BY `id` DESC'); //TODO make it to another function
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
