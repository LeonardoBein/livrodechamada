<?php
include_once("classes/seguranca.php");
if ($install == false) {
	sleep(1);
	die(header("Location: install/"));
}

redirection_home();

$seguranca = new seguranca();

$sid = isset($_COOKIE['CookieSID'])? base64_decode($_COOKIE['CookieSID']) : null;
$ssid = isset($_COOKIE['CookieSSID']) ? base64_decode($_COOKIE['CookieSSID']): null;
$array = array('hash' => $sid ,'key' => $ssid);

if ($seguranca->validaUsuario($array) == true) {
	header("Location: ".get_url('lc_interno/index.php'));
}




 ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tela de Login - Sistema Livro de Chamada</title>
		<link rel="shortcut icon" href="icones/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/button.css">
				<?php not_javascript();?>
				<script type="text/javascript" src="js/password.js"></script>
				<script type="text/javascript" src="js/jquery-2.1.4.js"></script>
        <script>
        			$(document).ready(function(){
        				/*ajax cadastra*/

        				$("form[name='cadastra']").submit(function(event){
        					event.preventDefault();
        					var name 	= 	$("input[name='nome']").val();
        					var user 	= 	$("#usuario_cadastra").val();
        					var mail 	= 	$("input[name='e-mail']").val();
        					var senha = 	$("input[name='confirma_senha']").val();
        					var code 	= 	$("input[name='codigo']").val();

        					$.ajax({
        						type: "POST",
        						url: "login/cadastra.php",
        						data: {
        							'nome'		: name,
        							'usuario'	:	user,
        							'e-mail'	: mail,
        							'senha'		: senha,
        							'codigo'	: code},
        						beforeSend: function(){
        							$("#loader").show();
        						},
        						success: function(data){
        							$("#loader").hide();
											if (data == 'create') {
												alert("Criado com Sucesso!");
												location.reload();
											}
											if (data == 'codigofalse') {
												$("#resposta").html("CODIGO INVÁLIDO");
											}
											if (data == 'userfalse') {
												$("#resposta").html("USUARIO OU EMAIL JÁ CADASTRADOS");

											}
											if (data == 'null') {
												$("form[name='cadastra'] label").css("color","red");
												$("#resposta").html("PREENCHA OS DADOS OBRIGATÓRIO");
											}

        						}

        					});
        				});
        				/*end ajax*/
        				$("input[type!=submit]").focus(function(){
        					$(this).css("background-color", "#cccccc");

        				});
        				$("input[type!=submit]").blur(function(){
        					$(this).css("background-color","#ffffff");
        				});
								$("input[type='reset']").click(function(){
									$("#resposta, #pass-info").html("");
				          $("#progress-default").removeClass().addClass("progress-stop");
									$("form[name='cadastra'] input").css("border-color", "#cccccc");

								});
        		    var password1       = $(".box-cadastra input[name='senha']");
        				var password2       = $("input[name='confirma_senha']");
        				var passwordsInfo   = $("#pass-info");
        				var progress				= $("#progress-default");
        				passwordStrengthCheck(password1,password2,passwordsInfo,progress);

        				$("#box_mess").click(function(){
        					$(this).hide();
        				});

        				$("input[name='e-mail']").keyup(function(){
        					var $this = $(this);
        					if (/^[a-z0-9.]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i.test($this.val())) {
        		        $this.css("border-color", "#159134");
        		      }
        		      else {
        		      $this.css("border-color","red");
        		      }
        				});
								$("form[name='cadastra'] input[type!='password'][name!='codigo']").blur(function(){

									 	var $this = $(this);
										var href = $(this).attr("name");
    								var value = $(this).val();

										if (value == "" | value == null) {
											$this.css("border-color","red").die();
										}

										if (href == 'e-mail') {
											if (/^[a-z0-9.]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i.test(value)) {
												$this.css("border-color", "#159134");
											}
											else {
												$this.css("border-color","red").die();

											}
										}
    								$.ajax({
        								type: "POST",
        								url: "login/novo_cadastro.php",
								        data: href+"="+value,
												beforeSend: function(){
													$("#loader").show();
												},
												success: function(data){
													$("#loader").hide();
													if (data == 'false') {
														$this.css("border-color","red");
														$("#resposta").html(href.toUpperCase() + " JÁ CADASTRADO");
													}
													if (data == 'true') {
														$this.css("border-color", "#159134");
														$("#resposta").html("");
													}
												}

    								});
  							});
        		});
               	</script>
    		</head>
