<?php

/**
 * System Interface controller
 */
class System {

  public static function error($value) {
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

  public static function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
  }

}

?>
