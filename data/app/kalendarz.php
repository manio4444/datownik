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
 2017-01-08 00:55:50
 <form action="" method="post">
 <div class="ui input urladd">
       <input type="text" class="calendar_txt" name="calendar_txt" placeholder="Tekst" value="">
       <input type="text" class="calendar_ts" name="calendar_ts" placeholder="Data w timestamp najlepiej" data-note="" value="">
       <button type="send" name="button"></button>
 </div>
</form>
