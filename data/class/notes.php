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
      <div class="note__urlify"
      >' . htmlspecialchars($text) . '</div>
      <div class="note_element__progress"></div>
    </div>
    ';

  }

  public function getData() {

    $sqlLimit = (
      array_key_exists('limit', $this->requestData)
      && is_numeric($this->requestData['limit'])
      && $this->requestData['limit'] !== 0
      ) ? " LIMIT " . $this->requestData['limit'] : "";

    $this->sqlReturn = $this->getInstance()->query('SELECT * FROM `notes` ORDER BY `id` DESC'.$sqlLimit); //TODO make it to another function

    return $this->sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }
}

?>
