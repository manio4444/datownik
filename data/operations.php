<?php

$header_back = false;

if ($_FILES) {
  foreach ($_FILES as $form_name=>$file_tab) {

  	if (is_uploaded_file($file_tab['tmp_name'])) {

  	if ($_SERVER[HTTP_HOST]=="localhost")
  		foreach ($file_tab as $temp3=>$temp4)
  			echo "$form_name=>$temp3=>" . $temp4 . "<br />";

  		$filesave = $file_tab['name'];
  		if ($_SERVER[HTTP_HOST]=="localhost") echo $filesave . "<br />";

  		$save_path = "upload/$filesave";
  		if ($_SERVER[HTTP_HOST]=="localhost") echo $save_path . "<br />";

  		if(move_uploaded_file($file_tab['tmp_name'], $save_path) && $_SERVER[HTTP_HOST]=="localhost")
        echo "ZAPISANO POPRAWNIE $save_path<br /><br />";
  		else if ($_SERVER[HTTP_HOST]=="localhost") echo "BŁĄD ZAPISU PLIKU $save_path";
  	}
  }
  $header_back = true; //robi przekierowanie headerem po skończeniu operacji

}

if(isset($_POST['plugin_change_perm'])) {
  echo "<pre>";
  var_dump($_POST);
  echo "</pre>";
  $temp = explode("#", $_POST['plugin_change_perm']);

  ini_zmiana('plugins', $temp[0], $temp[1]);
  $header_back = true; //robi przekierowanie headerem po skończeniu operacji
}


if(isset($_POST['calendar_ts']) && isset($_POST['calendar_txt'])) {
  $pdo_operation = $sql_pdo->prepare( 'INSERT INTO `calendar_static` (`data`, `txt`) VALUES (:data, :txt)' );
  $pdo_operation->bindValue(':data', $_POST['calendar_ts'], PDO::PARAM_STR);
  $pdo_operation->bindValue(':txt', $_POST['calendar_txt'], PDO::PARAM_STR);
  $pdo_operation->execute();
  $header_back = true; //robi przekierowanie headerem po skończeniu operacji
}


if(isset($_POST['action']) && $_POST['action']=="notatka" && $_POST['urladd']) {
    $pdo_operation = $sql_pdo->prepare( 'INSERT INTO `notes` (`txt`) VALUES (:txt)' );
    $pdo_operation->bindValue(':txt', $_POST['urladd'], PDO::PARAM_STR);
    $pdo_operation->execute();
    $header_back = 'notatki'; //robi przekierowanie headerem po skończeniu operacji
}

if(isset($_POST['note_ajax'])) {
  if (!$_POST['note_id'] && $_POST['note_txt']) {
    $pdo_operation = $sql_pdo->prepare( 'INSERT INTO `notes` (`txt`) VALUES (:txt)' );
    $pdo_operation->bindValue(':txt', $_POST['note_txt'], PDO::PARAM_STR);
    $pdo_operation->execute();
    echo $sql_pdo->lastInsertId();
  } elseif (!$_POST['note_txt'] && $_POST['note_id'] && $_POST['note_delete']) {
    $pdo_operation = $sql_pdo->prepare( 'DELETE FROM `notes` WHERE `id` = :id' );
    $pdo_operation->bindValue(':id', $_POST['note_id'], PDO::PARAM_INT);
    $pdo_operation->execute();
    echo "deleted";
  } elseif ($_POST['note_id']!=='waiting') {
    $pdo_operation = $sql_pdo->prepare( 'UPDATE `notes` SET `txt` = :txt WHERE `id` = :id' );
    $pdo_operation->bindValue(':id', $_POST['note_id'], PDO::PARAM_INT);
    $pdo_operation->bindValue(':txt', $_POST['note_txt'], PDO::PARAM_STR);
    $pdo_operation->execute();
    echo "edit";
  }
}

if(isset($_POST['action']) && $_POST['action']=="zakladka" && $_POST['urladd']) {
    $bookmark_title = get_title($_POST['urladd']);
    $pdo_operation = $sql_pdo->prepare( 'INSERT INTO `bookmarks` (`href`, `title`) VALUES (:href, :title)' );
    $pdo_operation->bindValue(':href', $_POST['urladd'], PDO::PARAM_STR);
    $pdo_operation->bindValue(':title', $bookmark_title, PDO::PARAM_STR);
    $pdo_operation->execute();
    $header_back = 'zakladki'; //robi przekierowanie headerem po skończeniu operacji
}

if(isset($_POST['bookmark_ajax'])) {
  if (!$_POST['bookmark_id'] && $_POST['bookmark_href']) {
    $bookmark_title = get_title($_POST['bookmark_href']);
    $pdo_operation = $sql_pdo->prepare( 'INSERT INTO `bookmarks` (`href`, `title`) VALUES (:href, :title)' );
    $pdo_operation->bindValue(':href', $_POST['bookmark_href'], PDO::PARAM_STR);
    $pdo_operation->bindValue(':title', $bookmark_title, PDO::PARAM_STR);
    $pdo_operation->execute();
    echo json_encode(array('id' => $sql_pdo->lastInsertId(), 'title' => $bookmark_title));
  } elseif (!$_POST['bookmark_href'] && $_POST['bookmark_delete']) {
    $pdo_operation = $sql_pdo->prepare( 'DELETE FROM `bookmarks` WHERE `id` = :id' );
    $pdo_operation->bindValue(':id', $_POST['bookmark_id'], PDO::PARAM_INT);
    $pdo_operation->execute();
    echo "deleted";
  } elseif ($_POST['bookmark_id'] && $_POST['bookmark_href']) {
    $pdo_operation = $sql_pdo->prepare( 'UPDATE `bookmarks` SET `href` = :href WHERE `id` = :id' );
    $pdo_operation->bindValue(':id', $_POST['bookmark_id'], PDO::PARAM_INT);
    $pdo_operation->bindValue(':href', $_POST['bookmark_href'], PDO::PARAM_STR);
    $pdo_operation->execute();
    echo "edit";
  } elseif ($_POST['bookmark_id'] && $_POST['bookmark_title']) {
    $pdo_operation = $sql_pdo->prepare( 'UPDATE `bookmarks` SET `title` = :title WHERE `id` = :id' );
    $pdo_operation->bindValue(':id', $_POST['bookmark_id'], PDO::PARAM_INT);
    $pdo_operation->bindValue(':title', $_POST['bookmark_title'], PDO::PARAM_STR);
    $pdo_operation->execute();
    echo "edit";
  }
}

if(isset($_POST['lockscreen_ajax'])) {
  if ($_POST['lockscreen_code']) {
    require FOLDER_CLASSES . '/' . 'lockscreen.php';
    $lockscreen = new lockscreen();
    echo $lockscreen->ajax_try_pin_code($_POST['lockscreen_code']);
  } else {
    echo "No code";
  }
}

if(isset($_POST['lockscreen_code'])) {
  require FOLDER_CLASSES . '/' . 'lockscreen.php';
  $lockscreen = new lockscreen();
  if ($lockscreen->try_pin_code($_POST['lockscreen_code']) ===true) {
    setcookie( "admin", 1, strtotime( '+30 days' ) );
    $header_back = true;
  }

}

if(isset($_POST['action']) && $_POST['action']=="wydarzenie" && $_POST['urladd']) {
  $header_back['app'] = 'kalendarz';
  $header_back['get']['txt'] = $_POST['urladd'];
}




if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest') die();
if ($header_back===true) header("Location:" . get_url());
else if (!empty($header_back)) {

  $filename = (is_array($header_back))
    ? FOLDER_APPS . "/" . $kontroller_tab[$header_back['app']] . $config['app_path_end']
    : FOLDER_APPS . "/" . $kontroller_tab[$header_back] . $config['app_path_end'];

  if (is_array($header_back) && file_exists($filename)) {
    $return = "Location:" . get_url('clean') . '?page='.$header_back['app'];
    if ($header_back['get']) foreach ($header_back['get'] as $key => $value) $return.= "&$key=$value";
    header($return);
  }
  else if (file_exists($filename)) header("Location:" . get_url('clean') . '?page='.$header_back);
}

// header("Location:http://" . $_SERVER[HTTP_HOST]);

 ?>
