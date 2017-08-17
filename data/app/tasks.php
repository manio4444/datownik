<section id="todo">

  <!-- <div class="note_area">
    <textarea placeholder="Zacznij wpisywać tekst aby dodać nową notatkę"></textarea>
  </div> -->

  <div class="task">
    <span>id: <?php echo $value['id']; ?></span><br>
    <span>date_mk: <?php echo $value['date_mk']; ?></span><br>
    <span>deadline: <?php echo $value['deadline']; ?></span><br>
    <span>date_fn: <?php echo $value['date_fn']; ?></span><br>
    <span>countdown: </span><span class="counter"></span><br>
    txt:
    <div class="ui left action icon input loading">
      <button class="ui teal labeled icon button">
        <i class="square outline icon"></i>
        Zrobione
      </button>
      <input type="text" placeholder="Treść zadania">
      <i class="search icon"></i>
    </div>
    <textarea data-task="<?php echo $value['id']; ?>"><?php echo $value['txt']; ?></textarea>
  </div>


<?php

foreach ($sql_pdo->query('SELECT * FROM `tasks` ORDER BY `id` DESC') as $value) :
 ?>




<div class="task">
  <span>id: <?php echo $value['id']; ?></span><br>
  <span>date_mk: <?php echo $value['date_mk']; ?></span><br>
  <span>deadline: <?php echo $value['deadline']; ?></span><br>
  <span>date_fn: <?php echo $value['date_fn']; ?></span><br>
  <span>finished: <input type="checkbox" <?php echo ($value['finished']>0 ? 'checked ' : null); ?>></span><br>
  <span>countdown: </span><span class="counter"></span><br>
  txt:
  <textarea data-task="<?php echo $value['id']; ?>"><?php echo $value['txt']; ?></textarea>
</div>

<?php endforeach; ?>




</section>
