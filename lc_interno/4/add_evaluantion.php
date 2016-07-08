<?php require ('header.php'); ?>

<?php
$turma = $_G['class'];
$disciplina = $_G['discipline'];
$data = date("d/m/Y");

$div = array(
          'Prova'                 => 'prova',
          'Atividade'             => 'atividade',
          'Recuperacao Prova'     => 'rec_prova',
          'Recuperacao Atividade' => 'rec_atividade');
 ?>
<input type="hidden" name="turma" value="<?=$turma ?>">
<input type="hidden" name="disciplina" value="<?=$disciplina ?>">
<div id="conteudo">
  <p>Cadastro de Avaliações</p>
  <p id="resposta"></p>
      <select>
          <option value="0" selected>- selecione um valor -</option>
          <?php
          foreach ($div as $key => $value) {
            echo sprintf("<option value='%s'>%s</option>",$value,$key);
          }
           ?>
      </select>

<?php

foreach ($div as $key => $value) {
  if (!preg_match('/rec/' , $value)) {
    $form = sprintf("

      <form id=\"@\" style=\"display: none;\">
        <p>#</p>
        <input type=\"hidden\" name=\"tipo\" value=\"@\">
        <p>Nome da #: <input type=\"text\" name=\"alias\" ></p>
        <p>Valor da #: <input type=\"text\" name=\"valor\" maxlength=\"4\" onkeypress=\"mascara(this,nota);\"></p>
        <p>Data de Aplicação: <input type=\"text\" name=\"data\" value=\"%s\" maxlength=\"10\" onkeypress=\"mascara(this,is_date)\"/></p>
        <p>Trimestre: %d</p>
        <input class=\"button blue\" type=\"submit\" value=\"Criar\">
      </form>
    ",$data,$_SESSION['trimestre']);
    $form = preg_replace('/#/',$key,$form);
    echo preg_replace('/@/',$value,$form);
  }
}


foreach ($div as $key => $value) {
  // Teste de avaliacoes criadoas.
  if (preg_match('/rec/',$value)) {
    preg_match('/rec_(\w+)/',$value,$array);
    $sql = sprintf("SELECT `id`, `alias`
                FROM `%s_%s_aval`
                WHERE `tipo`= '%s' and `trimestre`='%d' and `hidden`='0'", $turma,$disciplina,$array[1],$_SESSION['trimestre']);

    $query = $connect->query($sql);
    if ($query->rowCount() >  0 ) {
      $relacao = "<table>
      <tr>
          <th>Select</th>
          <th>".ucwords($array[1])."</th>
      </tr>";
      while ($list = $query->fetch(PDO::FETCH_ASSOC)) {
        $relacao .= "
        <tr>
            <th><input type=\"checkbox\" name=\"relacao_rec[]\" value=\"".$list["id"]."\"></th>
            <th>".$list["alias"]."</th>
        </tr>";
      }
      $relacao .= "
      </table>
      <p>Nome da Recuperação: <input type=\"text\" name=\"alias\" ></p>
      <p>Data de Aplicação: <input type=\"text\" value=\"".$data."\" name=\"data\" maxlength=\"10\" onkeypress=\"mascara(this,is_date);\"></p>
      <p>Trimestre: ".$_SESSION['trimestre']."</p>
      <input class=\"button blue\" type=\"submit\" value=\"Criar\">
      ";
    }
    else {
      $relacao = "Sem ".ucwords($array[1])." cadastrada.";
    }
    // End avaliacoes.
    //Create form Recuperacao
    $form = sprintf("
      <form id=\"@\" style=\"display: none;\">
        <p>#</p>
        <input type=\"hidden\" name=\"tipo\" value=\"@\">
        %s
      </form>

    ",$relacao);
    $form = preg_replace('/#/',$key,$form);
    echo preg_replace('/@/',$value,$form);
  }
}
?>
</div>
<?php require("rodape.php"); ?>
