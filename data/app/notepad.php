<?php
$notes = new notes;
?>

<section id="notepad" class="notes_container">

  <?php

  echo $notes->getTemplate(); //first empty

  foreach ($notes->sqlReturn as $data) {

    echo $notes->getTemplate($data);

  }
  ?>

</section>
