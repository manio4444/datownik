<section id="main_page">
  <pre>
    <span>javascript:(function(){var win = window.open('http://studiocitrus.pl/datownik/?urladd='+window.location.href, '_blank'); win.focus();})();</span>
  </pre>
<br><br>


<form method="POST" class="start_form">
  <span class="start_form_title">MULTICONTENT:</span>
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

  <br><br>

</form>

<?php

echo 'PHP: ' . phpversion();

 ?>
</section>
