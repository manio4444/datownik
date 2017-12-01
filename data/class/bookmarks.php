<?php
/**
*
*/
class bookmarks {

  public $sqlReturn;

  public function __construct() {
    global $sql_pdo; //TODO try not to do like that, maybe extedns from pdo?
    $this->sqlReturn = $sql_pdo->query('SELECT * FROM `bookmarks` ORDER BY `id` DESC');
  }

  public function getTemplate($data = array()) {

    if (isset($data['id'])) {
      $data_bookmark = ' data-bookmark="' . $data['id'] . '"';
      $disabled = ''; // TODO because shows error if not exists
      $href_placeholder = 'Adres URL';
    } else {
      $data_bookmark = ''; // TODO because shows error if not exists
      $disabled = '  disabled';
      $href_placeholder = 'Wklej adres URL aby dodać nowy wpis';
      $data['href'] = ''; // TODO because shows error if not exists
      $data['title'] = ''; // TODO because shows error if not exists
    }
    return '
    <div class="url_container"' . $data_bookmark . '>
    <a href="' . $data['href'] . '" target="_blank" class="image">
    ' //. (if_is_this_image($data['href'])) ? '<img src="' . $data['href'] . '" alt="">' : null
    . '</a>
    <input type="text" class="name" name="" placeholder="Najpierw podaj link" value="' . $data['title'] . '"' . $disabled . '>
    <select class="ui search dropdown tags" multiple="multiple"' . $disabled . '>
    <option value="">Dodaj tagi</option>
    <option value="AL">śmieszne</option>
    <option value="AK">html</option>
    <option value="AZ">kotki</option>
    </select>
    <input type="text" class="href" name="" placeholder="' . $href_placeholder . '" value="' . $data['href'] . '">
    </div>
    ';

  }
}

?>
