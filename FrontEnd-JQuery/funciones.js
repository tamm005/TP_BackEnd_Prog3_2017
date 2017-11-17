
//var servidor="http://localhost:8080/servidor/BackEnd-PHP-jwt/api/";
var servidor="http://localhost/test/TP/BackEnd-PHP-jwt/api/"; 
function ingresar()
{
	
	console.log("ingresar");
	var _correo=$("#usuario").val();
	var _clave=$("#clave").val();
	console.log(_correo+_clave);
	$.ajax({
		 type: "post",
		url: servidor+"ingreso/",
		data: {
	        datosLogin: {
	        usuario: _correo,
	        clave: _clave 
    	}
    	}
   		
	})
	.then(function(retorno){
		console.info("bien",retorno);
		
		if (typeof(Storage) !== "undefined") {
    		// Code for localStorage/sessionStorage.
    		localStorage.setItem('tokenUTNFRA', retorno.token);


		} else {
		   console.log("Sorry! No Web Storage support..");
		}
		
	
	},function(error){
		alert(error.responseText);
		console.info("error",error);
	});
	
	
}

function enviarToken()
{
	$.ajax({
		  url: servidor+"tomarToken/",
		  type: 'GET',
		 
		  headers: {"miTokenUTNFRA": localStorage.getItem('tokenUTNFRA')}
	}).then( function(itemResponse) {
		
        console.info("bien -->",itemResponse);
    }, 
    function(error) {

    	alert(error.responseText);
        console.info("error",error);
    });
}