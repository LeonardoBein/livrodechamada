<?php

$_A['turma'] = $_G['class'];
$_A['disciplina'] = $_G['discipline'];
if(($_A['turma'] == null) || ($_A['disciplina'] == null) ){die();}

$sql = "SELECT `id`,`data`,`alias` FROM `".$_A['turma']."_".$_A['disciplina']."_pres` WHERE `trimestre` = '".$_SESSION['trimestre']."' ORDER BY `data` ASC, `id` ASC ";
$query = $connect->query($sql);


while($array = $query->fetch(PDO::FETCH_ASSOC)){

    echo "<form name=\"alias_chamada\" id=\"".$array['id']."\">

        <p>Conteúdo do dia ".des_formata_data($array['data']).":
        <input type=\"hidden\" name=\"alter\" value=\"1\"/>
        <input name='alias' type='text' maxlength=\"150\" value='" . $array['alias'] . "' />
        <input type=\"submit\" value=\"Salvar\" />
        </form>";



}
?>
<script>
$("form[name='alias_chamada']").submit(function(evn){
  evn.preventDefault();
  var id = $(this).attr("id");
  var alias = $("#"+id+" input[name='alias']").val();
  var alter = "1";
  var classe = $("input[name='turma']").val();
  var discipline = $("input[name='disciplina']").val();

  $.ajax({
    type: "POST",
    url: format_url_data(classe,discipline,'save_call'),
    data: {'alias': alias,'alter':alter,'id':id},
    beforeSend: function(){},
    success: function(data){
        if (/ok/g.test(data)){
          $("#"+id+" input[name='alias']").val(alias);
          $("#content_resposta").html("Salvo com sucesso!");
        }
        else if (/null_alias/g.test(data)) {
          $("#"+id+" input[name='alias']").css("border-color","red");
          $("#content_resposta").html("Não premitido deixar o conteudo da aula em branco!");
          $("#"+id+" input[name='alias']").val($("#"+id+" input[name='alias']").attr("value"));
        }
        else {
          alert("ERROR");
        }


    }



  });

});


</script>
