
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
		  url: servidor+"tomarToken/",//tomarGrilla seria. Lo que hago es empezar a pedirle datos, pero como tengo que
		  type: 'GET', //estar logueado...en el header le paso el nombre de mi token.
		 			//le paso mi token para que lo valide todo el tiempo
		  headers: {"miTokenUTNFRA": localStorage.getItem('tokenUTNFRA')}//tokenUTNFRA es como lo almaceno en el localstorage
	}).then( function(itemResponse) {
		
        console.info("bien -->",itemResponse);
    }, 
    function(error) {

    	alert(error.responseText);
        console.info("error",error);
    });
}