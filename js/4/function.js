function format_url_data(classes,discipline,action){

		var url = window.location.href;
		if (/^https|http/g.test(action)) {
			url = action;
		}
		else if (/(?:index\.php)\/(\w+|)\/(\w+|)\/?(\w+|)\/?(.+|)/g.test(url) && classes == "" && discipline == "" && action == "") {
			url = url.replace(/(?:index\.php)\/(\w+)\/(\w+)\/?(\w+|)\/?(.+|)/g,"index.php/");
			url = url;
		}
		else if (/(?:index\.php)\/(\w+|)\/(\w+|)\/?(\w+|)\/?(.+|)/g.test(url) && classes == "" && discipline == "") {
			url = url.replace(/(?:index\.php)\/(\w+)\/(\w+)\/?(\w+|)\/?(.+|)/g,"index.php/$1/$2/");
			url = url+action+"/";
		}
		else if (/index\.php.+/g.test(url)) {
			url=url.replace(/(.+\/index\.php).+/g,"$1");
			url = url+"/"+classes+"/"+discipline+"/"+action;
		}
		else if (!/index\.php$/g.test(url)){
			url = url+'index.php/'+classes+"/"+discipline+"/"+action;;
		}
		else {
			url=url.replace(/(.+\/index\.php)/g,"$1");
			url=url+"/"+classes+"/"+discipline+"/";
		}

		return url;

}
/* -----------------------------------
animation windows

*/
function animate_window_show(windows, background){
	$(background).css({"opacity": "0.8"}).toggle(function(){
		$(windows).toggle();
	});

}

function animate_window_hide(windows,background,close){

			$(close+", "+background).click(function(){
						$(windows).hide();
						$(background).animate({opacity: "0"},function(){
						$(background).hide();
						});
			});
			$(document).on('keyup',function(key){

				if (key.which === 27) {
					$(close).trigger('click');

				}

			});

}

/*
--------------------------------------
*/

/*-------------------------------------
		calendario*/

		$(function() {
		  $( "#calendario" ).datepicker({
		    dateFormat: 'dd/mm/yy',
		    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
		    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
				showOtherMonths: true,
				selectOtherMonths: true
		  });
		});


/*-------------------------------------*/
