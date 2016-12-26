<!-- Rounded switch -->
pokaż źródło
<label class="switch">
  <input type="checkbox" class="checkbox_switcher">
  <div class="slider round"></div>
</label>
<br><br>

<?php


$licznik_kon = 1;

foreach (explode(PHP_EOL, file_get_contents('contacts.vcf')) as $key => $value) {

  $temp[]= $value;

	if ($value == 'END:VCARD') {

    echo "<div class='contact_line'>";
      echo "<div class='kon'>";
        echo "<div class='img'></div>";
        echo "<div class='txt'>";


        foreach ($temp as $value2) {
        	//echo "$licznik_kon => ";
        	if (substr($value2, 0, 2)=='FN') {
            $value2 = substr($value2, 3);
            $value2 = str_replace('ENCODING=QUOTED-PRINTABLE;CHARSET=UTF-8:', '', $value2);
            $value2 = str_replace('=20', ' ', $value2);
            $value2 = str_replace('=C5=82', 'ł', $value2);
            $value2 = str_replace('=C5=81', 'Ł', $value2);
            $value2 = str_replace('=C4=99', 'ę', $value2);
            $value2 = str_replace('=C3=B3', 'ó', $value2);
            $value2 = str_replace('=C3=B2', 'ó', $value2);
            $value2 = str_replace('=C5=BC', 'ż', $value2);
            $value2 = str_replace('=C5=BA', 'ź', $value2);
            $value2 = str_replace('=C5=84', 'ń', $value2);
            $value2 = str_replace('=C5=9B', 'ś', $value2);
            $value2 = str_replace('=C4=85', 'ą', $value2);
            $value2 = str_replace('=C4=87', 'ć', $value2);
            $value2 = str_replace('=C5=9A', 'Ś', $value2);
            $value2 = str_replace('=C5=BB', 'Ż', $value2);
            $value2 = str_replace('=C4=85', 'ą', $value2);




            echo "<div class='naz'>" . str_replace('=20', ' ', $value2) . "</div>";

          }
        	else if (substr($value2, 0, 3)=='TEL') echo "<div class='num'>" . substr($value2, strpos($value2, ':')+1) . "</div>";
        }
        echo "</div>";
      echo "</div>";

      echo "<div class='reszta'>";
      foreach ($temp as $value2) echo "$value2<br>";
      echo "</div>";

    echo "</div>";


    $licznik_kon++;

		unset($temp);
	}

}

?>
