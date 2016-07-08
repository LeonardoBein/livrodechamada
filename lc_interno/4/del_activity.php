<?php
$turma        = $_G['class'];
$disciplina   = $_G['discipline'];
$atividade    = $_G['id'];

$sql = sprintf("UPDATE `%s_%s_aval`
  SET `hidden`='1'
  WHERE `alias` = '%s' and `trimestre`='%d' and `hidden`!='1'",
  $turma,$disciplina,$atividade,$_SESSION['trimestre']);

  if (!$query = $connect->query($sql)) {
    $error = $connect->errorInfo();
    die(var_dump($error));

  }
  if (!$query->rowCount()) {
    die("not_exists");
  }
  echo "success";
 ?>
