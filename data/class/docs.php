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

    $text = (isset($data['txt'])) ? $data['txt'] : NULL;
    $title = (isset($data['title'])) ? $data['title'] : NULL;

    return '
    <form method="post" class="docs-element js-docs--element">
      <h2 class="docs-title">
        ' . $title . '
      </h2>
      <div class="docs-options">
        <button class="ui blue button js-docs--save">Save</button>
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
