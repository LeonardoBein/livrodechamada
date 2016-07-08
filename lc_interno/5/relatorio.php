<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Relatórios</title>
        <script type="text/javascript" src="../../js/acoes.js"></script>
        <link rel="stylesheet" type="text/css" href="../../css/style-interno.css"/>
        <link rel="stylesheet" type="text/css" href="../../css/style-header.css">
        <link rel="stylesheet" type="text/css" href="../../css/style-tabelas.css">
    </head>

    <body>
    <?php

include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
include("include/header.php");

$seguranca = new seguranca();
$seguranca->protegePagina();

$_A['turma'] = $_POST['turma'];
$_A['disciplina'] = $_POST['disciplina'];

echo "<div id=\"conteudo\"><div id=\"meio\" class=\"relatorio\"><form id=\"1\" method=\"post\">
    <input type=\"hidden\" name=\"turma\" value=\"".$_A['turma']."\">
    <input type=\"hidden\" name=\"disciplina\" value=\"".$_A['disciplina']."\">



    <table align=\"center\">
        <tr>
            <th>Chamada</th>
            <th>Avaliacao</th>
            <th>Canhoto</th>
        </tr>
        <tr>
            <td>
            <input  type=\"submit\" value=\"Imprimir\" onclick=\"acao_form_new_windows('gerar_pdf_pres.php?turma=".$_A['turma']."&disciplina=".$_A['disciplina']."','chamada');\"/>
            </td>
            <td>
            <input  type=\"submit\" value=\"Imprimir\" onclick=\"acao_form_new_windows('gerar_pdf_avaliacao.php?turma=".$_A['turma']."&disciplina=".$_A['disciplina']."','avaliacao');\"/>
            </td>
            <td>
            Imprimir
            </td>

        </tr>

    </table>
    </form></div></div>";






        ?>

    </body>
</html>
