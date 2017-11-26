<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '../composer/vendor/autoload.php';
require_once 'clases/AccesoDatos.php';
require_once 'clases/cdApi.php';
require_once 'clases/AutentificadorJWT.php';
require_once 'clases/MWparaCORS.php';
require_once 'clases/MWparaAutentificar.php';
require_once 'clases/usuario.php';
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['determineRouteBeforeAppMiddleware'] = true;
/*

¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);


/*Comentario ApiDoc*/
/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->post('/ingreso/', function (Request $request, Response $response) {    
    
	$token="";
  $ArrayDeParametros = $request->getParsedBody()['datosLogin'];
  $usuario = $ArrayDeParametros['usuario'];
  $clave = $ArrayDeParametros['clave'];

 // var_dump($ArrayDeParametros );
  if( $usuario &&  $clave )// SI... me pasaron los "DOS" parametros: usuario y clave
  {

      if( usuario::esValido($usuario,$clave))
      {
        $datos=array('usuario'=>$usuario,'clave'=>$clave);//NO VA PASS, pasar perfil,rol,ultimo/1er/actual acceso.
        $token= AutentificadorJWT::CrearToken($datos);//porque el token me lo va a mostrar en el frontend
        $retorno=array('datos'=> $datos, 'token'=>$token );//a parte del token retorno lo que ME traigo los datos que le puse en usuario.php 'TraerUno'
        $newResponse = $response->withJson( $retorno ,200); //aclarar en la linea 33 lo que retorno y porqué
      }
      else
      {
        $retorno=array('error'=> "no es usuario valido" );
        $newResponse = $response->withJson( $retorno ,409); 
      }
  }else
  {
        $retorno=array('error'=> "Faltan los datos del usuario y su clave" );
        $newResponse = $response->withJson( $retorno  ,411); 

  }
 
	
  $newResponse
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods',  'POST');

  return $newResponse;//devuelvo $retorno con los datos(usuario y clave) y el token(validado)
                      //o retorno un mensaje del error mas un nro que identifique el tipo de error
});

$app->get('/ingreso/', function (Request $request, Response $response,$arg) {    
    
  $token="";

  $datos=$request->getParam();
  if(isset( $arg['usuario']) && isset( $arg['clave']) )
  {
      $usuario=$ArrayDeParametros['usuario'];
      $clave= $ArrayDeParametros['clave'];

      if(usuario::esValido($usuario,$clave))
      {
        $datos=array('usuario'=>$usuario,'clave'=>$clave);
        $token= AutentificadorJWT::CrearToken($datos);
        $retorno=array('datos'=> $datos, 'token'=>$token );
        $newResponse = $response->withJson( $retorno ,200); 
      }
      else
      {
        $retorno=array('error'=> "no es usuario valido" );
        $newResponse = $response->withJson( $retorno ,409); 
      }
  }else
  {
        $retorno=array('error'=> "Faltan los datos del usuario y su clave" );
        $newResponse = $response->withJson( $datos  ,411); 
  }
 
  return $newResponse;
   });


//es lo que tiene que hacer cada vez que hay una peticion de datos, y esa epticion de datos necesita loguearse
$app->get('/tomarToken[/]', function (Request $request, Response $response) {    
    
    //EL NOMBRE del token es muy importante, porque es lo que tengo que pasar al frontEnd. apiDoc en linea33 con el nombre
    //
    $arrayConToken = $request->getHeader('miTokenUTNFRA');
    $token=$arrayConToken[0];

    try {

      AutentificadorJWT::VerificarToken($token);
      $response->getBody()->write(" PHP :Su token es ".$token);  
      $respuesta=usuario::Traertodos();    
      $newResponse = $response->withJson($respuesta); 

    } catch (Exception $e) {

      $textoError="error ".$e->getMessage();
      $error = array('tipo' => 'acceso','descripcion' => $textoError);
      $newResponse = $response->withJson( $error , 403); 

    }
    
    return $newResponse;


});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});
$app->run();