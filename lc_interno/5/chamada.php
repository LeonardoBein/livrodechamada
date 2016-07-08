<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CHAMADA</title>
<meta charset="utf-8">
        <script type="text/javascript" src="../../js/acoes.js"></script>
        <script type="text/javascript" src="../../js/mask.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../css/style-interno.css">
        <link rel="stylesheet" type="text/css" href="../../css/style-header.css">
	<link rel="stylesheet" type="text/css" href="../../css/style-tabelas.css">
	<link rel="stylesheet" type="text/css" href="../../css/geral.css">
	<link rel="stylesheet" type="text/css" href="../../css/chamada.css">
    </head>

<body>


<?php
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
include("include/header.php");
echo '<div id="conteudo"><div id="meio" class="chamada">';
$seguranca = new seguranca();
$seguranca->protegePagina();


$data = date("d/m/Y");
$turma = $_REQUEST["turma"];
$disc = $_REQUEST["disciplina"];
$error = (isset($_GET['error'])) ? $_GET['error'] : null;


switch($error){
    case "1":
        echo "Por favor insira o conteudo da aula!</br>";
    default:

}

if((empty($turma)) || (empty($disc))){
    die(header("Location: index.php"));

}
echo "Chamada da turma: " . $turma . ",   da disciplina de: " . $disc . "</BR>";

//$chamada = "SELECT  FROM  `" . $prof . "_" . $turma . "_" . $disc . "_pres`";
//$nome = "SELECT id, nome FROM " . $turma;
$link = conecta::_link();


    $aulas = "Select data FROM  `" . $turma . "_" . $disc . "_pres`";
if($totalaulas = mysqli_query($link,$aulas)){
    $somaaulas = mysqli_num_rows($totalaulas);
    echo '<p class="total">TOTAL DE AULAS DADAS:  ' . $somaaulas . '</p>';
}

    echo '
    <form method="post" action="gravachamada.php">
<div id="conteudochamada">
    <p>Conteudo da aula: <input type="text" name="alias" maxlength="150"/></p>
<p>DIA:<input name="data" type="text"  maxlength="10" value="'.$data.'" onkeypress="mascara(this,is_date);"/></p><p>Trimestre: '.$_SESSION['trimestre'].'</p></div>
    <table align="center">

    <input type="hidden" name="turma" value="' . $turma . '"/>
    <input type="hidden" name="disciplina" value="' . $disc . '"/>
    <input type="hidden" name="trimestre" value="'.$_SESSION['trimestre'].'" />
  <tr>
    <th class="cabnumero" scope="row">N&uacute;mero</th>
    <td class="cabnome">Nome</td>
    <td class="cabchamada">CHAMADA</td>
    <td class="cabfaltas">Total Faltas </td>

  </tr>';
$x1 = 'SELECT `id` ,`nome` FROM `' . $turma.'` WHERE `nome` = "" LIMIT 1';
$x2 = mysqli_query($link,$x1);
$x3 = mysqli_fetch_assoc($x2);

if($x3['id'] == "1"){
    header("Location: alteranomes.php?errorsn=1&turma=".$turma);
    break;

}

for ( $x = 0 ; $x < $x3['id']; $x++){
   $sql = "SELECT `id`,`nome` FROM `" . $turma . "` WHERE `id`=" .$x;
   $sql2 = "SELECT ifnull(SUM(n_". $x . "),0) as soma FROM  `" . $turma . "_" . $disc . "_pres`";
  if($pres = mysqli_query($link,$sql2)){
    $totalpres = mysqli_fetch_array($pres);
    //echo "FALTAS" . $totalpres["soma"] . "</bR>";
   $totalpresenca = $somaaulas - $totalpres["soma"];
if ($result = mysqli_query($link,$sql)){
    $nome = mysqli_fetch_assoc($result);
   // echo $nome['id'] . $nome['nome'] . "</BR>";
     echo '<tr>
    <th class="numero" scope="row">'. $nome["id"] . '</th>
    <td class="nome">'. $nome["nome"] . '</td>
    <td class="check" tabindex="'. $nome["id"] . '"><input name="n_'.$nome["id"]. '" type="checkbox" value="off" tabindex="' . $nome["id"] . '"/></td>
     <td class="faltas">' . $totalpresenca . '</td>
  </tr>';
}
}
}





echo '</table><input type="submit" value="GRAVAR"></form>
<a href="index.php">VOLTAR</a>
';
mysqli_close($link);
?>
    </div></div>
    </body>
</html>
