<?php
$tasks = new tasks;
?>

<section id="todo">

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

<br>
<br>
<br>
<br>


<div class="todo_list">


  <div class="ui card">
    <div class="content">
      <div class="header">Jenny Hess</div>
      <div class="description">
        Jenny is a student studying Media Management at the New School
      </div>
    </div>
    <div class="ui bottom attached button">
      <i class="add icon"></i>
      Add Friend
    </div>
  </div>

<?php

foreach ($tasks->sqlReturn as $value) :
 ?>




<div class="ui card task" data-task="<?php echo $value['id']; ?>">
  <div class="content">
    <div class="header"><input type="text" name="" value="<?php echo $value['txt']; ?>"></div>
    <div class="meta">id: <?php echo $value['id']; ?></div>
    <div class="description">
      <span>date_mk: <?php echo $value['date_mk']; ?></span><br>
      <span>deadline: <?php echo $value['deadline']; ?></span><br>
      <span>date_fn: <?php echo $value['date_fn']; ?></span><br>
      <span>finished: <input type="checkbox" <?php echo ($value['finished']>0 ? 'checked ' : null); ?>></span><br>
      <span>countdown: </span><span class="counter"></span><br>
    </div>
  </div>
  <div class="content">
    txt:
    <textarea><?php echo $value['txt']; ?></textarea>
  </div>

  <button class="ui teal button">
    <i class="square outline icon"></i>
    Zrobione
  </button>
</div>

<?php endforeach; ?>

</div>




</section>
