<?php
/**
*
*/
class docs extends defaultController {

  public $sqlReturn;

  public function __construct() {
    global $sql_pdo; //TODO try not to do like that, maybe extedns from pdo?
    $this->sqlReturn = $sql_pdo->query('SELECT * FROM `docs` ORDER BY `id` DESC'); //TODO make it to another function
  }

  public function getElement($id) {
    global $sql_pdo; //TODO try not to do like that, maybe extedns from pdo?
    $sql_pdo_object = $sql_pdo->query('SELECT * FROM `docs` WHERE `id` = '.$id.'');
    return $sql_pdo_object->fetch(PDO::FETCH_ASSOC);
  }

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
}

?>
