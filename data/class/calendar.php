<?php
/**
*
*/
class calendar extends defaultController {

  public $sqlReturn;

  public function __construct() {
    $this->dbInstance = $this->getInstance();

    if (null === $this->dbInstance) {
      System::error('Klasa "' . get_class() . '" Nie ma dostępu do połączenia SQL');
      return false;
    }
  }

  public function getFutureEvents() {
    $limit = $this->getParam('limit');

    if (!$limit) {
      return $this->error404('Brak podanej wartości limit');
    }
    if (!is_numeric($limit)) {
      return $this->error404('Wartości limit musi być liczbą całkowitą');
    }

    $sqlReturn = $this->dbInstance->query('SELECT * FROM `calendar_static` WHERE `data` > CURRENT_TIMESTAMP ORDER BY `calendar_static`.`data` ASC LIMIT '.$limit.'');

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }

  protected function saveEvent() {
    if (
      !$this->existsParam('txt')
      || !$this->existsParam('data')
    ) {
      return $this->error404('Nie wprowadzono wymaganych danych');
    }
    if (empty($this->requestData['txt'])) {
      return $this->error404('Pole tekst nie może być puste');
    }
    if (empty($this->requestData['data'])) {
      return $this->error404('Pole data nie może być puste');
    }

    $sqlObj = $this->dbInstance->prepare( 'INSERT INTO `calendar_static` (`txt`, `data`) VALUES (:txt, :data)');
    $sqlObj->bindValue(':txt', $this->requestData['txt'], PDO::PARAM_STR);
    $sqlObj->bindValue(':data', $this->requestData['data'], PDO::PARAM_STR);
    $sqlObj->execute();
    $EventId = $this->dbInstance->lastInsertId();
    $sqlReturn = $this->getInstance()->query('SELECT * FROM `calendar_static` WHERE `id` = ' . $EventId);
    $lastInsertElement = $sqlReturn->fetch(PDO::FETCH_ASSOC);

    return array(
      'message' => 'Utworzono nowe wydarzenie',
      'newElement' => $lastInsertElement,
    );

  }
}

?>
