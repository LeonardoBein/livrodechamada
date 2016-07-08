<?php require ("header.php"); ?>
<div id="conteudo">
  <div id="meio" class="chamada">

<?php
$data = date("d/m/Y");
$turma = $_G["class"];
$disc = $_G["discipline"];
?>

<?php
$aulas = "Select `data` FROM  `" . $turma . "_" . $disc . "_pres`";

if($totalaulas = $connect->query($aulas)){
    $somaaulas = $totalaulas->rowCount();
    echo '<p class="total">TOTAL DE AULAS DADAS:  ' . $somaaulas . '</p>';
}
?>

    <form name='chamada'>
      <div id="conteudochamada">
        <p><input type="button" name="view_content" value="Ver todas aulas"> Conteudo da aula: <input type="text" name="alias" maxlength="150"/></p>
        <p>DIA:<input id="calendario" name="data" type="text"  maxlength="10" value="<?=$data ?>" onkeypress="mascara(this,is_date);"/></p>
        <p>Trimestre: <?php echo $_SESSION['trimestre']; ?></p>
        <p>Marcar todos: <input type="checkbox" value="off" name="all_presence"></p>
        <p id="resposta"></p>
      </div>

    <table align="center">

        <input type="hidden" name="turma" value="<?=$turma ?>"/>
        <input type="hidden" name="disciplina" value="<?=$disc ?>"/>
      <tr>
        <th class="cabnumero" scope="row">N&uacute;mero</th>
        <td class="cabnome">Nome</td>
        <td class="cabchamada">CHAMADA</td>
        <td class="cabfaltas">Total Faltas </td>
      </tr>

<?php
$sql = sprintf("SELECT `id`, `nome` FROM `%s` WHERE `nome`!='' ", $turma);
$query = $connect->query($sql);

if($query->rowCount() == 0){
    die('<tr><th>Sem alunos</th></tr>');

}
while ($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
  $sql = sprintf("SELECT ifnull(SUM(n_%s),0) as soma FROM `%s_%s_pres`",$fetch['id'],$turma,$disc);
  if ($query1 = $connect->query($sql)) {
    $totalpres = $query1->fetch(PDO::FETCH_ASSOC);
    $totalpresenca = $somaaulas - $totalpres["soma"];
  }

  echo '
      <tr>
        <th class="numero">'. $fetch["id"] . '</th>
        <td class="nome">'. $fetch["nome"] . '</td>
        <td class="check"><input name="n_[]" type="checkbox"/></td>
        <td class="faltas">' . $totalpresenca . '</td>
      </tr>';

}
?>




    </table>
    <input type="submit" value="GRAVAR">
  </form>
  </div>
  <div class="window" style="display: none;">
  <p class="close">[X] Fechar</p>
  <p id="content_resposta"></p>
  <div id='content'></div>
  </div>
  <div id="background" style="width: 100%; height: 100%; display: none; opacity: 0.8;"></div>
</div>
<?php require("rodape.php"); ?>
