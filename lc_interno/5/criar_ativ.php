<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>Criar Atividade</title>
        <script type="text/javascript" src="js/main.js"></script>
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
$_A['data'] = date("d/m/Y");
$_A['mascara_data'] = "'##/##/####'";
$_A['mascara_valor'] = "'#.##'";

$_A['turma'] = (isset($_REQUEST['turma'])) ? ($seguranca->trata_var($_REQUEST['turma'])) : null;
$_A['disciplina'] = (isset($_REQUEST['disciplina'])) ? ($seguranca->trata_var($_REQUEST['disciplina'])) : null;
$_A['link'] = conecta::_link();


if((empty($_A['turma'])) || (empty($_A['disciplina']))){
    die(header("Location: index.php"));

}

echo '
<body><div id="conteudo"><div id="meio" class="criativ">
<p>Cadastro de Avaliações</p>
    <select onchange="Mudar_estado(this);">
        <option value="0" selected>- selecione um valor -</option>
        <option value="div_prova">Prova</option>
        <option value="div_avaliacao">Atividade</option>
        <option value="div_rec_prova">Recuperacao Prova</option>
        <option value="div_rec_avaliacao">Recuperacao Atividade</option>
    </select>
    <br><br>
<div id="div_prova" style="display: none;">
    <fieldset>
    <p>Prova</p>
<form id="form" name="form" method="post" action="grava_ativ.php">
    <input type="hidden" name="tipo" value="prova">
    <input type="hidden" name="turma" value="'.$_A['turma'].'">
    <input type="hidden" name="disciplina" value="'.$_A['disciplina'].'">

   <p>Nome da Prova: <input type="text" name="alias" ></p>
   <p>Valor da Prova: <input type="text" name="valor" maxlength="4" onkeypress="mascara(this,nota);"></p>
   <p>Data de Aplicação: <input type="text" name="data" value="'.$_A['data'].'" maxlength="10" onkeypress="mascara(this,is_date)"/></p>
   <p>Trimestre: '.$_SESSION['trimestre'].'</p>


    <input type="submit" value="Criar">
   </form>
</fieldset></div>
<div id="div_avaliacao" style="display: none;">
    <fieldset>
    <p>Avaliação</p>
    <form id="form" name="form" method="post" action="grava_ativ.php">
        <input type="hidden" name="tipo" value="atividade">
        <input type="hidden" name="turma" value="'.$_A['turma'].'">
        <input type="hidden" name="disciplina" value="'.$_A['disciplina'].'">

        <p>Nome da Atividade: <input type="text" name="alias"></p>
        <p>Valor da Atividade: <input type="text" name="valor" maxlength="4" onkeypress="mascara(this,nota);"></p>
        <p>Data de Aplicação: <input type="text" value="'.$_A['data'].'" name="data" maxlength="10" onkeypress="mascara(this,is_date);"></p>
        <p>Trimestre: '.$_SESSION['trimestre'].'</p>


    <input type="submit" value="Criar">
    </form>
</fieldset>
</div>
<div id="div_rec_prova" style="display: none;">
    <fieldset>
<form id="form" name="form" method="post" action="grava_ativ.php">
    <input type="hidden" name="tipo" value="rec_prova">
    <input type="hidden" name="turma" value="'.$_A['turma'].'">
    <input type="hidden" name="disciplina" value="'.$_A['disciplina'].'">

   <p>Recuperação da Prova: ';

    $search_prova = "SELECT `id`, `tipo`, `alias` FROM `".$_A['turma']. "_" .$_A['disciplina']. "_aval` WHERE `tipo`= 'prova'";
    $query_prova = mysqli_query($_A['link'],$search_prova);
    $numero_prova = mysqli_num_rows($query_prova);
if($numero_prova == false){
    echo '<select><option value="0" selected>- crie uma prova -</option></select>';
}
if($numero_prova > "0"){
    echo "
    <table>
    <tr>
        <th>Select</th>
        <th>Prova</th>
    </tr>";
    while ($array =  mysqli_fetch_assoc($query_prova)){

        echo '<tr>
            <th><input type="checkbox" name="relacao_rec[]" value="'.$array["id"].'"></th>
            <th>'.$array["alias"].'</th>
        </tr>';


    }
    echo "</table>";

}

echo '</p>
    <p>Nome da Recuperação: <input type="text" name="alias" ></p>
   <p>Data de Aplicação: <input type="text" value="'.$_A['data'].'" name="data" maxlength="10" onkeypress="mascara(this,is_date);"></p>
   <p>Trimestre: '.$_SESSION['trimestre'].'</p>
';

if($numero_prova > "0"){
    echo '<input type="submit" value="Criar">';
}


   echo '</form>
</fieldset>
</div>
<div id="div_rec_avaliacao" style="display: none;">
    <fieldset>
<form id="form" name="form" method="post" action="grava_ativ.php">
    <input type="hidden" name="tipo" value="rec_atividade">
    <input type="hidden" name="turma" value="'.$_A['turma'].'">
    <input type="hidden" name="disciplina" value="'.$_A['disciplina'].'">
   <p>Recuperação da Atividade: ';

    $search_avaliacao = "SELECT `id`, `tipo`, `alias` FROM `".$_A['turma']. "_" .$_A['disciplina']. "_aval` WHERE `tipo`= 'atividade'";
    $query_avaliacao = mysqli_query($_A['link'],$search_avaliacao);
    $numero_avaliacao = mysqli_num_rows($query_avaliacao);
if($numero_avaliacao == false){
    echo '<select><option value="0" selected>- crie uma atividade -</option></select>';
}
if($numero_avaliacao > "0"){
    echo "<table>
    <tr>
        <th>Select</th>
        <th>Atividade</th>
    </tr>";
    while ($array_a =  mysqli_fetch_assoc($query_avaliacao)){

        echo '<tr>
            <th><input type="checkbox" name="relacao_rec[]" value="'.$array_a["id"].'"></th>
            <th>'.$array_a["alias"].'</th>
        </tr>';
    }
    echo "</table>";
}

echo '</p>
    <p>Nome da Recuperação: <input type="text" name="alias" ></p>
   <p>Data de Aplicação: <input type="text" value="'.$_A['data'].'" name="data" maxlength="10" onkeypress="mascara(this,is_date);"></p>
   <p>Trimestre: '.$_SESSION['trimestre'].'</p>
';

if($numero_avaliacao > "0"){

echo '<input type="submit" value="Criar">';
}

echo '</form>
</fieldset>
    </div><p><a href="index.php">Voltar</a></p></div>

';





?>
        </div>
    </body>

</html>
