<?php
$notes = new notes;
?>

<section id="notepad" class="">

  <?php
  echo '<pre>microtime: '.microtime(true).'</pre><br><br>';
  ?>

  <div class="notes_search">
    <div class="ui input">
      <input type="text"class="dasdsa" data-note-search placeholder="Szukaj...">
    </div>
  </div>

  <div class="notes_container">

    <?php

    echo $notes->getTemplate(); //first empty

    foreach ($notes->getData() as $data) {

      echo $notes->getTemplate($data);

    }
    ?>

  </div>


</section>
