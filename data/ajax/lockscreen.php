<?php
/**
*
*/
// class docsAjax extends docs {
class lockscreenAjax extends lockscreen {

  public function render() {

    $bool = parent::try_pin_code($_POST['lockscreen_code']);
    if ($bool === true) {
      setcookie( 'datownik_' . md5('_admin'), md5('datownik_access'), strtotime( '+1 days' ) );
      return array(
        'status' => 200,
        'message' => 'valid',
      );
    } else {
      return array(
        'status' => 404,
        'message' => 'invalid',
      );
    }

  }

}

?>
