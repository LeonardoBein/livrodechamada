<?php
//include("include_prof/error.php");
include("include/define.php");
include("gerar_html_avaliacao.php");
include_once(constant("INCLUDE_PATH_SEGURANCA"));
include(constant("INCLUDE_PATH_MPDF")); //Inclui a biblioteca do mpdf
$seguranca = new seguranca();
$seguranca->protegePagina();

$turma = $_GET['turma'];
$disciplina = $_GET['disciplina'];

$html = gerar_html_avaliacao($turma,$disciplina);

$arquivo = "avaliacao-".$_SESSION['usuarioLogin']."-".$turma."-".$disciplina.".pdf";

$mpdf=new mPDF();
$mpdf->mirroMargins = true;
$mpdf->WriteHTML($html);
$mpdf->Output($arquivo,'I');

/*
I mostra no navegador
D Download para o cliente

*/

?>
