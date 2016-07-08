<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>Alteração de Atividade</title>
        <script type="text/javascript" src="../../js/acoes.js"></script>
        <script type="text/javascript" src="../../js/mask.js"></script>
        <link rel="stylesheet" type="text/css" href="../../css/style-interno.css">
        <link rel="stylesheet" type="text/css" href="../../css/style-header.css">
        <link rel="stylesheet" type="text/css" href="../../css/style-tabelas.css">
        <link rel="stylesheet" type="text/css" href="../../css/geral.css">
    </head>
    <body>

<?php
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
include("include/header.php");
$seguranca = new seguranca();
$seguranca->protegePagina();



//variaveis
$_A['turma'] = $_POST['turma'];
$_A['disciplina'] = $_POST['disciplina'];
$_A['prof'] = $_SESSION['usuarioLogin'];
$_A['id'] = $_POST['id'];


if((empty($_A['turma'])) || (empty($_A['disciplina'])) || (empty($_A['id']))){
    die(header("Location: index.php"));

}

$_A['link'] = conecta::_link();

$sql_nome = 'SELECT `id`, `nome` FROM `'.$_A['turma'].'` WHERE `nome` != ""';
$_A['query_nome'] = mysqli_query($_A['link'],$sql_nome);
if(($qtd = mysqli_num_rows($_A['query_nome'])) == 0){
    header("Location: alteranomes.php?errorsn=1&turma=".$_A['turma']);
    break;
}
$range = range(1,$qtd);


$sql_nota = sprintf("SELECT `id`,`alias`,`valor`, `n_%s` FROM `%s_%s_aval` WHERE `id` = '%s'", implode("`, `n_",$range),$_A['turma'],$_A['disciplina'],$_A['id']);
$_A['query_nota'] = mysqli_query($_A['link'],$sql_nota);
$lista_nota = mysqli_fetch_array($_A['query_nota'], MYSQL_NUM);

echo '<div id="conteudo"><div id="meio" class="avaliacao"><form method="post" action="gravaavaliacao.php"><table>
    <input type="hidden" value="'.$_A['turma'].'" name="turma">
    <input type="hidden" value="'.$_A['disciplina'].'" name="disciplina"><tr><td>Prova: '.$lista_nota[1].'</td><td>Valor: '.$lista_nota[2].'</td></tr>


    <tr><td>numero</td><td>nomes</td></tr>';


$x = 3;
while($lista_nome = mysqli_fetch_assoc($_A['query_nome'])){
    echo '
<tr>
    <td>'.$lista_nome['id'].'</td>
    <td>'.$lista_nome['nome'].'</td>
    <td>
        <input type="text" name="n_'.$lista_nome['id'].'"tabindex="'.$lista_nome['id'].'" value="'.$lista_nota[$x].'" onkeypress="mascara(this,nota);" onblur="limita_value(this,\''.$lista_nota[2].'\');" maxlength="4"></td>
</tr>';
    $x++;
}
echo '<input type="hidden" name="qtd" value="'.$qtd.'"><input type="hidden" name="id" value="'.$_A['id'].'"></table><input type="submit" value="Salvar"></form>

<a href="escolha_ativ.php?turma='.$_A['turma'].'&disciplina='.$_A['disciplina'].'">VOLTAR</a></div></div>

';


?>

         </body>

</html>
