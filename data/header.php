<header>
  <nav>
    <button type="button" class="hamburger"></button>
    <ul>
      <li><a href="<?php $explode = explode('?', $_SERVER['REQUEST_URI'], 2); echo $explode[0]; ?>">Main</a></li>
      <li><a href="?page=kalendarz">Kalendarz</a></li>
      <li><a href="?page=zakladki">Zakladki</a></li>
      <li><a href="?page=notatki">Notatki</a></li>
      <li><a href="?page=kontakty">Kontakty</a></li>
      <li><a href="?page=pliki">Pliki</a></li>
      <li><a href="?page=ustawienia">Ustawienia</a></li>
      ustawienia
    </ul>
  </nav>
</header>
<main>
<section>
