<section id="settings_page">
<?php
mcrypt_encrypt();
foreach (read_folder(FOLDER_PLUGINS) as $value) {
  $read_folder[$value[0] . $value[1]] = '';   //tworzy tablice o id takim jak folder+nazwa pliku
}

// echo "<pre>";var_dump($read_folder);echo "</pre>";
// echo "[PLUGINS.INI]<br>"; foreach ($ini['plugins'] as $key => $value) echo "$key = $value<BR>";

$read_folder = array_merge($read_folder, $ini['plugins']); //łączy tablice tak że dopisuje zezwolenia
// echo "<pre>";var_dump($read_folder);echo "</pre>";
// echo "<br><br><br><br>";
foreach ($read_folder as $key => $value) {
  $plugins_return[$key]['permission'] = $value;
  $plugins_return[$key]['exists'] = (file_exists(FOLDER_PLUGINS . "$key")) ? true : false;
}

//echo "<pre>";var_dump($plugins_return);echo "</pre>";

echo '
<form class="" action="" method="post">
<table class="ui compact celled definition table">
  <thead class="full-width">
    <tr>
      <th>Ścieżka</th>
      <th>Status</th>
      <th>Zezwolony</th>
      <th>Opcje</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
';
foreach ($plugins_return as $key => $value) {
  // $value[0] = ( $value[0] == FOLDER_PLUGINS) ? '/' : str_replace(FOLDER_PLUGINS, '', $value[0]);

  echo "<tr>";
  echo "<td><i class='file outline icon'></i>$key</td>";
  echo ($value['exists']===true) ? "<td class='positive'><i class='icon checkmark'></i>Istnieje</td>" : "<td class='negative'><i class='attention icon'></i>Nie istnieje</td>";
  if ($value['permission']=='tak') echo "<td class='positive'><i class='icon checkmark'></i>Zezwolono</td>";
  else if ($value['permission']=='nie') echo "<td class='negative'><i class='icon close'></i>Nie zezwolono</td>";
  else echo "<td>Brak decyzji</td>";
  if ($value['permission']=='tak') echo "<td></td><td><button name='plugin_change_perm' type='submit' value='$key#nie' class='ui negative basic button'>Nie zezwalaj</button></td>";
  else if ($value['permission']=='nie') echo "<td><button name='plugin_change_perm' type='submit' value='$key#tak' class='ui positive basic button'>Zezwól</button></td><td></td>";
  else echo "<td><button name='plugin_change_perm' type='submit' value='$key#tak' class='ui positive basic button'>Zezwól</button></td><td><button name='plugin_change_perm' type='submit' value='$key#nie' class='ui negative basic button'>Nie zezwalaj</button></td>";
  echo "</tr>";
}
echo '
  </tbody>
  <tfoot class="full-width">
    <tr>
      <th></th>
      <th colspan="4">
        <div class="ui right floated small primary labeled icon button">
          <i class="user icon"></i> Add User
        </div>
        <div class="ui small  button">
          Approve
        </div>
        <div class="ui small  disabled button">
          Approve All
        </div>
      </th>
    </tr>
  </tfoot>
</table>
</form>
';

 //ini_zmiana('plugins', '/semantic/Nowy folderdrodasdsadpdown222.min.js', 'tak');

 ?>


</section>
