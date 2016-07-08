<?php
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
$seguranca = new seguranca();
$seguranca->protegePagina();

$_A['prof'] = $_SESSION['usuarioLogin'];
$_A['trimestre'] = $_POST['trimestre'];
$_A['trimestre_auto'] = $_POST['trimestre_auto'];


if($_A['trimestre_auto'] == "01"){

        $_A['sql_tri'] = 'UPDATE `tb_usuario` SET `trimestre` = "0" WHERE `usuario` = "'.$_A['prof'].'"';
        $_A['link'] = conecta::_link();
        if(!mysqli_query($_A['link'], $_A['sql_tri'])){die("Error: ".mysqli_error($_A['link']));}



}
elseif(($_A['trimestre'] > "0") && ($_A['trimestre'] < "4")){

    $_A['sql'] = 'UPDATE `tb_usuario` SET `trimestre` = "'.$_A['trimestre'].'" WHERE `usuario` = "'.$_A['prof'].'"';
    $_A['link'] = conecta::_link();
    if(!mysqli_query($_A['link'], $_A['sql'])){die("Error: ".mysqli_error($_A['link']));}


}
header("Location: index.php");
