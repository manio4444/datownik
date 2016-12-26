<?php
mcrypt_encrypt();
foreach (read_folder($config['plugins_folder']) as $value) {
  $read_folder[$value[0] . $value[1]] = '';   //tworzy tablice o id takim jak folder+nazwa pliku
}

// echo "<pre>";var_dump($read_folder);echo "</pre>";
// echo "[PLUGINS.INI]<br>"; foreach ($ini['plugins'] as $key => $value) echo "$key = $value<BR>";

$read_folder = array_merge($read_folder, $ini['plugins']); //łączy tablice tak że dopisuje zezwolenia
// echo "<pre>";var_dump($read_folder);echo "</pre>";
// echo "<br><br><br><br>";
foreach ($read_folder as $key => $value) {
  $plugins_return[$key]['permission'] = $value;
  $plugins_return[$key]['exists'] = (file_exists($config['plugins_folder'] . "$key")) ? true : false;
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
  // $value[0] = ( $value[0] == $config['plugins_folder']) ? '/' : str_replace($config['plugins_folder'], '', $value[0]);

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

<section id="#lockscreen">
 <div id="loading-div"></div>
 <div id="statusbar-20"></div>
 <div id="main-div">
 <div id="statusbar-40"></div>
 <div id="title">Enter Passcode</div>
 <div id="input-div">
   <span class="input-num" id="input-num-1">·</span>
   <span class="input-num" id="input-num-2">·</span>
   <span class="input-num" id="input-num-3">·</span>
 </div>
 <div class="num-row">
   <button class="num" id="num-1">1</button>
   <button class="num" id="num-2">2</button>
   <button class="num" id="num-3">3</button>
 </div>
 <div class="num-row">
   <button class="num" id="num-4">4</button>
   <button class="num" id="num-5">5</button>
   <button class="num" id="num-6">6</button>
 </div>
 <div class="num-row">
   <button class="num" id="num-7">7</button>
   <button class="num" id="num-8">8</button>
   <button class="num" id="num-9">9</button>
 </div>
 <div class="num-row">
   <button class="num" id="num-10">←</button>
   <button class="num" id="num-0">0</button>
   <button class="num" id ="num-11">OK</button>
 </div>
</div>
</section>
