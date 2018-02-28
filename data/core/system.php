<?php

/**
 * System Interface controller
 */
class System {

  public function error($value) {
    // global $error;
    // $error[] = $value;
    echo "<pre class='error'>! Error - $value</pre>";
  }

}

?>
