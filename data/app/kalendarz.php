<?php

$months_names = array(
  'Styczeń',
  'Luty',
  'Marzec',
  'Kwiecień',
  'Maj',
  'Czerwiec',
  'Lipiec',
  'Sierpień',
  'Wrzesień',
  'Październik',
  'Listopad',
  'Grudzień',
);

// echo '<h2>Styczeń 2017</h2>';
// echo draw_calendar2(01,2017);
?>

<button class="ui labeled icon button">
  <i class="plus icon"></i>
  Dodaj wydarzenie
</button>

<form action="" method="post">
  <div class="ui input">
    <input type="text" class="calendar_txt" name="calendar_txt" placeholder="Opis" value="">
  </div>
  <div class="ui input">
    <input type="text" class="calendar_ts flatpickr" name="calendar_ts" placeholder="Data" data-note="" value="">
  </div>
  <button type="send" class="ui labeled icon button">
    <i class="plus icon"></i>
    Dodaj wydarzenie
  </button>
</div>
</form>

<?php
$m = date('m');
$y = date('Y');
for ($i=1; $i < 13 ; $i++) {
  // date('m')
  if($m>12) {
    $m=$m-12;
    $y++;
  }
  echo '<h2>' . $months_names[$m-1] ." $y</h2>";
  echo draw_calendar2($m,$y);
  $m++;
}



 ?>
