<?php
$turma = $_G['class'];
$disciplina = $_G['discipline'];
$id = $_G['id'];

/*action*/
if ($id != null) {
  $pdf = new report($id);
  $pdf->discipline_class($turma,$disciplina,$_SESSION['trimestre']);
  $pdf->create();
  die();
}
 ?>

<?php require("header.php"); ?>

<div id="conteudo">

<div class="reports"><h2>PDF</h2>
  <div class="action_report"><a href="atividade" target="_blank"><button class="button blue">Atividades</button></a></div>
  <div class="action_report"><a href="chamada" target="_blank"><button class="button blue">Chamada</button></a></div>
  <div class="action_report"><a href="canhoto" target="_blank"><button class="button blue">Canhoto</button></a></div>
</div>

</div>
<?php require("rodape.php"); ?>
