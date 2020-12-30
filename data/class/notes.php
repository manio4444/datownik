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

    $this->addParam('limit', $limit);

  }

  public function searchData() {

    if (
      !$this->getParam('txt')
      || empty($this->getParam('txt'))
    ) {
      return $this->error404('Nie można wyszukać notatek, brak tekstu');
    }

    $txt = '%' . $this->getParam('txt') . '%';
    $sqlReturn = $this->getDbInstance()->prepare('SELECT id, txt FROM `notes` WHERE `txt` LIKE :txt ORDER BY `txt` DESC');
    $sqlReturn->bindValue(':txt', $txt, PDO::PARAM_STR);
    $sqlReturn->execute();

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }

  public function getData() {

    $sqlLimit = (
      $this->getParam('limit')
      && is_numeric($this->getParam('limit'))
      && $this->getParam('limit') !== 0
      ) ? " LIMIT " . $this->getParam('limit') : "";

    $sqlReturn = $this->getInstance()->query('SELECT * FROM `notes` ORDER BY `id` DESC'.$sqlLimit);

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }

  public function addNote() {

    if (
      !$this->getParam('txt')
      || empty($this->getParam('txt'))
    ) {
      return $this->error404('Nie można utworzyć notatki, brak tekstu');
    }

    $sqlReturn = $this->getDbInstance()->prepare('INSERT INTO `notes` (`txt`) VALUES (:txt)');
    $sqlReturn->bindValue(':txt', $this->getParam('txt'), PDO::PARAM_STR);
    $sqlReturn->execute();
    $lastInsertId = $this->getDbInstance()->lastInsertId();
    $sqlReturn = $this->getInstance()->query('SELECT * FROM `notes` WHERE `id` = ' . $lastInsertId);
    $lastInsertElement = $sqlReturn->fetch(PDO::FETCH_ASSOC);

    return $lastInsertElement;

  }

  public function editNote() {

    if (
      !$this->getParam('id')
      || empty($this->getParam('id'))
      || !is_numeric($this->getParam('id'))
    ) {
      return $this->error404('Nie można edytować notatki, brak/niepoprawny ID');
    }

    if (
      !$this->getParam('txt')
      || empty($this->getParam('txt'))
    ) {
      return $this->error404('Nie można edytować notatki, brak tekstu');
    }

    $sqlReturn = $this->getDbInstance()->prepare( 'UPDATE `notes` SET `txt` = :txt WHERE `id` = :id' );
    $sqlReturn->bindValue(':id', $this->getParam('id'), PDO::PARAM_INT);
    $sqlReturn->bindValue(':txt', $this->getParam('txt'), PDO::PARAM_STR);
    $sqlReturn->execute();
    $sqlReturn = $this->getInstance()->query('SELECT * FROM `notes` WHERE `id` = ' . $this->getParam('id'));
    $lastInsertElement = $sqlReturn->fetch(PDO::FETCH_ASSOC);

    return $lastInsertElement;

  }

  public function deleteNote() {

    if (
      !$this->getParam('id')
      || empty($this->getParam('id'))
      || !is_numeric($this->getParam('id'))
    ) {
      return $this->error404('Nie można usunąć notatki, brak/niepoprawny ID');
    }

    $sqlReturn = $this->getDbInstance()->prepare('DELETE FROM `notes` WHERE `id` = :id');
    $sqlReturn->bindValue(':id', $this->getParam('id'), PDO::PARAM_INT);
    $sqlReturn->execute();

    return true;

  }


}

?>
