<?php

/**
 * defaultController
 */
class defaultController extends database {

  public function getViewTitle() {
    return DEFAULT_TITLE . get_class($this);
  }

}

?>
