//Mensaje de confirmacion con varios checkbox
function confirmar_varios(mensaje,form_id){
    var mensaje_final = "<div style='padding: 20px;'><b style='color: #004040;font-size: medium;'>"+mensaje+"</b></div>";
	alertify.confirm(mensaje_final, function (e) {
		if (e) {
            var bandera = false;
            var length = document.forms.length;
            for(var i = 0; i < length; i++) {
                if(document.forms[i].id == form_id) {
                    form = document.forms[i];
                    bandera = true;
                    break;
                }
            }
            if (bandera){
                form.submit();
            } else {
                alertify.error("Error en Formulario");
            }                    
		} else { 
            alertify.error("Operaci&oacute;n cancelada");
    	} 
	});	
};    
//Mensaje de confirmacion de link individual
function confirmar_individual(mensaje,$link){
    var mensaje_final = "<div style='padding: 20px;'><b style='color: #004040;font-size: medium;'>"+mensaje+"</b></div>";
	alertify.confirm(mensaje_final, function (e) {
		if (e) {
            location.href = $link;
		} else { 
            alertify.error("Operaci&oacute;n cancelada");
    	} 
	});	    
}; 

//Mensaje de alerta
function alerta(mensaje){
    var mensaje_final = "<div style='padding: 20px;'><b style='color: #004040;font-size: medium;'>"+mensaje+"</b></div>";
	alertify.alert(mensaje_final, function () {
	});
};

function loading(mensaje){
    var mensaje_final = "<div style='padding: 20px;'><b style='color: #004040;font-size: medium;'>"+mensaje+"</b></div>";
	alertify.loading(mensaje_final, function () {
	});
};






/*
///////// EJEMPLOS DE CODIGO DE ALERTFY /////////

function alerta(mensaje){
	//un alert
	alertify.alert(mensaje, function () {
		//aqui introducimos lo que haremos tras cerrar la alerta.
		//por ejemplo -->  location.href = 'http://www.google.es/';  <-- Redireccionamos a GOOGLE.
	});
}

function confirmar(mensaje){
	//un confirm
	alertify.confirm(mensaje, function (e) {
		if (e) {
			alertify.success("Has pulsado '" + alertify.labels.ok + "'");
		} else { 
            alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
		}
	});
    return false; 	
}

function datos(mensaje){
	//un prompt
	alertify.prompt(mensaje, function (e, str) { 
		if (e){
			alertify.success("Has pulsado '" + alertify.labels.ok + "'' e introducido: " + str);
		}else{
			alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
		}
	});
	return false;
}

function notificacion(mensaje){
	alertify.log(mensaje); 
	return false;
}

function ok(mensaje){
	alertify.success(mensaje); 
	return false;
}

function error(mensaje){
	alertify.error(mensaje); 
	return false; 
}
*/