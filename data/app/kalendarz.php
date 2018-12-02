<section>
<?php

$months_names[1]  = 'Styczeń';
$months_names[2]  = 'Luty';
$months_names[3]  = 'Marzec';
$months_names[4]  = 'Kwiecień';
$months_names[5]  = 'Maj';
$months_names[6]  = 'Czerwiec';
$months_names[7]  = 'Lipiec';
$months_names[8]  = 'Sierpień';
$months_names[9]  = 'Wrzesień';
$months_names[10] = 'Październik';
$months_names[11] = 'Listopad';
$months_names[12] = 'Grudzień';

// echo '<h2>Styczeń 2017</h2>';
// echo draw_calendar2(01,2017);

$calendar_txt_value = (isset($_GET['txt'])) ? $_GET['txt'] : '';
?>


<form class="calendar__buttons" action="" method="post">
  <div class="ui input">
    <input type="text" class="calendar_txt" name="calendar_txt" placeholder="Opis" value="<?php echo $calendar_txt_value; ?>">
  </div>
  <div class="ui input">
    <input type="text" class="calendar_ts flatpickr" name="calendar_ts" placeholder="Data" data-note="" value="">
  </div>
  <button type="send" class="ui labeled icon button">
    <i class="plus icon"></i>
    Dodaj wydarzenie
  </button>
</form>

<form class="calendar__buttons calendar__buttons--dayoff" action="" method="post">
  <div class="ui input">
    <input type="text" class="calendar_txt" name="calendar_dayoff_txt" placeholder="Opis" value="<?php echo $calendar_txt_value; ?>">
  </div>
  <div class="ui input">
    <input type="text" class="calendar_ts flatpickr-dateonly" name="calendar_dayoff_ts" placeholder="Data" data-note="" value="">
  </div>
  <button type="send" class="ui labeled icon button">
    <i class="plus icon"></i>
    Wolne praca
  </button>
</form>

<br>

<?php

$preg_match_month = '/\d\d\d\d[-]([0][1-9]|[1][0-2])/'; // for example 2018-12

if (isset($_GET['month']) && preg_match($preg_match_month, $_GET['month'])) {

  $getExplode = explode('-', $_GET['month']);
  $month = $getExplode[1];
  $year  = $getExplode[0];
  echo '<h2>' . $months_names[$month] ." $year</h2>";
  echo draw_calendar2($month, $year);

} else {

  $previousMonth = date('m') - 1;
  $previousYear  = date('Y');

  for ($i = 0; $i < 12 ; $i++) {
    if($previousMonth == 0) {
      $previousMonth = 12;
      $previousYear--;
    }
    echo '<a href="' . System::getUrl() . '&month=' . $previousYear . '-' . sprintf("%02d", $previousMonth) . '">' . $previousYear . '-' . sprintf("%02d", $previousMonth) . ' | </a>';
    $previousMonth--;
  }

  echo "<br><br>";

  $m = date('m');
  $y = date('Y');

  for ($i=1; $i < 13 ; $i++) {
    if($m>12) {
      $m=$m-12;
      $y++;
    }
    echo '<h2>' . $months_names[$m] ." $y</h2>";
    echo draw_calendar2($m,$y);
    $m++;
  }
}





 ?>
</section>
