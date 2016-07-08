<html>

    <head>

        <meta charset="utf-8">
        <title>Nova Senha</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <script type="text/javascript" src="../js/password.js"></script>
				<script type="text/javascript" src="../js/jquery-2.1.4.js"></script>
        <script>
        $(document).ready(function(){
          var password1       = $(".box-cadastra input[name='senha']");
          var password2       = $(".box-cadastra input[name='confirma_senha']");
          var passwordsInfo   = $("#pass-info");
          var progress				= $("#progress-default");
          passwordStrengthCheck(password1,password2,passwordsInfo,progress);





        });

        </script>



    </head>





<body>
  <?php
  include("../classes/seguranca.php");


  $id = (int) ($_GET['id']/8);
  $emailMd5 = $_GET['email'];
  $uidMd5 = $_GET['uid'];
  $data = $_GET['key'];
  $tabela_usuario = "tb_usuario";
  $limit = "600";



  if((empty($id)) || (empty($emailMd5)) || (empty($uidMd5)) || (empty($data))){
      die(header("Location: ../index.php?error=linkfalse"));


  }

  $link = new conecta();

  $sql = "SELECT `email`,`uid`,`data` FROM `".$tabela_usuario."` WHERE `id` = '$id' LIMIT 1";
  $sql_query = $link->query($sql);

  $assoc = $sql_query->fetch(PDO::FETCH_ASSOC);

  $valido = false;

  $segundos = time() - $data;

  if(($emailMd5 === md5($assoc['email'])) && ($uidMd5 === md5($assoc['uid'])) && ($data === $assoc['data']) && ($segundos < $limit)){
      $valido = true;}


  if($valido === true){

      echo "
  <div class=\"window\">
    <form method=\"post\" action=\"change_pass.php\">
        <label>Nova senha</label>
          <input type=\"hidden\" name=\"id\" value=\"".$id."\">

      <label>Senha [*]</label>
          <p class=\"box-cadastra\"><input type=\"password\" name=\"senha\" maxlength=\"50\"/></p>

      <label>Confirme a senha [*]</label>
          <p class=\"box-cadastra\"><input type=\"password\" name=\"confirma_senha\" maxlength=\"50\"/></p>

      <div id=\"limit-bar\"><span id=\"pass-info\"></span><div id=\"progress-default\" class=\"progress-stop\"> </div></div>
        <p><input type=\"submit\" value=\"Salvar\"></p>

    </form></div>




      ";


  }




  else{
     die(header("Location: ../index.php?error=linkfalse"));
  }

  ?>


    </body>
</html>
