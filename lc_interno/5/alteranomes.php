<html>
    <head>

        <title>Minha pagina</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../../css/style-interno.css">
        <link rel="stylesheet" type="text/css" href="../../css/style-header.css">
        <link rel="stylesheet" type="text/css" href="../../css/style-tabelas.css">
        <link rel="stylesheet" type="text/css" href="../../css/geral.css">
        <script type="text/javascript" src="../../js/acoes.js"></script>
        <script type="text/javascript" src="../../js/mask.js"></script>
    </head>
<body>
<?php
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
include("include/header.php");
$seguranca = new seguranca();
$seguranca->protegePagina();


$link = conecta::_link();


$turma = (isset($_REQUEST['turma'])) ? $_REQUEST['turma'] : null;

if($turma == null){

    die(header("Location: index.php"));

}



$consulta = "SELECT `id`, `nome` FROM `" . $turma . "`";
echo "<div id=\"conteudo\"><div id=\"meio\" class=\"nomes\">ALTERA&Ccedil&AtildeO OU INCLUS&AtildeO DE ALUNOS NA TURMA: " . $turma .".</BR></BR>";

$msg = new msg();

if (isset($_GET['error'])){
  $msg->true_msg('error');
  switch($_GET['error']){
      case "1":
        $msg->mensagem("Por favor insira os nomes dos alunos");
        break;
      default:
        $msg->mensagem("erro nao encontrado");
        break;
    }
}
$msg->_print();

echo '
      <form name="alunos" method="post" action="alter.php"><table class="nomes" align="center">
        <tr>
        <td>N&uacutemero</td>
        <td>Nome</td>
        </tr>';
$result = mysqli_query($link,$consulta);

if (mysqli_num_rows($result)>0){
    while ($lista = mysqli_fetch_assoc($result)){
        echo "<tr>
        <td align='center'><input name='id[]' type='hidden' value='" . $lista['id'] . "'/>".$lista['id']."</td>
            <td><input name='nome[]' tabindex='id[]' type='text' size='30' value='" . $lista['nome'] . "' onkeypress=\"mascara(this,nome)\"/></td>
            <tr>";
    }

}
else{echo "erro!!!!";}

echo "<tr align='center'><td colspan='2'><input type='submit' value='ALTERAR'><input type='hidden' name='turma' value='" . $turma . "'/>
    </td></tr></table><a href='index.php'>VOLTAR</a></form></div></div>";

mysqli_close($link);
?>
</body>
</html>
