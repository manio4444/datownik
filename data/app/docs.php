<?php
$docs = new docs;
?>

<section id="docs" class="<?php if (Router::getGetParams('id')) echo 'docs-single';  ?>">

  <?php

  if (Router::getGetParams('id')) {

    $data = $docs->getElement(Router::getGetParams('id'));
    echo $docs->getTemplate($data);

  } else {

    //first empty
    echo $docs->getTemplate(array(
      'title' => 'Nowy dokument',
    ));

    foreach ($docs->getData() as $data) {

      echo $docs->getTemplate($data);

    }

  }

  ?>

</section>

<script src="js/docs.js"></script>
