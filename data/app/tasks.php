<?php
$tasks = new tasks;
?>

<section id="todo">

  <div class="todo_list">


    <form method="post" class="ui card task" data-task>
      <input type="hidden" name="task_id" value="">
      <div class="content">
        <div class="header">Nowy task</div>
        <div class="description ui form">
          <div class="field">
            <label>tytuł:</label>
            <input type="text" name="txt" value="">
          </div>

          <div class="field">
            <div class="ui toggle checkbox">
              <input type="hidden" name="no_deadline" value="1">
              <input type="checkbox" name="no_deadline" value="0" data-task-deadlock checked>
              <label>enable deadline</label>
            </div>
          </div>

          <div class="field deadline">
            <label>deadline:</label>
            <div class="ui icon input">
              <input type="text" name="deadline" class="flatpickr" value="">
              <i class="fas fa-trash icon link"></i>
            </div>
          </div>

        </div>
      </div>
      <div class="ui bottom attached button" data-task-save>
        <i class="add icon"></i>
        Dodaj nowy
      </div>
    </form>

    <?php foreach ($tasks->getData() as $value) : ?>

      <form method="post" class="ui card task<?php if($value['no_deadline']==="1") echo " no-deadline"; ?>" data-task="<?php echo $value['id']; ?>">
        <div class="content">
          <div class="header"><?php echo $value['txt']; ?></div>
          <span data-task-details class="meta far fa-eye"></span>

          <div class="description ui form">
            <div class="field disabled">
              <label>id:</label>
              <input type="text" name="id" value="<?php echo $value['id']; ?>">
            </div>

            <div class="field disabled">
              <label>date_mk:</label>
              <input type="text" name="" value="<?php echo $value['date_mk']; ?>">
            </div>

            <div class="field">
              <div class="ui toggle checkbox">
                <input type="hidden" name="no_deadline" value="1">
                <input type="checkbox" name="no_deadline" value="0" data-task-deadlock <?php if($value['no_deadline']!=="1") echo " checked"; ?>>
                <label>enable deadline</label>
              </div>
            </div>

            <div class="field deadline">
              <label>deadline:</label>
              <div class="ui icon input">
                <input type="text" name="deadline" class="flatpickr" data-timer-deadline value="<?php echo $value['deadline']; ?>">
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

            <div class="field disabled delete">
              <div class="ui button fluid" data-task-delete>Usuń</div>
            </div>
          </div>
        </div>


        <button class="ui teal button" data-task-done>
          <i class="square outline icon"></i>
          Zrobione
        </button>
      </form>

    <?php endforeach; ?>

  </div>

</section>

<div class="ui small basic modal tasks__modal">
  <div class="ui icon header">
    <i class="archive icon"></i>
    Potwierdź wykonanie zadania:
  </div>
  <div class="content tasks__modal_content">
    {{TEXT}}
  </div>
  <div class="actions">
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      Tak
    </div>
    <div class="ui red cancel inverted button">
      <i class="remove icon"></i>
      Nie
    </div>
  </div>
</div>
