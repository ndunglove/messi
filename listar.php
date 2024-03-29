<?php
session_start();
require('conexion.php');
require('config.php');
//require_once 'PHPPaging.lib.php'; 

/* function getPageParameter($nombre, $defaultvalue, $debug=false):
 * Funci�n que busca y devuelve un parametro '$nombre' de Pagina 
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
	$orr=substr($cadena,0,4);//extrae los tres primeros caracteres de cadena tratando de buscar OR
	$or= trim($orr);//se quita los espacios en blanco tanto a la derecha como a la izquierda	
	
	if($or=="and" || $or=="AND")//si encuentra OR entonces devuelve el resto de la cadena, excluyendo el OR q se euncuentra al inicio
		$cadena=substr($cadena,4);
			
	return $cadena;
}


$dep=getPageParameter("iddeporte","");
	
$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
mysql_select_db($MySQL_BaseDatos, $link);
 
//$paging = new PHPPaging($link);
//$paging->porPagina(8);
//$paging->mostrarActual("<span class=\"navthis\">{n}</span>"); 
//$paging->nombreVariable("pag"); 
//$paging->linkEstructura('deporte_index.php?pag={n}');
 
$sql="";
$select="SELECT club.ID_Club, club.N_Nombre NombreClub, cancha.ID_Cancha, cancha.N_Nombre NombreCancha, cancha.T_Imagen  Img, canchaxclub.C_Reputacion rep, canchaxclub.C_Precio precio ";
$from="FROM club, canchaxclub, cancha  ";
$where=" WHERE club.ID_Club=canchaxclub.ID_Club 
AND canchaxclub.ID_cancha=cancha.ID_Cancha AND cancha.F_Estado=1 AND club.F_Estado=1 AND cancha.ID_Deporte=".$_SESSION["deporte"]." ";


		/**** DISTRITO ******/
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
		$from.=", distrito";
		$where.=" AND club.ID_Distrito=distrito.ID_Distrito 
		AND ".$distrito." "	;
	}
	
		/**** RANKING CANCHA *****	*/
	$rep="";
	$repCH=getPageParameter("rank","");
 	if($repCH!=""){
		$rep=" ORDER BY canchaxclub.C_Reputacion DESC";
	}
  	 

	
		/**** TIPO CANCHA ******/	
$result = mysql_query("SELECT * FROM tipocancha WHERE ID_Deporte=".$dep);
$cantTipoCancha=mysql_num_rows($result);
$tipo="";

for($i=1;$i<=$cantTipoCancha;$i++){
	$idTipo[$i]=getPageParameter("popup3".$i,"");
	if($idTipo[$i]!="")
	  {$tipo.=" OR cancha.ID_TipoCancha=".$idTipo[$i];}//if
}
	
	if($tipo!=""){
		$tipo=quitaORinicial($tipo);	
		$tipo="(".$tipo.")";		
		$from.=",tipocancha";
		$where.=" AND cancha.ID_TipoCancha=tipocancha.ID_TipoCancha 
		AND ".$tipo." "	;
	}
			
	/**** TAMANO CANCHA ******/
$result = mysql_query("SELECT * FROM tamcancha WHERE ID_Deporte=".$dep);
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
		$from.=", tamcancha";		
		$where.=" AND cancha.ID_TamanoCancha=tamcancha.ID_TamanoCancha 
		AND ".$tamano." ";
	}
				
	/**** PRECIO ******/
	$precio="";	
		$precioMin=getPageParameter("precioMinimo","");
		$precioMax=getPageParameter("precioMaximo","");
	
	if($precioMin=="")
	$precioMin="(SELECT min(C_precio) FROM canchaxclub)";	
	if($precioMax=="" || $precioMax=="0")
	$precioMax="(SELECT max(C_precio) FROM canchaxclub)";	
		
	$precio="canchaxclub.C_Precio BETWEEN $precioMin AND $precioMax";
	$precio="(".$precio.")";
	$where.=" AND $precio "	;
		
	
	/**** SERVICIOS ******/
	$result = mysql_query("SELECT * FROM servicio WHERE ID_Deporte=".$dep);
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
		$from.=", servicioxclub, servicio";
		$where.=" AND club.ID_Club=servicioxclub.ID_Club 
AND servicioxclub.ID_Servicio=servicio.ID_Servicio 
AND ".$servicios." "	;	
	}
	
	
		/**** ESTACIONAMIENTO ******/

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
		$from.=", estacionamiento";
		$where.=" AND club.ID_Estacionamiento=estacionamiento.ID_Estacionamiento 
		AND ".$estacionamiento." "	;
	}
	
		/**** DUCHAS ******/	
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
		$from.=", ducha";
		$where.=" AND club.ID_Ducha=ducha.ID_Ducha 
		AND ".$ducha." ";
	}
	
	
	  /**** KIOSKO ******/
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
		$from.=", kiosko ";
		$where.=" AND club.ID_Kiosko=kiosko.ID_Kiosko 
		AND ". $kiosko." ";
	}
		
	
	
	
/*	
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
	echo "<b>SELECT: </b>".$select;
	echo "<br>";
	echo "<b>FROM : </b>".$from;
	echo "<br>";
	echo "<b>WHERE: </b>".$where;
*/	

//$aux3=" GROUP BY cancha.ID_Cancha ";
$_SESSION["query"]=$select.$from.$where;

$where.=" GROUP BY club.ID_Club, cancha.ID_cancha";
$relevancia =" ORDER BY club.C_Relevancia, canchaxclub.C_Relevancia DESC";
//$sql=$select.$from.$where.$rep;
$sql=$select.$from.$where.$rep;

//echo "<br/><b>CONSULTA: </b><br/>".$sql;	
//$paging->agregarConsulta($sql); 
//$paging->ejecutar();
//$result = mysql_query($sql);
//$cantClubEncontrados=$paging->numTotalRegistros();
$i=0;

$result=mysql_query($sql);

if($result!=false)
	{ 
	//$links = $paging->fetchNavegacion();
//	if ($paging->numTotalPaginas()>1)
//		print('<div class="navi">'.$links.'</div><br/>');
		$cont=mysql_num_rows($result);
		if ($cont==0)
		{
			print("<b>No se encontraron resultados con el criterio especificado.</b>");	
		}
		
		while ($row = mysql_fetch_array($result)){	
		?>
		 
							
				<div class="search_gridView_container_box">
                <div class="featuredProduct">&nbsp;</div>
                <div class="productImage">             
                  
                  <a href="ver_club.php?id=<?php echo $row['ID_Club'];?>" target="_blank" onclick="abrir(this.href); return false"><img src="<?php print($ruta_img.$row['ID_Club'].".jpg"); ?>"  width="90" height="90"  border="0"> </a> </div>
                <!-- productImage DIV *** END -->
                <div class="prodTitle"> 
                	<a href="ver_club.php?id=<?php echo $row['ID_Club'];?>" target="_blank" onclick="abrir(this.href); return false"><b> <?php echo $row["NombreClub"]; ?></b></a><br/>
                    <a href="ver_cancha.php?club=<?php echo $row['ID_Club'];?>&id=<?php echo $row['ID_Cancha'];?>" target="_blank" onclick="abrir(this.href); return false"> <b><?php echo $row["NombreCancha"]; ?></b></a><br/>
                    <span style="font-weight:bold; font-size:15px;color:#1C8C00;" >desde S/. <?php echo $row["precio"]; ?> </span> </div>
               
             	<div class="productImage2"> 
                  <a href="ver_cancha.php?club=<?php echo $row['ID_Club'];?>&id=<?php echo $row['ID_Cancha'];?>" target="_blank" onclick="abrir(this.href); return false"><img src="<?php print($row['Img']); ?>"  width="150" height="150"  border="0"> </a> </div>
                <!-- productImage DIV *** END -->
                <div class="shopBtn"> <a href="deporte_horario.php?club=<?php echo $row['ID_Club'];?>&cancha=<?php echo $row['ID_Cancha'];?>" class="comparePricesBtn"><span>Reservar</span> </a> </div>
                <div class="moreInfo"><a>&nbsp;</a></div>
                <div class="search_gridView_containerBottom">
                   <ul>
            <li>
            <a >Puntuaci&oacute;n: <img src="images/rating_<?php 
				$tempor=$row['rep'];
				$rank="";
				switch ($tempor) {
					case 1:   $rank="1"; break;
					case 1.5: $rank="1_5"; break;
					case 2:   $rank=2; break;
					case 2.5: $rank="2_5"; break;
					case 3:	  $rank=3; break;
					case 3.5: $rank="3_5"; break;
					case 4:   $rank=4; break;
					case 4.5: $rank="4_5"; break;
					case 5:   $rank=5; break;
					default:  $rank=0; break;
					}
				echo $rank;			
			?>.gif" height=11 width=60 border=0></a>
        </li></ul>
          
                </div>
                <!-- search_gridView_containerBottom DIV *** END -->
              </div>
              <!-- search_gridView_container_box DIV *** END -->
           
		
	<?php		
	}//while
	
			
}//if

else printf("<center><br/><br/><b>NO SE ENCONTRO CLUB SEGUN LOS CRITERIOS DE BUSQUEDA</b></center><br/><br/>");

?>