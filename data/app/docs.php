<?php
$docs = new docs;
?>

<section id="docs">
  <form  method="post">

    <?php
    echo $docs->getTemplate();
    ?>

    <?php
    foreach ($docs->sqlReturn as $data) {

      echo $docs->getTemplate($data);

    }
    ?>


  </form>
</section>
