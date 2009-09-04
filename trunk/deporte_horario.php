<?php 
	session_start();
	require ("funciones.php");
	require('conexion.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	//verifica si en la fecha y hora dada 
	function es_reservado($fecha,$hora_inicio,$id_cancha,$link,$id_club){
				$fecha=split("/",$fecha);
				$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
				$result = mysql_query("SELECT * FROM horario h1, hora h2 WHERE h1.ID_Hora=h2.ID_Hora AND ID_Club=".$id_club." AND ID_Cancha=".$id_cancha." AND h1.D_Fecha='".$fecha."' AND h2.D_HoraInicio<=".$hora_inicio." AND h2.D_HoraFin>=".$hora_inicio,$link);
		 		$row = mysql_fetch_row($result);
				if ($row==false)
					return false;
				else return true;
		}
	
	//regresa un row con todos los datos de la chancha
	function dame_Cancha($id_cancha,$link,$depo)
	{
		$result = mysql_query("SELECT cancha.ID_Cancha, cancha.N_Nombre, cancha.F_Techado, tamcancha.N_Nombre, tipocancha.N_Tipo 
							   FROM cancha, tamcancha, tipocancha 
							   WHERE cancha.ID_TamanoCancha=tamcancha.ID_TamanoCancha AND cancha.ID_TipoCancha=tipocancha.ID_TipoCancha AND cancha.ID_Deporte=".$depo." AND cancha.ID_Cancha=".$id_cancha.";",$link);
		$row = mysql_fetch_row($result);
		return $row;			
	}	
	
	//variable de navegación del horario
	if(!isset($_GET["pg"]))
	{
		$pg=1;	
	}
	else $pg=$_GET["pg"];
	
	//variable de deporte
	
	$dep=$_SESSION["deporte"];
	
	//query de prueba
	
	/*$query="SELECT club.ID_Club, club.N_Nombre NombreClub, cancha.ID_Cancha, cancha.N_Nombre NombreCancha 
			FROM cancha, canchaxclub, club, distrito,kiosko, ducha, estacionamiento,servicioxclub, servicio,tamcancha, tipocancha 
			WHERE cancha.ID_Cancha=canchaxclub.ID_Cancha AND canchaxclub.ID_Club=club.ID_Club AND cancha.ID_Deporte=1 
			GROUP BY cancha.ID_Cancha;"; 
	*/
	$query=$_SESSION["query"];
	if (isset($_GET["club"]))
		$_SESSION["club"]=$_GET["club"];
	$club=$_SESSION["club"];
		//limites de paginacion
	if($pg>5) $pg=5;
	if($pg<1) $pg=1;

	//
	
	if (!isset($_POST['action'])) 
	{
		$_POST['action'] = "undefine";
	}

	if ($_POST['action'] == "sel_cancha")
	{
		if (isset($_POST["canchas"]))
		{
			$_SESSION["cancha"]=$_POST["canchas"];
		}
	}

	if (isset($_GET["cancha"]))
		$_SESSION["cancha"]=$_GET["cancha"];
	$cancha=$_SESSION["cancha"];
	$_SESSION["back"]=0;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	if ($dep==1)
		print('<link rel="shortcut icon" href="images/pelota_futbol.ico">');
	else if ($dep==2)
			print('<link rel="shortcut icon" href="images/pelota_tenis.ico">');
?>

<link rel="stylesheet" type="text/css" href="estilos/Estilo.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo3.css" >
<link rel="stylesheet" type="text/css" href="estilos/horario.css" >
<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie6.css" />
  
<![endif]-->
<!--[if gte IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie7.css" />
<![endif]-->
<title>CanchasOnline.com | Reserva de horarios</title>

</style>
<script language="JavaScript"> 
function todos(num) {
	var varCheck = document.getElementById(num);
	var varCheck2 = document.getElementsByTagName("span");
	if (varCheck.checked==true)
	{
		varCheck.checked=false;
		//varCheck.style.display=none;
		//varCheck2[num-1].style.display = "none" ;
		
	}
	else {varCheck.checked=true;
		varCheck2[num-1].style.display = "block" ;
	}
}

function validate(esto) 
{ 
    var error = ''; 
    var validate = false; 
    var input = esto.getElementsByTagName('input'); 
    for(var i=0;i<input.length;i++) 
    { 
        switch(input[i].type) 
        { 
            case 'checkbox': 
                if(input[i].checked==true) 
                { 
                    validate = true; 
                } 
                break; 
            default: 
                break; 
        } 
    } 
    if(validate==true) 
    { 
        return true; 
    } 
    else 
    { 
        alert('Por favor, debe seleccionar al menos una hora de reserva.'); 
        return false; 
    } 
} 
</script>

</head>

<body>
<div id="todo">
<div id="nubes">
<div id="pgSiteContainer" >
<div id="banner">
<div class="logo">
</div>

<?php include('topmenu.php') ?>
<?php 
	if ($dep==1)
		print('<div class="top_futbol"> </div>');
	else if ($dep==2)
			print('<div class="top_tenis"> </div>');
?>

<div class="clearing">&nbsp;</div>
</div>

<div id="pgPageContent">
<div class="top">
</div>
<div class="cuerpo2">
<div class="clearing">&nbsp;</div>


<!--horarios -->
<div id="sa_wrapper">
 <div id="sa_content_wrapper">
    <div id="sa_content">
<div id="sa_listTop">
<div id="sortBy">
            <ul>                
                <li ><em>Paso 2 de 4</em></li>
            </ul>
        </div>
          <div id="sa_products">
          
<div id="horario_container">
<h2> Horario de Reservas </h2>
<h3> <?php 
		//imprime fechas a mostrar en la tabla
		if ($pg==1)
			$fecha_inicio=$fecha;		
		else $fecha_inicio=aumenta_fecha($fecha,7*($pg-1));
		$fecha_fin=aumenta_fecha($fecha_inicio,6);
		printf("(".$fecha_inicio." al ".$fecha_fin.")");  
	?>
</h3>
<br/>

<div id="temporal">
<form method="post" action="deporte_detalle.php" onsubmit="return validate(this)" >
<div align="right" style="padding-right:60px;">
<h4 align="left" style="float:left; padding-left:60px;">
	<?php
		//imprime la navegación
		if ($pg>1)
			{	$ante=$pg-1;
				printf('<a href="deporte_horario.php?pg='.$ante.'" style="font-weight:bold; font-size:11px; color:#09C;">semana anterior</a>');
			}
		if ($pg<5)
			{
				printf(' | ');
				$desp=$pg+1;
				printf(' <a href="deporte_horario.php?pg='.$desp.'" style="font-weight:bold; font-size:11px; color:#09C;">semana siguiente</a>');
			}
	?>
</h4>
<input type="submit" name="reservar" id="reservar" value="Reservar" class="boton2" />
<input type="reset" name="reset" id="reset" value="Borrar selecci&oacute;n" class="boton2" />
</div>
<div align="right" style="padding-right:60px;"><br/>
<label style="font-weight:bold;">Aviso: El recargo por luz es de S/. y es automático a partir de las 18:00 horas</label>.<br/><br/></div>
<table id="horario" align="center">
	<colgroup>
    	<col class="vzebra-odd" />
    	<col class="vzebra-even" />
    	<col class="vzebra-even" />
        <col class="vzebra-even" />
        <col class="vzebra-even" />
        <col class="vzebra-even" />
        <col class="vzebra-even" />
        <col class="vzebra-even" />
    </colgroup>
	<thead>
    	<tr>
        	<th scope="col" id="vzebra-adventure">Hora</th>
            <?php
				//imprime el head de la tabla
				$nroDia=$CDia;
				$temp="";
				for ($i=1;$i<8;$i++)
				{
					$temp=aumenta_fecha($fecha_inicio,$i-1);
					$nombre=get_NDia($nroDia);
					printf('<th scope="col" id="vzebra-adventure">'.$nombre.'<br/><label style="font-size:10px;"> '.$temp.'</label></th>');					
					if ($nroDia+1>7)
						$nroDia=1;
					else $nroDia++;
				}
				
			?>
       	</tr>
    </thead>
	<tbody>
	<?php 
		$k=0;
		for($i=7;$i<23;$i++)
		{			
			$aux=$i+1;
			?>
			<tr>
            	<td align="right"><?php /*imprime las horas por dia */ $nroDia=$CDia; printf($i.":00 - ".$aux.":00");?></td>
            			
			<?php
			
			for($j=0;$j<7;$j++)
			{ 
			?>
				<td align="center"><?php //lena la tabla de horario
										
										 $hora=date("H:i:s"); 
										 $hora=split(":",$hora);
						        		 $fecha_fin=aumenta_fecha($fecha_inicio,$j); 
										 
										 if (($fecha_fin==$fecha && $hora[0]<$i) || ($fecha_fin!=$fecha)) 
										 {
											 if (es_reservado($fecha_fin,$i,$cancha,$link,$club)==true)
												  printf('<label>reservado</label>');
											 else 
											     { $k++;
												 printf('<a  ><span id="'.$k.'"><input name="reserva[]" onClick="todos('.$k.');" type="checkbox" value="'.$i.';'.$nroDia.';'.$fecha_fin.'" /></span></a>'); 
												 }
										 }

										 if ($nroDia+1>7)
										     $nroDia=1;
										 else $nroDia++;
								   ?>
               	</td>
            			
			<?php				
			} ?>
            </tr>
            <?php
			
		}
	?>	
    </tbody>
</table>
<div align="right" style="padding-right:60px;">
<input type="submit" name="reservar" id="reservar" value="Reservar" class="boton2" />
<input type="reset" name="reset" id="reset" value="Borrar selecci&oacute;n" class="boton2" />
<input type="hidden" name="action" value="reservar" />
</div>
</form>
</div>

</div>

</div>
          <!-- DIV close sa_products -->
         <div id="pg_pagination">
				
				<div class="clearing">&nbsp;</div>
				<div id="pg_paginationRight"></div>
			</div>

 
        </div>
        <!-- DIV close listTop -->
 </div>
    <!-- DIV close sa_content -->
  </div>
      <!-- DIV close sa_content_wrapper -->
      <div class="clearing">&nbsp;</div>
      <div style="clear:both"></div>
    </div>
    <!-- DIV close sa_wrapper -->

    <div class="clearing">&nbsp;</div>
      <div style="clear:both"></div>
    </div>
    <!-- DIV close pgContent Body -->
    <div class="bottom"></div>
  </div>
  <!-- End pgPageContent -->
  <br>
  </div><!-- End pgSiteContainer -->

<div id="footer">
</div>
			   
 </div> <!-- End Nubes -->
			
</div> <!-- End Todo -->

</body>
</html>