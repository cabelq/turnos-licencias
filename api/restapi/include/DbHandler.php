<?php
/**
 *
 * @About:      Database connection manager class
 * @File:       Database.php
 * @Date:       $Date:$ Nov-2015
 * @Version:    $Rev:$ 1.0
 * @Developer:  Federico Guzman (federicoguzman@gmail.com)
 **/
class DbHandler {
 
    var $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
 
    public function createAuto($array)
    {
        //aqui puede incluir la logica para insertar el nuevo auto a tu base de datos
    }
 
    public function esFeriado($dia)
    {
        $feriado_query = "SELECT fecha FROM feriados WHERE fecha = ?";
        $fer = $this->conn->prepare( $feriado_query );
        $fer->execute( array($dia) );
        $datos_feriado = $fer->fetch();
        if ( $fer->rowCount() == 0 ) {
            return false;
        } else {
            return true;
        }
    }

    public function totalTurnos($fecha)
    {
        $query = "SELECT COUNT(fecha_turno) AS total FROM turnos where fecha_turno = ? AND fecha_anulado IS NULL ORDER BY orden_turno";
        $turnos = $this->conn->prepare($query);
        $turnos->execute( array($fecha) );
        while ( $row = $turnos->fetch() ) {
            return $row['total'];
        }
    }

    public function getTurnosAsignados($fecha) {
        $sql = "SELECT * FROM v_turnos WHERE Fecha = ? AND Anulado IS NULL AND Estado_Registro_Vencimiento = 0 ORDER BY Turno ASC" ;
        
        $turnos = $this->conn->prepare( $sql );
        $turnos->execute( array($fecha) );
        $turnos_asginados = $turnos->fetchAll();
        return $turnos_asginados;
    }

    public function getTurnosAsignadosFechaDni($fecha, $dni) {
        $sql = "SELECT * FROM v_turnos WHERE Fecha = ? AND Dni = ? AND Anulado IS NULL AND Estado_Registro_Vencimiento = 0 ORDER BY Turno ASC" ;
        
        $turnos = $this->conn->prepare( $sql );
        $turnos->execute( array($fecha, $dni) );
        $turnos_asginados = $turnos->fetchAll();
        return $turnos_asginados;
    }    

    public function getTurnosAsignadosDni( $dni) {
        $sql = "SELECT * FROM v_turnos WHERE  Dni = ? AND Anulado IS NULL AND Estado_Registro_Vencimiento = 0 ORDER BY Turno ASC" ;
        
        $turnos = $this->conn->prepare( $sql );
        $turnos->execute( array($dni) );
        $turnos_asginados = $turnos->fetchAll();
        return $turnos_asginados;
    }  

    public function getFeriados( $anio) {
      
        $sql = "SELECT * FROM feriados WHERE fecha BETWEEN '" . $anio . "-01-01' AND '" . $anio . "-12-31' ORDER BY fecha ASC" ;
        
		
        $q = $this->conn->prepare( $sql );
        // $q->execute( array($anio) );
        $q->execute( );
        $feriados = $q->fetchAll();
        
        return $feriados;
    }  

    public function login($usuario, $pass) {
        
        $password = md5($pass);
        $return = array();
       
		$sth = $this->conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $sth->execute( array($usuario));
		if( $row = $sth->fetch() ) {
			if($row["password"] == $password) {
				if ( $row["estado"] == 1 ) {
					if ( time() <= strtotime( "13:00:00" ) || $row ['tipo'] == 1 ) {
                        						//Grabo en LOGS//
						// $sth2 = $this->conn->prepare("INSERT INTO logs (id_usuario, entra) VALUES (?,?)");
						// $fechHora =  date("Y-m-d H:i:s");
                        // $sth2->execute(array($usuario, $fechHora));
                        $return["error"] = false;
                        $return["message"] = "usuario  "; //  . count($turnos); //podemos usar count() para conocer el total de valores de un array
                        $return["usuario"] = $row;
     					
					} else {
						grabarLogNoPermitido($usuario,$pass);
                        $return["error"] = true;
                        $return["message"] = "Horario no permitido.";
                        $return["usuario"] = [];
					}
				} else {
					grabarLogNoPermitido($usuario,$pass);
					// echo $mensaje_error_1;
                    $return["error"] = true;
                    $return["message"] = "Usuario sin permisos.";
                    $return["usuario"] = [];
            }
			} else {
                // echo $mensaje_error;
                $return["error"] = true;
                $return["message"] = "Usuario o contraseña incorrectos.";
                $return["usuario"] = [];
			}
		} else {
            $return["error"] = true;
            $return["message"] = "Usuario o contraseña incorrectos1.";
            $return["usuario"] = [];
		}
		
        return $return;
    }

    /*public function grabarLogNoPermitido($usuario,$password) {
        // $dbh = crear_pdo();
        $sth2 = $this->conn->>prepare("INSERT INTO logs_intentos (usuario, password, fechaHora) VALUES (?,?,?)");
        $sth2->execute(array($usuario, $password, date("Y-m-d H:i:s")));
    }    */
}


?>