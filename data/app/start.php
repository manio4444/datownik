<section id="main_page">
  <pre>
    <span>javascript:(function(){var win = window.open('http://studiocitrus.pl/datownik/?urladd='+window.location.href, '_blank'); win.focus();})();</span>
  </pre>
<br><br>


<form method="POST">
  MULTICONTENT<br>
  <textarea name="urladd" rows="5" cols="100"><?php echo isset($_GET['urladd']) ? $_GET['urladd'] : null; ?></textarea>
  <button type="send" name="action" class="ui disabled button" value="zadanie">Zadanie</button>
  <button type="send" name="action" class="ui disabled button" value="wydarzenie">Wydarzenie</button>
  <button type="send" name="action" class="ui button" value="zakladka">Zakładka</button>
  <button type="send" name="action" class="ui button" value="notatka">Notatka</button>
  <button type="send" name="action" class="ui disabled button" value="dokument">Dokument</button>
  <button type="send" name="action" class="ui disabled button" value="kontakt">Kontakt</button>
  <button type="send" name="action" class="ui disabled button" value="kod/haslo">Kod/hasło</button>

  <br><br>

</form>

<?php

echo 'PHP: ' . phpversion();

 ?>
</section>
