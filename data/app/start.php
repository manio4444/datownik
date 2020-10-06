<section id="main_page">

  <pre>
    Serwis w wersji react: <a href="http://datownik-react.studiocitrus.pl/">http://datownik-react.studiocitrus.pl/</a>
  </pre>

  <form method="POST" class="start_form">

    <h1 class="start_form_title">Multicontent:</h1>
    <textarea name="urladd" rows="5" cols="100"><?php echo isset($_GET['urladd']) ? $_GET['urladd'] : null; ?></textarea>


    <div class="ui vertical buttons">

      <button type="send" name="action" class="ui labeled icon button" value="zadanie">
        <span class="far fa-calendar-check icon"></span>
        <span>Zadanie</span>
      </button>

      <button type="send" name="action" class="ui labeled icon button" value="wydarzenie">
        <span class="far fa-calendar icon"></span>
        <span>Wydarzenie</span>
      </button>

      <button type="send" name="action" class="ui labeled icon button" value="zakladka">
        <span class="fas fa-external-link-square-alt icon"></span>
        <span>Zakładka</span>
      </button>

      <button type="send" name="action" class="ui labeled icon button" value="notatka">
        <span class="far fa-sticky-note icon"></span>
        <span>Notatka</span>
      </button>

      <button type="send" name="action" class="ui labeled icon disabled button" value="dokument">
        <span class="far fa- icon"></span>
        <span>Dokument</span>
      </button>

      <button type="send" name="action" class="ui labeled icon disabled button" value="kontakt">
        <span class="far fa- icon"></span>
        <span>Kontakt</span>
      </button>

      <button type="send" name="action" class="ui labeled icon disabled button" value="kod/haslo">
        <span class="far fa- icon"></span>
        <span>Kod/hasło</span>
      </button>

    </div>

  </form>

  <div class="main_page_dates">

    <h1 class="start_form_title">Kalendarz:</h1>

    <?php

    $calendar = new calendar;

    if ($calendar->getFutureEvents()->rowCount() > 0) {

      foreach ($calendar->getFutureEvents(5) as $value) : ?>

      <div class="ui card red task" data-task="<?php echo $value['id']; ?>">
        <input type="hidden" data-timer-deadline value="<?php echo $value['data']; ?>">
        <div class="content">
          <div class="header"><?php echo $value['txt']; ?></div>
          <div class="meta"><?php echo $value['data']; ?></div>

        </div>
        <div class="extra content">
          <i class="fas fa-stopwatch"></i>
          <span type="text" name="" data-timer-output value="">&nbsp;</span>

        </div>
      </div>

      <?php
    endforeach;

  } else {

    echo "<pre>";
    echo "Brak nadchodzących wydarzeń z kalendarza";
    echo "</pre>";

  }

  ?>

    <a class="ui button fluid" href="?page=kalendarz">Zobacz wszystkie</a>

  </div>


  <div class="main_page_dates">

    <h1 class="start_form_title">To do:</h1>

    <?php

    $tasks = new tasks;
    $tasks->addParam('limit', 5);
    $tasksData = $tasks->getData();

    if (is_array($tasksData) && count($tasksData) > 0) {

      foreach ($tasksData as $value) : ?>

      <div class="ui card teal task" data-task="<?php echo $value['id']; ?>">
        <input type="hidden" data-timer-deadline value="<?php echo $value['deadline']; ?>">
        <div class="content">
          <div class="header"><?php echo $value['txt']; ?></div>
          <div class="meta"><?php echo $value['deadline']; ?></div>

        </div>
        <div class="extra content">
          <i class="fas fa-stopwatch"></i>
          <span type="text" name="" data-timer-output value="">&nbsp;</span>

        </div>
      </div>

      <?php
    endforeach;

  } else {

    echo "<pre>";
    echo "Brak nadchodzących zadań";
    echo "</pre>";

  }
  ?>

    <a class="ui button fluid" href="?page=do-zrobienia">Zobacz wszystkie</a>

  </div>


  <pre>
    <span>javascript:(function(){var win = window.open('http://studiocitrus.pl/datownik/?urladd='+window.location.href, '_blank'); win.focus();})();</span>
  </pre>
  <pre>
    <?php echo 'Current PHP version: ' . phpversion(); ?>
  </pre>
  <pre>
    https://stackoverflow.com/questions/18377891/how-can-i-let-user-paste-image-data-from-the-clipboard-into-a-canvas-element-in
  </pre>
  <pre>
    do code snippetów -
    https://codepen.io/chriscoyier/pen/GBbOJd
  </pre>

</section>

<section id="main_page_notes">

  <h1 class="notes_title">Ostatnie notatki:</h1>

  <div class="notes_container">

    <?php

    if (Router::importViewClass('notatki')) {

      $notes = new notes;
      $notes->setLimit(7);

      echo $notes->getTemplate(); //first empty

      foreach ($notes->getData() as $data) {
        echo $notes->getTemplate($data);
      }

    }

    ?>

    <div class="notes_more">
      <a class="ui button" href="?page=notatki">Zobacz wszystkie</a>
    </div>

  </div>

</section>
