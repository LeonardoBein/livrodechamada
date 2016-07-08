<?php
$turma      = $_G['class'];
$disciplina = $_G['discipline'];
$atividade  = $seguranca->trata_var($_G['id']);
$nota       = $seguranca->trata_var($_POST['value'],'array_float');
$number     = $seguranca->trata_var($_POST['number'],'array_int');


if ($nota != null || $number != null) {


$sql = sprintf("SELECT `valor`
                FROM `%s_%s_aval`
                WHERE `hidden`='0' and `trimestre`='%d' and `alias`= '%s'",
                $turma,$disciplina,$_SESSION['trimestre'],$atividade);
$query = $connect->query($sql);
$valor = $query->fetch(PDO::FETCH_ASSOC);

  foreach ($nota as $key => $value) {
    if ($value > $valor['valor']) {
      $value = $valor['valor'];
    }
    $sql_set[] = sprintf(" `n_%d` = '%.2f' ",$number[$key],$value);
  }


  $sql = sprintf("UPDATE `%s_%s_aval`
                SET %s
                WHERE `hidden`='0' and `trimestre`='%d' and `alias`= '%s'",
              $turma,$disciplina,implode(',',$sql_set),$_SESSION['trimestre'],$atividade,$valor);
  if (!$query = $connect->query($sql)) {
    $error = $connect->errorInfo();
    echo $sql;
    die(var_dump($error));
  }
  echo "success";
}


 ?>
