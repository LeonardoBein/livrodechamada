

<?php

echo '
	<div id="barra" >Olá '.$_SESSION['usuarioNome'].', Seja Bem-Vindo
    <input type="checkbox" id="control-nav" />
  <label for="control-nav" class="control-nav"></label>
  <label for="control-nav" class="control-nav-close"></label>

  <nav>
    <ul>
      <li>
        <a href="index.php"><img src="../icones/home.svg" border="0" width="25" height="25"/><h>INICIO</h></a>
      </li>
      <li>
        <a class="button_menu" href="configurar.php"><img src="../icones/config.png" border="0" width="25" height="25"/><h>CONFIGURAÇÃO</h></a>
      </li>
      <li>
        <a href="../include/saida.php"><img src="../icones/sair.png" border="0" width="25" height="25"/><h>SAIR</h></a>
      </li>
    </ul>
  </nav>
  </div>

';
?>
