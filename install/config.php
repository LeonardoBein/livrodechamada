<?php require("include/header.php");
echo dirname(__DIR__);


?>
<html>

<head>
    <meta charset="utf-8">
    <title>Configuracao</title>
    <script type="text/javascript" src="client.js"></script>
    <script type="text/javascript" src="../js/jquery-2.1.4.js"></script>
    <script>
    $(document).ready(function(){
      $("input[name='recaptcha']").click(function(){
          $("#recaptcha").toggle();

      });
    });
    </script>

</head>
<body>

<h1>Informe os dados</h1>
    <form method="post" action="install.php">
      <label>Configuracao do DB</label>
        <p>Servidor: <input type="text" value="localhost" name="host" onkeyup="evento_lower_case(this);" /></p>
        <p>Nome do Banco de dados: <input type="text" value="livrodechamada" name="bancDB" onkeyup="evento_lower_case(this);" /></p>
        <p>Usuario do Banco de Dados: <input type="text" value="root" name="userDB" onkeyup="evento_lower_case(this);" /></p>
        <p>Senha do Banco de Dados: <input type="text" name="passwordDB" value="root" /></p>
      <br><label>Configuracao de Dominio</label>
        <p>Site(caminho) : <input type="text" name="siteP" value="exemple.com" onkeyup="evento_lower_case(this);"></p>
        <p>email para cadastro dos usuarios: <input type="email" name="emailSender" /></p>
        <p>codigo de cadastro: <input type="text" name="code" value="code123"></p>
        <p>habilitar reCaptcha: <input type="checkbox" name="recaptcha"></p>
        <div id="recaptcha" style="display: none;">
            <p>key site: <input type="text" name="recaptcha_key_site"></p>
            <p>key secret: <input type="text" name="recaptcha_key_secret"></p>
        </div>
    <p><input type="submit" value="Continuar"></p>


    </form>


</body>



</html>
