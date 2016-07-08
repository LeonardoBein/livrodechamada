$(document).ready(function(){

    $("input[name='view_content']").click(function(env){
        env.preventDefault();
        var classes = $("input[name='turma']").val();
        var discipline = $("input[name='disciplina']").val();

        $.ajax({
          type: "POST",
          url:   format_url_data(classes,discipline,'list_content_call'),
          beforeSend: function(){
            $("#loader").show();
          },
          success: function(data){
            $("#loader").hide();
            $("#content_resposta").html("");
            $("#content").html(data);
            animate_window_show(".window","#background");

          }
        });
    });
    /*---------FORM CHAMADA--------------*/
    $("form[name='chamada']").submit(function(event){
      event.preventDefault();
      var presenca = new Array();
      var number = new Array();
      var valor = 0;
      $("input[name='n_[]']").each(function(){
          if ($(this).prop("checked"))
            valor = true;
          else valor = false;
          presenca.push(valor);
      });
      $(".numero").each(function(){
        number.push($(this).html());

      });

      var discipline = $("input[name='disciplina']").val();
      var classe = $("input[name='turma']").val();
      var date = $("input[name='data']").val();
      var alias = $("input[name='alias']").val();
      /*------AJAX ---------*/

      $.ajax({
        type: "POST",
        url: format_url_data(classe,discipline,'save_call'),
        data: {'chamada':presenca,'data':date,'alias':alias,'number':number},
        beforeSend: function(){
          $("#loader").show();
        },
        success: function(data){
          $("#loader").hide();
          if (/ok/g.test(data)) {
            //$("#resposta").html("Salvo como sucesso!");
            alert("Salvo como sucesso!");
            location.reload();
          }
          else if (/null_alias/g.test(data)){
            $("#resposta").show().html("Preencha o conteudo da aula!");
            $("input[name='alias']").css("border-color", "red");
          }
          else {
            alert("ERROR");
          }
        }
      });
      /*---------END AJAX ------*/
    });
    /*------------END FORM CHAMADA------------*/



    $("#resposta").dblclick(function(){
      $(this).hide();
    });

    animate_window_hide(".window","#background",".close");

    $("input[name='all_presence']").click(function(){
          $('input[name="n_[]"]').each(function(){
               if ($(this).prop( "checked"))
                $(this).prop("checked", false);
               else $(this).prop("checked", true);
             });
    });




});
