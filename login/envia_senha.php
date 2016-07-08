  <?php

include('../classes/seguranca.php');
$seguranca = new seguranca();



$email = (isset($_POST['e-mail'])) ? ($seguranca->trata_var($_POST['e-mail'])) : null;
$data = time();
$uid = uniqid( rand( ), true );
$dominio = DOMINIO;
$emailsender = MAIL_SENDER;
$assunto_email = "Nova Senha";
$quebra_linha = "\n";


if($email == null){die(header("Location: ../index.php"));}


$link = new conecta();


$sql_select = "SELECT `id`,`nome`, `email` FROM `tb_usuario` WHERE `email` = '".$email."' LIMIT 1";

$query_select = $link->query($sql_select);


$assoc = $query_select->fetch(PDO::FETCH_ASSOC);

if(empty($assoc)){die(header("Location: ../index.php?error=false"));}


$sql_update = "UPDATE `tb_usuario` SET `data` = '".$data."', `uid` = '".$uid."' WHERE `id` = '".$assoc['id']."'";

if(!$link->query($sql_update)){
    die(header("Location ../index.php"));


}

$url = sprintf("id=%d&email=%s&uid=%s&key=%s",($assoc['id']*8), md5($email) , md5($uid) , $data);

$mensagem = "Olá ".$assoc['nome'].". \nEste e-mail foi enviado em resposta ao pedido de nova senha do Sistema de Livro de chamada do Colégio Estadual Leoncio Correia. \nPara criar uma nova senha acesse o link abaixo: \n";

$mensagem .= sprintf("http://%s/login/nova_senha.php?%s",$dominio,$url);



  $headers = "MIME-Version: 1.0".$quebra_linha;
  $headers .= "Content-type: text/plain; charset=iso-8859-1".$quebra_linha;
  $headers .= "From: ".$emailsender.$quebra_linha;
  //$headers .= "Return-Path: ".$emailsender.$quebra_linha;
  //$headers .= "Reply-To: ".$emailResposta.$quebra_linha;

  if(!mail($email,$assunto_email,$mensagem,$headers,"-r".$emailsender)){
        $headers .= "Return-Path: " . $emailsender . $quebra_linha;
        mail($email, $assunto_email, $mensagem, $headers );

  }

    header("Location: ../index.php?msg=enviado");

?>
