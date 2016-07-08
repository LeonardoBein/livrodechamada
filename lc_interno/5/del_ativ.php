<?php
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
$seguranca = new seguranca();
$seguranca->protegePagina();



$_A['prof'] = $_SESSION['usuarioLogin'];
$_A['disciplina'] = $_POST['disciplina'];
$_A['turma'] = $_POST['turma'];
$_A['id'] = $_POST['id'];

$_A['link'] = conecta::_link();

$sql = sprintf("UPDATE `%s_%s_aval`
  SET `hidden`='1'
  WHERE `id` = '%s'",$_A['turma'],$_A['disciplina'],$_A['id']);

if(mysqli_query($_A['link'],$sql)){
    header("Location: escolha_ativ.php?turma=".$_A['turma']."&disciplina=".$_A['disciplina']."");
}

else{

    echo "Error: ". mysqli_error($_A['link']);
}

?>
