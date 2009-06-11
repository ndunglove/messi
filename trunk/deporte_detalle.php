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
			$fecha3=$fecha[2].'-'.$fecha3[1].'-'.$fecha3[0];
			$query_1="INSERT INTO hora (D_HoraInicio,D_HoraFin) VALUES (".$r[0].",".$r[0].")";
			mysql_query($query_1);
			$hora_id=mysql_insert_id();
			
			$query="INSERT INTO horario (ID_Hora, ID_Cancha,D_Fecha, C_Dia, ID_Reserva) VALUES (".$hora_id.", ".$cancha.", '".$fecha."', ".$r[1].", ".$_SESSION["reserva"].")";
			mysql_query($query);		
		}
	}
	
	if(!isset($_SESSION["back"]))	
	{
		$_SESSION["back"]=0;
	}
	
	$vuelve=$_SESSION["back"];
	
	if ($_POST['action']=="adicional")
	{
		//funcion para agregar los detalles adicionales a la reserva
		
		$adicional=$_POST["adicionales"];
		foreach ($adicional as $r)
		{
			$adicional=$r.';'.$adicional;
		}
		
		$query_4="UPDATE reserva SET T_DetallesAdicionales='".$adicional."' WHERE ID_Reserva=".$_SESSION["reserva"].")";
		$result=mysql_query($query_4);
		
		if ($result==false)
			$_SESSION["back"]=0;
		else $_SESSION["back"]=1;
	
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="estilos/horario.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo3.css" >
<title>Untitled Document</title>
</head>

<body>
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
        <?php if ($vuelve==0) { ?>
		<form action="deporte_detalle.php" method="post">
		<?php 
			//lista los servicios adicionales que se pueden contratar.
			$query="SELECT servicio.N_Nombre FROM servicioxclub, servicio WHERE servicio.ID_Deporte=".$_SESSION["deporte"]." AND servicioxclub.ID_Club=".$_SESSION["club"]." AND servicioxclub.ID_Servicio=servicio.ID_Servicio GROUP BY servicio.N_Nombre";
			$result = mysql_query($query);
			while ($row = mysql_fetch_array($result))
			{			
				printf('<span><input type="checkbox" name="adicionales[]" value="'.$row[0].'" /> '.$row[0].'</span> <br/><br/>');	
			}
		?>
			<input type="submit" name="reservar" id="reservar" value="Agregar" />
        	<input type="hidden" name="action" value="adicional" />          
		</form>
        
        <?php }
		else printf("Muchas gracias, su reserva se ha realizado satisfactoriamente");
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
</body>
</html>