<?php
class usuario
{
	 public static function esValido($usuario, $clave) {
      

       if($usuario=="admin@admin.com" && $clave=="1234")
       {
         return true;
       }
       else
       {
          return false;

       }
      
    }
    public static function TraerTodos() {//traer a todos los usuarios para filtrarlos por perfil, mail, legajo, preferencia
      
	    $uno= new stdClass();
	    $uno->nombre="jose";
	    $uno->apellido="perez";
	    $dos= new stdClass();
	    $dos->nombre="maria";
	    $dos->apellido="sosa";
	    $tres= new stdClass();
	    $tres->nombre="pablo";
	    $tres->apellido="agua";

	    $retorno=array($uno,$dos,$tres);

     	return $retorno;
      
	}
	

	//metodo privado traerUno-> que me traiga un obj con ese usuario y ese password
	//si está instanciado retorno true, sino false.
	//tengo que ir a la bd para verificar esto, pero lo hago en otro metodo

	//metodo que se conecte a la bd y lo devuelve
	//metodo que verifica si existe o no que es 'esValido'

}