$(document).ready(function(){

/*excluir ativiade*/
    $("button[name='excluir']").on('click', function(env){
      env.preventDefault();
      var id = $(this).val().replace(/\s/g,"+");
      var classe = $("input[name='turma']").val();
      var discipline = $("input[name='disciplina']").val();
      $.ajax({
        type: "POST",
        url: format_url_data(classe,discipline,'del_atividade')+"/"+id,
        data: '',
        beforeSend: function(){
          $("#loader").show();
        },
        success: function(data){
          $("#loader").hide();
          if (/success/g.test(data)) {
            location.assign(format_url_data(classe,discipline,"avaliacao"));
          }
          else {
            alert("error");
          }
        }
      });
    });
/*------------*/

    $("form").submit(function(env){
      env.preventDefault();
      var classe      = $("input[name='turma']").val();
      var discipline  = $("input[name='disciplina']").val();
      var id          = $(this).find("button").val().replace(/\s/g,"+");
      var value       = new Array();
      var number      = new Array();

      $("input[name='n_[]']").each(function(){
        if ($(this).val() != "0") {
          value.push($(this).val());
          number.push($(this).parent().parent().eq(0).find("td").html());
        }
      });

      $.ajax({
        type: "POST",
        url: format_url_data(classe,discipline,'salva_atividade')+"/"+id,
        data: {'value':value,'number':number},
        beforeSend: function(){
          $("#loader").show();
        },
        success: function(data){
          $("#loader").hide();
          if (/success/g.test(data)) {
            location.reload();
          }
          else {
            alert("erro");
          }
        }

      });
    });


});
