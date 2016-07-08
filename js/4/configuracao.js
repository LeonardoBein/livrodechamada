$(document).ready(function(){

  $("button[name='del_device']").click(function(env){
    env.preventDefault();
    var key = $(this).val();
    $.ajax({
      type: "POST",
      url: "del_devices",
      data: {"device":key},
      beforeSend: function(){},
      success: function(data){
        if(/success/g.test(data)){
          location.reload();
        }
      }
    });
  });

});
