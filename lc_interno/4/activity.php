<?php require("header.php"); ?>
<?php
$turma = $_G['class'];
$disciplina = $_G['discipline'];
$id = $_G['id'];
 ?>
<div id="conteudo">

<?php
$alunos = $connect->get_nomes($turma);

$sql = sprintf("SELECT `id`,`valor`,`tipo`, `n_%s`
              FROM `%s_%s_aval`
              WHERE `alias`= '%s' and `hidden`='0' LIMIT 1", implode("`, `n_",$alunos['number'] ),$turma,$disciplina,$id);

$query = $connect->query($sql);
$nota = $query->fetch(PDO::FETCH_ASSOC);

if ($nota['id'] == null) {
  die("<h1>Não encontrado: '".$id."'</h1></div>");
}

$tipo = array(
  'prova'         => 'Prova' ,
  'atividade'     => 'Atividade' ,
  'rec_prova'     => 'Recuperaçao De Prova' ,
  'rec_atividade' => 'Recuperaçao De Atividade');

foreach ($tipo as $key => $value) {
  if ($nota['tipo'] == $key) {
    $nota['tipo'] = $value;
  }
}
 ?>
  <div id="meio" class="avaliacao">
    <form>
      <table>
        <input type="hidden" value="<?=$turma ?>" name="turma">
        <input type="hidden" value="<?=$disciplina ?>" name="disciplina">
        <input type="hidden" name="id" value="<?=$nota['id']; ?>">
      <tr>
        <td><?php echo $nota['tipo'].": ".$id; ?></td>
        <td>Valor: <?php echo $nota['valor']; ?></td>
        <td><button name="excluir" class="button red" value="<?=$id ?>">Excluir</button></td>


      <tr>
        <td>Numero</td>
        <td>Nomes</td>
      </tr>
<?php

foreach ($alunos['name'] as $key => $value) {
  $x = 'n_'.$alunos['number'][$key];
  $print = sprintf('
      <tr>
          <td>%d</td>
          <td>%s</td>
          <td>
            <input type="text" name="n_[]" value="'.$nota[$x].'" onkeypress="mascara(this,nota);" onblur="limita_value(this,\''.$nota['valor'].'\');" maxlength="4">
          </td>
      </tr>',$alunos['number'][$key],$value );
    echo $print;
}
 ?>
      </table>
      <input class='button blue' type="submit" value="Salvar">
    </form>
  </div>
</div>


<?php require("rodape.php"); ?>
