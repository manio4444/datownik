<?php
/**
*
*/
class systemInfo extends defaultController {

  public function getSystemInfo() {
    global $ini; //TODO - make configuration class

    $system_version = $ini['config']['system_version'];

    if (!$system_version) {
      return $this->error404('Nie można pobrać wersji systemu');
    }

    $systemInfo['system_version'] = $system_version;

    return $systemInfo;

  }

}

?>
