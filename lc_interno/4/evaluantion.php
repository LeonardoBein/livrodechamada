<?php require("header.php"); ?>

<?php
$turma = $_G['class'];
$disciplina = $_G['discipline'];
 ?>

<div id="conteudo">
  <input type="hidden" name="turma" value="<?=$turma ?>">
  <input type="hidden" name="disciplina" value="<?=$disciplina ?>">
<div class="menu">
</div>
<?php

$tipo = array(
  'prova'         => 'Prova' ,
  'atividade'     => 'Atividade' ,
  'rec_prova'     => 'Recuperaçao De Prova' ,
  'rec_atividade' => 'Recuperaçao De Atividade');

$sql_orig = sprintf("SELECT `id`,`alias`
            FROM `%s_%s_aval`
            WHERE `tipo`='#' and `trimestre`='%d' and `hidden`='0' ORDER BY `data` ASC, `id` ASC ",
            $turma,$disciplina,$_SESSION['trimestre']);

foreach ($tipo as $key => $value) {
  $sql[$key] = preg_replace('/\#/',$key,$sql_orig);
}


foreach ($sql as $key => $value) {
  $query = $connect->query($value);
  if ($query->rowCount() > 0) {
    $coluna = "";
    while ($list = $query->fetch(PDO::FETCH_ASSOC)) {

    $coluna .= '
    <li>
      <a>'.$list['alias'].'</a>
    </li>';

    }
    $return = sprintf("
    <h1 class='h1_ctl' env='#'>%s</h1>
    <div id='#' style='display: block;'>
      <nav class='ativ'>
      <ul>
        %s
      </ul>
    </nav>
    </div>
    ",$tipo[$key],$coluna);
  }
  else {
    $return = sprintf("
    <h1 class='h1_ctl' env='#'>%s</h1>
    <div id='#' style='display: none;'>
    Sem avaliação
    </div>
    ",$tipo[$key]);
  }
echo preg_replace('/#/',$key,$return);
}
 ?>


</div>
<?php require("rodape.php"); ?>
