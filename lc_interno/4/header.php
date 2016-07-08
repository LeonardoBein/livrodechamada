<?php
$home = "lc_interno/index.php/".$_G['class']."/".$_G['discipline'];
?>

<!DOCTYPE html>
<html>

    <head>

		<meta name="viewport" content="width=device-width">
		<meta charset="utf-8">
        <title><?php get_title($_G['action']); ?></title>
        <link rel="shortcut icon" href="<?php echo get_url('icones/favicon.ico') ?>" type="image/x-icon" />
        <?php not_javascript();?>

        <?php
        stylesheet(array( 'style-interno', 'style-header', 'geral','button','loader' , '4/'.$_G['action'] ));
        javascript(array( 'jquery-2.1.4', 'jquery-ui' ,'4/menu','mask' , '4/function', '4/'.$_G['action'] ));
        ?>

    </head>



    <body>

<header>

	<div id="barra" ><a href="<?php echo get_url($home); ?>"><div class="logo"></div></a>
    <input type="checkbox" id="control-nav" />
  <label for="control-nav" class="control-nav">
    <span class="menu1 round"></span>
    <span class="menu2 round"></span>
    <span class="menu3 round"></span>
  </label>
  <label for="control-nav" class="control-nav-close"></label>

  <nav id="nav_header">
    <?php
    /*------Menu list--------*/
    $nome_user = explode(" ",$_SESSION['usuarioNome']);
    $ul = array(
    'Home'        => get_url($home) ,
    'Avaliação'   => array(
                      'Criar'       => "cria_avaliacao" ,
                      'Avaliações'  => "avaliacao"),
    'Chamada'     => "chamada",
    'Turma'       => "alunos",
    'Relatório'   => "relatorio",
    ucwords($nome_user[0]) => array(
                                'Configuração' =>  "configuracao" ,
                                'Exit'   => get_url("include/logout.php")));

    echo create_list($ul);
    /*-------------------------*/
     ?>
  </nav>
</div>
<div id="status">
  <div id="trimestre" class="box">
    <?php echo $_SESSION['trimestre']; ?>&deg; Trimestre</div>
  <div id="turma" class="box">Turma: <?=$_G['class'] ?></div>
  <div id="disciplina" class="box">Disciplina: <?=$_G['discipline'] ?></div>
</div>
</header>
