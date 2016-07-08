$(document).ready(function(){
  /*Menu Mobile*/
  $(".menu").on('click','li', function(){
    var width = $(window).width(), height = $(window).height();
    if (width < 800) {
      var menu = $(this).children('.sub-menu');
      var submenu =  $(this).parent();

      if(submenu.hasClass('sub-menu') && menu.length == 0){
         location.assign(format_url_data('','',$(this).find("a").attr("href")));
         return false;
      }
      else if(menu.length > 0 && menu.is(":hidden")){
        menu.show();
        return false;
      }
      else if(menu.length > 0 && menu.is(":visible")){
        menu.hide();
        return false;
      }
      else {
        location.assign(format_url_data('','',$(this).find("a").attr("href")));
      }
    }
  });
  /*Menu Desktop*/
  $(".menu").on('click','a',function(env){
    env.preventDefault();
    var menu = $(this).children('.sub-menu');
    var submenu =  $(this).parent().parent();
    /*sub menu*/
    if(submenu.hasClass('sub-menu') && menu.length == 0){
       location.assign(format_url_data('','',$(this).attr("href")));
       return false;
    }/*menu*/
    else {
      location.assign(format_url_data('','',$(this).attr("href")));
    }
  });
  $(".editar").on('click','input',function(env){
    env.preventDefault();
    var id = $(this).parent().parent();
    var classe = id.find(".coluna1").html();
    var discipline = id.find(".coluna2").html();
    location.assign(format_url_data(classe,discipline,''));
  });



});
