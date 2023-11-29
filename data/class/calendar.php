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

    $sqlReturn = $this->dbInstance->prepare('SELECT id, data AS date, txt, "static" AS type
    FROM `calendar_static`
    WHERE data > CURRENT_TIMESTAMP
    UNION ALL
    SELECT id, data AS date, txt, "dayoff" AS type
    FROM `calendar_dayoff`
    WHERE data > CURRENT_TIMESTAMP
    UNION ALL
    SELECT id, data AS date, txt, "birthdays" AS type
    FROM `calendar_birthdays`
    WHERE MONTH(data) >= MONTH(CURRENT_TIMESTAMP)
    AND DAY(data) >= MONTH(CURRENT_TIMESTAMP)
    OR MONTH(data) = MONTH(CURRENT_TIMESTAMP) + 1
    ORDER BY date ASC
    LIMIT :limit
    ');
    $sqlReturn->bindValue(':limit', $limit, PDO::PARAM_INT);
    $sqlReturn->execute();

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }

  public function getMonthEvents() {
    $month = $this->getParam('month');
    $year = $this->getParam('year');

    if (!$month) {
      return $this->error404('Brak podanej wartości month');
    }
    if (!$year) {
      return $this->error404('Brak podanej wartości year');
    }
    if (!is_numeric($month)) {
      return $this->error404('Wartości month musi być liczbą całkowitą');
    }
    if (!is_numeric($year)) {
      return $this->error404('Wartości year musi być liczbą całkowitą');
    }

    $sqlReturn = $this->dbInstance->prepare('SELECT id, data AS date, DAY(data) AS day, txt, "static" AS type
    FROM `calendar_static`
    WHERE MONTH(data) = :month
    AND YEAR(data) = :year
    UNION ALL
    SELECT id, data AS date, DAY(data) AS day, txt, "dayoff" AS type
    FROM `calendar_dayoff`
    WHERE MONTH(data) = :month
    AND YEAR(data) = :year
    UNION ALL
    SELECT id, data AS date, DAY(data) AS day, txt, "birthdays" AS type
    FROM `calendar_birthdays`
    WHERE MONTH(data) = :month
    ORDER BY date ASC');
    $sqlReturn->bindValue(':month', $month, PDO::PARAM_INT);
    $sqlReturn->bindValue(':year', $year, PDO::PARAM_INT);
    $sqlReturn->execute();

    return $sqlReturn->fetchAll(PDO::FETCH_ASSOC);

  }

  public function getBirthdaysAll() {
    $sqlReturn = $this->dbInstance->prepare('SELECT id, data AS date, txt FROM `calendar_birthdays`');
    $sqlReturn->execute();

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

  protected function saveBirthday() {
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

    $sqlObj = $this->dbInstance->prepare( 'INSERT INTO `calendar_birthdays` (`txt`, `data`) VALUES (:txt, :data)');
    $sqlObj->bindValue(':txt', $this->requestData['txt'], PDO::PARAM_STR);
    $sqlObj->bindValue(':data', $this->requestData['data'], PDO::PARAM_STR);
    $sqlObj->execute();
    $BirthdayId = $this->dbInstance->lastInsertId();
    $sqlReturn = $this->getInstance()->query('SELECT * FROM `calendar_birthdays` WHERE `id` = ' . $BirthdayId);
    $lastInsertElement = $sqlReturn->fetch(PDO::FETCH_ASSOC);

    return array(
      'message' => 'Utworzono nowe wydarzenie cykliczne',
      'newElement' => $lastInsertElement,
    );

  }
}

?>
