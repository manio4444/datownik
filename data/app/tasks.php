<?php
$tasks = new tasks;
?>

<section id="todo">

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

    <?php foreach ($tasks->sqlReturn as $value) : ?>

      <div class="ui card task" data-task="<?php echo $value['id']; ?>">
        <div class="content">
          <div class="header">
            <?php echo $value['txt']; ?>
            <!-- <div class="ui fluid input" style="font-size:14px;">
              <input type="text" name="" value="<?php echo $value['txt']; ?>">
            </div> -->
          </div>
          <div class="meta">[id: <?php echo $value['id']; ?>]</div>
          <div class="description">
            <span>date_mk:</span>
            <div class="ui fluid input disabled" style="font-size:14px;">
              <input type="text" name="" value="<?php echo $value['date_mk']; ?>">
            </div>
            <br>
            <span>deadline: <?php echo $value['deadline']; ?></span>
            <div class="ui fluid input" style="font-size:14px;">
              <input type="text" name="" class="flatpickr" data-timer-deadline value="<?php echo $value['deadline']; ?>">
            </div>
            <br>
            <span>date_fn: <?php echo $value['date_fn']; ?></span>
            <div class="ui fluid input disabled" style="font-size:14px;">
              <input type="text" name="" value="<?php echo $value['date_fn']; ?>">
            </div>
            <br>
            <span>finished: <input type="checkbox" <?php echo ($value['finished']>0 ? 'checked ' : null); ?>></span><br>
            <span>countdown: </span><span class="counter"></span>
            <div class="ui fluid input" style="font-size:14px;">
              <input type="text" name="" data-timer-output value="">
            </div>
            <br>
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
