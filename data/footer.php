<?php if (isset($error)) foreach ($error as $value) echo "<pre class='error'>! Error - $value</pre>"; ?>
</main>
<script src="js/scripts.js?v=<?php echo md5_file('js/scripts.js'); ?>"></script>

</body>
</html>
