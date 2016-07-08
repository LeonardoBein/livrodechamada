<?php
include("../classes/seguranca.php");

$id = $_GET['id'];
$emailMd5 = $_GET['email'];
$uidMd5 = $_GET['uid'];
$dataMd5 = $_GET['key'];
$tabela_usuario = "tb_usuario";

if((empty($id)) || (empty($emailMd5)) || (empty($uidMd5)) || (empty($dataMd5))){
    die(header("Location: ../index.php?error=validanull"));


}

$link = new conecta();

$sql = "SELECT `email`,`uid`,`data` FROM `".$tabela_usuario."` WHERE `id` = '$id' LIMIT 1";
$sql_query = $link->query($sql);

$assoc = $sql_query->fetch(PDO::FETCH_ASSOC);


$valido = true;


if($emailMd5 !== md5($assoc['email']))
    $valido = false;

if($uidMd5 !== md5($assoc['uid']))
    $valido = false;

if($dataMd5 !== md5($assoc['data']))
    $valido = false;



if($valido === true){

    $sql = "UPDATE `".$tabela_usuario."` SET `ativo`='1' WHERE `id`='$id'";
    $sql_query = $link->query( $sql );
    header("Location: ../index.php?msg=validatrue");


}
else{
    die(header("Location: ../index.php?error=validanull"));


}


?>
