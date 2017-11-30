<?php
$bookmarks = new bookmarks;
?>

<section id="bookmarks">
  <form  method="post">

    <?php
    echo $bookmarks->getTemplate();
    ?>

    <?php
    foreach ($bookmarks->sqlReturn as $data) {

      echo $bookmarks->getTemplate($data);

    }
    ?>


  </form>
</section>
