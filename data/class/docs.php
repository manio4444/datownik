<?php
/**
*
*/
class docs {

  public $sqlReturn;

  public function __construct() {
    global $sql_pdo; //TODO try not to do like that, maybe extedns from pdo?
    $this->sqlReturn = $sql_pdo->query('SELECT * FROM `docs` ORDER BY `id` DESC');
    $this->sqlReturn = $sql_pdo->query('SELECT * FROM `docs` ORDER BY `id` DESC');
  }

  public function getTemplate($data = array()) {

      $text = $data['text'];

    return '
    <textarea name="" id="" class="tinymce">' . $text . '</textarea>
    ';

  }
}

?>
