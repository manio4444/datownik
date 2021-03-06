<?php

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
  /* Pola tekstowe */
  $headings = array('Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');

/* Inicjacja wartości */
  $first_day = date('N',mktime(0,0,0,$month,1,$year));	// dzien miesiaca wg ISO-8601: 1-7
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year)); //Ilość dni w danym miesiącu
  $days_in_this_week = 1;
  $dates_array = array();
  $events_month = get_events_month($month,$year);


/* Start zwracania wartości */
  $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

  if ($first_day > 1) {	// puste zanim zacznie sie od pierwszego dnia
    $days_in_past_month = date('t', strtotime(date('Y-m',mktime(0,0,0,$month,1,$year))." -1 month")); //Ilość dni w POPRZEDNIM miesiącu
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
      if (@is_array($events_month[$day]) && count($events_month[$day])>0) {
        foreach ($events_month[$day] as $value) {
          $calendar.= '<p class="day-event day-event--' . $value['type'] . '"><a href="' . get_url() . '&id=' . $value['id'] . '">' . $value['txt'] . '</a><span class="details">' . $value['data'] . '</span></p>';
        }
      }
      $calendar.= '<p class="day-event add-event">+</p>';
//###################################################################################################


		$calendar.= '</td>';
		if($day_of_week == 7) {
			$calendar.= '</tr>';
      if ($day < $days_in_month) $calendar.= '<tr class="calendar-row">'; //otwiera nowy wiersz jesli dzien nie jest ostatnim dniem miesiaca
		}
		$first_day++;
	}

	/* finish the rest of the days in the week */
  $y = 1;
	if($day_of_week < 7) {
		for($x = $day_of_week; $x <= 6; $x++):
			$calendar.= '<td class="calendar-day-np"><div class="day-number">' . $y . '</div></td>';
      $y++;
		endfor;
	}

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';

	/* all done, return result */
	return $calendar;
}



function get_events_month($month, $year) {
  global $sql_pdo;

  $query = "SELECT id, data, DAY(data) AS 'day', txt, 'static' AS type
  FROM calendar_static
  WHERE MONTH(data) = $month
  AND YEAR(data) = $year
  UNION ALL
  SELECT id, data, DAY(data) AS 'day', txt, 'dayoff' AS type
  FROM `calendar_dayoff`
  WHERE MONTH(data) = $month
  AND YEAR(data) = $year
  ORDER BY data ASC";

  foreach ($sql_pdo->query($query)->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
    $return[$value['day']][] = $value;
  }

  if (!empty($return)) return $return;
}

function get_events_day($day,$month,$year) {
  global $sql_pdo;
  echo "#$day<br>";
  $day = 0;
  if(!empty($day) || is_numeric($day)) echo "TAK<br>";
  $ts_start = mktime(0,0,0,$month,$day,$year);	// timestamt start
  $ts_end = mktime(23,59,59,$month,$day,$year);	// timestamt start
  // echo "$ts_start<br>";
  // echo $ts_end;
  foreach ($sql_pdo->query("SELECT id, data, txt FROM `calendar_static` WHERE `data` >= FROM_UNIXTIME('$ts_start') AND `data` <= FROM_UNIXTIME('$ts_end')")->fetchAll(PDO::FETCH_ASSOC) as $key => $value) $return[] = $value;

  echo "<pre>";
  var_dump($return);


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
  $ini_file = FOLDER_INI . "/$ini.ini";
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
      $full_path = FOLDER_PLUGINS . $key;
      $pathinfo = pathinfo($full_path);
      if ($pathinfo['extension']=='css') echo "<link href='$full_path' rel='stylesheet' type='text/css'>" . PHP_EOL;
      else if ($pathinfo['extension']=='js') echo "<script src='$full_path'></script>" . PHP_EOL;
      else echo "<!-- Nie rozpoznano typu pliku - $full_path-->" . PHP_EOL;
    }
  }
}

function get_title($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $html = curl_exec($ch);
  curl_close($ch);
  preg_match('/<title>(.+)<\/title>/',$html,$matches);
  $title = $matches[1];
  return $title.'';
}


function if_is_this_image($path) {
  if (
    stristr($path, '.jpg') ||
    stristr($path, '.jpeg') ||
    stristr($path, '.gif') ||
    stristr($path, '.png') ||
    stristr($path, '.svg')
  ) {
    if(@is_array(getimagesize($path))) return true;
    else return false;
  } else return false;
}


function get_url($type = null) {
  //domyślnie zwraca pełny adres
  //dodać ify na przyszłość
  if ($type=='clean') return 'http://' . strtok( $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],'?');
  else return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}


 ?>
