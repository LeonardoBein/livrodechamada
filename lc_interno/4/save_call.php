<?php
$classe       =      $_G['class'];
$discipline   =      $_G['discipline'];
$presenca     =      isset($_POST['chamada'])? $_POST['chamada']: null;
$trimestre    =      $_SESSION['trimestre'];
$alias        =      $_POST['alias'];
$data         =      isset($_POST['data'])? formata_data($_POST['data']): null;
$alter        =      $seguranca->trata_var($_POST['alter'],'integer');
$id           =      $seguranca->trata_var($_POST['id'],'integer');
$number       =      $seguranca->trata_var($_POST['number']);



if ($alias == NULL || $alias == "") {
  die("null_alias");
}

if ($alter == 1) {
  $sql = sprintf("UPDATE `%s_%s_pres` SET `alias`='%s' WHERE `id`='%d' ",
                $classe,    $discipline ,         $alias,         $id );
}
else {
  foreach ($presenca as $key => $value) {
    $presenca[$key] = ($value == 'true') ? 1 : 0;
  }
  $sql = sprintf("INSERT INTO %s_%s_pres ( `data` , `alias` , `trimestre`, `n_%s`)
  VALUES (   '%s'    ,   '%s'  ,    '%s'     ,'%s')" , $classe,$discipline, implode('`, `n_', $number),
            $data   , $alias , $trimestre, implode("', '", $presenca));
}



if(!$connect->query($sql)){
  $error = $connect->errorInfo();
  die($error[2]);
}
echo "ok";

 ?>
