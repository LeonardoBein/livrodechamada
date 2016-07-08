$(document).ready(function(){

    if ($("input[name='turma']").val() == "" || $("input[name='disciplina']").val() == "" ) {
      $(".editar").eq(0).find("input").trigger('click');
    }

    $("#adic").submit(function(env){
      env.preventDefault();
      var classe = $("input[name='turma'][type='text']").val();
      var discipline = $("input[name='disciplina'][type='text']").val();

      $.ajax({
        type: "POST",
        url: format_url_data(classe,discipline,'add_classes'),
        beforeSend: function(){
          $("#loader").show();
        } ,
        success: function(data){
          $("#loader").hide();
          if (/success/g.test(data)) {
            location.reload();
          }
          else if (/var_null/g.test(data)) {
            $("#resposta").html("Dado(s) necessário(s)!");
            $("form input[type!='submit']").each(function(){
              if ($(this).val() == "")
                  $(this).css("border-color","red");
            });
          }
          else if (/exists_class/g.test(data)) {
            $("#resposta").html("Disciplina "+discipline+" já criada");
            $("input[name='disciplina']").css("border-color","red");
          }
          else {
            $("body").html(data);
          }
        }
      });
    });
    /*Excluir*/
    $(".apagar").on('click','button',function(env){
      env.preventDefault();
      var id = $(this).val();
      var classes = $("#"+id+" .coluna1").html();
      var discipline = $("#"+id+" .coluna2").html();
      if (confirm("Deseja escluir a Disciplina: "+discipline)) {
        $.ajax({
          type: "POST",
          url: format_url_data(classes,discipline,'del_classes'),
          data: {'id':id},
          beforeSend: function(){
            $("#loader").show();
          },
          success: function(data){
            $("#loader").hide();
            if (/success/g.test(data)) {
              location.replace(format_url_data("","",""));
            }
            else {
              $("body").html(data);
            }
          }
        });
      }
    });

});
