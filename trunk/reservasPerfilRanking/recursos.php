<?php

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