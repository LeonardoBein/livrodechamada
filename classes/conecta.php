<?php
require(RAIZ.'config/db_inc.php');
class conecta extends PDO{

    private $bc = "mysql:host=".LOCALHOSTDB.";dbname=".BANCDB;
    private $user = USERNAMEDB;
    private $passwd = PASSWORDDB;
    public $link = null;


    function __construct(){

      try {
        if ($this->link == null) {
          $conc = parent::__construct( $this->bc , $this->user, $this->passwd );
          $this->link = $conc;
          return $this->link;
        }

      } catch (PDOException $e) {
        echo "Connection failed: ". $e->getMessage( );
        return false;
      }

    }

    public function install_table(){
      $final = false;
      $conc = $this->link;

        $sql= "CREATE TABLE IF NOT EXISTS `tb_usuario` (
      `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
      `nome` varchar(100) NOT NULL,
      `usuario` varchar(50) NOT NULL,
      `email` varchar(60) NOT NULL,
      `senha` varchar(60) NOT NULL,
      `trimestre` int(1) NOT NULL,
      `tipo` int(1) DEFAULT NULL,
      `uid` varchar(50) NOT NULL,
      `id_browser` TEXT NOT NULL,
      `data` varchar(14) NOT NULL,
      `ativo` tinyint(1) NOT NULL
    ) DEFAULT CHARSET = Latin1 COLLATE = latin1_general_cs";

      $query = self::query($sql);

      $sql = "CREATE TABLE IF NOT EXISTS `relacao_prof_turma` (
        `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `usuario` varchar(50) NOT NULL,
        `turma` varchar(50) NOT NULL,
        `disciplina` varchar(50) NOT NULL
      ) DEFAULT CHARSET = Latin1 COLLATE = latin1_general_cs";

      $query = self::query($sql);

      $sql = "CREATE TABLE IF NOT EXISTS `calendario` (
        `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `trimestre1` varchar(100) DEFAULT NULL,
        `trimestre2` varchar(100) DEFAULT NULL,
        `trimestre3` varchar(100) DEFAULT NULL
      )";
      $query = self::query($sql);

      $sql = "SELECT * FROM `calendario`";
      $query = self::query($sql);
      if ($query->rowCount() == 0){
          $sql = "INSERT INTO `calendario`(`trimestre1`) VALUES ('1')";
          $query = self::query($sql);
      }

      $sql = "SELECT `id` FROM `tb_usuario` WHERE `id`='1' OR `tipo`= '1' LIMIT 1";

      $query = self::query($sql);


      if ($query->rowCount() == 0){
        $final = 1;
      }
      else {
        $final = 4;
      }
      return $final;
    }

    public function get_nomes($turma = '',$total = false){

      if ($turma == NULL) {
        die("error class is null");
      }

      if ($total == true) {
        $sql = sprintf("SELECT `id`, `nome`
                        FROM `%s`",$turma);
      }else {
        $sql = sprintf("SELECT `id`, `nome`
                        FROM `%s`
                        WHERE `nome` != ''",$turma);
      }

      if (!$query = self::query($sql)) {
          $error = self::errorInfo();
          die(var_dump($error));
      }

      while ($list = $query->fetch(PDO::FETCH_ASSOC)) {
        $array['name'][]    = $list['nome'];
        $array['number'][]  = $list['id'];
      }
      return $array;

    }

    function __destruct( ){
      $this->link = null;
    }


}
?>
