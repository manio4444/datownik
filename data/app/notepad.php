<section id="notepad">

  <div class="note_area">
    <textarea placeholder="Zacznij wpisywać tekst aby dodać nową notatkę"></textarea>
  </div>
<?php

foreach ($sql_pdo->query('SELECT * FROM `notes` ORDER BY `id` DESC') as $value) :
 ?>

<div class="note_area">
  <textarea data-note="<?php echo $value['id']; ?>"><?php echo $value['txt']; ?></textarea>
</div>

<?php endforeach; ?>




</section>
