
<?php
include_once("include/define.php");
include_once(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
include_once(constant("INCLUDE_PATH_FUNCOES"));
$seguranca = new seguranca();
$seguranca->protegePagina();

function gerar_html_pres($turma,$disciplina){
$_A['link'] = conecta::_link();
$_A['turma'] = $turma;
$_A['disciplina'] = $disciplina;

$html = "<html>

<body>
<table border=\"1\">

        <tr><th>N°</th><th>data/mes</th></tr><tr><td></td>";

$sql = "SELECT `data` FROM `".$_A['turma']."_".$_A['disciplina']."_pres` WHERE `trimestre` = '".$_SESSION['trimestre']."' ORDER BY `data` ASC, `id` ASC ";
$_A['query'] = mysqli_query($_A['link'],$sql);

if(!$_A['query']){die("Error".mysqli_error($_A['link']));}

$sql_nomes = 'SELECT `id` ,`nome` FROM `' . $_A['turma'].'` WHERE `nome` = "" LIMIT 1';
$_A['query_nomes'] = mysqli_query($_A['link'],$sql_nomes);
$_qtd = mysqli_fetch_assoc($_A['query_nomes']);
while($assoc_data = mysqli_fetch_assoc($_A['query'])){

    $dia = separa_data($assoc_data['data'],"dia");
    $mes = separa_data($assoc_data['data'],"mes");
    $html .= '<td>'.$dia.'-'.$mes.'</td>';


}
$html .= "</tr>";

for($x = 1; $x < $_qtd['id']; $x++ ){
    $numero = "n_".$x;
    $query = "query".$x;
    $sql = "SELECT `n_".$x."` FROM `".$_A['turma']."_".$_A['disciplina']."_pres` WHERE `trimestre` = '".$_SESSION['trimestre']."' ORDER BY `data` ASC, `id` ASC ";
    $_A[$query] = mysqli_query($_A['link'],$sql);

    $html .= "<tr>";
    $html .= '<td>'.$x.'</td>';

    // Enquanto uma linha de dados existir, coloca esta linha em $assoc_valor como uma matriz associativa
    while($assoc_valor = mysqli_fetch_assoc($_A[$query])){
        if($assoc_valor[$numero] == "0"){
            $html .= '<td>F</td>';
        }
        if($assoc_valor[$numero] == "1"){
            $html .= '<td>C</td>';
        }



    }
    $html .= '</tr>';

}
$html .= "</table></body>
</html>";

return $html;
}


?>
