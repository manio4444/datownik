<section id="main_page">
  <pre>
    <span>javascript:(function(){var win = window.open('http://studiocitrus.pl/datownik/?urladd='+window.location.href, '_blank'); win.focus();})();</span>
  </pre>
<br><br>


<form method="POST">
  MULTICONTENT<br>
  <textarea name="urladd" rows="5" cols="100"><?php echo isset($_GET['urladd']) ? $_GET['urladd'] : null; ?></textarea>
  <div class="ui buttons">
    <button type="send" name="action" class="ui disabled button red" value="zadanie">Zadanie</button>
    <button type="send" name="action" class="ui red button" value="wydarzenie">Wydarzenie</button>
    <button type="send" name="action" class="ui button red" value="zakladka">Zakładka</button>
    <button type="send" name="action" class="ui button yellow" value="notatka">Notatka</button>
    <button type="send" name="action" class="ui disabled button red" value="dokument">Dokument</button>
    <button type="send" name="action" class="ui disabled button red" value="kontakt">Kontakt</button>
    <button type="send" name="action" class="ui disabled button red" value="kod/haslo">Kod/hasło</button>
  </div>

  <br><br>

</form>

<?php

echo 'PHP: ' . phpversion();

 ?>
</section>
