$(document).ready(function(){

  $("select").change(function(){
    var id = $(this).val();
    $("#conteudo > form[id != '"+id+"']").hide();
    $("#"+id).show();
  });
  $("form").submit(function(env){
    env.preventDefault();
    var classe      = $("input[name='turma']").val();
    var discipline  = $("input[name='disciplina']").val();
    var tipo        = $(this).find("input[name='tipo']").val();
    var alias       = $(this).find("input[name='alias']").val();
    var data        = $(this).find("input[name='data']").val();
    var valor       = $(this).find("input[name='valor']").val();
    var $this       = $(this);
    if (/rec/g.test(tipo)) {
      var relacao_rec = new Array();
      $(this).find("input[name='relacao_rec[]']").each(function(){
          if($(this).prop("checked"))
            relacao_rec.push($(this).val());
      });
      var data = {'alias':alias,'data':data,'relacao':relacao_rec,'tipo':tipo};
    }
    else {
      var data = {'alias':alias,'data':data,'valor':valor,'tipo':tipo};
    }


    $.ajax({
      type: "POST",
      url:  format_url_data(classe,discipline,'salva_avaliacao'),
      data: data,
      beforeSend: function(){
        $("#loader").show();
      },
      success: function(data){
          $("#loader").hide();
        if (/success/g.test(data)) {
          location.assign(format_url_data(classe,discipline,'avaliacao'));
        }
        else if (/empty/g.test(data)) {
          $this.find("input").each(function(){
            if($(this).val() == "")
              $(this).css("border-color","red");
          });
        }
        else if (/error_limit|name_exists/g.test(data)) {
          $("#resposta").html("Limite de 10 pontos por trimestre ou nomes repetidos excedido!");
        }
        else {
          alert("error");
        }

      }


    });
  });

});
