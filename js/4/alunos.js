$(document).ready(function(){
  $("form[name='alunos']").submit(function(env){
    var nome   = new Array();
    var id     = new Array();
    var classe = $("input[name='turma']").val();
    env.preventDefault();

    $("input[name='nome[]']").each(function(){
      if ($(this).val() != "" | $(this).attr("value") != ""){
          nome.push($(this).val());
          id.push($(this).attr("id"));
      }
    });

    $.ajax({
      type: "POST",
      url: format_url_data(classe,'','alterar_alunos'),
      data: {'id':id, 'nome':nome},
      beforeSend: function(){
        $("#loader").show();
      },
      success: function(data){
        $("#loader").hide();
        if (/success/g.test(data)) {
          alert("Salvo com sucesso!");
          location.reload();
        }
        else {
          $("body").html(data);
        }


      }



    });


  });



});
