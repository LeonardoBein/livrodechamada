<?php

//include("include_prof/error.php");
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
include(constant("INCLUDE_PATH_MPDF")); //Inclui a biblioteca do mpdf
include("gerar_html_pres.php");
$seguranca = new seguranca();
$seguranca->protegePagina();

$turma = $_GET['turma'];
$disciplina = $_GET['disciplina'];

$html = gerar_html_pres($turma,$disciplina);


$arquivo = "presenca-".$_SESSION['usuarioLogin']."-".$turma."-".$disciplina.".pdf";

$mpdf=new mPDF();
$mpdf->SetAuthor('leo');
$mpdf->SetTitle('Title');
$mpdf->SetCreator('livrodechamada');
$mpdf->WriteHTML($html);
$mpdf->Output($arquivo,'I');

/*
I mostra no navegador
D Download para o cliente

*/

?>
