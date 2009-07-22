<?php 
	require ("funciones.php");
	require('conexion.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	//verifica si en la fecha y hora dada 
	function es_reservado($fecha,$hora_inicio,$id_cancha,$link){
		$finn=$hora_inicio+1;
				$fecha=split("/",$fecha);
				$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
				$result = mysql_query("SELECT * FROM horario h1, hora h2 WHERE h1.ID_Hora=h2.ID_Hora AND ID_Cancha=".$id_cancha." AND h1.D_Fecha='".$fecha."' AND h2.D_HoraInicio<=".$hora_inicio." AND h2.D_HoraFin>=".$finn,$link);
				
				//echo ("SELECT * FROM horario h1, hora h2 WHERE h1.ID_Hora=h2.ID_Hora AND ID_Cancha=".$id_cancha." AND h1.D_Fecha='".$fecha."' AND h2.D_HoraInicio<=".$hora_inicio." AND h2.D_HoraFin>=".$finn);
				
		 		$row = mysql_fetch_row($result);
				if ($row==false)
					return false;
				else return true;
		}
	function es_reservado2($fecha,$hora_inicio,$id_cancha,$link){
		$finn=$hora_inicio+1;
				$fecha=split("/",$fecha);
				$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
				$result = mysql_query("SELECT * FROM horario h1, hora h2 WHERE h1.ID_Hora=h2.ID_Hora AND ID_Cancha=".$id_cancha." AND h1.D_Fecha='".$fecha."' AND h2.D_HoraInicio<=".$hora_inicio." AND h2.D_HoraFin>=".$finn,$link);
				//echo ("SELECT * FROM horario h1, hora h2 WHERE h1.ID_Hora=h2.ID_Hora AND ID_Cancha=".$id_cancha." AND h1.D_Fecha='".$fecha."' AND h2.D_HoraInicio<=".$hora_inicio." AND h2.D_HoraFin>=".$finn);
				$row = mysql_fetch_array($result);
				if ($row==false)
					return "";
				else return $row["ID_Reserva"];
		}
	
	//regresa un row con todos los datos de la chancha
	function dame_Cancha($id_cancha,$link,$depo)
	{
		$result = mysql_query("SELECT cancha.ID_Cancha, cancha.N_Nombre, cancha.F_Techado, tamcancha.N_Nombre, tipocancha.N_Tipo, cancha.C_Precio
							   FROM cancha, tamcancha, tipocancha 
							   WHERE cancha.ID_TamanoCancha=tamcancha.ID_TamanoCancha AND cancha.ID_TipoCancha=tipocancha.ID_TipoCancha AND cancha.ID_Deporte=".$depo." AND cancha.ID_Cancha=".$id_cancha.";",$link);
		$row = mysql_fetch_array($result);
		return $row;			
	}	
	
	//variable de navegación del horario
	/*if(!isset($_GET["pg"]))
	{
		$pg=1;	
	}
	else $pg=$_GET["pg"];*/
	$pg=getPageParameter("pg","1");
	
	//variable de deporte
	
	//$dep=$_SESSION["deporte"];
	$dep=1;
	//$club=$_SESSION["club"];
	$club=1;
	
	//query de prueba	
	
	

	
	/*if (!isset($_POST['action'])) 
	{
		$_POST['action'] = "undefine";
	}

	if ($_POST["action"] == "sel_cancha")
	{
		if (isset($_POST["canchas"]))
		{
			$_SESSION["cancha"]=$_POST["canchas"];
		}
	}
	*/
	
	$action=getPageParameter("action","undefine");
	if($action=="sel_cancha"){
			$canchas=getPageParameter("canchas","");
			if($canchas!="")
			{
				$_SESSION["cancha"]=$canchas;
				}
	}
	

	if (!isset($_SESSION["cancha"]))
		$cancha=0;
	else $cancha=$_SESSION["cancha"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="estilos/horario.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo3.css" >
<title>Untitled Document</title>
</head>

<body>
<?php /*
echo "Paginacion ".$pg."<br>";	
echo "Action ".$action."<br>";	
echo "Sesion ".$_SESSION["cancha"]."<br>";	
echo "SesionCancha ".$cancha."<br>";
echo "PostCancha ".$canchas."<br>";*/

?>
<div id="pgSiteContainer" >
<div id="banner">

<div id="topmenu">
		<ul>
			<li><a href="perfil.php" id="topmenu1" accesskey="1" title="">Perfil</a></li>
			<li><a href="reservas.php" id="topmenu3" accesskey="2" title="">Reservas Realizadas</a></li>
			<li><a href="logout.php" id="topmenu2" accesskey="3" title="">Logout</a></li>
		</ul>
	</div>

<div class="clearing">&nbsp;</div>
</div>

<div id="pgPageContent">
<div class="top">
</div>
<div class="cuerpo">
<div class="clearing">&nbsp;</div>

	<!--canchas -->
	<div id="sa_wrapper">
	 <div id="sa_content_wrapper">
	    <div id="sa_content">
	<div id="sa_listTop">
			<div id="sortBy">
	            <ul>            
	                <li ><em>Canchas</em></li>    
	            </ul>
	        </div>        
	        <div id="sa_products">
			<form action="deporte_horario.php" method="post">
			<?php 
				//lista las canchas resultantes del query.
				$query="SELECT cancha.ID_Cancha, cancha.N_Nombre NombreCancha 
							FROM cancha, canchaxclub, club 
							WHERE cancha.ID_Cancha=canchaxclub.ID_Cancha AND canchaxclub.ID_Club=club.ID_Club AND club.ID_Club=".$club." 
							AND cancha.ID_Deporte=".$dep." 
							GROUP BY cancha.ID_Cancha"; 
						$result = mysql_query($query,$link);
						$cantCanchasEncontradas=mysql_num_rows($result);
						
						
						printf('<select name="canchas" id="canchas" onchange="this.form.submit();" >');	
						if($cantCanchasEncontradas > 0){
								printf('<option value="0" >Escoge una Cancha</option>');	
								while($row = mysql_fetch_array($result)){
									?>									
									<option value='<?php echo $row["ID_Cancha"];?>'<?php echo (($row["ID_Cancha"]==getPageParameter("canchas",""))?" selected='selected'":"");?>><?php echo $row["NombreCancha"];?></option>
									<?php
								//printf('<option value="'.$row["ID_Cancha"].'">'.$row["NombreCancha"].'</option>');	
								//echo "<br>".$row["ID_Cancha"].$row["NombreCancha"];
								}//while		
							}//if
						else
						printf('<option value="0" selected>No hay Canchas</option>');
						
  					printf('</select>');
				
				
				
				/*
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result))
				{
					$fila=dame_Cancha($row["ID_Cancha"],$link,$dep);
					$techado="No";
					if ($fila[2]==1)
						$techado="Si";
					if ($cancha!=0 && $fila[0]==$cancha)
						$temp='checked="checked"';
					else $temp="";
					
					printf('<span><input type="radio" name="canchas" value="'.$fila[0].'" '.$temp.' />'.$fila[1].' (Tama&ntilde;o: '.$fila[3].', Tipo: '.$fila[4].', Techado: '.$techado.')</span> <br/>');	
				}*/
			?>
				<input type="submit" name="reservar" id="reservar" value="Reservar" />
	        	<input type="hidden" name="action" value="sel_cancha" />          
			</form>
			<?php if($cancha!=""){
				$detalleCancha=dame_Cancha($cancha,$link,$dep);
					if ($detalleCancha[2]==1) $techado="Si";
					else $techado="No";
				printf('<span>'.$detalleCancha[0].' '.$detalleCancha[1].' (Tama&ntilde;o: '.$detalleCancha[3].', Tipo: '.$detalleCancha[4].', Techado: '.$techado.') --> S/. '.$detalleCancha["C_Precio"].'</span>');
			}
			?>
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

<?php
	if ($cancha!=0)
	{
?>
<!--horarios -->
<div id="sa_wrapper">
 <div id="sa_content_wrapper">
    <div id="sa_content">
<div id="sa_listTop">
<div id="sortBy">
            <ul>                
                <li ><em>Horarios</em></li>
            </ul>
        </div>
          <div id="sa_products">
          
<div id="horario_container">
<h2> <?php
		$canch=getPageParameter("canchas","");
	if($canch!=""){
				
		$result = mysql_query("SELECT * FROM cancha WHERE ID_Cancha=".$canch.";",$link);
		$row = mysql_fetch_array($result);
		echo "Cancha : ".$row["N_Nombre"];
		}	
		
		
?>  </h2>
<h2> Horario de Reservas </h2>
<h3> <?php 
		//imprime fechas a mostrar en la tabla
		if($pg <= 0){
			$auxPg=0;
			if($pg < 0) $auxPg=-1*$pg;
		$fecha_inicio=disminuye_fecha($fecha,7*($auxPg+1));
		}
		else if($pg > 0)
		if ($pg==1)
			$fecha_inicio=$fecha;		
		else $fecha_inicio=aumenta_fecha($fecha,7*($pg-1));
				
		$fecha_fin=aumenta_fecha($fecha_inicio,6);
		//echo "FECHA ".$fecha."<br>";
		printf("(".$fecha_inicio." al ".$fecha_fin.")");  
	?>
</h3>
<h4>
	<?php
		//imprime la navegación
	
	
				$anioAnt=$pg-52;
				printf(' <a href="deporte_horario.php?pg='.$anioAnt.'&amp;action=sel_cancha&amp;canchas='.$canchas.'"> &lt;&lt;A&ntilde;oAnt</a>');
				$mesAnt=$pg-4;
				printf(' <a href="deporte_horario.php?pg='.$mesAnt.'&amp;action=sel_cancha&amp;canchas='.$canchas.'"> &lt;&lt;mesAnt</a>');
				$ante=$pg-1;
				printf('<a href="deporte_horario.php?pg='.$ante.'&amp;action=sel_cancha&amp;canchas='.$canchas.'"> &lt;&lt;SemAnt</a> ');
			
				$desp=$pg+1;
				printf(' <a href="deporte_horario.php?pg='.$desp.'&amp;action=sel_cancha&amp;canchas='.$canchas.'"> SemSgte>></a>');
				$mesSgte=4+$pg;
				printf(' <a href="deporte_horario.php?pg='.$mesSgte.'&amp;action=sel_cancha&amp;canchas='.$canchas.'"> mesSgte>></a>');
				$anioSgte=52+$pg;
				printf(' <a href="deporte_horario.php?pg='.$anioSgte.'&amp;action=sel_cancha&amp;canchas='.$canchas.'"> A&ntilde;oSgte>></a>');
				

	?>
</h4>
<form method="post" action="deporte_detalle.php">
<table id="horario" align="center">
	<colgroup>
    	<col class="vzebra-odd" />
    	<col class="vzebra-even" />
    	<col class="vzebra-odd" />
        <col class="vzebra-even" />
        <col class="vzebra-odd" />
        <col class="vzebra-even" />
        <col class="vzebra-odd" />
        <col class="vzebra-even" />
    </colgroup>
	<thead>
    	<tr>
        	<th scope="col" id="vzebra-comedy">Hora</th>
            <?php
				//imprime el head de la tabla
				$nroDia=$CDia;
				for ($i=1;$i<8;$i++)
				{
					$nombre=get_NDia($nroDia);
					printf('<th scope="col" id="vzebra-adventure">'.$nombre.'<br>'.aumenta_fecha($fecha_inicio,$i-1).'</th>');					
					if ($nroDia+1>7)
						$nroDia=1;
					else $nroDia++;
				}
				
			?>
       	</tr>
    </thead>
	<tbody>
	<?php 

		for($i=7;$i<24;$i++)
		{			
			$aux=$i+1;
			?>
			<tr>
            	<td align="right"><?php /*imprime las horas por dia */ $nroDia=$CDia; printf($i.":00 - ".$aux.":00");?></td>
            			
			<?php
			for($j=0;$j<7;$j++)
			{ 
			?>
				<td align="center">
				<?php //lena la tabla de horario
					$hora=date("H:i:s"); 
					$hora=split(":",$hora);
					$fecha_fin=aumenta_fecha($fecha_inicio,$j); 
					$reservado=es_reservado2($fecha_fin,$i,$cancha,$link);
					
										
					if(fecha1MenorFecha2($fecha_fin,$fecha) || ($fecha_fin==$fecha && $hora[0]>=$i)){//if($fecha_fin < $fecha )
						if ($reservado!="")
						  printf('<a href="detalle_reserva.php?id='.$reservado.'" target="blank">FUE reservado</a>');
						else {printf("$fecha_fin");}
					}
																	
					else if (($fecha_fin==$fecha && $hora[0]<$i) || ($fecha_fin!=$fecha)) 
					 {
					 //if (es_reservado($fecha_fin,$i,$cancha,$link)==true)
					 if($reservado!="")
					 		printf('<a href="detalle_reserva.php?id='.$reservado.'" target="blank">reservado</a>');
					else {printf('<input name="'.$i.';'.$nroDia.';'.$fecha_fin.'" type="checkbox" value="reservar" />'); 
					echo "$fecha_fin";
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
<input type="submit" name="reservar" id="reservar" value="Reservar" />
<input type="reset" name="reset" id="reset" value="Cancelar" />
<input type="hidden" name="action" value="reservar" />
</form>
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
<?php
}
?>
    <div class="clearing">&nbsp;</div>
      <div style="clear:both"></div>
    </div>
    <!-- DIV close pgContent Body -->
    <div class="bottom"></div>
  </div>
  <!-- End pgPageContent -->
  <br>
  </div><!-- End pgSiteContainer -->
</body>
</html>