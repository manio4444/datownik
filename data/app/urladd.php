<section id="bookmarks">
<form  method="post">

<!-- <table>
<div class="ui input">
  <input type="text" name="urltitle" value="<?php echo title($_GET['urladd']); ?>" placeholder="Nazwa">
</div>
<br>
<div class="ui input">
  <input type="text" name="urladd" value="<?php echo $_GET['urladd']; ?>" placeholder="Adres URL">
</div>
<br>

<select class="ui fluid search dropdown" name="urlkat" multiple="">
  <option value=>Wybierz kategorię</option>
  <option value="filmy">filmy</option>
  <option value="ważsne">ważqwne</option>
  <option value="ważdne">waożne</option>
  <option value="wafżne">waiżne</option>
  <option value="wagżne">waużne</option>
  <option value="wahżne">wayżne</option>
  <option value="wajżne">watżne</option>
  <option value="wakżne">ważrne</option>
  <option value="walżne">ważene</option>
</select>

<input type="submit" class="ui button" value="Dodaj">

</table>
</form> -->


  <div class="url_container">
    <a href="" target="_blank" class="image"></a>
      <input type="text" class="name" name="" placeholder="Najpierw podaj link" value="" disabled="">
      <select class="ui search dropdown tags" multiple="multiple" disabled="">
        <option value="">Dodaj tagi</option>
        <option value="AL">śmieszne</option>
        <option value="AK">html</option>
        <option value="AZ">kotki</option>
      </select>
      <input type="text" class="href" name="" placeholder="Wklej adres URL aby dodać nowy wpis" data-note="" value="">
  </div>

<?php foreach ($sql_pdo->query('SELECT * FROM `bookmarks` ORDER BY `id` DESC') as $value) : ?>

<div class="url_container" data-bookmark="<?php echo $value['id']; ?>">
  <a href="<?php echo $value['href']; ?>" target="_blank" class="image">
    <?php if (if_is_this_image($value['href'])) echo '<img src="' . $value['href'] . '" alt="">'; ?>
  </a>
  <input type="text" class="name" name="" placeholder="Najpierw podaj link" value="<?php echo $value['title']; ?>">
  <select class="ui search dropdown tags" multiple="multiple">
    <option value="">Dodaj tagi</option>
    <option value="AL">śmieszne</option>
    <option value="AK">html</option>
    <option value="AZ">kotki</option>
  </select>
  <input type="text" class="href" name="" placeholder="Adres URL" value="<?php echo $value['href']; ?>">
</div>

<?php endforeach; ?>
</form>
</section>
