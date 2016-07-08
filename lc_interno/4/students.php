<?php
require("header.php");
$turma = $_G['class'];
?>

<div id="conteudo">
  <div class="content content-right">
    more information
  </div>
  <div class="content content-left">
      <form name="alunos">
        <input type="hidden" name="turma" value="<?=$turma ?>">
          <div class="column-left">Nº</div>
          <div class="column-right">Nome</div>
<?php
$alunos = $connect->get_nomes($_G['class'],true);

foreach ($alunos['name'] as $key => $value) {
  echo "
    <div class=\"column-left\">
    ".$alunos['number'][$key]."
    </div>
    <div class=\"column-right\">
      <input name='nome[]' id=\"".$alunos['number'][$key]."\" type='text' size='30' value='".$value."' onkeypress=\"mascara(this,nome)\"/>
    </div>
    ";
}
?>
              <input type='submit' class="button blue" value='ALTERAR'>
              <input type='hidden' name='turma' value="<?=$turma ?>"/>


      </form>
    </div>
  </div>
<?php require("rodape.php"); ?>
