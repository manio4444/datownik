<?php
/**
*
*/
class multisearch extends defaultController {

  public function getData() {

    $notes = new notes;
    $notes->addParam('txt', $this->requestData['txt']);
    $result['notes'] = $notes->searchData();
    $result['notes123'] = $notes->searchData();

    // $tasks = new tasks;
    // $tasksController->addParam('txt', this->requestData['txt']);
    // $result['tasks'] = $tasks->searchData();

    // $docs = new docs;
    // $docsController->addParam('txt', this->requestData['txt']);
    // $result['docs'] = $docs->searchData();

    return $result;

  }

}

?>
