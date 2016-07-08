<?php
 //include("include_prof/error.php");
 //include_once("include/define.php");
 include_once(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
 include_once(constant("INCLUDE_PATH_FUNCOES"));
 $seguranca = new seguranca();
 $seguranca->protegePagina();

function gerar_html_avaliacao($turma,$disciplina){

$_A['turma'] = $turma;
$_A['disciplina'] = $disciplina;
$_A['link'] = conecta::_link();

$html  = "<html><body>
<table border=\"1\">

<tr><td></td>
";

$sql_alias = "SELECT `alias`,`valor` FROM `".$_A['turma']."_".$_A['disciplina']."_aval` WHERE `trimestre` = '".$_SESSION['trimestre']."' ORDER BY `data` ASC, `id` ASC ";
$_A['query'] = mysqli_query($_A['link'],$sql_alias);

if(!$_A['query']){die("Error".mysqli_error($_A['link']));}

while($array = mysqli_fetch_assoc($_A['query'])){
    $html  .= "<td>".$array['alias']." - Valor: ".$array['valor']."</td>";



}
$html  .= "</tr><tr><td>N°</td>";

$sql_data = "SELECT `data` FROM `".$_A['turma']."_".$_A['disciplina']."_aval` WHERE `trimestre` = '".$_SESSION['trimestre']."' ORDER BY `data` ASC, `id` ASC ";
$_A['query_data'] = mysqli_query($_A['link'],$sql_data);

if(!$_A['query_data']){die("Error".mysqli_error($_A['link']));}

while($array_data = mysqli_fetch_assoc($_A['query_data'])){

    $dia = separa_data($array_data['data'],"dia");
    $mes = separa_data($array_data['data'],"mes");
    $html  .= "<td>".$dia."-".$mes."</td>";



}
$html  .= "</tr>";

$sql_nomes = 'SELECT `id` ,`nome` FROM `' . $_A['turma'].'` WHERE `nome` = "" LIMIT 1';
$_A['query_nomes'] = mysqli_query($_A['link'],$sql_nomes);
$_qtd = mysqli_fetch_assoc($_A['query_nomes']);

for($x = 1; $x < $_qtd['id']; $x++){
    $numero = "n_".$x;
    $query = "query_".$x;
    $sql = "SELECT `n_".$x."` FROM `".$_A['turma']."_".$_A['disciplina']."_aval` WHERE `trimestre` = '".$_SESSION['trimestre']."' ORDER BY `data` ASC, `id` ASC ";
    $_A[$query] = mysqli_query($_A['link'],$sql);

    $html  .=  "<tr>";
    $html  .=  '<td>'.$x.'</td>';

    while($valor = mysqli_fetch_assoc($_A[$query])){
        $html  .= "<td>".$valor[$numero]."</td>";


    }

    $html  .= "</tr>";
}

    $html .= "</table></body></html>";
return $html;
}
?>
