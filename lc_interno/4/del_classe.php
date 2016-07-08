<?php
$turma = $_G['class'];
$disciplina = $_G['discipline'];
$id = $seguranca->trata_var($_POST['id'], 'integer');

if ($id == "" || $turma == ""|| $disciplina == "") {
  die();
}

$sql = array(

'relacao'   => sprintf("DELETE FROM `relacao_prof_turma` WHERE `id`='%d'",$id),
'aval'      => sprintf("DROP TABLE `%s_%s_aval`", $turma,$disciplina),
'pre'       => sprintf("DROP TABLE `%s_%s_pres`", $turma,$disciplina)
);

foreach ($sql as $value) {
  if (!$error = $connect->query($value)) {
    $error = $connect->errorInfo();
    die($error[2]);
  }
}
echo "success";
 ?>
