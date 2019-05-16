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

  public function addNote() {

    if (
      !array_key_exists('txt', $this->requestData)
      || empty($this->requestData['txt'])
    ) {
      return $this->error404('Nie można utworzyć notatki, brak tekstu');
    }

    $sqlReturn = $this->getDbInstance()->prepare('INSERT INTO `notes` (`txt`) VALUES (:txt)');
    $sqlReturn->bindValue(':txt', $this->requestData['txt'], PDO::PARAM_STR);
    $sqlReturn->execute();
    $lastInsertId = $this->getDbInstance()->lastInsertId();
    $sqlReturn = $this->getInstance()->query('SELECT * FROM `notes` WHERE `id` = ' . $lastInsertId);
    $lastInsertElement = $sqlReturn->fetch(PDO::FETCH_ASSOC);

    return $lastInsertElement;

  }

  public function editNote() {

    if (
      !array_key_exists('id', $this->requestData)
      || empty($this->requestData['id'])
      || !is_numeric($this->requestData['id'])
    ) {
      return $this->error404('Nie można edytować notatki, brak/niepoprawny ID');
    }

    if (
      !array_key_exists('txt', $this->requestData)
      || empty($this->requestData['txt'])
    ) {
      return $this->error404('Nie można edytować notatki, brak tekstu');
    }

    $sqlReturn = $this->getDbInstance()->prepare( 'UPDATE `notes` SET `txt` = :txt WHERE `id` = :id' );
    $sqlReturn->bindValue(':id', $this->requestData['id'], PDO::PARAM_INT);
    $sqlReturn->bindValue(':txt', $this->requestData['txt'], PDO::PARAM_STR);
    $sqlReturn->execute();
    $sqlReturn = $this->getInstance()->query('SELECT * FROM `notes` WHERE `id` = ' . $this->requestData['id']);
    $lastInsertElement = $sqlReturn->fetch(PDO::FETCH_ASSOC);

    return $lastInsertElement;

  }

}

?>
