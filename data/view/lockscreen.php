<?php

// require FOLDER_CLASSES . '/' . 'lockscreen.php';
// $lockscreen = new lockscreen();

/*
* Acually is there need for implement lockscreen class?
*/

?>
<section class="lockscreen">
  <div class="lockscreen__container">
    <div class="lockscreen__title">Enter Passcode</div>
    <div class="lockscreen__inputs">
      <span data-input="1"></span>
      <span data-input="2"></span>
      <span data-input="3"></span>
      <span data-input="4"></span>
    </div>
    <div class="lockscreen__buttons_row">
      <button data-button="1">1</button>
      <button data-button="2">2</button>
      <button data-button="3">3</button>
    </div>
    <div class="lockscreen__buttons_row">
      <button data-button="4">4</button>
      <button data-button="5">5</button>
      <button data-button="6">6</button>
    </div>
    <div class="lockscreen__buttons_row">
      <button data-button="7">7</button>
      <button data-button="8">8</button>
      <button data-button="9">9</button>
    </div>
    <div class="lockscreen__buttons_row">
      <button data-button="0">0</button>
    </div>
  </div>
  <form method="post" id="lockscreen__form">
    <input type="hidden" name="lockscreen_code" class="lockscreen__form_input">
  </form>
</section>

<script src="js/lockscreen.js"></script>
