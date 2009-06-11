<?php
//require_once( "recursos.php" );
//fnSessionStart();
require('conexion.php');
	require('config.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
    
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
function quitaORinicial($cadena){	
	$orr=substr($cadena,0,3);//extrae los tres primeros carcteres de cadena tratando de buscar OR
	$or= trim($orr);//se quita los espacios en blaco tanto a la derecha como a la izquierda	
	
	if($or=="or" || $or=="OR")//si encuentra OR entonces devuelve el resto de la cadena, excluyendo el OR q se euncuentra al inicio
		$cadena=substr($cadena,4);
			
	return $cadena;
}

function quitaANDinicial($cadena){	
	$orr=substr($cadena,0,4);//extrae los tres primeros carcteres de cadena tratando de buscar OR
	$or= trim($orr);//se quita los espacios en blanco tanto a la derecha como a la izquierda	
	
	if($or=="and" || $or=="AND")//si encuentra OR entonces devuelve el resto de la cadena, excluyendo el OR q se euncuentra al inicio
		$cadena=substr($cadena,4);
			
	return $cadena;
}



$sql="SELECT club.ID_Club, club.N_Nombre NombreClub, cancha.N_Nombre NombreCancha 
FROM cancha, canchaxclub, club, distrito,kiosko, ducha, estacionamiento,servicioxclub, servicio,tamcancha, tipocancha 
 WHERE cancha.ID_Cancha=canchaxclub.ID_Cancha 
AND cancha.ID_TipoCancha=tipocancha.ID_TipoCancha 
AND cancha.ID_TamanoCancha=tamcancha.ID_TamanoCancha 
AND canchaxclub.ID_Club=club.ID_Club 
AND club.ID_Distrito=distrito.ID_Distrito 
AND club.ID_Kiosko=kiosko.ID_Kiosko 
AND club.ID_Ducha=ducha.ID_Ducha 
AND club.ID_Estacionamiento=estacionamiento.ID_Estacionamiento 
AND club.ID_Club=servicioxclub.ID_Club 
AND servicioxclub.ID_Servicio=servicio.ID_Servicio ";



$result = mysql_query("SELECT * FROM distrito");
$cantDistritos=mysql_num_rows($result);
$distrito="";

for($i=1;$i<=$cantDistritos;$i++){
	$idistrito[$i]=getPageParameter("vendorIds".$i,"");
	if($idistrito[$i]!=""){$distrito.=" OR club.ID_Distrito=".$idistrito[$i];
	}//if
}	
	if($distrito!=""){
		$distrito=quitaORinicial($distrito);	
		$distrito="(".$distrito.")";
		$sql.=" AND $distrito "	;
	}
	
	
	
	
	$result = mysql_query("SELECT * FROM tipocancha");
$cantTipoCancha=mysql_num_rows($result);
$tipo="";

for($i=1;$i<=$cantTipoCancha;$i++){
	$idTipo[$i]=getPageParameter("popup3".$i,"");
	if($idTipo[$i]!=""){$tipo.=" OR cancha.ID_TipoCancha=".$idTipo[$i];
	}//if
}
	
	if($tipo!=""){
		$tipo=quitaORinicial($tipo);	
		$tipo="(".$tipo.")";		
		$sql.=" AND $tipo "	;
	}
			
	
$result = mysql_query("SELECT * FROM tamcancha");
$cantTamCancha=mysql_num_rows($result);
$tamano="";

for($i=1;$i<=$cantTamCancha;$i++){
	$idTamano[$i]=getPageParameter("popup5".$i,"");
	if($idTamano[$i]!=""){$tamano.=" OR cancha.ID_TamanoCancha=".$idTamano[$i];
	}//if
}
	
	if($tamano!=""){
		$tamano=quitaORinicial($tamano);	
		$tamano="(".$tamano.")";		
		$sql.=" AND $tamano "	;
	}
		
		
	/**** PRECIO ******/
	$precio="";	
		$precioMin=getPageParameter("precioMinimo","");
		$precioMax=getPageParameter("precioMaximo","");
	
	if($precioMin=="")
	$precioMin="(SELECT min(C_precio) FROM cancha)";	
	if($precioMax=="" || $precioMax=="0")
	$precioMax="(SELECT max(C_precio) FROM cancha)";	
		
	$precio="cancha.C_Precio BETWEEN $precioMin AND $precioMax";
	$precio="(".$precio.")";
	$sql.=" AND $precio "	;
		
	
	
	$result = mysql_query("SELECT * FROM servicio");
$cantServicio=mysql_num_rows($result);
$servicios="";

for($i=1;$i<=$cantServicio;$i++){
	$nombreServ[$i]=getPageParameter("popup4".$i,"");
	if($nombreServ[$i]!=""){$servicios.=" OR servicio.N_Nombre='".$nombreServ[$i]."'";
	}//if
}	
	if($servicios!=""){
		$servicios=quitaORinicial($servicios);	
		$servicios="(".$servicios.")";	
		$sql.=" AND $servicios "	;	
	}
	
	

//$result = mysql_query("SELECT * FROM servicio");
//$cant=mysql_num_rows($result);
$estacionamiento="";
for($i=1;$i<=3;$i++){
	$estac[$i]=getPageParameter("estacionamiento".$i,"");
	if($estac[$i]!=""){
		if($i==1)$estacionamiento.=" AND estacionamiento.F_Pagado=".$estac[$i];
		if($i==2)$estacionamiento.=" AND estacionamiento.F_Gratis=".$estac[$i];
		if($i==3)$estacionamiento.=" AND estacionamiento.F_Vigilado=".$estac[$i];
	}//if
}	
	if($estacionamiento!=""){
		$estacionamiento=quitaANDinicial($estacionamiento);	
		$estacionamiento="(".$estacionamiento.")";		
		$sql.=" AND $estacionamiento "	;
	}
	
	
$ducha="";
for($i=1;$i<=2;$i++){
	$duchaAC[$i]=getPageParameter("duchas".$i,"");
	if($duchaAC[$i]!=""){
		if($i==1)$ducha.="";// OR ducha.F_AguaCaliente=".$duchaAC[$i];
		if($i==2)$ducha.=" OR ducha.F_AguaCaliente=".$duchaAC[$i];
	}//if
}	
	if($ducha!=""){
		$ducha=quitaORinicial($ducha);	
		$ducha="(".$ducha.")";		
		$sql.=" AND $ducha "	;
	}
	
	
	

$kiosko="";
for($i=1;$i<=2;$i++){
	$kioskoCh[$i]=getPageParameter("kiosko".$i,"");
	if($kioskoCh[$i]!=""){
		if($i==1)$kiosko.="";// OR kiosko.F_Chela=".$kioskoCh[$i];
		if($i==2)$kiosko.=" OR kiosko.F_Chela=".$kioskoCh[$i];
	}//if
}	
	if($kiosko!=""){
		$kiosko=quitaORinicial($kiosko);	
		$kiosko="(".$kiosko.")";		
		$sql.=" AND $kiosko "	;
	}
	
	$sql.=" GROUP BY club.ID_Club ";
	
	echo $distrito;
	echo "<br>***********************<br>";	
	echo $tipo;
	echo "<br>***********************<br>";
	echo $tamano;
	echo "<br>***********************<br>";
	echo $precio;
	echo "<br>***********************<br>";
	echo $servicios;
	echo "<br>***********************<br>";
	echo $estacionamiento;
	echo "<br>***********************<br>";
	echo $ducha;
	echo "<br>***********************<br>";
	echo $kiosko;
	echo "<br>_______________________________________________________________________________________________<br>";
	echo "CONSULTA :<br>".$sql;

$_SESSION['query']=$sql;
$result = mysql_query($sql);
$cantClubEncontrados=mysql_num_rows($result);

if($cantClubEncontrados > 0)
	{ 
		while ($row = mysql_fetch_array($result)){
		
		?>
		
		
              <div class="search_gridView_container_box">
                <div class="featuredProduct">&nbsp;</div>
                <div class="productImage">
             
                  
                  <a href="#"  ><img src="<?php printf($ruta_img.$row["ID_Club"].".jpg"); ?>"  width="160" height="160"  border="0"> </a> </div>
                <!-- productImage DIV *** END -->
                <div class="prodTitle"> <a href="#"  class="prod_title"  ><b> <?php echo $row["NombreClub"]; ?></b> </a> </div>
                <div class="price" >
                  <p><a href="#" rel="nofollow">$000.00</a> </p>
                </div>
                <div class="shopBtn"> <a href="reservar.php?club=<?php echo $row['ID_Club'];?>" class="comparePricesBtn"><span>Reservar</span> </a> </div>
                <div class="moreInfo"><a>&nbsp;</a></div>
                <div class="search_gridView_containerBottom">
                  &nbsp;
                 <!-- <ul>
                    <li><a href="#" onMouseOver="showDescription(this,'review_Desc_89656464')" onMouseOut="hideDescription('review_Desc_89656464')" ><img src="images/rating_4_5_newr.gif" height=11 width=60 alt="4.5 Star Review" border=0></a></li>
                    
                  </ul> -->
                </div>
                <!-- search_gridView_containerBottom DIV *** END -->
              </div>
              <!-- search_gridView_container_box DIV *** END -->
		
	<?php		
	}//while
}//if

else printf("<br><br><b>NO SE ENCONTRO CLUB SEGUN LOS CRITERIOS DE BUSQUEDA");

  ?>