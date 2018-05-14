<?php
/**
*
*/
class calendar extends defaultController {

  public $sqlReturn;

  public function __construct() {
    if (null === $this->getInstance()) {
      System::error('Klasa "' . get_class() . '" Nie ma dostępu do połączenia SQL');
      return false;
    }
  }

  public function getFutureEvents($limit = 10) {

    $query = $this->getInstance()->query('SELECT * FROM `calendar_static` WHERE `data` > CURRENT_TIMESTAMP ORDER BY `calendar_static`.`data` ASC LIMIT '.$limit.'');

    return $query;

  }
}

?>
