<pre>
<?php if (isset($error)) foreach ($error as $value) echo "<b>! Error - $value</b><br>"; ?>
</pre>
</main>
<script src="js/scripts.js?v=<?php echo md5_file('js/scripts.js'); ?>"></script>

</body>
</html>
