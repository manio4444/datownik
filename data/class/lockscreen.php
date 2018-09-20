<?php
/**
*
*/
class lockscreen {

  public $sqlReturn;
  private $pinCode;
  private $logFile;

  public function __construct() {
    global $sql_pdo; //TODO try not to do like that, maybe extedns from pdo?
    global $ini;
    $this->pinCode = $ini['lockscreen']['pincode'];
    $this->logFile = FOLDER_LOGS . '/' . 'log_lockscreen_access';
  }

  public function ajax_try_pin_code($lockscreen_code) {
    if ($this->try_pin_code($lockscreen_code) === true) {
      return 'valid';
    } else {
      return 'invalid';
    }
  }

  public function try_pin_code($lockscreen_code) {
    $log_entry = date("Y-m-d H:i:s") . ' ' . $lockscreen_code . ' ' . $_SERVER['REMOTE_ADDR'] . ' ' . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL;
    file_put_contents($this->logFile, $log_entry, FILE_APPEND);
    if ($lockscreen_code == $this->pinCode) {
      return true;
    } else {
      return false;
    }
  }




}

?>
