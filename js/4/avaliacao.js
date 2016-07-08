$(document).ready(function(){

  $(".h1_ctl").click(function(){
    var id  = $(this).attr("env");
    $("#"+id).toggle();


  });

  $(".ativ a").click(function(){
    var id = $(this).html().replace(/\s/g,"+");
    var classe = $("input[name='turma']").val();
    var discipline = $("input[name='disciplina']").val();
    location.assign(format_url_data(classe,discipline,'atividade')+"/"+id);
  });

  
});
