<?php
if (isset($error)) foreach ($error as $value) echo "<pre class='error'>! Error - $value</pre>";
?>
</main>
<script src="js/functions.js?v=<?php echo md5_file('js/scripts.js'); ?>"></script>
<script src="js/scripts.js?v=<?php echo md5_file('js/scripts.js'); ?>"></script>
<script src="js/notes.js?v=<?php echo md5_file('js/notes.js'); ?>"></script>
<script src="js/bookmarks.js?v=<?php echo md5_file('js/bookmarks.js'); ?>"></script>
<script src="js/tasks.js?v=<?php echo md5_file('js/bookmarks.js'); ?>"></script>

</body>
</html>
