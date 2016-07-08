<?php
include("../classes/seguranca.php"); // Inclui o arquivo com as funcoes


//array
$type = array('usuario','nome','email');


$valor[] =   (isset($_POST['usuario']))  ? $_POST['usuario'] : null;
$valor[] =   (isset($_POST['nome']))     ? $_POST['nome']    : null;
$valor[] =  (isset($_POST['e-mail']))   ? $_POST['e-mail']  : null;



for ($i=0; $i < 3; $i++) {
    if ($valor[$i] != null) {
      $sql = 'SELECT `usuario` FROM `tb_usuario` WHERE `'.$type[$i].'`="'. $valor[$i]. '" ';
      break;
    }

}
if ($i == 3) {
  die();
}


$link = new conecta();

$query = $link->query($sql);

if ($query->rowCount() == 0) {
  die("true");
}

die("false");
 ?>
