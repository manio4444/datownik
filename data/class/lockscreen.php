<?php
/**
*
*/
class lockscreen {

  public $sqlReturn;
  private $pinCode;

  public function __construct() {
    global $sql_pdo; //TODO try not to do like that, maybe extedns from pdo?
    global $ini;
    $this->pinCode = $ini['lockscreen']['pincode'];
  }

  public function ajax_try_pin_code($lockscreen_code) {
    if ($this->try_pin_code($lockscreen_code) === true) {
      return 'valid';
    } else {
      return 'invalid';
    }
  }

  public function try_pin_code($lockscreen_code) {
    if ($lockscreen_code == $this->pinCode) {
      return true;
    } else {
      return false;
    }
  }




}

?>
