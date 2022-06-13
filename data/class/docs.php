<?php
/**
*
*/
class docs extends defaultController {

  public function getTemplate($data = array()) {

    $id = (isset($data['id'])) ? $data['id'] : NULL;
    $text = (isset($data['txt'])) ? $data['txt'] : NULL;
    $title = (isset($data['title'])) ? $data['title'] : NULL;

    return '
    <form method="post" class="docs-element js-docs--element" data-docs="' . $id . '">
      <h2 class="docs-title">
      <i class="edit outline icon"></i>
      <input type="text" class="js-docs--title" value="' . $title . '" />
      </h2>
      <div class="docs-options">
        <button class="ui blue button js-docs--save">Zapisz</button>
        <button class="ui button js-docs--editname">Zmień nazwę</button>
        <button class="ui button">Fullscreen</button>
        <button class="ui button">Discard</button>
      </div>
      <div class="docs-textarea">
        <textarea name="" id="" class="tinymce js-docs--txt">' . $text . '</textarea>
      </div>
    </form>
    ';

  }

  public function getData() {

    $sqlLimit = (
      $this->existsParam('limit')
      && is_numeric($this->requestData['limit'])
      && $this->requestData['limit'] !== 0
      ) ? " LIMIT " . $this->requestData['limit'] : "";

      $sqlReturn = $this->getInstance()->query('SELECT * FROM `docs` ORDER BY `id` DESC'.$sqlLimit);

      return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getElement($id) {
      $sqlReturn = $this->getInstance()->query('SELECT * FROM `docs` WHERE `id` = '.$id.'');
      return $sqlReturn->fetch(PDO::FETCH_ASSOC);
    }

    public function addDoc() {

      if (
        !$this->existsParam('title')
        || empty($this->requestData['title'])
      ) {
        return $this->error404('Nie można utworzyć dokumentu, brak nazwy dokumentu');
      }

      if (
        !$this->existsParam('txt')
        || empty($this->requestData['txt'])
      ) {
        return $this->error404('Nie można utworzyć dokumentu, brak tekstu');
      }

      $sqlReturn = $this->getDbInstance()->prepare( 'INSERT INTO `docs` (`txt`, `title`) VALUES (:txt, :title)' );
      $sqlReturn->bindValue(':txt', $this->requestData['txt'], PDO::PARAM_STR);
      $sqlReturn->bindValue(':title', $this->requestData['title'], PDO::PARAM_STR);
      $sqlReturn->execute();
      $lastInsertId = $this->getDbInstance()->lastInsertId();
      $sqlReturn = $this->getInstance()->query('SELECT * FROM `docs` WHERE `id` = ' . $lastInsertId);
      $lastInsertElement = $sqlReturn->fetch(PDO::FETCH_ASSOC);

      return $lastInsertElement;

    }

    public function editDoc() {

      if (
        !$this->existsParam('id')
        || empty($this->requestData['id'])
        || !is_numeric($this->requestData['id'])
      ) {
        return $this->error404('Nie można edytować dokumentu, brak/niepoprawny ID');
      }

      if (
        !$this->existsParam('title')
        || empty($this->requestData['title'])
      ) {
        return $this->error404('Nie można edytować, brak nazwy dokumentu');
      }

      if (
        !$this->existsParam('txt')
        || empty($this->requestData['txt'])
      ) {
        return $this->error404('Nie można edytować dokumentu, brak tekstu');
      }

      $sqlReturn = $this->getDbInstance()->prepare( 'UPDATE `docs` SET `txt` = :txt, `title` = :title WHERE `id` = :id' );
      $sqlReturn->bindValue(':id', $this->requestData['id'], PDO::PARAM_INT);
      $sqlReturn->bindValue(':txt', $this->requestData['txt'], PDO::PARAM_STR);
      $sqlReturn->bindValue(':title', $this->requestData['title'], PDO::PARAM_STR);
      $sqlReturn->execute();
      $message = "Edytowano poprawnie";
      return array(
        'message' => "Edytowano poprawnie",
        'id' => $this->requestData['id'],
        'title' => $this->requestData['title'],
      );

    }

}

?>
