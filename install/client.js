function troca_valores(obj, valor){

    if(obj.value == valor){
        obj.value = '';
    }
    else if(obj.value == ''){
        obj.value = valor;
    }

}
function evento_lower_case(obj) {
		obj.value = obj.value.toLowerCase();
	}
