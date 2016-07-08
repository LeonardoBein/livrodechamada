<?php


function data_mktime($dia,$mes,$ano){

$data =  (date("z", mktime(0,0,0,$mes,$dia,$ano)) + 1);
return $data;
}
function formata_data($data){
    $data = isset($data)? $data: null;
    if ($data != null) {
      $dataF = sprintf("%s-%s-%s",substr($data,6,9),substr($data,3,-5),substr($data,0,-8));
      return $dataF;
    }
    else {
      return $data;
    }



}
//aaaa-mm-dd
function des_formata_data($data){

    $dataF = sprintf("%s/%s/%s",substr($data,8),substr($data,5,-3),substr($data,0,-6));
    return $dataF;


}

function insert_data($inicio,$termino){

    $inicioAno = substr($inicio,0,4);
    $inicioMes = substr($inicio,5,-3);
    $inicioDia = substr($inicio,8);

    $terminoAno = substr($termino,0,4);
    $terminoMes = substr($termino,5,-3);
    $terminoDia = substr($termino,8);

    $retorna_mktime[] = mktime(0,0,0,$inicioMes,$inicioDia,$inicioAno);
    $retorna_mktime[] = mktime(0,0,0,$terminoMes,$terminoDia,$terminoAno);
    return $retorna_mktime;


}


function separa_data($data,$tipo){

    switch($tipo){
        case "ano":
            $Ano = substr($data,0,4);
            return $Ano;
        case "dia":
            $Dia = substr($data,8);
            return $Dia;
        case "mes":
            $Mes = substr($data,5,-3);
            return $Mes;
        default:
            return false;



    }


}

/*
$data hoje = date("z",mktime(0,0,0,12,03,2015));
$array_data = unserialize($trimestre1Mysql);
return false ou true;
*/
function trimestre($data_hoje,$array_data){
    if( ($data_hoje >= date("z", $array_data[0])) && ($data_hoje <= date("z",$array_data[1]) )){
        return true;

    }
    else{return false;}

}

/*
The function of logout
*/
function LogOut(){
$seguranca = new seguranca();
$seguranca->saidaUsuario();

}
/*##############################
      Functions GET
################################*/
/*
Get class and discipline and action
*/
function get_url_var(){
  $seguranca = new seguranca();
  /*expressions*/
  $express1 = '/(?:index\.php)\/(\w+|)\/(\w+|)\/?(\w+|)\/?(.+|)/';

  $url = getenv('REQUEST_URI');

  if (preg_match($express1 , $url)) {
    preg_match($express1, $url, $array);
    $new_array = array(
      'class' => strtoupper($array[1]) ,
      'discipline' => strtoupper($array[2]),
      'action'=> strtolower($array[3]),
      'id' => transform_url_id($array[4]));
  }
  else {
    if (preg_match('/[index.php]|[lc_interno\/]/',$url)) {
      $new_array = array('action' => 'index','class' => '' ,'discipline' => '');
    }
  }
  if ($new_array['action'] == ""){
    $new_array['action'] = 'index';}
if (!guard_class($new_array['class'],$new_array['discipline'],$_SESSION['usuarioLogin'])) {
  if ($new_array['action'] != 'add_classes') {
    $new_array['action'] = '404';
    error(404);
  }
}

  return $seguranca->trata_var($new_array);
}

function get_url($ops=''){

  if ($ops != '') {
    return URL_PRINCIPAL."/".$ops;
  }
  else {
    return URL_PRINCIPAL;
  }
}

function get_title($title){

  if ($title == '404') {
    $title = 'Pagina nao encontrada';
  }
  $title = ($title != 'index') ? ucwords($title) : 'Livro de Chamada';
  echo $title;

}

function get_trimestre($user){
  $connect = new conecta();


  $consulta = "SELECT `nome`,`trimestre` FROM `tb_usuario` WHERE usuario = '" . $user . "'";

  $result = $connect->query($consulta);



  if($row = $result->fetch(PDO::FETCH_ASSOC)) {
  	if($row['trimestre'] == "0"){
          $_SESSION['trimestre_auto'] = 1;
          $sql_trimestre = "SELECT `trimestre1`,`trimestre2`,`trimestre3` FROM `calendario` WHERE `id` = '1' LIMIT 1";
          $querry = $connect->query($sql_trimestre);
          $assoc = $querry->fetch(PDO::FETCH_ASSOC);
          if (trimestre(date("z"), unserialize($assoc['trimestre1']))){
              $_SESSION['trimestre'] = "1";
          }
          elseif (trimestre(date("z"), unserialize($assoc['trimestre2']))){
              $_SESSION['trimestre'] = "2";
          }
          elseif (trimestre(date("z"), unserialize($assoc['trimestre3']))){
              $_SESSION['trimestre'] = "3";
          }
          else{
            die('Erro de identificação de trimestre. Entre em contato com o admin');}
      }
      else{
          $_SESSION['trimestre_auto'] = 0;
          $_SESSION['trimestre'] = $row['trimestre'];

      }

}
}
/*#########################
      End Functions GET
###########################*/


/*
The function create link for stylesheet
*/
function stylesheet($arr){
  $seguranca = new seguranca();
    foreach ($arr as $value) {
      $arquivo = RAIZ."css/".$value.".css";
      if ($seguranca->trata_var($value) != null) {
        if (file_exists($arquivo) && is_file($arquivo)) {
          echo '<link rel="stylesheet" type="text/css" href="'.get_url('css/'.$value.'.css').'" >';
        }
      }
    }
}
/*
The function create link for javascript
*/
function javascript($arr){
  $seguranca = new seguranca();
  foreach ($arr as $value) {
    $arquivo = RAIZ."js/".$value.".js";
    if ($seguranca->trata_var($value) != null) {
      if (file_exists($arquivo) && is_file($arquivo)) {
        echo '<script type="text/javascript" src="'.get_url('js/'.$value.'.js').'"></script>';
      }
    }
  }
}

/*
the function classes list in home
*/

function list_class($user){

$connect = new conecta();

$query = $connect->query("SELECT `id`, `turma`, `disciplina` FROM `relacao_prof_turma` WHERE usuario = '" . $user . "' ORDER BY turma ASC");

if ($query->rowCount() > 0) {
  while ($list = $query->fetch(PDO::FETCH_ASSOC)) {
    echo '
        <form class="form-tablet" id="'.$list['id'].'">
          <div class="coluna1" >' . $list["turma"] . '</div>
          <div class="coluna2">' . $list["disciplina"] . '</div>
          <div class="editar"><input type="button" class="button blue"value="Editar"></div>
          <div class="more-info">Em breve mais opcoes</div>
          <div class="apagar"><button type="button" name="apagar" value="'.$list['id'].'" class="button red">Excluir</button></div>
        </form>';
  }
}else {
  echo "Sem turmas cadastradas!!";
}
}

function path_way($level = 0){
    $path = dirname(__FILE__);
  for ($i=0; $i < $level ; $i++) {
    $path = dirname($path);
  }
  return $path;
}

/*
garante a integridade dos usuarios
*/
function guard_class($turma,$disciplina,$user){
  $connect = new conecta();
  $seguranca = new seguranca();

  $turma = $seguranca->trata_var($turma);
  $disciplina = $seguranca->trata_var($disciplina);
  $user = $seguranca->trata_var($user);

  if ($turma == false || $disciplina == false)
      return true;

  $sql = sprintf("SELECT
      IF(`turma`='%s' and `disciplina`='%s' and `usuario`!='%s',true,false) as test
      FROM `relacao_prof_turma`",$turma,$disciplina,$user);

    $query = $connect->query($sql);
    while ($test = $query->fetch(PDO::FETCH_ASSOC)) {
      if ($test['test'] == '1' ) {
        return false;
      }
    }
    $sql = sprintf("SELECT
        IF(`turma`='%s' and `disciplina`='%s' and `usuario`='%s',true,false) as test
        FROM `relacao_prof_turma`",$turma,$disciplina,$user);
    $query = $connect->query($sql);
    while ($test = $query->fetch(PDO::FETCH_ASSOC)) {
      if ($test['test'] == '1' ) {
        return true;
      }
    }
}
/*
create list ul/li and submenu
*/
function create_list($array){
$menu = "<ul class='menu clearfix'>";
foreach ($array as $key1 => $value1) {
  if (is_array($value1)) {
    $menu .= "
    <li>
      <a href='#'>".$key1."</a>
    <ul class='sub-menu clearfix'>";
    foreach ($value1 as $key2 => $value2) {
      if (is_array($value2)) {
        die("Error in function 'create_list', array limit");
      }
      $menu .= "<li><a href='".$value2."'>".$key2."</a></li>";
    }
    $menu .= "</ul></li>";
  }else {
    $menu .= "<li><a href=\"".$value1."\">".$key1."</a></li>";
  }
}
return $menu .= "</ul>";
}
/*Traduz a variavel id */
function transform_url_id($id,$type = false){
if ($type == false) {
 return preg_replace('/\+/',' ',$id);
}
elseif ($type == true) {
  return preg_replace('/\s/','+',$id);
}
else {
  return false;
}
}
/*-----------*/
/*
*The function 'redirection home' redirects to the default url
*/
function  redirection_home(){
  $protocolo = (getenv('HTTPS') == true )? 'https' : 'http' ;
  $host = getenv('HTTP_HOST');
  $uri = getenv('REQUEST_URI');
  $pattern = "/^".preg_replace('/\//','\/',get_url())."/";
  if (!preg_match($pattern,$protocolo.'://'.$host.$uri)) {
    header("Location: ".get_url());
  }
}
/*----------*/
function not_javascript(){
  echo '
  <noscript>
    <meta http-equiv="refresh" content="0; url='.get_url('error/no_javascript.html').'">
  </noscript>';
}
function version_system(){
  return VERSION;
}
function error($type = 404){

  switch ($type) {
    case 404: header("Location: ".URL_PRINCIPAL."/lc_interno/index.php///404") ; break;

    default:
      # code...
      break;
  }
}
/*-#####################
Functions for config.php
#######################
*/
function devices(){
  $connect =  new conecta();
  $sql = sprintf('SELECT `id_browser` FROM `tb_usuario` WHERE `usuario`="%s"',$_SESSION['usuarioLogin']);
  $query = $connect->query($sql);
  $browser = $query->fetch(PDO::FETCH_ASSOC);
  $browser = unserialize($browser['id_browser']);
foreach ($browser['salve'] as $key => $value) {
  $identify = get_browser($value['status']['browser']);
  $msg[] = sprintf("<td>%s (%s) no %s</td><td>%s</td><td>%s</td><td><button name=\"del_device\" class=\"button red\" value=\"%s\">Excluir</button></td>",
        $identify->browser,
        $identify->version,
        $identify->platform,
        $value['status']['ip'],
        date("d/m/Y h:i:s A",$value['status']['data']),
        $key);
}
return sprintf("
<table>
  <tbody>
    <tr>
      <td>Navegador</td><td>IP</td><td>Atividade mais recente</td>
    </tr>
    <tr>
      %s
    </tr>
  </tbody>
</table>",implode("</tr><tr>
",$msg));

}
/*
Delet devices authorized fur user
*/
function del_devices($key){
  $key = (int)$key;
  $connect =  new conecta();
  $sql = sprintf('SELECT `id_browser` FROM `tb_usuario` WHERE `usuario`="%s"',$_SESSION['usuarioLogin']);
  $query = $connect->query($sql);
  $browser = $query->fetch(PDO::FETCH_ASSOC);
  $id_browser = unserialize($browser['id_browser']);
  unset($id_browser['salve'][$key]);
  $connect->query("UPDATE `tb_usuario` SET `id_browser`='".serialize($id_browser)."' WHERE `usuario`='".$_SESSION['usuarioLogin']."' LIMIT 1");
  echo "success";
}
/*---*/
//*****
function password(){echo
  '<form method="post" action="'.get_url('login/change_pass.php').'">
    <input type="hidden" name="boolean" value="true">
    <p>Senha antiga: <input type="password" name="old"></p>
    <p>Nova senha: <input type="password" name="new" id="new"></p>
    <p>Confirma Senha: <input type="password" name="confirm" id="confirm"></p>
    <p id="senha"></p>
    <p id="enviar" style="display: none"><input type="submit" value="Salva"></p>
  </form>';
}
function about($msg = false){
  if (!$msg) {
    return "The System is in version: ".version_system();
  }
  else {
    return $msg;
  }
}
/*
#####################
*/
?>
