<?php
// logout de la pagina, para desloguear al usuario
session_start();
$_SESSION = array();
session_destroy();
header("Location: index.php");
exit();
?>