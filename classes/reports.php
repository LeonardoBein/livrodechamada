<?php
include(RAIZ."include/mpdf/mpdf.php");
/**
 * The class is for generate reports
 */
class report{
  public $type,
         $class,
         $discipline,
         $trimestre,
         $stylesheet = '',
         $javascript = '',
         $mpdf;

  private $connect;

  function __construct($type){
    $this->type = $type;
    $this->mpdf = new mPDF('c','A4');
    $this->connect = new conecta();

  }

  public function discipline_class($class,$discipline,$trimestre='1'){
    $this->class = $class;
    $this->discipline = $discipline;
    $this->trimestre = $trimestre;
  }
  private function html_basic($head,$body){

    $body = "<body>".$body."</body>";
    $head = "<head>".$head."</head>";
    return
    "<!DOCTYPE html>
    <html>".
    $head.
    $body.
    "</html>";

  }
  private function head(){
    $title = ucwords($this->type);

    return sprintf("
      <title>%s</title>
      <meta charset=\"utf-8\">
      <style>%s</style>
      <script>%s</script>
    ",
  $title,
  $this->stylesheet,
  $this->javascript);

  }
  public function stylesheet($file = ''){
    if (file_exists($file) && is_file($file) && $file != null) {
      $this->stylesheet = file_get_contents($file);
    }

  }
  public function javascript($file = ''){
    if (file_exists($file) && is_file($file) && $file != null) {
      $this->javascript = file_get_contents($file);
    }
  }
  /*
  * funcão cria uma tabela contendo as presenças
  *
  */
  private function chamada(){
    $turma = $this->class;
    $disciplina = $this->discipline;
    $trimestre = $this->trimestre;
    $banc = $this->connect;
    /*inicio*/
    $content = "
    <table border=\"1\">
      <tr>
        <th>N°</th>
        <th>data/mes</th>
      </tr>
      <tr>
        <td></td>";
    /*-------*/

    $number = $banc->get_nomes($turma,true);

    $sql = sprintf("SELECT `data`
                    FROM `%s_%s_pres`
                    WHERE `trimestre`='%d' ORDER BY `data` ASC, `id` ASC",
                $turma,
                $disciplina,
                $trimestre);

    $datas = $banc->query($sql);

    while($fetch = $datas->fetch(PDO::FETCH_ASSOC)){

        $dia = separa_data($fetch['data'],"dia");
        $mes = separa_data($fetch['data'],"mes");
        //datas-----------
        $content .= '<td>'.$dia.'-'.$mes.'</td>';
    }
    $content .= "</tr>";
    foreach ($number['number'] as $key => $value) {

      $sql = sprintf("SELECT `n_%d`
            FROM `%s_%s_pres`
            WHERE `trimestre` = '%d' ORDER BY `data` ASC, `id` ASC ",
          $value,
          $turma,
          $disciplina,
          $trimestre);

      $content .= "
      <tr>
        <td>".$value."</td>";
        $pres = $banc->query($sql);

      while ($list = $pres->fetch(PDO::FETCH_ASSOC)) {
        if($list['n_'.$value] == "0"){
            $content .= '<td>F</td>';
        }
        else if($list['n_'.$value] == "1"){
            $content .= '<td>C</td>';
        }
      }
      $content .= '</tr>';
    }
    $content .= "</table>";
    return $content;
  }

  private function atividade(){
    $turma = $this->class;
    $disciplina = $this->discipline;
    $trimestre = $this->trimestre;
    $banc = $this->connect;

    $content = "
    <table border=\"1\">
      <tr>
        <td></td>
    ";
    $sql = sprintf("SELECT `alias`,`valor`
            FROM `%s_%s_aval`
            WHERE `trimestre` = '%d' and `hidden` ='0' ORDER BY `data` ASC, `id` ASC ",
            $turma,
            $disciplina,
            $trimestre);

    $alias = $banc->query($sql);
    /*
    * lista os nomes das atividades e seu valores
    */
    while ($list = $alias->fetch(PDO::FETCH_ASSOC)) {
      $content .= sprintf("<td>%s - Valor: %.2f</td>" ,$list['alias'],$list['valor']);
    }
    /*--*/
    $content .= "
      </tr>
      <tr>
        <td>N°</td>";
    $sql = sprintf("SELECT `data`
                    FROM `%s_%s_aval`
                    WHERE `trimestre` = '%d' and `hidden`='0' ORDER BY `data` ASC, `id` ASC",
                  $turma,
                  $disciplina,
                  $trimestre);
    $data = $banc->query($sql);
    while($array_data = $data->fetch(PDO::FETCH_ASSOC)){
        $dia = separa_data($array_data['data'],"dia");
        $mes = separa_data($array_data['data'],"mes");
        $content  .= "<td>" . $dia . "-" . $mes . "</td>";
    }
    $content .= "</tr>";

    $number = $banc->get_nomes($turma,true);

    foreach ($number['number'] as $value) {

      $sql = sprintf("SELECT `n_%d`
                      FROM `%s_%s_aval`
                      WHERE `trimestre` = '%d' and `hidden`='0' ORDER BY `data` ASC, `id` ASC",
                    $value,
                    $turma,
                    $disciplina,
                    $trimestre);
      $query = $banc->query($sql);
      $content .= "
      <tr>
        <td>".$value."</td>";
      while ($valor = $query->fetch(PDO::FETCH_ASSOC)) {
        $content .= sprintf("<td>%.2f</td>",$valor['n_'.$value]);
      }
      $content  .= "</tr>";
    }
    return $content."</table>";
  }

  private function canhoto(){
    $turma      = $this->class;
    $disciplina = $this->discipline;
    $trimestre  = $this->trimestre;
    $banc       = $this->connect;


    $nomes = $banc->get_nomes($turma,true);

    $sql = sprintf("SELECT `data` FROM  `%s_%s_pres`",$turma,$disciplina);

    if($totalaulas = $banc->query($sql)){
        $notas[0] = $totalaulas->rowCount();
    }

    foreach ($nomes['number'] as $value) {

      $sql = sprintf("SELECT `id` ,`relacao_rec`, `n_%d`
                      FROM `%s_%s_aval`
                      WHERE `trimestre`='%d' and `hidden`='0' and `relacao_rec` != '' ",
                      $value,
                      $turma,
                      $disciplina,
                      $trimestre);
      $query = $banc->query($sql);
      if ($query->rowCount()) {
        while($recuperacao = $query->fetch(PDO::FETCH_ASSOC)){
          $ids = unserialize($recuperacao['relacao_rec']);

          $sql = sprintf("SELECT sum(`n_%d`) as soma
                          FROM `%s_%s_aval`
                          WHERE `trimestre`='%d' and `hidden`='0' and ( `id`='%s' )",
                          $value,
                          $turma,
                          $disciplina,
                          $trimestre,
                          implode("' or `id` = '",$ids));

          $query1 = $banc->query($sql);
          $soma = $query1->fetch(PDO::FETCH_ASSOC);
          if ($soma['soma'] > $recuperacao['n_'.$value]) {
            $nota = $nota + $soma['soma'];
          }
          else {
            $nota = $nota + $recuperacao['n_'.$value];
          }
          $bloques[] = $recuperacao['id'];
          foreach ($ids as $value1) {
            $bloques[] = $value1;
          }
        }
    }else {
      $bloques = array('');
    }


      $sql = sprintf("SELECT sum(`n_%d`) as soma
                      FROM `%s_%s_aval`
                      WHERE `trimestre`='%d' and `hidden`='0' and ( `id`!='%s' )",
                      $value,
                      $turma,
                      $disciplina,
                      $trimestre,
                      implode("' and `id` != '",$bloques));
      $query = $banc->query($sql);
      $soma = $query->fetch(PDO::FETCH_ASSOC);
      $notas[$value]['nota'] = $nota + $soma['soma'];
      $nota = 0;

      $sql = sprintf("SELECT ifnull(SUM(`n_%s`),0) as soma
                      FROM `%s_%s_pres`",
                      $value,
                      $turma,
                      $disciplina);
      if ($query1 = $banc->query($sql)) {
          $totalpres = $query1->fetch(PDO::FETCH_ASSOC);
          $notas[$value]['faltas'] = $notas[0] - $totalpres["soma"];
      }
    }
    //$content = "total de aulas: ".$notas[0]."<br>";
    $content_n = '';
    foreach ($nomes['number'] as $value) {
      $content_n .= sprintf("
      <tr>
        <td>%d</td>
        <td>%.2f</td>
        <td>%d</td>
      </tr>",
      $value,
      $notas[$value]['nota'],
      $notas[$value]['faltas']);

  }
    return $content = sprintf("
    <table border='1'>
      <tbody>
      <tr>
        <td>N°</td>
        <td>Notas</td>
        <td>Faltas</td>
      </tr>
      %s
      </tbody>
    </table>",$content_n);
  }

  public function create(){

    switch ($this->type) {
      case 'chamada':    $end = self::html_basic(self::head(),self::chamada());  break;
      case 'atividade':  $end = self::html_basic(self::head(),self::atividade());  break;
      case 'canhoto':    $end = self::html_basic(self::head(),self::canhoto()); break;
      default: die();
    }


    //$this->mpdf->SetAuthor('leo');
    $this->mpdf->SetDisplayMode('fullpage');
    //$this->mpdf->SetTitle('Title');
    $this->mpdf->SetCreator('Livro de Chamada');
    $this->mpdf->WriteHTML($end);
    $this->mpdf->Output($this->type."-".$this->class."-".$this->discipline.'.pdf','I');
    /*
    I mostra no navegador
    D Download para o cliente

    */
  }
}







 ?>
