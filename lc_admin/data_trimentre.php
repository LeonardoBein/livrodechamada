<?php
include("../classes/seguranca.php");
$seguranca = new seguranca();
$seguranca->protegePagina();
?>

<?php


$link = conecta::_link();
$sql = "SELECT `trimestre1`, `trimestre2` ,`trimestre3` FROM `calendario` WHERE `id` = '1'";
$query = mysqli_query($link,$sql);
$assoc = mysqli_fetch_assoc($query);
$trimestre[] = unserialize($assoc['trimestre1']);
$trimestre[] = unserialize($assoc['trimestre2']);
$trimestre[] = unserialize($assoc['trimestre3']);

echo '<form>';
for($x = 1; $x <= 3 ;$x++){
            echo '


        <fieldset>

        <p>Comeco do '.$x.' trimestre:
            <input type="text" name="inicio[]" value="'.date("d/m/Y",$trimestre[($x - 1)][0]).'" maxlength="10" onkeypress="mascara(this,date);"/>
        </p>

        <p>Termino do '.$x.' trimestre:
        <input type="text" name="termino[]" value="'.date("d/m/Y",$trimestre[($x - 1)][1]).'" maxlength="10" onkeypress="mascara(this,date);"/>
        </p>

        </fieldset>
            ';
            }
echo '<p><input type="submit" value="salvar"></p></form>';



?>
<script>
	$(document).ready(function (){
		
		$( "form" ).submit(function(event){
			event.preventDefault();
			var inicio = new Array();
			var termino = new Array(); 
			$("input[name='inicio[]']").each(function(){
				inicio.push($(this).val());
			});
			$("input[name='termino[]']").each(function(){
				termino.push($(this).val());
			});
			$.ajax({
				type: "POST",
				url: "grava_calendario.php" ,
				data: {'inicio':inicio,'termino': termino},
				
				beforeSend: function(){
					$("#loader").show();
				},
				success: function(data){
					$("#loader").hide();
					if(data == "ok"){
						$(".button_menu[href='data_trimentre.php']").trigger('click');	
					}
					else{
						$("a[href='index.php']").trigger('click');
					}
					
				}	
				
			});
			
		});	
	});

</script>
