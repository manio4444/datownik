<?php
/**
*
*/
class tasks extends defaultController {

  public $sqlReturn;

  public function __construct() {
    if (null === $this->getInstance()) {
      System::error('Klasa "' . get_class() . '" Nie ma dostępu do połączenia SQL');
      return false;
    }
    $this->sqlReturn = $this->getInstance()->query('SELECT * FROM `tasks` ORDER BY `id` DESC'); //TODO make it to another function
  }

  public function getTemplate($data = array()) {
  }

}

?>
