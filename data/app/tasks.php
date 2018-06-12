<?php
$tasks = new tasks;
?>

<section id="todo">

  <div class="todo_list">


    <div class="ui card task" data-task>
      <div class="content">
        <div class="header">Nowy task</div>
        <div class="description ui form">
          <div class="field">
            <label>tytuł:</label>
            <input type="text" name="" value="">
          </div>

          <div class="field deadline">
            <label>deadline:</label>
            <div class="ui icon input">
              <input type="text" name="" class="flatpickr" value="">
              <i class="fas fa-trash icon link" data-task-deadlock></i>
            </div>
          </div>

          <div class="field disabled">
            <label>no_deadline:</label>
            <input type="text" name="no_deadline">
          </div>

        </div>
      </div>
      <div class="ui bottom attached button" data-task-save>
        <i class="add icon"></i>
        Dodaj nowy
      </div>
    </div>

    <?php foreach ($tasks->sqlReturn as $value) : ?>

      <div class="ui card task" data-task="<?php echo $value['id']; ?>">
        <div class="content">
          <div class="header"><?php echo $value['txt']; ?></div>
          <div class="meta" data-task-details>szczegóły</div>

          <div class="description ui form">
            <div class="field disabled">
              <label>id:</label>
              <input type="text" name="" value="<?php echo $value['id']; ?>">
            </div>

            <div class="field disabled">
              <label>date_mk:</label>
              <input type="text" name="" value="<?php echo $value['date_mk']; ?>">
            </div>

            <div class="field deadline">
              <label>deadline:</label>
              <div class="ui icon input">
                <input type="text" name="" class="flatpickr" data-timer-deadline value="<?php echo $value['deadline']; ?>">
                <i class="fas fa-trash icon link" data-task-deadlock></i>
              </div>
            </div>

            <div class="field disabled">
              <label>no_deadline:</label>
              <input type="text" name="no_deadline" value="<?php echo $value['no_deadline']; ?>">
            </div>

            <div class="field disabled">
              <label>date_fn:</label>
              <input type="text" name="" value="<?php echo $value['date_fn']; ?>">
            </div>

            <div class="field disabled">
              <label>finished:</label>
              <input type="text" name="" value="<?php echo $value['finished']; ?>">
            </div>

            <div class="field">
              <label>countdown:</label>
              <input type="text" name="" data-timer-output value="">
            </div>

            <div class="field disabled">
              <label>txt:</label>
              <textarea rows="2"><?php echo $value['txt']; ?></textarea>
            </div>
          </div>
        </div>


        <button class="ui teal button" data-task->
          <i class="square outline icon"></i>
          Zrobione
        </button>
      </div>

    <?php endforeach; ?>

  </div>

</section>
