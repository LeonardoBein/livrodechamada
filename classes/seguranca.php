<?php
require_once(dirname( __DIR__).'/config/main_inc.php');

if (DEBUG == true) {
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
}

date_default_timezone_set('America/Sao_Paulo');

require_once('conecta.php');
require_once(RAIZ.'include/function.php');
require_once('_function.php');
require_once('bcrypt.php');
require_once('matematica.php');
require_once('reports.php');
session_start();

class seguranca{

    public $paginaLogin = URL_PRINCIPAL;
    private $validaSempre = true ,$tabela = 'tb_usuario', $new_var, $connect = null;

    function __construct(){

        $this->connect = new conecta();
        return $this->connect;
    }

    //$password     password user
    //$type         metodo utiliza
    public function encryptPassword($password,$type = true){

        if($type == true){
          return bcrypt::hash($new_pass,mt_rand(4,14));
        }

        switch ($type) {
          case 'md5':
              if(function_exists('md5')){
                return md5($password);
              }
            break;
          case 'sha1':
            if (function_exists('sha1')){
              return sha1($password);
            }
            break;
          default:
            return $password;
            break;
        }
    }
/*
* trata a varia contar ataques sql injetion
*input variavel (optional type)
*return false caso falha ou a variavel tratada
*/
    public function trata_var($var,$type = false){

      $var = (isset($var)) ? $var : null ;

      if ($type == false && $var != null) {
        $condition = gettype($var);
      }
      elseif ($type != false && $var != null) {
        $condition = $type;
      }
      else {
        return $var;
      }

        switch ($condition) {
          case 'string': return addslashes($var); break;
          case 'integer': return (int) $var; break;
          case 'array':
                  foreach ($var as $key => $value) {
                    $new_var[$key] = addslashes($value);
                  }
                  return $new_var;
                  break;
          case 'array_int':
                  foreach ($var as $key => $value) {
                    $new_var[$key] = (int) $value;
                  }
                  return $new_var;
                  break;
          case 'array_float':
                  foreach ($var as $key => $value) {
                      $new_var[$key] = (float) $value;
                  }
                  return $new_var;
                  break;
          case 'float': return (float) $var; break;
          default:
            return false;
            break;
        }
      }
    public function id_user($user,$password,$text=false){
      $ip = getenv("REMOTE_ADDR");
      $browser = getenv("HTTP_USER_AGENT");
      $data = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
      $fusion = hash("sha256" ,md5($ip.$browser.$user.$password));
      if ($text == true) {
        return $fusion;
      }
      else {
        $array = array('id'       => bcrypt::hash($fusion,mt_rand(4,13)) ,
                       'status'   => array('ip'       => $ip ,
                                           'browser'  => $browser,
                                           'data'     => $data));

        return $array;
      }

    }


    public function validaUsuario($array){
        if (!is_array($array)) {
          die("Error in function 'validaUsuario', is not array");
        }
        $nusuario     = isset($array['usuario']) ? self::trata_var($array['usuario']) : null;
        $nsenha       = isset($array['senha']) ? self::trata_var($array['senha']) : null;
        $hash         = isset($array['hash']) ? $array['hash'] : null;
        $key          = isset($array['key']) ? self::trata_var($array['key']) : null;
        $banc         = $this->connect;


        if ($hash != null && $key != null) {
          $query = $banc->query("SELECT `id`, `usuario`,`nome`, `tipo`, `ativo`, `id_browser` FROM `".$this->tabela."` WHERE `uid`='".$key."' LIMIT 1");
          $assoc = $query->fetch(PDO::FETCH_ASSOC);

          $id_browser = unserialize($assoc['id_browser']);

          if (! is_array( $id_browser ) || $id_browser == null ) { return false; }
          else {
            $check = false;
            foreach ($id_browser['salve'] as $key1 => $value) {
              if (bcrypt::check($hash,$value['id'])) {
                $id_browser['salve'][$key1]['status']['data'] = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
                $check = true;
                break;
              }
            }
            if ($check == false) {
              foreach ($id_browser['limit'] as $key1 =>$value) {
                if (bcrypt::check($hash,$value['id'])) {
                  $id_browser['limit'][$key1]['status']['data'] = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
                  $check = true;
                  break;
                }
              }
            }
          }
          if ( ( $check == true ) && ( $assoc['ativo'] == true ) ) {
              $banc->query("UPDATE `tb_usuario` SET `id_browser`='".serialize($id_browser)."' WHERE `uid`='".$key."' LIMIT 1");
              $_SESSION['usuarioID']    = $assoc['id']; // Pega o valor da coluna 'id do registro encontrado
              $_SESSION['usuarioNome']  = $assoc['nome'];
              $_SESSION['usuarioTipo']  = $assoc['tipo'];
              $_SESSION['usuarioLogin'] = $assoc['usuario']; //user


              return true;
            }
            else { return false; }


        }
        elseif (($hash == null || $key == null) && $nusuario == null ){return false;  }

        // Monta uma consulta SQL (query) para procurar um usuário
        $sql = 'SELECT `id`, `nome`, `usuario`, `senha`,`tipo`, `ativo` FROM `'.$this->tabela.'` WHERE `usuario` = "'.$nusuario.'" LIMIT 1';


        $query = $banc->query($sql);
        $resultado = $query->fetch(PDO::FETCH_OBJ);
        // Verifica se encontrou algum registro
        if (!bcrypt::check($nsenha , $resultado->senha)) {return false;}

        if (empty($resultado)) {return false;}

        else if($resultado->ativo == 0){
            die(header("Location: ".$this->paginaLogin."/index.php?error=validanull"));
        }
        else {
            // Definimos dois valores na sessão com os dados do usuário
            $_SESSION['usuarioID']    = $resultado->id; // Pega o valor da coluna 'id do registro encontrado
            $_SESSION['usuarioNome']  = $resultado->nome;
            $_SESSION['usuarioTipo']  = $resultado->tipo;
            $_SESSION['usuarioLogin'] = $array['usuario'];

            return true;
        }
}

    public function protegePagina(){

        $registro_sessao = (isset($_SESSION['registro_atividade'])) ? $_SESSION['registro_atividade'] : null;
        $limit = (isset($_SESSION['time_limit'])) ? $_SESSION['time_limit'] : null ;

        /*time of user*/
        if($registro_sessao != null && $limit != null){
            $segundos = time() - $registro_sessao;
                if($segundos > $limit){
                    $banc         = $this->connect;
                    $sid          = $_SESSION['SID'];
                    $ssid         = $_SESSION['SSID'];
                    $query        = $banc->query("SELECT `id_browser` FROM `".$this->tabela."` WHERE `uid`='".$ssid."' LIMIT 1");
                    $assoc        = $query->fetch(PDO::FETCH_ASSOC);
                    $id_browser   = unserialize($assoc['id_browser']);

                    foreach ($id_browser['limit'] as $key => $value) {
                      if (bcrypt::check($hash,$value['id'])) {
                        break;
                      }
                    }
                    unset($id_browser['limit'][$key]);
                    unset($_SESSION);
                    $banc->query("UPDATE `tb_usuario` SET `id_browser`='".serialize($id_browser)."' WHERE `uid`='".self::trata_var($ssid)."' LIMIT 1");
                    die(header("Location: ".$this->paginaLogin."/?error=timelimit"));
                }
        else{
            $_SESSION['registro_atividade'] = time();
        }}
        /*   */

        if (!isset($_SESSION['usuarioID']) || !isset($_SESSION['usuarioNome'])) {

            $this->expulsaVisitante();
        }
        else {

        if ($this->validaSempre == true) {

          $sid = isset($_COOKIE['CookieSID'])? base64_decode($_COOKIE['CookieSID']) : $_SESSION['SID'];
          $ssid = isset($_COOKIE['CookieSSID']) ? base64_decode($_COOKIE['CookieSSID']): $_SESSION['SSID'];
          $array = array('hash' => $sid ,'key' => $ssid);
      // Verifica se os dados salvos na sessão batem com os dados do banco de dados
      if (!self::validaUsuario($array)) {
             $this->expulsaVisitante();
      }
      return true;
    }
  }
}

    public function expulsaVisitante(){

  // Remove as variáveis da sessão (caso elas existam)

  unset($_SESSION);
  $expira = time() - 3600;
  setCookie('CookieSID',"",$expira,"/");
  setCookie('CookieSSID',"",$expira,"/");

  // Manda pra tela de login
  die(header("Location: ".$this->paginaLogin."?error=login_invalido"));
}


    function saidaUsuario(){

        unset($_SESSION);
        $expira = time() - 3600;
        setCookie('CookieSID',"",$expira,"/");
        setCookie('CookieSSID',"",$expira,"/");


  die(header("Location: ".$this->paginaLogin."?msg=logout"));
}
    function __destruct(){
      $this->connect = null;

    }


}
?>
