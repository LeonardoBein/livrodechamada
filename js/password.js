function passwordStrengthCheck(password1, password2, passwordsInfo,progress){
    var WeakPass = /(?=.{5,}).*/;
    var MediumPass = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/;
    var StrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/;
    var VryStrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])\S{5,}$/;

    $(password1).keyup(function(e) {
        if(VryStrongPass.test(password1.val())){
            passwordsInfo.html("Muito Forte, Impressionante!");
            progress.removeClass().addClass('progress-vrystrongpass');
        }
        else if(StrongPass.test(password1.val())){
            passwordsInfo.html("Forte!");
            progress.removeClass().addClass('progress-strongpass');
        }
        else if(MediumPass.test(password1.val())){
            passwordsInfo.html("Bom!");
            progress.removeClass().addClass('progress-goodpass');
        }
        else if(WeakPass.test(password1.val())){
            passwordsInfo.html("Algo fraco!");
            progress.removeClass().addClass('progress-stillweakpass');
        }
        else if ((password1.val()) == "" ) {
          passwordsInfo.html("");
          progress.removeClass().addClass("progress-stop");
        }
        else{
            passwordsInfo.html("Muito fraca!");
            progress.removeClass().addClass('progress-weakpass');
        }
    });

    $(password2).keyup(function(e) {
        if(password1.val() !== password2.val()){
            passwordsInfo.html("As passwords não são iguais!");
            password1.css("border-color", "red");
            password2.css("border-color", "red");
        }
        else if (password1.val() == "" | password2.val() == "") {
          passwordsInfo.html("");
          progress.removeClass().addClass('progress-stop');
        }
        else{
            passwordsInfo.html("Passwords iguais!");
            password1.css("border-color", "#159134");
            password2.css("border-color", "#159134");
        }
    });
}
