<section id="todo">

  <!-- <div class="note_area">
    <textarea placeholder="Zacznij wpisywać tekst aby dodać nową notatkę"></textarea>
  </div> -->
<?php

foreach ($sql_pdo->query('SELECT * FROM `tasks` ORDER BY `id` DESC') as $value) :
 ?>




<div class="task">
  <span>id: <?php echo $value['id']; ?></span><br>
  <span>date_mk: <?php echo $value['date_mk']; ?></span><br>
  <span>date_fn: <?php echo $value['date_fn']; ?></span><br>
  txt:
  <textarea data-task="<?php echo $value['id']; ?>"><?php echo $value['txt']; ?></textarea>
</div>

<?php endforeach; ?>




</section>
