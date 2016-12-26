<table>



<?php


/* sample usages */



echo '<h2>Pażdżernik 2016</h2>';
echo draw_calendar2(10,2016);

echo '<h2>Kwiecień 2017</h2>';
echo draw_calendar2(04,2017);

for ($i=1; $i < 13 ; $i++) {
  echo '<h2>' . $i .' - 2017</h2>';
  echo draw_calendar2($i,2017);
}



 ?>

</table>
