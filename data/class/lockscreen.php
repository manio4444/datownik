<?php
/**
*
*/
class lockscreen extends defaultController {

  public $sqlReturn;
  private $pinCode;
  private $logFile;
  private $authenticationSalt = 'z28GmJA6bzh2rAm5';
  private $authenticatedId;

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
        'token' => $this->newSession(),
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

  protected function newSession() {
    $expireDate = strtotime( '+1 days' );
    $sqlReturn = $this->getDbInstance()->prepare('INSERT INTO `authentication` (`exp`) VALUES (:exp)');
    $sqlReturn->bindValue(':exp', $expireDate, PDO::PARAM_STR);
    $sqlReturn->execute();
    $this->authenticatedId = $this->getDbInstance()->lastInsertId();

    return base64_encode($this->authenticatedId) . $this->authenticationSalt;
  }

  public function checkAuth() {
    $sessionId = $this->parseSessionId($this->requestData['token']);
    if (
      !$this->existsParam('token')
      || empty($this->requestData['token'])
      || !is_numeric($sessionId)
    ) {
      return $this->error404('Nieprawidłowy token sesji');
    }

    $sqlReturn = $this->getInstance()->query('SELECT * FROM `authentication` WHERE `id` = '.$sessionId.'');
    return $sqlReturn->fetch(PDO::FETCH_ASSOC);
  }

  protected function parseSessionId($sessionIdToken) {
    return base64_decode(str_replace($this->authenticationSalt, '', $sessionIdToken));
  }

}

?>
