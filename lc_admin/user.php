<?php
include("../classes/seguranca.php");
$seguranca = new seguranca();
$seguranca->protegePagina();

$link = conecta::_link();

$sql = "SELECT `nome`, `ativo` FROM `tb_usuario` WHERE 1";

$query = mysqli_query($link, $sql);

echo "<table>
		<tr>
			<td>Usuario</td>
			<td>Ativo</td>
		</tr>";
while($user = mysqli_fetch_assoc($query)){
	$ativo = ($user['ativo'] == 1)? "checked": null;
	
	echo "
		<tr>
			<td>".$user['nome']."</td>
			<td><input type=\"checkbox\"".$ativo."></td>
		</tr>
	";
	
	
} 
echo "</table>";

?>
