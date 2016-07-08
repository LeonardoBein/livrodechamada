<?php
include("../classes/seguranca.php");
$seguranca = new seguranca();

$senha = (isset($_POST['senha'])) ? (bcrypt::hash($_POST['senha'], mt_rand(4,13))) : null;
$id = $seguranca->trata_var($_POST['id']);
$array = array('usuario' => $_SESSION['usuarioLogin'], 'senha' => $_POST['old']);
$boolen = isset($_POST['boolean']) ? $_POST['boolean'] : null;
$new_password_config = ($boolen == 1) ?  : null ;
$data = time();

if ($boolen == true) {
  if ($seguranca->validaUsuario($array)) {

    $senha = bcrypt::hash($_POST['new'], mt_rand(4,13));
    $id = $_SESSION['usuarioLogin'];
    $sql = "UPDATE `tb_usuario` SET `senha` = '".$senha."',`data`='".$data."' WHERE `usuario` = '".$id."' LIMIT 1";

  }
  else{
    $test = strpos($_SERVER['HTTP_REFERER'], "?");
    if ($test === false) {
      die(header("Location: ".$_SERVER['HTTP_REFERER']."?error=incorrect"));
    }else {
      die(header("Location: ".$_SERVER['HTTP_REFERER'].""));
    }
  }
}

$link =  new conecta();


$sql = "UPDATE `tb_usuario` SET `senha` = '".$senha."',`data`='".$data."' WHERE `id` = '".$id."' LIMIT 1";
if(!$link->query($sql)){
    session_destroy();
    die(header("Location: ../index.php"));

}
else{
    session_destroy();
    die(header("Location: ../index.php?msg=successpassword"));

}

?>
