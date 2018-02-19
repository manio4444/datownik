<section id="main_page">

  <form method="POST" class="start_form">
    <h1 class="start_form_title">Multicontent:</h1>
    <textarea name="urladd" rows="5" cols="100"><?php echo isset($_GET['urladd']) ? $_GET['urladd'] : null; ?></textarea>



    <div class="ui icon right pointing dropdown button">
  <div class="text">File</div>
  <i class="dropdown icon"></i>
  <div class="menu">
    <div class="item">New</div>
    <div class="item">
      <span class="description">ctrl + o</span>
      Open...
    </div>
    <div class="item">
      <span class="description">ctrl + s</span>
      Save as...
    </div>
    <div class="item">
      <span class="description">ctrl + r</span>
      Rename
    </div>
    <div class="item">Make a copy</div>
    <div class="item">
      <i class="folder icon"></i>
      Move to folder
    </div>
    <div class="item">
      <i class="trash icon"></i>
      Move to trash
    </div>
    <div class="divider"></div>
    <div class="item">Download As...</div>
    <div class="item">
      <i class="dropdown icon"></i>
      Publish To Web
      <div class="menu">
        <div class="item">Google Docs</div>
        <div class="item">Google Drive</div>
        <div class="item">Dropbox</div>
        <div class="item">Adobe Creative Cloud</div>
        <div class="item">Private FTP</div>
        <div class="item">Another Service...</div>
      </div>
    </div>
    <div class="item">E-mail Collaborators</div>
  </div>
</div>



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


  <pre>
    <span>javascript:(function(){var win = window.open('http://studiocitrus.pl/datownik/?urladd='+window.location.href, '_blank'); win.focus();})();</span>
  </pre>
  <pre>
    <?php echo 'Current PHP version: ' . phpversion(); ?>
  </pre>

</section>

<section id="main_page_notes">

  <h1 class="notes_title">Ostatnie notatki:</h1>

  <div class="notes_container">

    <?php
    Router::importViewClass('notatki');

    $notes = new notes;

    // echo $notes->getTemplate(); //first empty

    $foreach_limit = 0;

    foreach ($notes->sqlReturn as $data) {
      echo $notes->getTemplate($data);
      if (++$foreach_limit >= 4) break;
    }
    ?>

  </div>

</section>
