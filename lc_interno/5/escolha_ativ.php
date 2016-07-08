<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Escolher atividade</title>
    <script type="text/javascript" src="../../js/acoes.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/style-interno.css">
    <link rel="stylesheet" type="text/css" href="../../css/style-header.css">
        <link rel="stylesheet" type="text/css" href="../../css/style-tabelas.css">
         <link rel="stylesheet" type="text/css" href="../../css/geral.css">

</head>
<body>

<?php
include_once("include/define.php");
include_once(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
include("include/header.php");
$seguranca = new seguranca();
$seguranca->protegePagina();


echo '<div id="conteudo"><div id="meio" class="escolhativ">';

//variaveis
$_A['turma'] = (isset($_REQUEST['turma'])) ? ($seguranca->trata_var($_REQUEST['turma'])) : null;
$_A['disciplina'] = (isset($_REQUEST['disciplina'])) ? ($seguranca->trata_var($_REQUEST['disciplina'])) : null;
$_A['prof'] = $_SESSION['usuarioLogin'];
$_A['mensagem'] = (isset($_GET['msg'])) ? $_GET['msg'] : null;
$_A['link'] = conecta::_link();
$_A['error'] = (isset($_GET['error'])) ? $_GET['error'] : null;

if((empty($_A['turma'])) || (empty($_A['disciplina']))){
    die(header("Location: index.php"));

}

$sql_prova = sprintf("SELECT `id`,`alias` FROM `%s_%s_aval` WHERE `tipo` = 'prova'",$_A['turma'],$_A['disciplina']);
$sql_atividade = sprintf("SELECT `id`,`alias` FROM `%s_%s_aval` WHERE `tipo` = 'atividade'",$_A['turma'],$_A['disciplina']);
$sql_rec_prova = sprintf("SELECT `id`,`alias` FROM `%s_%s_aval` WHERE `tipo` = 'rec_prova'",$_A['turma'],$_A['disciplina']);
$sql_rec_atividade = sprintf("SELECT `id`,`alias` FROM `%s_%s_aval` WHERE `tipo` = 'rec_atividade'",$_A['turma'],$_A['disciplina']);

$_A['query_prova'] = mysqli_query($_A['link'],$sql_prova);
$_A['query_atividade'] = mysqli_query($_A['link'],$sql_atividade);
$_A['query_rec_prova'] = mysqli_query($_A['link'],$sql_rec_prova);
$_A['query_rec_atividade'] = mysqli_query($_A['link'],$sql_rec_atividade);

switch($_A['mensagem']){
    case "1":
        echo "<div class=\"msg\">Salvo com sucesso!</div>";

    default:
        break;
}
switch($_A['error']){
    case "limit":
        echo "<div class=\"error\">Limite de avaliacoes estourado (maior que 10 pontos)<br/>Por favor exclua</div>";
        break;
    default:
        break;



}

if((mysqli_num_rows($_A['query_prova']) == false) && (mysqli_num_rows($_A['query_atividade']) == false) && (mysqli_num_rows($_A['query_rec_prova']) == false) && (mysqli_num_rows($_A['query_rec_atividade']) == false)  ){
    header("Location: criar_ativ.php?a=1&turma=".$_A['turma']."&disciplina=".$_A['disciplina']."");
}





if(mysqli_num_rows($_A['query_prova'])){
    echo '<div id="div_prova" style="display: block;"><table>

        <tr><td>prova</td></tr>';


while($lista_prova = mysqli_fetch_assoc($_A['query_prova'])){
    echo '<form id="'.$lista_prova['id'].'" method="post" >
        <input name="turma" type="hidden" value ="' . $_A['turma'] . '">
        <input name="disciplina" type="hidden" value ="' . $_A['disciplina'] . '">
        <input name="id" type="hidden" value ="' . $lista_prova['id'] . '">
<tr>
    <td>'.$lista_prova['alias'].'</td>
    <td>
        <input type="submit" value="IR" onclick="acao_form('. $lista_prova['id'] . ',\'avaliacao.php\');" />
    </td>
    <td><input type="submit" value="X" onclick="acao_form_confirm('.$lista_prova['id'].',\'del_ativ.php\',\'Deseja excluir a prova '.$lista_prova['alias'].'?\');"</td>
</tr></form>';



}
}
echo '</table>';



if(mysqli_num_rows($_A['query_atividade'])){
    echo '<div id="div_prova" style="display: block;"><table border="1">

        <tr><td>atividade</td></tr>';


while($lista_atividade = mysqli_fetch_assoc($_A['query_atividade'])){
    echo '<form id="'.$lista_atividade['id'].'" method="post" >
        <input name="turma" type="hidden" value ="' . $_A['turma'] . '">
        <input name="disciplina" type="hidden" value ="' . $_A['disciplina'] . '">
<tr>
    <td>'.$lista_atividade['alias'].'</td>
    <td>
        <input type="submit" value="IR" onclick="acao_form('. $lista_atividade['id'] . ',\'avaliacao.php\');" /><input name="id" type="hidden" value ="' . $lista_atividade['id'] . '">
        <td><input type="submit" value="X" onclick="acao_form_confirm('.$lista_atividade['id'].',\'del_ativ.php\',\'Deseja excluir a atividade '.$lista_atividade['alias'].'?\');"</td>
    </td>
</tr></form>';



}
}
echo '</table>';


if(mysqli_num_rows($_A['query_rec_prova'])){
    echo '<div id="div_prova" style="display: block;"><table border="1">

        <tr><td>rcc prova</td></tr>';

while($lista_rec_prova = mysqli_fetch_assoc($_A['query_rec_prova'])){
    echo '<form id="'.$lista_rec_prova['id'].'" method="post" >
        <input name="turma" type="hidden" value ="' . $_A['turma'] . '">
        <input name="disciplina" type="hidden" value ="' . $_A['disciplina'] . '">
<tr>
    <td>'.$lista_rec_prova['alias'].'</td>
    <td>
        <input type="submit" value="IR" onclick="acao_form('. $lista_rec_prova['id'] . ',\'avaliacao.php\');" /><input name="id" type="hidden" value ="' . $lista_rec_prova['id'] . '">
        <td><input type="submit" value="X" onclick="acao_form_confirm('.$lista_rec_prova['id'].',\'del_ativ.php\',\'Deseja excluir a recuperacao '.$lista_rec_prova['alias'].'?\');"</td>
    </td>
</tr></form>';



}
}
echo '</table>';



if(mysqli_num_rows($_A['query_rec_atividade'])){
    echo '<div id="div_prova" style="display: block;"><table border="1">

        <tr><td>rec_atividade</td></tr>';


while($lista_rec_atividade = mysqli_fetch_assoc($_A['query_rec_atividade'])){
    echo '<form id="'.$lista_rec_atividade['id'].'" method="post" >
        <input name="turma" type="hidden" value ="' . $_A['turma'] . '">
        <input name="disciplina" type="hidden" value ="' . $_A['disciplina'] . '">
<tr>
    <td>'.$lista_rec_atividade['alias'].'</td>
    <td>
        <input type="submit" value="IR" onclick="acao_form('. $lista_rec_atividade['id'] . ',\'avaliacao.php\');" /><input name="id" type="hidden" value ="' . $lista_rec_atividade['id'] . '">
    </td>
    <td><input type="submit" value="X" onclick="acao_form_confirm(\''.$lista_rec_atividade['id'].'\',\'del_ativ.php\',\'Deseja excluir a recuperacao '.$lista_rec_atividade['alias'].'?\');"/></td>
</tr></form>';



}
}


echo '</table><form id="form_criar" method="post" action="criar_ativ.php">
        <input name="turma" type="hidden" value ="' . $_A['turma'] . '">
        <input name="disciplina" type="hidden" value ="' . $_A['disciplina'] . '"><input type="submit" value="Criar"></div></div>';
?>


</body>




</html>
