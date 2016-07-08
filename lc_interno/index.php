<?php
require_once(dirname(__DIR__)."/classes/seguranca.php");
redirection_home();
define('PATH_LC_INTERNO' , RAIZ."lc_interno/");

$seguranca = new seguranca();
$seguranca->protegePagina();
$connect = new conecta();

$_A['usuarioTipo'] = $seguranca->trata_var($_SESSION['usuarioTipo'],'integer');

if($_A['usuarioTipo'] == "1"){

    die(header("Location: ../lc_admin/index.php"));


}

$_G = get_url_var();


switch($_A['usuarioTipo']){
    case "2":
        header("Location: 2/index.php");
        break;
    case "3":
        header("Location: 3/index.php");
        break;
    case "4":
        require (PATH_LC_INTERNO ."4/index.php");
        break;
    case "5":
        header("Location: 5/index.php");
        break;
    default:
        expulsaVisitante();
        break;

}



?>
