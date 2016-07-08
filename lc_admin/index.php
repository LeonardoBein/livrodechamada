<?php
include("../classes/seguranca.php");
$seguranca = new seguranca();
$seguranca->protegePagina();
?>
<html>

    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<meta charset="utf-8">
          <title>Sistema Livro de Chamada Leoncio Correia</title>
      <link rel="stylesheet" type="text/css" href="../css/style-interno.css">
      <link rel="stylesheet" type="text/css" href="../css/style-header.css">
      <link rel="stylesheet" type="text/css" href="../css/root.css">
      <link rel="stylesheet" type="text/css" href="../css/geral.css">
	<script  type="text/javascript" src="../js/acoes.js"></script>
	<script  type="text/javascript" src="../js/mask.js"></script>
	<script  type="text/javascript" src="../js/jquery-2.1.4.js"></script>
	

    </head>

    <body>
      <?php include("include/header.php");?>
      
		<div class="menu">
			<a href="data_trimentre.php" class="button_menu" >Data trimentres</a>
			<a href="user.php" class="button_menu">Usuarios</a>
		</div>
      <div id="loader" style="display: none;" >Carregando...</div>
      
      <div id="conteudo"></div>
    </body>

</html>

<script>
	$(document).ready(function(){
		$(".button_menu").click(function(env){
			env.preventDefault();
			var href = $(this).attr("href");
			
			$.ajax({
			
				type: "POST",
				url: href,
				
				beforeSend: function(){
					
					$("#loader").show();
					
				},
				
				success: function(data){
					$("#loader").hide();
					$("#conteudo").html(data);
					
				}
				
			});
		});
		
		
		
	});



</script>

