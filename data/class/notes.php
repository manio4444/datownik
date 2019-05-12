<?php
/**
*
*/
class notes extends defaultController {

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

  public function setLimit($limit) {

    if (!is_numeric($limit)) {
      return false;
    }

    $this->requestData['limit'] = $limit;

  }

  public function getData() {

    $sqlLimit = (
      array_key_exists('limit', $this->requestData)
      && is_numeric($this->requestData['limit'])
      && $this->requestData['limit'] !== 0
      ) ? " LIMIT " . $this->requestData['limit'] : "";

    $sqlReturn = $this->getInstance()->query('SELECT * FROM `notes` ORDER BY `id` DESC'.$sqlLimit); //TODO make it to another function

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }
}

?>
