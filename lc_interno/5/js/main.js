function Mudar_estado(obj) {
    var valor = obj.value ;
    
    
    switch(valor){
            
        case "div_prova": 
            document.getElementById("div_prova").style.display = "inline";
            document.getElementById("div_avaliacao").style.display = "none";
            document.getElementById("div_rec_prova").style.display = "none";
            document.getElementById("div_rec_avaliacao").style.display = "none";break;
        
        case "div_avaliacao": 
            document.getElementById("div_avaliacao").style.display = "inline";
            document.getElementById("div_prova").style.display = "none";
            document.getElementById("div_rec_prova").style.display = "none";
            document.getElementById("div_rec_avaliacao").style.display = "none";break;;
            
        case "div_rec_prova": 
            document.getElementById("div_rec_prova").style.display = "inline";
            document.getElementById("div_prova").style.display = "none";
            document.getElementById("div_avaliacao").style.display = "none";
            document.getElementById("div_rec_avaliacao").style.display = "none";break;;
        
        case "div_rec_avaliacao": 
            document.getElementById("div_rec_avaliacao").style.display = "inline";
            document.getElementById("div_prova").style.display = "none";
            document.getElementById("div_avaliacao").style.display = "none";
            document.getElementById("div_rec_prova").style.display = "none";break;;
    
            
            
            
    }
    
    
}

