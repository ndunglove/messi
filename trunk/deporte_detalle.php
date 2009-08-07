<?php
	session_start();
	require("funciones.php");
	require('conexion.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
		
	if(!isset($_POST['action']))
	{
		$_POST['action']="undefine";
	}
	
	$cancha=$_SESSION["cancha"];
	$club=$_SESSION["club"];
	$usuario=$_SESSION["ID"];
	$dep=$_SESSION["deporte"];
	
	if ($_POST['action']=="reservar")
	{
		$fecha2=$fecha;
		$fecha2=split("/",$fecha2);
		$fecha2=$fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0];
		
		$query_2="INSERT INTO reserva (ID_Usuario,D_FechaReserva) VALUES(".$usuario.",'".$fecha2."')";
		mysql_query($query_2);
		
		$_SESSION["reserva"]=mysql_insert_id();
		
		$reserva=$_POST["reserva"];
		foreach ($reserva as $r)
		{
			$r = split(';',$r);
			$fecha3=$r[2];
			$fecha3=split("/",$fecha3);
			$fecha3=$fecha3[0].'-'.$fecha3[1].'-'.$fecha3[2];
			$query_1="INSERT INTO hora (D_HoraInicio,D_HoraFin) VALUES (".$r[0].",".$r[0].")";
			mysql_query($query_1);
			$hora_id=mysql_insert_id();
			
			$query="INSERT INTO horario (ID_Hora, ID_Cancha, ID_Club, D_Fecha, C_Dia, ID_Reserva) VALUES (".$hora_id.", ".$cancha.", ".$club.", '".cambiaf_a_mysql($fecha3)."', ".$r[1].", ".$_SESSION["reserva"].")";
			mysql_query($query);		
		}
	}		
	
	if ($_POST['action']=="adicional")
	{
		//funcion para agregar los detalles adicionales a la reserva
		
		$adi="";
		if (isset($_POST["adicionales"]))
			$adi=$_POST["adicionales"];
		$adi_aux="";
		
		if($adi!=""){
		foreach ($adi as $r)
		{			
			$adi_aux=$r.';'.$adi_aux;
		}
		
			$query_4="UPDATE reserva SET T_DetallesAdicionales='".$adi_aux."' WHERE ID_Reserva=".$_SESSION["reserva"];
			$result=mysql_query($query_4);
			
			if ($result==false)
				$_SESSION["back"]=0;
			else $_SESSION["back"]=1;
		}		
		else $_SESSION["back"]=1;
	
	}
	$vuelve=$_SESSION["back"];
	
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
<title>CanchasOnline.com | Detalles de reserva</title>

<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("¿Esta seguro que desea grabar su reserva?")
	if (answer){
		alert("Gracias, su reserva se ha guardado satisfactoriamente")
		window.location = "reservasPorConfirmar.php";
	}
	else{
		alert("Su reserva ha sido cancelada")
		window.location = "perfil.php?cancelar=1";
	}
}
//-->
</script>


</head>

<body>

<div id="todo2">
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

<!--canchas -->
<div id="sa_wrapper">
 <div id="sa_content_wrapper">
    <div id="sa_content">
<div id="sa_listTop"> 


		<div id="sortBy">
            <ul>            
                <li ><em>Paso 3 de 4</em></li>    
            </ul>
        </div>        
        <div id="sa_products">
        <?php if ($vuelve==0) { ?>
		<form action="deporte_detalle.php" method="post">
		<?php 
			//lista los servicios adicionales que se pueden contratar.
			$query="SELECT servicio.N_Nombre FROM servicioxclub, servicio WHERE servicio.ID_Deporte=".$_SESSION["deporte"]." AND servicioxclub.ID_Club=".$_SESSION["club"]." AND servicioxclub.ID_Servicio=servicio.ID_Servicio GROUP BY servicio.N_Nombre";
			$result = mysql_query($query);
		print('<span style="font-size:13px; font-weight:bold;">SERVICIOS ADICIONALES (Opcional)</span><br/><br/>');
			while ($row = mysql_fetch_array($result))
			{			
				
				print('<span><input type="checkbox" name="adicionales[]" value="'.$row[0].'" /> '.$row[0].'</span> <br/><br/>');	
				if ($row[0]=='luz')
					printf('<span style="font-weight:bold;">Aviso: El recargo por luz es automático a partir de las 18:00 horas.</span><br/><br/>');
					
			}
			
			if (($result==false) || (mysql_num_rows($result)==0))
				printf('<span style="font-weight:bold;">NO SE HAN ENCONTRADO SERVICIOS ADICIONALES PARA MOSTRAR.</span><br/><br/>');
			
		?>
			<input type="submit" name="reservar" id="reservar" value="Continuar" class="boton"/>
			<input type="hidden"  name="action" value="adicional" />          
		</form>
        
        <?php }
		else 
			{
			
				
				$query="SELECT club.N_Nombre nclub,cancha.N_Nombre ncancha, reserva.D_FechaReserva rfecha, horario.D_Fecha nfecha, hora.D_HoraInicio nhora, distrito.N_Nombre ndistrito, reserva.T_DetallesAdicionales nadicionales, canchaxclub.C_Precio nprecio, servicioxclub.F_Recargo recargo, club.T_Banco banco, club.T_CuentaBanco cuenta FROM reserva, horario, canchaxclub, club, cancha, distrito, hora, servicioxclub, servicio WHERE reserva.ID_Reserva=horario.ID_Reserva AND horario.ID_Club=canchaxclub.ID_Club AND horario.ID_Cancha=canchaxclub.ID_Cancha AND canchaxclub.ID_Club=club.ID_Club AND club.ID_Club=servicioxclub.ID_Club AND servicioxclub.ID_Servicio=servicio.ID_Servicio AND servicio.N_Nombre='luz' AND club.ID_Distrito=distrito.ID_Distrito AND canchaxclub.ID_Cancha=cancha.ID_Cancha AND horario.ID_Hora=hora.ID_Hora AND reserva.ID_Reserva=".$_SESSION["reserva"]." ORDER BY horario.D_Fecha ASC";
				$result=mysql_query($query);
				
				$row=mysql_fetch_array($result);
				$cant=mysql_num_rows($result); 
				$tot=0;
				$tot=$cant*$row['nprecio'];
				
				?>
               <form>

               	<table id="horario2">
                	<thead>
                    	<tr>
                        	<th colspan="2">DETALLES DE LA RESERVA</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<tr><td><span style="font-weight:bold;">Club:</span></td><td><span style="font-weight:normal;"> <?php print($row['nclub']); ?></span></td></tr>
                    	<tr><td><span style="font-weight:bold;">Cancha:</span></td><td><span style="font-weight:normal;"> <?php print($row['ncancha']); ?></span></td></tr>
                        <tr>
                          <td><span style="font-weight:bold;">Fecha de Reserva:</span></td><td><span style="font-weight:normal;"> <?php print(cambiaf_a_normal($row['rfecha'])); ?></span></td></tr>
                        <tr><td><span style="font-weight:bold;">Hora(s):</span></td><td><span style="font-weight:normal;"> <?php 
						    $horasluz=0;
							print($row['nhora'].':00 ('.cambiaf_a_normal($row['nfecha']).')');
							if ($row['nhora']>=18)
								$horasluz=$horasluz + 1;
								
							while ($row2 = mysql_fetch_array($result)){
									print('<br/>'.$row2['nhora'].':00 ('.cambiaf_a_normal($row2['nfecha']).')');
									if ($row2['nhora']>=18)
										$horasluz=$horasluz + 1;
									
									} 
							$tot2=$horasluz*$row['recargo'];	
							$TOTAL=$tot+$tot2;
							
							$query_5="UPDATE reserva SET C_MontoTotal=".$TOTAL." WHERE ID_Reserva=".$_SESSION["reserva"];
							mysql_query($query_5);
							
									?></span></td></tr>
                        <tr><td><span style="font-weight:bold;">Distrito:</span></td><td> <span style="font-weight:normal;"><?php print($row['ndistrito']); ?></span></td></tr>
                        <tr><td><span style="font-weight:bold;">Servicios Adicionales:</span> </td><td><span style="font-weight:normal;"><?php print($row['nadicionales']); ?></span></td></tr>                        
                        <tr>
                          <td><span style="font-weight:bold;">Sub Total: </span></td><td><span style="font-weight:normal;"> <?php print('S/.'.$row['nprecio'].' x '.$cant.' = S/.'.$tot); ?> (No incluye cargos por servicios adicionales)</span></td></tr>
                        <tr>
                          <td><span style="font-weight:bold;">Recargo por hora de luz:  </span></td><td><span style="font-weight:normal;"> <?php print('S/.'.$row['recargo'].' x '.$horasluz.' = S/.'.$tot2); ?></span></td>
                        </tr>
                        <tr>
                          <td><span style="font-weight:bold;">Monto Total:</span></td><td>   <span style="font-weight:normal;"><?php print('S/.'.$TOTAL); ?> (No incluye IGV)</span></td>
                        </tr>
                        <tr><td><span style="font-weight:bold;">Banco a Depositar:</span></td><td><span style="font-weight:normal;"><?php print($row['banco']); ?></span></td></tr>
                        <tr><td><span style="font-weight:bold;">Cuenta a Depositar:</span></td><td><span style="font-weight:normal;"><?php print($row['cuenta']); ?></span></td></tr>
                        <tr><td></td><td align="right"><input type="button" name="confirmar" value="Grabar Reserva" class="boton" onclick="confirmation()" >
                                              <input type="button" name="imprimir" value="Imprimir" onclick="window.print();" class="boton"></td></tr>
                        <tr><td></td>
                          <td align="right"><p>EL monto mínimo a depositar es el 50% del Monto total mostrado arriba <br />
en un plazo máximo de 6 horas.</p>
                            <p>Por favor, para ingresar el voucher de pago ir a <br/>
                              <span style="font-weight:bold;">&quot;reservas realizadas&quot;</span><br/>
                            (link en la parte superior de la página)</p></td>
                        </tr>                                                
                    </tbody>
                </table>
				</form>
			<?php }
		
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


<div class="clearing">&nbsp;</div>
      <div style="clear:both"></div>
    </div>
    <!-- DIV close pgContent Body -->
    <div class="bottom"></div>
  </div>
  <!-- End pgPageContent -->
  <br>
  </div><!-- End pgSiteContainer -->
 	



 
 </div>
<!-- End Nubes -->
<div id="footer2">
 </div>

</div>
<!-- End Todo -->
</body>
</html>