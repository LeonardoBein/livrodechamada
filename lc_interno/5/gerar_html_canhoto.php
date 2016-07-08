<?php
//include("include_prof/error.php");
include_once("include_prof/define.php");
include_once(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
$seguranca = new seguranca();
$seguranca->protegePagina();


//function gerar_html_canhoto($turma,$disciplina){
$_A['link'] = conecta::_link();
$_A['turma'] = $_POST['turma'];
$_A['disciplina'] = $_POST['disciplina'];

echo $_A['turma']."-".$_A['disciplina'];

echo "<html>

<body>
<table border=\"1\">

        <tr><th>N°</th><th>data/mes</th></tr><tr><td></td>";





//}







?>
