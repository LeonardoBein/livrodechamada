<html>
    <head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta charset="utf-8">
		    <title>Alterar chamada</title>
		    <script type="text/javascript"  src="../../js/acoes.js"></script>
        <script type="text/javascript"  src="../../js/jquery-2.1.4.js"></script>
		    <link rel="stylesheet" type="text/css" href="../../css/style-interno.css"/>
	    	    <link rel="stylesheet" type="text/css" href="../../css/style-header.css">
		    <link rel="stylesheet" type="text/css" href="../../css/style-tabelas.css">
		    <link rel="stylesheet" type="text/css" href="../../css/geral.css">
        <script>
          $(document).ready(function(){
            $("#box_mess").click(function(){
              $(this).hide();

            });

          });

        </script>
	</head>

    <body>
<?php
include('include/error.php');
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
include(constant("INCLUDE_PATH_FUNCOES"));
include("include/header.php");
$seguranca = new seguranca();
$seguranca->protegePagina();
$msg = new msg();


$_A['turma'] = (isset($_REQUEST['turma'])) ? ($seguranca->trata_var($_REQUEST['turma'])) : null;
$_A['disciplina'] = (isset($_REQUEST['disciplina'])) ? ($seguranca->trata_var($_REQUEST['disciplina'])) : null;
$_A['mensagem'] = (isset($_GET['msg'])) ? ((string)$_GET['msg']) : null;
$_A['link'] = conecta::_link();
$_A['error'] = (isset($_GET['error'])) ? ((string)$_GET['error']) : null ;
if(($_A['turma'] == null) || ($_A['disciplina'] == null) ){die(header("Location: index.php"));}

if($_A['error'] != null)
    $msg->true_msg('error');
if ($_A['mensagem'] != null) {
  $msg->true_msg('msg');
}
$sql = "SELECT `id`,`data`,`alias` FROM `".$_A['turma']."_".$_A['disciplina']."_pres` WHERE `trimestre` = '".$_SESSION['trimestre']."' ORDER BY `data` ASC, `id` ASC ";
$_A['query'] = mysqli_query($_A['link'],$sql);

echo '<div id="conteudo"><div id="meio" class="alterachamada">';


switch($_A['mensagem']){
    case "1":
        $msg->mensagem("Salvo com sucesso");
        break;
    default:
        break;

}
switch($_A['error']){
    case "nullnome":
        $msg->mensagem("Aula sem conteudo");
        break;
    default:
        break;



}
$msg->_print();

if(!mysqli_num_rows($_A['query'])){
    die(header("Location: chamada.php?turma=".$_A['turma']."&disciplina=".$_A['disciplina'].""));

}

while($array = mysqli_fetch_assoc($_A['query'])){

    echo "<form id=\"".$array['id']."\" method=\"post\">

        <p>Conteúdo do dia ".des_formata_data($array['data']).":
        <input type=\"hidden\" name=\"alter\" value=\"1\"/>
        <input type=\"hidden\" name=\"turma\" value=\"".$_A['turma']."\"/>
        <input type=\"hidden\" name=\"disciplina\" value=\"".$_A['disciplina']."\"/>
        <input type=\"hidden\" name=\"id\" value=\"".$array['id']."\"/>
        <input name='alias' type='text' maxlength=\"150\" value='" . $array['alias'] . "' />
        <input type=\"submit\" value=\"Salvar\" onclick=\"acao_form(". $array['id'] .",'gravachamada.php');\"/>
        </form>";



}
echo "
<form method=\"post\" action=\"chamada.php\">
<input type=\"hidden\" name=\"turma\" value=\"".$_A['turma']."\"/>
<input type=\"hidden\" name=\"disciplina\" value=\"".$_A['disciplina']."\"/>
<input type=\"submit\" value=\"Criar Nova\"/>
</form></div></div>

";



?>
    </body>
    </html>
