<?php
$turma        = $_G['class'];
$disciplina   = $_G['discipline'];
$alias        = $seguranca->trata_var($_POST['alias']);
$data         = $seguranca->trata_var(formata_data($_POST['data']));
$valor        = isset($_POST['valor']) ? $seguranca->trata_var($_POST['valor'],'float') : null;
$relacao      = isset($_POST['relacao'])? $seguranca->trata_var($_POST['relacao'],'array_int'): null;
$tipo         = $seguranca->trata_var($_POST['tipo']);
?>


<?php

if ($tipo == null || $alias == null || $data == null) {
  die("data_empty");
}

/*
method reuperação
*/

if (preg_match("/rec/",$tipo) && $relacao != null) {

  $sql = sprintf("SELECT SUM(valor) as soma
                  from `%s_%s_aval`
                  where `id`='%s'",
                  $turma,$disciplina,
                  implode("' or `id`='",$relacao));

  $query = $connect->query($sql);
  $soma = $query->fetch(PDO::FETCH_ASSOC);
  $relacao_sql = serialize($relacao);

  $sql = sprintf("INSERT INTO `#_@_aval`
  (
      `data`,
      `trimestre`,
      `alias`,
      `tipo`,
      `valor`,
      `relacao_rec`,
      `hidden`) SELECT * FROM (SELECT

      '%s',
      '%d',
      '%s',
      '%s',
      '%f',
      '%s',
      '0'
  ) as tmp
  WHERE NOT EXISTS(
    SELECT `alias` FROM `#_@_aval` WHERE `alias`='%s' and `hidden`='0' and `trimestre`='%d'
  ) LIMIT 1
  ",  $data,
      $_SESSION['trimestre'],
      $alias,
      $tipo,
      $soma['soma'],
      $relacao_sql,
      $alias,
      $_SESSION['trimestre']);
  $sql = preg_replace('/#/',$turma,$sql);
  $sql = preg_replace('/@/',$disciplina,$sql);

    if (!$query = $connect->query($sql)) {
      $error = $connect->errorInfo();
      die(var_dump($error));

    }
    if (!$query->rowCount()) {
      die("name_exists");
    }
    echo "success";


}
/*--------------*/
/*method prova/atividade*/
elseif(preg_match("/prova|atividade/",$tipo) && $valor != null) {

  $sql = sprintf("INSERT INTO `#_@_aval`
  (
    `data`,
    `trimestre`,
    `alias`,
    `tipo`,
    `valor`,
    `hidden`
  ) SELECT * FROM
  (SELECT
    '%s',
    '%d',
    '%s',
    '%s',
    '%.2f',
    '0') as tmp
  WHERE NOT EXISTS
  (SELECT `alias` FROM `#_@_aval` WHERE `hidden`='0' and `trimestre`='%d' and `alias`='%s') and
  (SELECT round(ifnull(SUM(valor),0),2) as soma FROM `#_@_aval`
      WHERE `hidden`='0' and `trimestre`='%d' and (`tipo`='prova' or `tipo`='atividade'))+%.2f <= 10.00 LIMIT 1",
  $data,
  $_SESSION['trimestre'],
  $alias,
  $tipo,
  $valor,
  $_SESSION['trimestre'],
  $alias,
  $_SESSION['trimestre'],
  $valor);
  $sql = preg_replace('/#/',$turma,$sql);
  $sql = preg_replace('/@/',$disciplina,$sql);
  if (!$query = $connect->query($sql)) {
    $error = $connect->errorInfo();
    die(var_dump($error));

  }
  if (!$query->rowCount()) {
    die("error_limit");
  }
  echo "success";

}
/*------------------*/
else {
  die("error type is not exists");
}
 ?>
