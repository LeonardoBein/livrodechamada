<?php
include("../include/funcoes.php");
include("../classes/seguranca.php");
$seguranca = new seguranca();
$seguranca->protegePagina();

$Inicios = $_POST['inicio'];
$Terminos = $_POST['termino'];
foreach($Inicios as $inicio){
	$inicio_trimestre[] = $inicio;
}
foreach($Terminos as $termino){
	$final_trimestre[] = $termino;
}

$link = conecta::_link();
for($x = 0; $x < 3 ; $x++){
  $valor = serialize(insert_data(formata_data($inicio_trimestre[$x]), formata_data($final_trimestre[$x])));
  $sql = "UPDATE `calendario` SET `trimestre".($x + 1)."`='".$valor."' WHERE `id`= '1'";

  if(!mysqli_query($link,$sql)){
    die("error");
  }

}
echo "ok";
?>
