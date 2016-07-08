<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require("../config/main_inc.php");
if ($install == true) {
  $error = file_get_contents("../erros/404-nao_encontrado.html");
  die($error);
}


 ?>
