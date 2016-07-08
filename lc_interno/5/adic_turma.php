<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script type="text/javascript" src="/livrodechamada/js/acoes.js"></script>


    </head>
    <body>

<?php
//include("include/error.php");
include("include/define.php");
include(constant("INCLUDE_PATH_SEGURANCA")); // Inclui o arquivo com o sistema de segurança
$seguranca = new seguranca();
$seguranca->protegePagina();


$turma = (isset($_POST['turma'])) ? ($seguranca->trata_var($_POST['turma'])) : null;
$disc = (isset($_POST['turma'])) ? ($seguranca->trata_var($_POST['disciplina'])) : null;
$prof = $_SESSION['usuarioLogin'];
$valores = range( 1 , 50 );

$link = conecta::_link();

//  Realiza se o from foi enviado em branco
if(($_POST['turma'] == "") || ($turma == null) || ($disc == null) || ($_POST['disciplina'] == "")){ die(header("Location: index.php?error=null"));}

    $sql_ava = sprintf("CREATE TABLE IF NOT EXISTS `" . $turma . "_" . $disc . "_aval`(`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,`data` DATE NOT NULL, `trimestre` INT(6) NOT NULL,`alias` varchar(60) NOT NULL,`tipo` varchar(13) NOT NULL, `valor` float ,`relacao_rec` varchar(700) NOT NULL ,`n_%s` float NOT NULL )", implode("` float NOT NULL, `n_", $valores));
    $sql_pre = sprintf("CREATE TABLE IF NOT EXISTS `" . $turma . "_" . $disc . "_pres`
(`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,`data` DATE NOT NULL,`alias` varchar(150),`trimestre` INT(6) NOT NULL,`n_%s` INTEGER(1) NOT NULL )",implode("` INTEGER(1) NOT NULL, `n_", $valores));
	$sql_turma = "CREATE TABLE IF NOT EXISTS `". $turma."` (`id` int(6) NOT NULL,`nome` varchar(30) NOT NULL, PRIMARY KEY (`id`))";
    $sql_turma_validar['codigo'] = "SELECT `usuario`, `disciplina`, `turma` FROM `relacao_prof_turma` WHERE `usuario` = '".$prof."' and `disciplina` = '".$disc."' and `turma` = '".$turma."'";
$sql_turma_validar['query'] = mysqli_query($link, $sql_turma_validar['codigo']);

if(mysqli_num_rows($sql_turma_validar['query']) > 0){
    die(header("Location: index.php?error=tbcriada"));
}

//Esta função retorna a sequência de leitura, ou FALSE em caso de falha.
if (mysqli_query($link, $sql_ava)) {

} else {die("Erro criando a tabela: " . mysqli_error($link));}

if (mysqli_query($link, $sql_pre)) {
    $prof_turma = ;
       if (mysqli_query($link, $prof_turma)){
           if (mysqli_query($link,$sql_turma)){
               $insere = sprintf("INSERT INTO `" . $turma . "`(`id`) VALUES (%s)", implode( '),(' , $valores ) );
               switch(mysqli_query($link, $insere)){
                   case 1:
                       $_link_bool = sprintf("alteranomes.php?errorsn=1&turma=%s", $turma );
                       echo 'Tabela Turma '. $turma .' Criada Com Sucesso!<br> Mas sem alunos cadastrados, Por favor insira<br><a href = "'.$_link_bool.'">INSERIR</a>';
                       break;;
                   case 0:
                       header("Location:  index.php");
                       break;;
                   default:
                       echo "Fatal error!!";;

               }

           }
        }
}

/*else {
    echo "Erro inserindo dados na tabela<br>" . mysqli_error($link);
    header("Refresh: 5, interno.php");
}*/

?>

    </body>
</html>
