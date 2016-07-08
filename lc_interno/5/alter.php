


<?php
/*Script para alterar os nomes dos alunos*/


include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
$seguranca = new seguranca();
$seguranca->protegePagina();


$turma = (isset($_POST['turma'])) ? ($seguranca->trata_var($_POST['turma'])) : null;
$id  = (isset($_POST['id'])) ? ($seguranca->trata_var($_POST['id'], 'array_int')) : null;
$nome  = (isset($_POST['nome'])) ? ($seguranca->trata_var($_POST['nome'])) : null;

$link = conecta::_link();


$limit = count($id);
for ($contagem = 0; $contagem < $limit; $contagem++) {
    //UPDATE  `u625913475_livro`.`3RHD` SET  `nome` =  'FABIO ZELAK' WHERE  `3RHD`.`id` =14;
    $insere = "UPDATE `" . $turma . "` SET `nome` = '" . $nome[$contagem] . "' WHERE `id`='" . $id[$contagem]."'";
    //UPDATE `3C` SET `id`=[value-1],`nome`=[value-2] WHERE 1
    if(!mysqli_query($link, $insere)){
        die("Erro ".mysqli_error($link));

    }
}

//echo '<br>Alunos cadastrados/alterados com sucesso!!!!';
header("Location: index.php");

mysqli_close($link);

?>
