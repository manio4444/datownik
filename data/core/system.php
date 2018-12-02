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

  public function headerBack() {
    header("Location:" . get_url());
    exit;
  }

  public static function getUrl($type = null) {
    if ($type=='clean') {
      return 'http://' . strtok( $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],'?');
    } else {
      return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
  }

}

?>
