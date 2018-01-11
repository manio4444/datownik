<?php
$docs = new docs;
?>

<section id="docs">

  <?php

  if (Router::getGetParams('id')) {

    $data = $docs->getElement(Router::getGetParams('id'));
    echo $docs->getTemplate($data);

  } else {

    echo $docs->getTemplate();

    foreach ($docs->sqlReturn as $data) {

      echo $docs->getTemplate($data);

    }

  }

  ?>

</section>

<script src="js/docs.js"></script>