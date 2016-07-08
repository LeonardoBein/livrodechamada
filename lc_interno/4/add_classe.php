<?php
$turma = $seguranca->trata_var($_G['class']);
$disciplina = $seguranca->trata_var($_G['discipline']);
$numbers = range(1,50);
if ($turma == "" | $disciplina == "") {
  die("var_null");
}

$sql = sprintf("SELECT
    IF(`turma`='%s' and `disciplina`='%s',true,false) as test
    FROM `relacao_prof_turma`",$turma,$disciplina);

  $query = $connect->query($sql);
  while ($test = $query->fetch(PDO::FETCH_ASSOC)) {
    if ($test['test'] == '1' ) {
      die("exists_class");
    }
  }

$sql = array(

'ava' => sprintf("CREATE TABLE IF NOT EXISTS `%s_%s_aval`
    (`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `data` DATE NOT NULL,
    `trimestre` INT(6) NOT NULL,
    `alias` varchar(60) NOT NULL,
    `tipo` varchar(13) NOT NULL,
    `valor` float ,
    `relacao_rec` varchar(700) NOT NULL ,
    `hidden` INT(1),
    `n_%s` float NOT NULL )DEFAULT CHARSET = Latin1 COLLATE = latin1_general_cs", $turma, $disciplina, implode("` float NOT NULL, `n_", $numbers)),

'pre' => array(
  'create' => sprintf("CREATE TABLE IF NOT EXISTS `%s_%s_pres`
      (`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `data` DATE NOT NULL,
      `alias` varchar(150),
      `trimestre` INT(6) NOT NULL,
      `n_%s` INTEGER(1) NOT NULL )
      DEFAULT CHARSET = Latin1 COLLATE = latin1_general_cs",
      $turma,$disciplina,implode("` INTEGER(1) NOT NULL, `n_", $numbers)),

  'insert'=> sprintf("INSERT INTO `%s`(`id`) VALUES (%s)", $turma, implode( '),(' , $numbers ) )),

'turma' => array(

  'create' => sprintf("CREATE TABLE IF NOT EXISTS `%s` (
    `id` int(6) NOT NULL PRIMARY KEY,
    `nome` varchar(30) NOT NULL ) DEFAULT CHARSET = Latin1 COLLATE = latin1_general_cs",$turma),

  'insert' => sprintf("INSERT INTO `%s` (`id`) VALUES (%s)", $turma, implode( '),(' ,range( 1 , 50) )
)),

'relacao' => sprintf("INSERT INTO `relacao_prof_turma`
  (`id`, `usuario`, `turma`, `disciplina`)
  VALUES
  ('','%s','%s','%s')", $_SESSION['usuarioLogin'],$turma,$disciplina)


   );


foreach ($sql as $key => $value1) {
  if (is_array($value1)) {
    foreach ($value1 as $value2) {
      if (!$connect->query($value2)) {
        $error = $connect->errorInfo();
        echo $error[2];
      }
    }
  }
  else {
    if (!$connect->query($value1)) {
      $error = $connect->errorInfo();
      echo $error[2];
    }
  }

}
echo "success";
