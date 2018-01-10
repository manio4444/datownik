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
<script>
$(document).on("input keypress paste change", "textarea.tinymce", function () {
    console.log("input entered");
});
</script>
