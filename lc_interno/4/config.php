<?php
$checked = ($_G['id'] == null)? 'checked':'';
$id = $_G['id'];

if ($id != null) {
  switch ($id) {
    case 'devices': $content = devices(); break;
    case 'del_devices': del_devices($_POST['device']); break;
    case 'about': $content = about(); break;
    default: error(404); break;
  }
}
 ?>


<?php require("header.php"); ?>
<div id="conteudo">
  <div id="menu_config">
    <div id="img">
      <img src="<?php echo get_url("icones/default_user.png")?>" height="100px" width="100px">
    </div>
    <div id="information">
      <p><?php echo ucwords($nome_user[0]).' '.ucwords($nome_user[1]) ?><br>Tipo: Professor<br>CELC</p>
      <label for="menu_config_input" class="menu_config_label"><span>Menu</span></label>
    </div>
    <input type="checkbox" id="menu_config_input" style="display: none;" <?=$checked ?>>
    <ul class="ul_config">
    <?php
    $option = array('Dispositivos' => 'devices','Senha' => 'password','Sobre' => 'about','Trimestre' => 'trimestre');

    foreach ($option as $key => $value) {
      echo "<li class=\"option_config\">
                  <a href=\"".$value."\">
                      <button class=\"button white left\">".$key."</button>

                  </a>
            </li>";
    }
    ?>
    </ul>
  </div>
  <div id="content"><p><?=$content ?></p></div>
</div>
<?php require("rodape.php"); ?>
