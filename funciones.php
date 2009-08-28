<?php 
	require ("config.php");
	
	//////////////////////////////////////////////////// 
//Convierte fecha de mysql a normal 
//////////////////////////////////////////////////// 
function cambiaf_a_normal($fecha){ 
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); 
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
    return $lafecha; 
} 

//////////////////////////////////////////////////// 
//Convierte fecha de normal a mysql 
//////////////////////////////////////////////////// 

function cambiaf_a_mysql($fecha){ 
    ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})", $fecha, $mifecha); 
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
    return $lafecha; 
} 


	//manejo de fechas
		$Dia=date("j",time());
		$NDia=date("l",time());
		$Mes=date("n",time());
		$Anio=date("Y",time());

		$aux="";
		$aux3="";
		Switch ($NDia) {
		case "Monday": 	$aux="Lunes"; 
						$aux3=1;
						break;
		case "Tuesday":	$aux="Martes"; 
						$aux3=2;
						break;
		case "Wednesday":$aux="Mi&eacute;rcoles"; 
						$aux3=3;
						break;
		case "Thursday":$aux="Jueves"; 
						$aux3=4;
						break;
		case "Friday":	$aux="Viernes"; 
						$aux3=5;
						break;
		case "Saturday":$aux="S&aacute;bado"; 
						$aux3=6;
						break;
		case "Sunday":	$aux="Domingo"; 
						$aux3=7;
						break;
		}

		$aux2="";
		Switch ($Mes) {
		case 1: $aux2="Enero"; break;
		case 2:$aux2="Febrero"; break;
		case 3:$aux2="Marzo"; break;
		case 4:$aux2="Abril"; break;
		case 5:$aux2="Mayo"; break;
		case 6:$aux2="Junio"; break;
		case 7:$aux2="Julio"; break;
		case 8:$aux2="Agosto"; break;
		case 9:$aux2="Septiembre"; break;
		case 10:$aux2="Octubre"; break;
		case 11:$aux2="Noviembre"; break;
		case 12:$aux2="Diciembre"; break;
		}

		/*if (strlen($Dia)==1)
			{$Dia="0".$Dia;}*/

		$NMes=$aux2;
		$NDia=$aux;
		$CDia=$aux3;
	
	$fechaN=$Dia."/".$NMes."/".$Anio;
	$fecha=$Dia."/".$Mes."/".$Anio;
	
	function get_NDia($id)
	{
		$nombre="";
		Switch ($id) {
		case 1: $nombre="Lunes"; 
						break;
		case 2:	$nombre="Martes"; 		
						break;
		case 3:	$nombre="Mi&eacute;rcoles"; 
						break;
		case 4:	$nombre="Jueves"; 
						break;
		case 5:	$nombre="Viernes"; 
						break;
		case 6:	$nombre="S&aacute;bado"; 
						break;
		case 7:	$nombre="Domingo"; 
						break;
		}
		
		return $nombre;
	}
	
	function DaysInMonth($mes,$anio)
    {
		$dias=31;	
    	 if ( $mes==4 || $mes==6 || $mes==9 || $mes==11)
		  	  $dias=30;
         else if ($mes==2)
		 	  {	if ((($anio % 4 == 0) && ($anio % 100 != 0)) || ($anio % 400==0))
                   $dias=29;
                else $dias=28;
			  }               
         
         return $dias;
    }
	
	function aumenta_fecha($fecha_Inicio,$inc)
	{
		$fecha_aux = split('/',$fecha_Inicio);		
        
        if ($fecha_aux[0] + $inc <= DaysInMonth($fecha_aux[1],$fecha_aux[2]))
        {
            $fecha_aux[0]=$fecha_aux[0]+$inc;
        }
        else if ($fecha_aux[0] + $inc > DaysInMonth($fecha_aux[1],$fecha_aux[2]))
        {
            if ($fecha_aux[1] + 1 < 13)
                {                    
                    $aux=$fecha_aux[0]+$inc-DaysInMonth($fecha_aux[1],$fecha_aux[2]);
					$fecha_aux[1]=$fecha_aux[1]+1;
					$fecha_aux[0]=$aux;
                }
            else if ($fecha_aux[1] + 1 >= 13)
                {
					$aux=$fecha_aux[0]+$inc-DaysInMonth($fecha_aux[1],$fecha_aux[2]);
                    $fecha_aux[2]=$fecha_aux[2]+1;
                    $fecha_aux[1]=1;
                    $fecha_aux[0]=$aux;
                }                
        }        
		$fecha=$fecha_aux[0]."/".$fecha_aux[1]."/".$fecha_aux[2];
		return $fecha;
	}
	
	
	//FIN fechas

//inicio reservas


/* function fnConnect( &$msg ):
 * Función que se conecta con el servidor
 * y selecciona la base de datos activa.
 * Retorna un mensaje en caso exista error.
*/
function fnConnect( &$msg ){
	$cn=mysql_connect("localhost","root","");
	if(!$cn){
		$msg = "Error en la conexión.";
		return 0;
	}
	$n = mysql_select_db("dbcanchasonline",$cn);
	if(!$n){
		$msg = "Base de datos no existe.";
		mysql_close($cn);
		return 0;
	}
	return $cn;
}


/* function fnSessionStart():
 * Función que inicia una sesión en el caso que no exista una.
*/

function fnSessionStart(){
	if (!session_id()) {
   session_start();
	}
}

/*function fnSessionEnd():
 * Función que finaliza una sesión.
*/
function fnSessionEnd(){
	session_unset();
	session_destroy();
}


/* function getPageParameter($nombre, $defaultvalue, $debug=false):
 * Función que busca y devuelve un parametro '$nombre' de Pagina 
 * en el caso que no la encuentre le asigna un valor por defecto '$defaultvalue'.
 * $debug=true nos sirve para saber si el parametro es mediante post o get
*/
function getPageParameter($nombre, $defaultvalue, $debug=false) {
   
   $pageparameter = isset($_GET[$nombre])?$_GET[$nombre]:$defaultvalue;
   if ($debug) echo "P0 ".$nombre.": ".$pageparameter."<br/>\n";
   $pageparameter = ($pageparameter==$defaultvalue && isset($_POST[$nombre]))?$_POST[$nombre]:$pageparameter;
   if ($debug) echo "P1 ".$nombre.": ".$pageparameter."<br/>\n";
   $pageparameter = ($pageparameter=="")?$defaultvalue:$pageparameter;
   if ($debug) echo "P2 ".$nombre.": ".$pageparameter."<br/>\n";
   if ($debug) echo "***<br/>\n";
   if (is_array($pageparameter)) {
      return $pageparameter;
   } else {
      return trim($pageparameter);
   }
}



/* function quitaORinicial($cadena){	
	* Busca y elimina los tres primeros caracteres de cadena tratando de buscar el texto 'OR'	
	* si encuentra OR entonces devuelve el resto de la cadena, excluyendo el OR q se euncuentra al inicio
*/
function quitaORinicial($cadena){	
	$orr=substr($cadena,0,3);//extrae los tres primeros carcteres de cadena tratando de buscar OR
	$or= trim($orr);//se quita los espacios en blaco tanto a la derecha como a la izquierda	
	
	if($or=="or" || $or=="OR")//si encuentra OR entonces devuelve el resto de la cadena, excluyendo el OR q se euncuentra al inicio
		$cadena=substr($cadena,4);
			
	return $cadena;
}


/* function quitaANDinicial($cadena){	
	* Busca y elimina los tres primeros caracteres de cadena tratando de buscar el texto 'AND'	
	* si encuentra OR entonces devuelve el resto de la cadena, excluyendo el OR q se euncuentra al inicio
}
*/
function quitaANDinicial($cadena){	
	$andd=substr($cadena,0,4);//extrae los tres primeros carcteres de cadena tratando de buscar AND
	$and= trim($andd);//se quita los espacios en blaco tanto a la derecha como a la izquierda	
	
	if($and=="and" || $and=="AND" || $and=="&&")//si encuentra AND entonces devuelve el resto de la cadena, excluyendo el OR q se euncuentra al inicio
		$cadena=substr($cadena,5);
	
	return $cadena;

}


/* function fnShowMsg($title,$msg):
 * muestra un mensaje una tabla, con su respectivo titulo
*/

function fnShowMsg($title,$msg){
    writeE("<table align='center' width='300' border='1'>");
    writeE("<tr>");
    writeE("<th>$title</th>");
    writeE("</tr>");
    writeE("<tr>");
		writeE("<td align='center'>$msg</td>");    
    writeE("</tr>");
    writeE("</table>");
}

/* function writeE($cad):
 * sirve para escribir mediante echo una cadena
*/
function writeE($cad){
	echo $cad . "\n";
}

?>