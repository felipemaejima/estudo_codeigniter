<footer>
    
</footer>
<?php
if(isset($scripts)) {
foreach($scripts as $script) { ?>
    <script src="<?= base_url("assets/js/$script.js");?>"></script>
<?php } } ?>
</body>
</html>