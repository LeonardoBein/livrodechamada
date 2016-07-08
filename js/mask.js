

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function nota(v){

    v=v.replace(/[^0-9]/g,"")

    if(/^[^1]/.test(v)){
        v=v.replace(/^(\d{1})(\d)/,"$1.$2")


    }
    else if(/^10/.test(v)){
        v=v.replace(/^(\d{2})(\d)/,"$1.$2")
    }
    else if(/(^1)/.test(v)){
        v=v.replace(/^(\d{1})(\d)/,"$1.$2")
    }
    return v
}
function is_date(v) {
  v=v.replace(/\D/g,"")
  v=v.replace(/(\d{2})(\d)/,"$1/$2")
  v=v.replace(/(\d{2})(\d)/,"$1/$2")
  return v
}

function nome(v) {
  v=v.replace(/[^A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+/, "");
  return v
}


function limita_value(x,limit){
    valor = x.value

    if(valor <= limit){
        x.style.borderColor = "#0bff00";

    }
    else{
        x.style.borderColor = "#ff0000";
        x.value = limit;
    }

}
function turma_for(v) {
    v=v.replace(/[^a-zA-Z\d]/, "");
    v=v.toUpperCase();
    return v
}
