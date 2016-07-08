<?php
require("header.php");


$alert = new msg();

//cache lembre-me
$login = (isset($_COOKIE['CookieLogin'])) ? base64_decode($_COOKIE['CookieLogin']) : '';
//$password = (isset($_COOKIE['CookiePassword'])) ? base64_decode($_COOKIE['CookiePassword']) : '';
$reminder = (isset($_COOKIE['CookieReminder'])) ? base64_decode($_COOKIE['CookieReminder']) : '';
$checked = ($reminder == 'YES') ? 'checked' : '';
//
 ?>
<body>

<?php

$error = (isset($_GET['error'])) ? ($_GET['error']) : null;
$mensagem = (isset($_GET['msg'])) ? ($_GET['msg']) : null;

if($error != null && $error != 'login_invalido')
    $alert->true_msg('error');
if($mensagem != null)
    $alert->true_msg('msg');



switch($error){
    case "login_invalido":
        echo "<script>
        $(document).ready(function()
        { $('#div_login').css('background','#fc4c4c');
        });
        </script>";
        break;
    case "timelimit":
        $alert->mensagem("Sem actividade há 5 minutos ou mais<br/> Por favor, faça o login novamente.");
        break;

    case "validanull":
        $alert->mensagem("Erro de ativação do usuario<br/>Por favor ative seu usuario pelo email");
        break;
    case "linkfalse":
        $alert->mensagem("O link nao é mais valido");
        break;
    default:
        break;


}
switch($mensagem){
    case "logout":
        $alert->mensagem("Obrigado por usar");
        break;
    case "create":
        $alert->mensagem("Seu cadastro foi Realizado com Sucesso<br/>Por favor ative sua conta atraves do email que enviamos a você");
        break;
    case "validatrue":
        $alert->mensagem("Seu cadastro foi validado com Sucesso");
        break;
    case "successpassword":
        $alert->mensagem("Sua senha foi alterado com Sucesso");
        break;
    case "enviado":
        $alert->mensagem("Acabamos de enviar um email para você sobre a alteração de Senha");
        break;
    default:
        break;



}

$alert->_print();
?>

<div id="cabecalho"></div>


<div id="loader" style="width: 100%; height: 100%; display: none; opacity: 0.8; z-index: 999;
position: absolute;
top: 0px;
left: 0px;
background-color: #000;" > </div>
<div class="box" id='div_login'>

<div id="conteudo">
  <h1><a href="<?php echo get_url();?>"><div class="logo"></div></a></h1>
    <form class="login_form" action="login/valida.php" method="post" name="login">
      <p>
        <label for="user_text">Usuário</br>
          <input type="text" id="user_text" name="usuario" maxlength="50" value="<?=$login?>" placeholder="Login" autofocus/>
        </label>
      </p>
      <p>
        <label for="password_text">Senha</br>
          <input class="campo" id="password_text" type="password" name="senha" maxlength="50" value="" placeholder="Password"/>
        </label>
      </p>

      <?php
      // include recaptcha
       if (RECAPTCHA == true) {
        echo sprintf('<div class="g-recaptcha" data-sitekey="%s"></div>
        <script src="https://www.google.com/recaptcha/api.js?hl=pt-BR"></script><br>',RECAPTCHA_site_key);
      }?>

      <p class="submit">
        <input type="submit" class="button blue" value="Entrar"/>
      </p>
      <p class="reminder">
        <label for="reminder">
          <input type="checkbox" id="reminder" name="reminder" value="YES" <?php echo $checked;?>> Continuar conectado
        </label>
      </p>
    </form>
</div>
<p style="text-align: center;"><a href="#Cadastra">Novo cadastro</a>
&nbsp;&nbsp;&nbsp;
<a class="option_login" href="#passwd">Esqueceu a senha?</a></p>
</div>
<div class='box box-color-green'>

<div id="limit-cadastra"  >
  <h1 id='Cadastra'>Começar agora mesmo!</h1>
	<form name="cadastra" class="login_form">
		<p id="resposta"></p>
		<label for="nome_cadastra">Nome [*]</label>
        <p class="box-cadastra" ><input id='nome_cadastra' class="obrigado" type="text" name="nome" maxlength="50"/></p>
    <label for="usuario_cadastra">Usuário [*]</label>
        <p class="box-cadastra" ><input id='usuario_cadastra' class="obrigado" type="text" name="usuario" maxlength="50"/></p>
    <label for="mail_cadastra">E-mail [*]</label>
        <p class="box-cadastra" ><input id='mail_cadastra' class="obrigado" type="text" name="e-mail" maxlength="50"/></p>
    <label for="password_cadastra">Senha [*]</label>
        <p class="box-cadastra"><input id='password_cadastra' type="password" name="senha" maxlength="50"/></p>
    <label for="confir_cadastra">Confirme a senha [*]</label>
        <p class="box-cadastra"><input id='confir_cadastra' type="password" name="confirma_senha" maxlength="50"/></p>
        <div id="limit-bar"><span id="pass-info"></span><div id="progress-default" class="progress-stop"> </div></div>
    <label for="codigo_cadastra">Código para cadastro [*]</label>
        <p class="box-cadastra"><input id='codigo_cadastra' type="text" name="codigo" maxlength="50" /></p>
    <input type="submit" name="entrar" class='button blue' value="Criar" />
  </form>

</div>
</div>

<div class="box">
  <div id="passwd">
  	<form class='login_form' method="post" name="new_senha" action="login/envia_senha.php">
  			<label>Redefinir sua senha</label>
  			<p>O Livro de Chamada vai enviar instruções de redefinição para o endereço de e-mail associado à sua conta.</p>
  			<p>E-mail: <input type="email" name="e-mail" maxlength="50"></p>
  			<p><input type="submit" value="Enviar"></p>




  	</form>
  </div>

</div>

<div id="background"></div>
<?php include("rodape.php");?>
