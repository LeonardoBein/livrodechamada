<?php
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
$seguranca = new seguranca();
$seguranca->protegePagina();





//banco de dados

//variaveis
$_A['turma'] = $_POST['turma'];
$_A['disciplina'] = $_POST['disciplina'];
$_A['prof'] = $_SESSION['usuarioLogin'];
$_A['id'] = $_POST['id'];
$_A['qtd'] = $_POST['qtd'];

$_A['link'] = conecta::_link();

for ($x = 1; $x <= $_A['qtd'];$x++){
    $y = "n_".$x;
    $z[] = "n_".$x;
    $a[] = $_POST[$y];
}
//update 3ib_abc_aval set n_1 = "0.02" ,n_2 = "5.00" where id = 1

for ($x = 1,$y = 0; $x <= $_A['qtd']; $x++, $y++){
    $sql = 'UPDATE `'.$_A['turma'].'_'.$_A['disciplina'].'_aval` SET `'.$z[$y].'` = "'.$a[$y].'" WHERE `id` = "'.$_A['id'].'"';
if(!mysqli_query($_A['link'],$sql)){die("Error: ".mysqli_error($_A['link']));}
}

header("Location: escolha_ativ.php?msg=1&turma=".$_A['turma']."&disciplina=".$_A['disciplina']."");


?>
