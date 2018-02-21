<?php

// require FOLDER_CLASSES . '/' . 'lockscreen.php';
// $lockscreen = new lockscreen();

/*
* Acually is there need for implement lockscreen class?
*/

?>
<section id="lockscreen">
  <div class="lockscreen_container">
    <div class="lockscreen_title">Enter Passcode</div>
    <div id="row_input">
      <span data-input="1"></span>
      <span data-input="2"></span>
      <span data-input="3"></span>
      <span data-input="4"></span>
    </div>
    <div class="row_btn">
      <button id="btn_1">1</button>
      <button id="btn_2">2</button>
      <button id="btn_3">3</button>
    </div>
    <div class="row_btn">
      <button id="btn_4">4</button>
      <button id="btn_5">5</button>
      <button id="btn_6">6</button>
    </div>
    <div class="row_btn">
      <button id="btn_7">7</button>
      <button id="btn_8">8</button>
      <button id="btn_9">9</button>
    </div>
    <div class="row_btn">
      <button id="btn_0">0</button>
    </div>
  </div>
  <form method="post" id="lockscreen_form">
    <input type="hidden" name="lockscreen_code" value="" id="code_input">
  </form>
</section>

<script src="js/lockscreen.js"></script>
