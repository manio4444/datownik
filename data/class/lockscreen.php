<?php
/**
*
*/
class lockscreen extends defaultController {

  public $sqlReturn;
  private $pinCode;
  private $logFile;

  public function __construct() {
    global $ini;
    $this->pinCode = $ini['lockscreen']['pincode'];
    $this->logFile = FOLDER_LOGS . '/' . 'log_lockscreen_access';
  }

  public function tryPasscode() {
    if (
      !$this->existsParam('code')
      || empty($this->requestData['code'])
      || !is_numeric($this->requestData['code'])
    ) {
      return $this->error404('Nie podano Passcode.');
    }

    if ($this->isPasscodeValid($this->requestData['code'])) {
      setcookie( 'datownik_' . md5('_admin'), md5('datownik_access'), strtotime( '+1 days' ) ); //TODO - refactor
      return array(
        'message' => 'Passcode poprawny',
        'isValid' => true,
      );
    } else {
      return array(
        'message' => 'Passcode błędny',
        'isValid' => false,
      );
    }
  }

  protected function isPasscodeValid($code) {
    $log_entry = date("Y-m-d H:i:s") . ' ' . $code . ' ' . $_SERVER['REMOTE_ADDR'] . ' ' . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL;
    file_put_contents($this->logFile, $log_entry, FILE_APPEND);
    return ($code === $this->pinCode);
  }




}

?>
