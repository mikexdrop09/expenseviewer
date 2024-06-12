<?php 
session_start();
session_destroy();
setcookie('D12id','', time() -1);
header('location: ./index.php');
 ?>
