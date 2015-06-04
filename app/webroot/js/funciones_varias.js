//Verifica si los checkbox estan vacios
function verificar_checkbox(id_tabla,id_checkbox) {
    
    var inicio_id_chechbox = 0;  
    var fin_id_checkbox = id_checkbox.length;

    var objeto= document.getElementById(id_tabla).getElementsByTagName('input');
    var cantidad_objetos = objeto.length;
    
    var cantidad_checkeados = 0;
    for (var i=0;i<cantidad_objetos;i++){   
               
    	var elemento = objeto[i].id.toString();
        
        if (elemento.substr(inicio_id_chechbox,fin_id_checkbox)==id_checkbox){    
    		if (objeto[i].checked){               
                cantidad_checkeados ++;    
    		}
        }    
    }

    if (cantidad_checkeados > 0){
        return true;
    } else {
        return false;
    }
};

function verificar_campo_tiny_vacio(element_id) {
    //Esta funcion la podemos encontrar en funciones_varias.js
    var campo_texto = tinymce.get(element_id).getContent();
    var campo_texto_completado = true;
    if (campo_texto.length == 0){
        campo_texto_completado = false;
    }
    
    if (campo_texto_completado) {
        return false;       
    } else {
        return true;
    }
}