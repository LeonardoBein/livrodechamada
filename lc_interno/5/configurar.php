<?php
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança



$seguranca = new seguranca();
$seguranca->protegePagina();

?>



<html>

    <head>
        <title>Configuração</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="../../js/acoes.js"></script>
        <link rel="stylesheet" type="text/css" href="../../css/style-interno.css">
        <link rel="stylesheet" type="text/css" href="../../css/style-header.css">
        <link rel="stylesheet" type="text/css" href="../../css/geral.css">
    </head>
    <body>
        <?php include("include/header.php");?>
        <div id="conteudo">
    <fieldset>
    <p>Configuração</p>
    <form method="post" action="salvar_conf.php">


        <p>Definir trimestre automatico:
<?php
echo "<select name=\"trimestre_auto\" onchange=\"mudar_estado_conf(this);\">";
            if ($_SESSION['trimestre_auto'] == 1) {
              echo "<option value=\"01\"selected>Sim</option>
                    <option value=\"0\">Não</option>";
                    $style = 'none';
            }
            else {
            echo "<option value=\"01\">Sim</option>
                  <option value=\"0\" selected>Não</option>";
                  $style = 'inline';
            }


echo "</select>";


?></p>
        <p id="p_tri" style="display: <?php echo $style;?>;">Trimestre à trabalhar: 1
          <input type="radio" name="trimestre" value="1" > 2
          <input type="radio" name="trimestre" value="2" > 3
          <input type="radio" name="trimestre" value="3" ></p>


<p><input type="submit" value="Salvar"></p>
    </form>
</fieldset>
<fieldset>
    <form method="post" action="../../login/reenviasenha.php">
      <input type="hidden" name="boolean" value="true">
      <p>Senha antiga: <input type="password" name="old"></p>
      <p>Nova senha: <input type="password" name="new" id="new"></p>
      <p>Confirma Senha: <input type="password" name="confirm" id="confirm" onkeyup="validasenha('new','confirm','senha','enviar');"></p>
      <p id="senha"></p>
      <p id="enviar" style="display: none"><input type="submit" value="Salva"></p>
    </form>
</fieldset>
</div>


    </body>




</html>
