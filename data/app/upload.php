<form action="" method="post" enctype="multipart/form-data">
    Wybierz pliki do wrzucenia:<br><br>
    <input type="file" name="file_upload"><br><br>
    <br>
    <input type="submit" value="Upload Image" name="submit">
</form>

<div class="filelist">
  <?php foreach (scandir('upload') as $key => $value) {
    echo "<a href='upload/$value'>$value</a><br>";
  } ?>
</div>
