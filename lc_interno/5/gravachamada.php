<?php


include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
$seguranca = new seguranca();
$seguranca->protegePagina();

$prof = $_SESSION['usuarioLogin'];
$_A['turma'] = (isset($_POST["turma"])) ? ($seguranca->trata_var($_POST['turma'])) : null;
$_A['disciplina'] = (isset($_POST["disciplina"])) ? ($seguranca->trata_var($_POST['disciplina'])) : null;
$_A['data'] = sprintf("%s-%s-%s",substr($_POST["data"],6,9),substr($_POST["data"],3,-5),substr($_POST["data"],0,-8));
$_A['trimestre'] = (isset($_POST['trimestre'])) ? ($seguranca->trata_var($_POST['trimestre'],'integer')) : null;
$_A['alias'] = (isset($_POST['alias'])) ? ($seguranca->trata_var($_POST['alias'])) : null;
$_A['bool'] = (isset($_POST['alter'])) ? ((bool) $_POST['alter']) : null;
$_A['id'] = (isset($_POST['id'])) ? ((int) $_POST['id']) : null;

$link = conecta::_link();



if($_A['bool'] == true){
    if($_A['alias'] == "" || $_A['alias'] == NULL){
        die(header("Location: altera_chamada.php?error=nullnome&turma=".$_A['turma']."&disciplina=".$_A['disciplina'].""));
    }

    $sql_altera_alias = "UPDATE `".$_A['turma']."_".$_A['disciplina']."_pres` SET `alias`='".$_A['alias']."' WHERE `id` = ".$_A['id']."";
    if(!mysqli_query($link,$sql_altera_alias)){
        die("Error:".mysqli_error($link));
    }
    die(header("Location: altera_chamada.php?msg=1&turma=".$_A['turma']."&disciplina=".$_A['disciplina'].""));

}
if($_A['alias'] == "" || $_A['alias'] == NULL){
    die(header("Location: chamada.php?error=1&turma=".$_A['turma']."&disciplina=".$_A['disciplina'].""));
}

for ($x = 1 ;$x < 51;$x++){
    $z = "n_" . $x;
    $h[] = "n_" . $x;
    $y[] = (isset($_POST[$z])) ? 1: 0;
}

$sql = "INSERT INTO  " .$_A['turma'] . "_" . $_A['disciplina'] . "_pres (data, alias ,trimestre , " .  implode (', ' , $h) . ") VALUES ('" . $_A['data'] . "', '".$_A['alias']."','". $_A['trimestre'] ."', " . implode(', ', $y) . ")" ;
   // $sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com');";

if (mysqli_query($link, $sql)) {
    //echo "CHAMADA REALIZADA COM SUCESSO!!";
    header("Location: index.php");
}
else {
    die("Error: " . $sql . "<br>" . mysqli_error($link));
}

mysqli_close($link);

?>
