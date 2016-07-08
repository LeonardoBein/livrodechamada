<?php
$turma = $_G['class'];

$id = $seguranca->trata_var($_POST['id'],'array_int');
$name =  $seguranca->trata_var($_POST['nome']);

foreach ($name as $key => $value) {
  $sql = sprintf("UPDATE `%s` SET `nome`='%s' WHERE `id`='%d'",$turma,$value,$id[$key]);
  //echo $sql."</br>";
  if (!$connect->query($sql)) {
    $error = $connect->errorInfo();
    var_dump($error);
  }
}

echo "success";
 ?>
