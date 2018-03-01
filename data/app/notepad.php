<?php
$notes = new notes;
?>

<section id="notepad" class="">

  <?php
  echo '<pre>microtime: '.microtime(true).'</pre><br><br>';
  ?>

  <div class="notes_container">

    <?php

    echo $notes->getTemplate(); //first empty

    foreach ($notes->sqlReturn as $data) {

      echo $notes->getTemplate($data);

    }
    ?>

  </div>


</section>
