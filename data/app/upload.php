
<section id="upload">

  <iframe src="<?php echo FOLDER_VENDORS ?>/filemanager/dialog.php?type=0&fldr=" class="upload__manager-iframe"></iframe>

  <form action="" method="post" enctype="multipart/form-data">
    Wybierz pliki do wrzucenia:
    <br>
    <br>
    <input type="file" name="file_upload">
    <br>
    <br>
    <input type="submit" value="Upload" name="submit" class="ui green button">
    <br>
    <br>
  </form>

  <ul class="filelist">
    <?php
    $excluded_filelist = array('.', '..');
    foreach (array_diff(scandir('upload'), $excluded_filelist) as $key => $value) {
      echo "
      <li class='filelist__element'>

        <a href='upload/$value'>$value</a>
      </li>";
    } ?>
  </ul>
</section>
