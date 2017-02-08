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
  $pdo_operation = $sql_pdo->prepare( 'INSERT INTO `bookmarks` (`href`) VALUES (:href)' );
    $pdo_operation->bindValue(':href', $_POST['urladd'], PDO::PARAM_STR);
    $pdo_operation->execute();
    $header_back = 'zakladki'; //robi przekierowanie headerem po skończeniu operacji
}

if(isset($_POST['bookmark_ajax'])) {
  if (!$_POST['bookmark_id']) {
    $pdo_operation = $sql_pdo->prepare( 'INSERT INTO `bookmarks` (`href`) VALUES (:href)' );
    $pdo_operation->bindValue(':href', $_POST['bookmark_href'], PDO::PARAM_STR);
    $pdo_operation->execute();
    echo $sql_pdo->lastInsertId();
  } elseif (!$_POST['bookmark_href'] && $_POST['bookmark_delete']) {
    $pdo_operation = $sql_pdo->prepare( 'DELETE FROM `bookmarks` WHERE `id` = :id' );
    $pdo_operation->bindValue(':id', $_POST['bookmark_id'], PDO::PARAM_INT);
    $pdo_operation->execute();
    echo "deleted";
  } elseif ($_POST['note_id']!=='waiting') {
    $pdo_operation = $sql_pdo->prepare( 'UPDATE `bookmarks` SET `href` = :href WHERE `id` = :id' );
    $pdo_operation->bindValue(':id', $_POST['bookmark_id'], PDO::PARAM_INT);
    $pdo_operation->bindValue(':href', $_POST['bookmark_href'], PDO::PARAM_STR);
    $pdo_operation->execute();
    echo "edit";
  }
}





if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest') die();
if ($header_back===true) header("Location:" . get_url());
else if (!empty($header_back)) {
  $filename = $config['app_path_start'] . "/" . $kontroller_tab[$header_back] . $config['app_path_end'];
  if (file_exists($filename)) header("Location:" . get_url('clean') . '?page='.$header_back);
}

// header("Location:http://" . $_SERVER[HTTP_HOST]);

 ?>
