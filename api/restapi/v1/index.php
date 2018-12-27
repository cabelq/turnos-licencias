<?php
/**
 *
 * @About:      API Interface
 * @File:       index.php
 * @Date:       $Date:$ Nov-2015
 * @Version:    $Rev:$ 1.0
 * @Developer:  Federico Guzman (federicoguzman@gmail.com)
 **/

/* Los headers permiten acceso desde otro dominio (CORS) a nuestro REST API o desde un cliente remoto via HTTP
 * Removiendo las lineas header() limitamos el acceso a nuestro RESTfull API a el mismo dominio
 * Nótese los métodos permitidos en Access-Control-Allow-Methods. Esto nos permite limitar los métodos de consulta a nuestro RESTfull API
 * Mas información: https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
 **/
header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: authorization");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');


if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
header( "HTTP/1.1 200 OK" );
exit();
}

include_once '../include/Config.php';

/* Puedes utilizar este file para conectar con base de datos incluido en este demo; 
 * si lo usas debes eliminar el include_once del file Config ya que le mismo está incluido en DBHandler 
 **/
require_once '../include/DbHandler.php'; 
// require 'vendor/autoload.php';

require '../libs/Slim/Slim.php'; 
require '../libs/JWT/JWT.php'; 
require '../libs/JWT/BeforeValidException.php'; 
require '../libs/JWT/ExpiredException.php'; 
require '../libs/JWT/SignatureInvalidException.php'; 

\Slim\Slim::registerAutoloader(); 
use \Firebase\JWT\JWT;
$app = new \Slim\Slim();
$key = 'Turnos_lienciaS';



/* Usando GET para consultar los autos */
$app->get('/auto', function() {
    
    $response = array();
    //$db = new DbHandler();

    /* Array de autos para ejemplo response
     * Puesdes usar el resultado de un query a la base de datos mediante un metodo en DBHandler
     **/
    $autos = array( 
                    array('make'=>'Toyota', 'model'=>'Corolla', 'year'=>'2006', 'MSRP'=>'18,000'),
                    array('make'=>'Nissan', 'model'=>'Sentra', 'year'=>'2010', 'MSRP'=>'22,000')
            );
    
    $response["error"] = false;
    $response["message"] = "Autos cargados: " . count($autos); //podemos usar count() para conocer el total de valores de un array
    $response["autos"] = $autos;

    echoResponse(200, $response);
});

/* Usando POST para crear un auto */

$app->post('/auto', 'authenticate', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('make', 'model', 'year', 'msrp'));

    $response = array();
    //capturamos los parametros recibidos y los almacxenamos como un nuevo array
    $param['make']  = $app->request->post('make');
    $param['model'] = $app->request->post('model');
    $param['year']  = $app->request->post('year');
    $param['msrp']  = $app->request->post('msrp');
    
    /* Podemos inicializar la conexion a la base de datos si queremos hacer uso de esta para procesar los parametros con DB */
    //$db = new DbHandler();

    /* Podemos crear un metodo que almacene el nuevo auto, por ejemplo: */
    //$auto = $db->createAuto($param);

    if ( is_array($param) ) {
        $response["error"] = false;
        $response["message"] = "Auto creado satisfactoriamente!";
        $response["auto"] = $param;
    } else {
        $response["error"] = true;
        $response["message"] = "Error al crear auto. Por favor intenta nuevamente.";
    }
    echoResponse(201, $response);
});


/* Usando POST para crear un auto */

$app->post('/login', function() use ($app, $key) {

    $response = array();
    //capturamos los parametros recibidos y los almacxenamos como un nuevo array
    $parametros = json_decode($app->request->getBody());
    $post = get_object_vars($parametros);
    // Podemos inicializar la conexion a la base de datos si queremos hacer uso de esta para procesar los parametros con DB 
    $db = new DbHandler();

    // Podemos crear un metodo que almacene el nuevo auto, por ejemplo: 
    $login = $db->login($post["usuario"], $post["password"] );

    // if ( is_array($login) ) {
    if (  $login["error"] == false ) {
        $time = time();
        $usuario = $login["usuario"];
        $token = array(
            'iat' => $time, // Tiempo que inició el token
            'exp' => $time + (60*60), // Tiempo que expirará el token (+1 hora)
            'data' => [ // información del usuario
                'id' => $usuario["id_usuario"],
                'name' => $usuario["ApeNom"]
            ]
        );
        // $key = 'Turnos_lienciaS';
        $jwt = \Firebase\JWT\JWT::encode($token, API_KEY);
      
        $response["error"] = $login["error"];
        $response["message"] = $login["message"] ;
        $response["token"] = $jwt;
        $response["expiraEn"] = $time + (60*60);
        $response["usuario"] = $usuario["ApeNom"];        
        echoResponse(200, $response);
    } else {
        $response["error"] = true;
        $response["message"] = "Error en login. Por favor intenta nuevamente.";
        echoResponse(401, $response);
        $app->stop();
    }
  
});

/* Usando GET para consultar los turnos asignados */
$app->get('/turnosasignados/:dia/:mes/:anio', 'authenticate', function($dia,$mes,$anio) {
    
    $fecha = $anio . '/'. $mes .'/'. $dia;
    
    $response = array();

    $dbh = new DbHandler();
    $turnos = $dbh->getTurnosAsignados($fecha);
    
    $response["error"] = false;
    $response["message"] = "Turnos asignados : " . count($turnos); //podemos usar count() para conocer el total de valores de un array
    $response["turnosasignados"] = $turnos;

    echoResponse(200, $response);
});

/* Usando GET para consultar los turnos asignados por fecha y dni */
$app->get('/turnosasignados/:dia/:mes/:anio/:dni', 'authenticate', function($dia,$mes,$anio,$dni) {
    
    $fecha = $anio . '/'. $mes .'/'. $dia;
    
    $response = array();

    $dbh = new DbHandler();
    $turnos = $dbh->getTurnosAsignadosFechaDni($fecha,$dni);
    
    $response["error"] = false;
    $response["message"] = "Turnos asignados : " . count($turnos); //podemos usar count() para conocer el total de valores de un array
    $response["turnosasignados"] = $turnos;

    echoResponse(200, $response);
});

/* Usando GET para consultar los turnos asignados por fecha y dni */
$app->get('/turnosasignados/:dni', 'authenticate', function($dni) {
    
    
    $response = array();

    $dbh = new DbHandler();
    $turnos = $dbh->getTurnosAsignadosDni($dni);
    
    $response["error"] = false;
    $response["message"] = "Turnos asignados : " . count($turnos); //podemos usar count() para conocer el total de valores de un array
    $response["turnosasignados"] = $turnos;

    echoResponse(200, $response);
});

/* Usando GET para consultar los turnos asignados por fecha y dni */
$app->get('/feriados/:anio', 'authenticate', function($anio) {
    
    
    $response = array();

    $dbh = new DbHandler();
    $feriados = $dbh->getFeriados($anio);
    
    $response["error"] = false;
    $response["message"] = "Feriados : " . count($feriados); //podemos usar count() para conocer el total de valores de un array
    $response["feriados"] = $feriados;

    echoResponse(200, $response);
});
 
/* Usando GET para consultar los turnos extendidos */
$app->get('/turnosextendidos', 'authenticate',function() {
    

    $ret = generaFechaTurno( date ("Y-m-d") );
    $response["error"] = false;
    $response["message"] = "get turnos!";
    $response["turnosextendidos"] = $ret;
    echoResponse(200, $response);
});


/* corremos la aplicación */
$app->run();

/*********************** USEFULL FUNCTIONS **************************************/

/**
 * Verificando los parametros requeridos en el metodo o endpoint
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
 
    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        
        $app->stop();
    }
}
 
/**
 * FUNCIONES DE BILELLO
 */
function compararFechas( $fecha, $hoy ) {
    $valoresPrimera = explode ("/", $fecha);
    $valoresSegunda = explode ("/", $hoy);
    $diaPrimera = $valoresPrimera[0];
    $mesPrimera = $valoresPrimera[1];
    $anyoPrimera = $valoresPrimera[2];
    $diaSegunda = $valoresSegunda[0];
    $mesSegunda = $valoresSegunda[1];
    $anyoSegunda = $valoresSegunda[2];
    $diasPrimeraJuliano = gregoriantojd( $mesPrimera, $diaPrimera, $anyoPrimera );
    $diasSegundaJuliano = gregoriantojd( $mesSegunda, $diaSegunda, $anyoSegunda );
    if( !checkdate( $mesPrimera, $diaPrimera, $anyoPrimera ) ) {
        // "La fecha ".$fecha." no es valida";
        return 0;
    } elseif ( !checkdate( $mesSegunda, $diaSegunda, $anyoSegunda ) ) {
        // "La fecha ".$hoy." no es valida";
        return 0;
    } else {
        return $diasPrimeraJuliano - $diasSegundaJuliano;
    }
}

function calcularFinSem ( $f ) {
    $dia_sem = date("N", strtotime($f));
    if($dia_sem == 6 or $dia_sem == 7) {
        return false;
    } else {
        return true;
    }
    return true;
}

function esFeriado( $dia ) {
    // Podemos inicializar la conexion a la base de datos si queremos hacer uso de esta para procesar los parametros con DB 
    $dbh = new DbHandler();
    return $dbh->esFeriado($dia);
}

function totalTurnos($fecha ) {
    $f = explode("/", $fecha);
    $d1 = $f[0];
    $m1 = $f[1];
    $y1 = $f[2];
    $f1 = $y1."/".$m1."/".$d1;

    // Podemos inicializar la conexion a la base de datos si queremos hacer uso de esta para procesar los parametros con DB 
    $dbh = new DbHandler();
    return $dbh->totalTurnos($f1);
}
function generaFechaTurno ( $vencimiento ) {
    $response = array();

    setlocale ( LC_TIME, 'spanish' ); //Cambio la configuraci�n de tiempo en PHP a nuestra regi�n
    //$vencimiento = date('Y/m/d'); //Linea agregada 09/08/2016. Funcion pincha cuando quiere calcular los arrays con las fechas posibles
                                    // en base al vencimiento real de la licencia.
    //$vencimiento = '2017/01/15';
    

    //Calculo dias de vencimiento antes y despues de la fecha
    //que figura en la licencia.
    $cnt = 0; //Inicializo en 0 para que me cuente el d�a del vencimiento inclusive.
    $indice = 0;
    $fecha_propuesta1 = Array();
    while ($cnt <= 1 ) { //Linea modificada el 21/11/2016 pedido por PASSINI "while ( $cnt <= 45 ) {"
        
        $fecha = date("d/m/Y", strtotime("$vencimiento - $cnt day"));
        $f = explode("/", $fecha);
        $d1 = $f[0];
        $m1 = $f[1];
        $y1 = $f[2];
        $f1 = $y1."/".$m1."/".$d1;
         if ( compararFechas( date('d/m/Y'),$fecha) >= 0 ) { //Pregunto si prox. fecha a proponer es pasado el dia de hoy, caso contrario no la propongo
           if ( !esFeriado($f1) ) { //Pregunto por si el dia es feriado. Tomo datos de MySQL.
                if ( calcularFinSem ( $f1 ) ) { //Pregunto si es fin de semana.
                    $fecha_propuesta1[$indice] = $fecha;
                    $indice++;
                }
            }

        }
        
        $cnt++;
    }
   
    krsort($fecha_propuesta1); //Ordeno de menor a mayor las fechas guardadas en el array.

    $cnt = 1; //Inicializo en 1 para que no me cuente el d�a del vencimiento (Ya lo inlui en calculo anterior).
    $fecha_propuesta2 = Array();
    while ( $cnt <= 365 ) {  //Linea modificada el 13/09/2016 pedido por PASSINI "while ( $cnt <= 90 ) {"
        $fecha = date("d/m/Y", strtotime("$vencimiento + $cnt day"));
        $f = explode("/", $fecha);
        $d1 = $f[0];
        $m1 = $f[1];
        $y1 = $f[2];
        $f1 = $y1."/".$m1."/".$d1;
        if ( compararFechas($fecha, date('d/m/Y')) >= 0 ) {
            if ( calcularFinSem ( $f1 ) ) {
                if ( !esFeriado($f1) ) {
                    $fecha_propuesta2[$indice] = $fecha;
                    $indice++;
                }
            }
        }
        $cnt++;
    }
   
    $fecha_propuesta3 = array_merge($fecha_propuesta1, $fecha_propuesta2);
    $ret = array();
    for($i = 0; $i < count($fecha_propuesta3); $i++) {
        // $ret[($i + 1).",$fecha_propuesta3[$i]"] = $fecha_propuesta3[$i];
        $retintem = array('fecha'=>$fecha_propuesta3[$i] , 'cantidadTurnos'=>totalTurnos($fecha_propuesta3[$i])
            , 'diaSemana'=>nomDia($fecha_propuesta3[$i]));
        // print_r($retintem);
        array_push($ret, $retintem);
    }
    return $ret;
}

/**
 * Validando parametro email si necesario; un Extra ;)
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoResponse(400, $response);
        
        $app->stop();
    }
}
 

function nomDia($fecha_ingles){
    $f = explode("/", $fecha_ingles);
    $d1 = $f[0];
    $m1 = $f[1];
    $y1 = $f[2];
    setlocale(LC_TIME, 'spanish');
    
    $nombre= utf8_encode(strftime("%A",mktime(0, 0, 0, $m1, $d1, $y1))); 
    return ucwords($nombre);
}


/**
 * Mostrando la respuesta en formato json al cliente o navegador
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
    // setting response content type to json
    $app->contentType('application/json');
 
    echo json_encode($response);
}

/**
 * Agregando un leyer intermedio e autenticación para uno o todos los metodos, usar segun necesidad
 * Revisa si la consulta contiene un Header "Authorization" para validar
 */
function authenticate(\Slim\Route $route)  {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        //$db = new DbHandler(); //utilizar para manejar autenticacion contra base de datos
 
        // get the api key
        $token = $headers['Authorization'];
       
       
       try {
             (new \Firebase\JWT\JWT())->decode($token, API_KEY, array('HS256'));
            
        } catch (\InvalidArgumentException $e) {
            // Key may not be empty
            $response["error"] = true;
            $response["message"] = "La llave no puede estar vacía";
            echoResponse(401, $response);
            $app->stop();
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            // Signature verification failed
            $response["error"] = true;
            $response["message"] = "Verificación de firma fallida";
            echoResponse(401, $response);
            $app->stop();
        } catch (\Firebase\JWT\BeforeValidException $e) {
            // Cannot handle token prior to <datetime>
            $response["error"] = true;
            $response["message"] = "No se puede manejar el token antes de <datetime>";
            echoResponse(401, $response);
            $app->stop();
        } catch (\Firebase\JWT\ExpiredException $e) {
            // Expired token
            $response["error"] = true;
            $response["message"] = "El token ha expirado";
            echoResponse(401, $response);
            $app->stop();
        } catch (\UnexpectedValueException $e) {
            // Wrong number of segments
            // Invalid header encoding
            // Invalid claims encoding
            // Invalid signature encoding
            // Empty algorithm
            // Algorithm not supported
            // Algorithm not allowed
            // "kid" invalid, unable to lookup correct key
            // "kid" empty, unable to lookup correct key           
            $response["error"] = true;
            $response["message"] = "Número incorrecto de segmentos";
            echoResponse(401, $response);            
            $app->stop();
        } catch (\DomainException $e) {
            // Null result with non-null input --at json decode
            // Algorithm not supported --at verify
            // OpenSSL error: <error> --at verify
            $response["error"] = true;
            $response["message"] = "Resultado nulo con entrada no nula - en decodificación json";
            $response["e"] = $e;
            echoResponse(401, $response);              
            $app->stop();
        } catch (\Exception $e) {
            // NA
            $response["error"] = true;
            $response["message"] = "NN";
            echoResponse(401, $response);    
            $app->stop();
        }

    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Falta token de autorización";
        echoResponse(401, $response);
        
        $app->stop();
    }
}
?>