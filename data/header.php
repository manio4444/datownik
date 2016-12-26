<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
<link href='imgcss/reset.css' rel='stylesheet' type='text/css'>
<?php load_plugins(); ?>
<link href='imgcss/main.css?v=<?php echo time(); ?>' rel='stylesheet' type='text/css'>
<link href='imgcss/calendar.css' rel='stylesheet' type='text/css'>
<link href='imgcss/contactsvcf.css' rel='stylesheet' type='text/css'>

<link href="https://fonts.googleapis.com/css?family=Kalam:300,400,700&amp;subset=latin-ext" rel="stylesheet">
<link href='imgcss/notepad.css' rel='stylesheet' type='text/css'>
<!-- <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script> -->

<!-- NIE DODAWAJ TU SKRYPTÓW ANI STYLÓW -->


<title>Datownik</title>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> -->
</head>
<body>
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
