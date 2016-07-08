<?php
include("../classes/seguranca.php"); // Inclui o arquivo com o sistema de coneccao

$seguranca = new seguranca();


$codigo = CODE_LOGIN;
$codigo_rec = $_POST["codigo"];
$nome = $_POST['nome'];
$usuario = (isset($_POST['usuario'])) ? ($seguranca->trata_var($_POST['usuario'])) : null ;
$email = (isset($_POST['e-mail'])) ? ($seguranca->trata_var($_POST['e-mail'])) : null;
$senha = (isset($_POST['senha'])) ? (bcrypt::hash($_POST['senha'], mt_rand(4,13))) : null;
$uid = uniqid( rand( ), true );
$data = time();
$valida = 0;
$dominio = DOMINIO;
$emailsender = MAIL_SENDER;
$assunto_email = "Confirma Cadastro";
$quebra_linha = "\n";
$emailResposta = MAIL_RESPOSTA; //email para caso de resposta


if ((empty($_POST['nome'])) || (empty($_POST['usuario'])) || (empty($_POST['e-mail'])) || (empty($_POST['senha'])) || (empty($_POST["codigo"])) ){
    die("null");


}




if ($codigo === $codigo_rec){
    //connection

    $conc = new conecta();
    $tipo = $conc->install_table();

    $sql_valida = "SELECT `usuario`,`email`, `uid` FROM `tb_usuario` WHERE `usuario` = '".$usuario."' OR `email` = '".$email."'";
    $query_valida = $conc->query($sql_valida);
    if(($query_valida->rowCount()) > 0){
        die("userfalse");

    }
    else{

        $sql = "INSERT INTO `tb_usuario`(`nome`, `usuario`, `email`, `senha`,`tipo`,`uid`,`data`,`ativo`) VALUES ('$nome','$usuario','$email','$senha','$tipo','$uid','$data','$valida')";

    $x = $conc->query($sql);



    // preparando a validacao por email
    $id = $conc->lastInsertId();

    $url = sprintf("id=%s&email=%s&uid=%s&key=%s", $id , md5($email) , md5($uid), md5($data));

    $mensagem = "Olá " . $nome . ".".$quebra_linha." Este e-mail foi enviado em resposta ao pedido de novo cadastro do Sistema de Livro de chamada do Colégio Estadual Leoncio Correia.".$quebra_linha."Para validar sua conta acesse o link abaixo: \n";
    $mensagem .= sprintf("http://%s/login/ativa.php?%s",$dominio,$url);

    //enviando por email


    $headers = "MIME-Version: 1.1".$quebra_linha;
    $headers .= "Content-type: text/plain; charset=iso-8859-1".$quebra_linha;
    $headers .= "From: ".$emailsender.$quebra_linha;
    //$headers .= "Return-Path: ".$emailsender.$quebra_linha;
    //$headers .= "Reply-To: ".$emailResposta.$quebra_linha;

    if(!mail($email,$assunto_email,$mensagem,$headers,"-r".$emailsender)){
        $headers .= "Return-Path: " . $emailsender . $quebra_linha;
        mail($email, $assunto_email, $mensagem, $headers );

    }



  echo "create";


}}
else{
 die("codigofalse");
}
?>
