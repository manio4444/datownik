<?php

// $config['plugins_folder'] = "data/plugins";
// $config['ini_folder'] = "data/config";


function config($temp) {
  global $config;
  return $config[$temp];
}

function title($lnk) {
	$lnk = str_replace('https', 'http', $lnk);  												  //szyfrowanych stron nie można ściągać
	if (preg_match("/^http/", $lnk)) {																		//sprawdza czy dostarczono link z którego trzeba wyciągnąć title
		$txt = file_get_contents($lnk);																			//pobiera kod strony
		$start = strpos($txt, '<title>')+7;																	//pobiera miejsce gdzie kończy się string <title> i zaczyna jego wartość
		$wynik = substr($txt, $start, strpos($txt, '</title>')-$start);			//zwraca wartość title
	} else $wynik = $lnk;

	$wynik = preg_replace('/[\/?:*"><|]/', '', $wynik);										//wyrzuca znaki niedozwolone w nazwach folderów
	return $wynik;
}



function draw_calendar2($month,$year) {

	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	$headings = array('Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';


	$first_day = date('N',mktime(0,0,0,$month,1,$year));	// dzien miesiaca wg ISO-8601: 1-7
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year)); //Ilość dni w danym miesiącu
	$days_in_this_week = 1;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

  if ($first_day > 1) {	// puste zanim zacznie sie od pierwszego dnia
    $days_in_past_month = date('t', strtotime(date('Y-m',mktime(0,0,0,$month,1,$year))." -1 month")); //Ilość dni w POPRZEDNIM miesiącu
    //$calendar.= '<td>'. $first_day_left_from_past_month .'</td>';
  	for($x = $days_in_past_month-$first_day+2; $x <= $days_in_past_month; $x++) {
  		$calendar.= '<td class="calendar-day-np"><div class="day-number">' . $x . '</div></td>';
  	}
  }

	/* keep going with days.... */
	for($day = 1; $day <= $days_in_month; $day++) {
    $day_of_week = date('N',mktime(0,0,0,$month,$day,$year)); //pobiera ktory to dzien tygodnia
		$calendar.= '<td class="calendar-day">';


//###################################################################################################
			/* add in the day number */
			$calendar.= "<div class='day-number'>$day</div>";
			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
      $check_day = check_day($day,$month,$year);
      $calendar.= '<p>asdasdsadasdsa</p>';
      foreach ($check_day as $key => $value) $events.= $value . "<br>";
      $calendar.= "<p>$events</p>";
      $calendar.= var_dump($events);

      unset($events);
//###################################################################################################


		$calendar.= '</td>';
		if($day_of_week == 7) {
			$calendar.= '</tr>';
      if ($day < $days_in_month) $calendar.= '<tr class="calendar-row">'; //otwiera nowy wiersz jesli dzien nie jest ostatnim dniem miesiaca
		}
		$first_day++;
	}

	/* finish the rest of the days in the week */
	if($day_of_week < 7) {
		for($x = $day_of_week; $x <= 6; $x++):
			$calendar.= '<td class="calendar-day-np"><div class="day-number">' . $x . '</div></td>';
		endfor;
	}

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';

	/* all done, return result */
	return $calendar;
}





function check_day($day,$month,$year) {
  global $sql_pdo;
  foreach ($sql_pdo->query("SELECT * FROM  `calendar_static`")->fetchAll(PDO::FETCH_ASSOC) as $key => $value) $return[] = $value;
  return $return;

}


function read_folder($folder, $i = 0, &$return = array(), $folder_first = null) {
$folder_first = ($folder_first == null ) ? $folder : $folder_first;
  $tab = array_diff(scandir($folder), array('..', '.'));
  foreach ($tab as $value) {
    $full_path = "$folder/$value";
    if(is_file($full_path)) {
      //$return[$i]['folder'] = $folder; //opcjolanie dodane nazwę folderu
      $folder_return = ($folder == $folder_first) ? '/' : str_replace($folder_first, '', $folder) . '/';
      $return[] = array($folder_return ,$value);
    }
    if(is_dir($full_path)) read_folder($full_path, $i++, $return, $folder_first);
  }
  return $return;
}

function read_folder_tree($folder) {

  $tab = array_diff(scandir($folder, 1), array('..', '.'));
  foreach ($tab as $value) {
    $full_path = "$folder/$value";
    if(is_file($full_path)) {
      $return[$folder] = array($full_path ,$value);
    }
    if(is_dir($full_path)) $return[$folder][] = read_folder_tree($full_path, $i++, $return);
  }
  return $return;
}



function ini_zmiana($ini, $co, $value) {
	global $config;
  $ini_file = $config['ini_folder'] . "/$ini.ini";
  $ini_tab = parse_ini_file($ini_file);
	$ini_tab[$co] = $value;
	foreach ($ini_tab as $temp=>$temp2) {
	$content .= "$temp = $temp2" . PHP_EOL;
	file_put_contents($ini_file, $content);
	}
}


function load_plugins() {
  global $ini;
  global $config;
  foreach ($ini['plugins'] as $key => $value) {
    if ($value == 'tak') {
      $full_path = $config['plugins_folder'] . $key;
      $pathinfo = pathinfo($full_path);
      if ($pathinfo['extension']=='css') echo "<link href='$full_path' rel='stylesheet' type='text/css'>" . PHP_EOL;
      else if ($pathinfo['extension']=='js') echo "<script src='$full_path'></script>" . PHP_EOL;
      else echo "<!-- Nie rozpoznano typu pliku - $full_path-->" . PHP_EOL;
    }
  }
}
 ?>
