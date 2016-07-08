<?php
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
$seguranca = new seguranca();
$seguranca->protegePagina();




//variaveis
$_A['prof'] = $_SESSION['usuarioLogin'];
$_A['tipo'] = (isset($_POST['tipo'])) ? ($seguranca->trata_var($_POST['tipo'], 'string')) : null;
$_A['turma'] = (isset($_POST['turma'])) ? ($seguranca->trata_var($_POST['turma'], 'string')) : null;
$_A['disciplina'] = (isset($_POST['disciplina'])) ? ($seguranca->trata_var($_POST['disciplina'], 'string')) : null;
$_A['alias'] = (isset($_POST['alias'])) ? ($seguranca->trata_var($_POST['alias'], 'string')) : null;
$_A['valor'] = (isset($_POST['valor'])) ? ($seguranca->trata_var($_POST['valor'],'float')) : null;
$_A['trimestre'] = (isset($_SESSION['trimestre'])) ? ($seguranca->trata_var($_SESSION['trimestre'], 'integer')): null;
$_A['data'] = $_A['data'] = sprintf("%s-%s-%s",substr($_POST["data"],6,9),substr($_POST["data"],3,-5),substr($_POST["data"],0,-8));
$_A['relacao_rec'] = (isset($_REQUEST['relacao_rec'])) ? ($seguranca->trata_var($_REQUEST['relacao_rec'], 'array')): null;
$_A['link'] = conecta::_link();

switch($_A['tipo']){
    case "prova":
        prova_atividade();
        break;
    case "atividade":
        prova_atividade();
        break;
    case "rec_prova":
        recuperacao();
        break;
    case "rec_atividade":
        recuperacao();
        break;
    default:
      break;



}





function recuperacao(){
    global $_A;
    //echo $_SESSION['usuarioLogin'].", ".$_A['turma'].", ".$_A['data'].", ".$_A['disciplina'].", ".$_A['alias'].", ".$_A['trimestre'].", ".$_A['tipo'];

    for ($i=0,$valor = 0; $i < count($_A['relacao_rec']) ; $i++) {

      $sql = "SELECT SUM(valor) as soma FROM `".$_A['turma']."_".$_A['disciplina']."_aval` WHERE `id`='". $_A['relacao_rec'][$i]. " '";
      $soma = mysqli_fetch_assoc(mysqli_query($_A['link'],$sql));
      $valor = $valor + $soma['soma'];
    }



if (!empty($_A['relacao_rec'])) {
    $relacao = serialize($_A['relacao_rec']);
    $sql = "INSERT INTO `".$_A['turma']."_".$_A['disciplina']."_aval` (`data`, `trimestre`, `alias`, `tipo`,`valor`, `relacao_rec`) VALUES ('".$_A['data']."', '".$_A['trimestre']."', '".$_A['alias']."', '".$_A['tipo']."','".$valor."','".$relacao."')";


    if(mysqli_query($_A['link'],$sql)){

    header("Location: escolha_ativ.php?turma=".$_A['turma']."&disciplina=".$_A['disciplina']."");
}
else {
    die("Error: " . $sql . "<br>" . mysqli_error($_A['link']));
}

}
}





function prova_atividade(){

global $_A;
$matematica = new matematica();

$sql_limit = "SELECT SUM(`valor`) as soma FROM `".$_A['turma']."_".$_A['disciplina']."_aval` WHERE `trimestre` =".$_A['trimestre']."  AND `tipo`= 'prova' OR `tipo`= 'atividade' ";

$sql = "INSERT INTO `".$_A['turma']."_".$_A['disciplina']."_aval` (`data`, `trimestre`, `alias`, `tipo`,`valor`) VALUES ('".$_A['data']."', '".$_A['trimestre']."', '".$_A['alias']."', '".$_A['tipo']."','".$_A['valor']."')";



//$sql = "INSERT INTO `3IB_ABC_aval` (`data`, `trimestre`, `alias`, `tipo`,`valor`) VALUES ('2015-08-13', '1', 'tet', 'prova', '5.25')";




$_A['query_limit'] = mysqli_query($_A['link'],$sql_limit);
$limit_ativ = mysqli_fetch_assoc($_A['query_limit']);

if($matematica->limite_avaliacoes( $limit_ativ['soma'] , $_A['valor'] ) == false) {
    die(header("Location: escolha_ativ.php?error=limit&turma=".$_A['turma']."&disciplina=".$_A['disciplina'].""));

}

if(mysqli_query($_A['link'],$sql)){

    echo "ok";
    header("Location: escolha_ativ.php?turma=".$_A['turma']."&disciplina=".$_A['disciplina']."");
}
else {
    die("Error: " . $sql . "<br>" . mysqli_error($_A['link']));
}


}








?>
