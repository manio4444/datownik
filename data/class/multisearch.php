<?php
/**
*
*/
class multisearch extends defaultController {

  public function getData() {

    if (
      !array_key_exists('txt', $this->requestData)
      || empty($this->requestData['txt'])
    ) {
      return $this->error404('Nie można wyszukać, brak tekstu');
    }

    $txt = '%' . $this->requestData['txt'] . '%';
    $sqlReturn = $this->getDbInstance()->prepare('SELECT id, txt FROM `notes` WHERE `txt` LIKE :txt ORDER BY `txt` DESC');
    $sqlReturn->bindValue(':txt', $txt, PDO::PARAM_STR);
    $sqlReturn->execute();

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }

}

?>
