<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
$seguranca = new seguranca();
$seguranca->protegePagina();


$disc = $_POST['disciplina'];
$turma = $_POST['turma'];
$id = $_POST['id'];

$link = conecta::_link();

$sql = "DELETE FROM `relacao_prof_turma` WHERE `id`=" . $id;
$sql2 = "DROP TABLE `" . $turma . "_" . $disc . "_aval`";
$sql3 = "DROP TABLE `" . $turma . "_" . $disc . "_pres`";
if (mysqli_query($link, $sql2)) {
    if(mysqli_query($link, $sql3)){
if (mysqli_query($link, $sql)) {
    //echo "TURMA APAGADA COM SUCESSO!!!!!";
    header("Location: index.php");
} else {
    die ("Error deleting record: " . mysqli_error($link));
}}}else{echo "error";}
mysqli_close($link);
?>
