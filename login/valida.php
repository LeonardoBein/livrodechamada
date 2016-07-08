<?php
// Inclui o arquivo com o sistema de segurança
require("../classes/seguranca.php");
$seguranca = new seguranca();

if (RECAPTCHA == true) {
  require_once(RAIZ."classes/recaptchalib.php");
  $secret_key = RECAPTCHA_secret_key;
  $response = null;
  $reCaptcha = new ReCaptcha($secret_key);
}


$tempo_limite = 300; //tempo limiti da sessao em segundos
$expira = time() + (60*60*24*30); // Cookie expira em 30 dias




// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //test ReCaptcha
  if (RECAPTCHA == true) {
    $response = $reCaptcha->verifyResponse(
          $_SERVER["REMOTE_ADDR"],
          $_POST["g-recaptcha-response"]
      );
    if ($response != null && $response->success) {
    }else {
      $seguranca->expulsaVisitante();
    }
  }
  // Salva duas variáveis com o que foi digitado no formulário
  // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
  $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
  $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
  $reminder = (isset($_POST['reminder'])) ? $_POST['reminder'] : '';
  // Utiliza uma função criada no seguranca.php pra validar os dados digitados
  //$x = new conecta();

$array = array('usuario' => $usuario ,'senha' => $senha );
if ($seguranca->validaUsuario($array) == true) {
      $link = new conecta();
      /*id*/
      $id_user = $seguranca->id_user($usuario,$senha);
      $sid = $seguranca->id_user($usuario,$senha,true);
      /*---*/
      $query = $link->query("SELECT `uid`,`id_browser` FROM `tb_usuario` WHERE `usuario`='".$seguranca->trata_var($usuario)."' LIMIT 1");
      $assoc = $query->fetch(PDO::FETCH_ASSOC);

      $browser = unserialize($assoc['id_browser']);

      //salve id_browser
      if ($reminder == 'YES') {
          if(!is_array($browser)){
            $browser = array('salve'  => array(0 => $id_user),
                             'limit' => array());
          }else {
            $more = true;
            foreach ($browser['salve'] as $value) {
              if (bcrypt::check($sid,$value['id'])) {
                $more = false;
                break;
              }
            }
          }
          if ($more == true) {
            $browser['salve'][] = $id_user;
          }

          setCookie('CookieSID', base64_encode($sid), $expira,"/");
          setCookie('CookieSSID', base64_encode($assoc['uid']) , $expira, "/");
          setCookie('CookieReminder', base64_encode('YES'), $expira,"/");
          setCookie('CookieLogin', base64_encode($usuario), $expira, "/");


        //setCookie('CookiePassword', base64_encode($senha), $expira, "/");
      }
      else {
        $array = 'limit';
        $expira = time() - 3600;

        if(!is_array($browser)){
          $browser = array('salve'  => array(),
                           'limit' => array(0 => $id_user));
        }else {
          $more = true;
          foreach ($browser['limit'] as $value) {
            if (bcrypt::check($sid,$value['id'])) {
              $more = false;
              break;
            }
          }
        }
        if ($more == true ) {
          $browser['limit'][] = $id_user;
        }

        setCookie('CookieReminder',"",$expira,"/");
        setCookie('CookieSID',"",$expira,"/");
        setCookie('CookieSSID',"",$expira,"/");
        setCookie('CookieLogin',"",$expira,"/");
        $_SESSION['SID'] = $sid;
        $_SESSION['SSID'] = $assoc['uid'];
        $_SESSION['registro_atividade'] = time();
        $_SESSION['time_limit'] = $tempo_limite;
      }
      $link->query("UPDATE `tb_usuario` SET `id_browser`='".serialize($browser)."' WHERE `usuario`='".$seguranca->trata_var($usuario)."' LIMIT 1");
      header("Location: ../lc_interno/index.php");
  } else{

    $seguranca->expulsaVisitante();
  }
}
