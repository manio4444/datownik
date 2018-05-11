<section id="main_page">

  <form method="POST" class="start_form">
    <h1 class="start_form_title">Multicontent:</h1>
    <textarea name="urladd" rows="5" cols="100"><?php echo isset($_GET['urladd']) ? $_GET['urladd'] : null; ?></textarea>


    <div class="ui vertical buttons">
      <button type="send" name="action" class="ui labeled icon disabled button" value="zadanie">
        <i class="checked calendar icon"></i>
        Zadanie
      </button>
      <button type="send" name="action" class="ui labeled icon button" value="wydarzenie">
        <i class="calendar icon"></i>
        Wydarzenie
      </button>
      <button type="send" name="action" class="ui labeled icon button" value="zakladka">
        <i class="external icon"></i>
        Zakładka
      </button>
      <button type="send" name="action" class="ui labeled icon button" value="notatka">
        <i class="sticky note outline icon"></i>
        Notatka
      </button>
      <button type="send" name="action" class="ui labeled icon disabled button" value="dokument">
        <i class="calendar icon"></i>
        Dokument
      </button>
      <button type="send" name="action" class="ui labeled icon disabled button" value="kontakt">
        <i class="calendar icon"></i>
        Kontakt
      </button>
      <button type="send" name="action" class="ui labeled icon disabled button" value="kod/haslo">
        <i class="calendar icon"></i>
        Kod/hasło
      </button>
    </div>
  </form>

  <div class="main_page_dates">

    <h1 class="start_form_title">Kalendarz:</h1>

    <?php
    // SELECT *  FROM `calendar_static` WHERE `data` > CURRENT_TIMESTAMP ORDER BY `calendar_static`.`data` ASC LIMIT 10

    if (Router::importViewClass('kalendarz')) {

      $calendar = new calendar;

      if ($calendar->getFutureEvents()->rowCount() > 0) {

        foreach ($calendar->getFutureEvents() as $value) : ?>

        <div class="ui card task" data-task="<?php echo $value['id']; ?>">
          <input type="hidden" data-timer-deadline value="<?php echo $value['data']; ?>">
          <div class="content">
            <div class="header"><?php echo $value['txt']; ?></div>
            <div class="meta"><?php echo $value['data']; ?></div>

          </div>
          <div class="content">
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


    }

    ?>

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

</section>

<section id="main_page_notes">

  <h1 class="notes_title">Ostatnie notatki:</h1>

  <div class="notes_container">

    <?php

    if (Router::importViewClass('notatki')) {

      $notes = new notes;

      echo $notes->getTemplate(); //first empty

      $foreach_limit = 0;

      foreach ($notes->sqlReturn as $data) {
        echo $notes->getTemplate($data);
        if (++$foreach_limit >= 7) break;
      }

    }

    ?>

  </div>

</section>
