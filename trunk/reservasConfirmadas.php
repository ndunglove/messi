
<?php 
	session_start();
	require('conexion.php');
	require('config.php');
	require('funciones.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	if (!isset($_SESSION["deporte"]))
	{
			$_SESSION["deporte"]=1;
	}
	
	$_SESSION["cancha"]=0;
	$dep=$_SESSION["deporte"];
	
	if (isset($_GET["idhor"]))
	{
		$query="UPDATE horario SET F_Califica=1 WHERE ID_horario=".$_GET["idhor"];
		mysql_query($query);
		
		$query="SELECT ID_Club, ID_Cancha FROM horario WHERE ID_horario=".$_GET["idhor"];
		$result=mysql_query($query);
		$row=mysql_fetch_row($result);
		
		$query="SELECT C_Reputacion FROM canchaxclub WHERE ID_Cancha=".$row[1]." AND ID_Club=".$row[0];
		$result2=mysql_query($query);
		$row2=mysql_fetch_row($result2);
		
		$aux=$row2[0]+1;
		$query="UPDATE canchaxclub SET C_Reputacion=".$aux." WHERE ID_Cancha=".$row[1]." AND ID_Club=".$row[0];
		mysql_query($query);
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CanchasOnline.com | B&uacute;squeda avanzada</title>
<!-- meta, js and css for PG only -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php 
	if ($dep==1)
		print('<link rel="shortcut icon" href="images/pelota_futbol.ico">');
	else if ($dep==2)
			print('<link rel="shortcut icon" href="images/pelota_tenis.ico">');
?>
<link rel="stylesheet" type="text/css" href="estilos/horario.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo2.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo.css" >


<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie6.css" />
  
<![endif]-->
<!--[if gte IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie7.css" />
<![endif]-->
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
<div class="cuerpo">
<div id="sa_wrapper">
  <!-- DIV open "sa_wrapper" -->
  <div class="clearing">&nbsp;</div>
 
  <div id="sa_filters">
 
  
     <?php include('menu_izq.php'); ?>
    <div height="10">&nbsp;</div>
  
  </div>
  <!-- End SA_FILTERS -->
  
  <div id="sa_content_wrapper">
    <div id="sa_content">
      <p class="spacer">&nbsp;</p>
      <form  id="productCompareForm" method="get" action="/laptop/p/13/compare/"  name="compare">
        <div id="sa_listTop">
        <div id="sortBy">
            <ul>
                
                <li ><em>Reservas confirmadas</em></li>

    
            </ul>
        </div>
          <div id="sa_products">     	
          	<div id="searchContainerBox_background"><br/>
          		
          	<div class="wrap" align='center'>
            <div align='left' style="padding-left:100px; font-size:14px;">
             Aqu&iacute; podr&aacute;s ver las reservas que has pagado y hayan sido aprobadas<br/> por el administrador del club.
            </div>
           <?php 
		  $idUsuario=$_SESSION["ID"];
			

				?>						
				
<table id="horario2">
				<tr>
					<th colspan='8'> RESERVAS ACTUALES CONFIRMADAS
					</th>
				</tr>
				<tr>
					<td>Club
					</td>
					<td>Cancha
					</td>
					<td>Fecha
					</td>
					<td>Detalles
					</td>
					<td>Pagado
					</td>
					<td>Estado
					</td>
					<td>Recomendar</td>
					<td>&nbsp;
					</td>
				</tr>				
				<?php 
				
				$fecha_aux=split('/',$fecha);
				$fecha_aux=$fecha_aux[0].'-'.$fecha_aux[1].'-'.$fecha_aux[2];
	
				$sql="SELECT club.N_Nombre, cancha.N_Nombre, reserva.D_FechaReserva, reserva.T_DetallesAdicionales, reserva.ID_Pago, reserva.T_Estado, reserva.ID_Reserva, horario.F_Califica FROM horario, reserva, club, cancha, pago WHERE reserva.ID_Usuario=".$idUsuario." AND  horario.ID_Reserva=reserva.ID_Reserva AND horario.ID_Club=club.ID_Club AND cancha.ID_Cancha = horario.ID_Cancha AND reserva.ID_Pago=pago.ID_Pago AND reserva.T_Estado=1 AND horario.D_Fecha >= '".cambiaf_a_mysql($fecha_aux)."'";
					
				$result = mysql_query($sql);
				
				
				while($row = mysql_fetch_array($result)) { ?>
				<tr>
					<td> <?php echo $row[0]; ?>
					</td>
					<td> <?php echo $row[1]; ?>
					</td>
					<td> <?php echo cambiaf_a_normal($row[2]); ?>
					</td>
					<td> <?php echo $row[3]; ?>
					</td>
					<td> <?php 
						if($row[4]==null || $row[4]=="0") 
							echo "no";
						else
							echo "si";
						?>
					</td>
						<td> <?php 
						if($row[5]==0) 
							echo "en espera";
						elseif($row[5]==1) 
							echo "aprobado";
						elseif($row[5]==2) 
							echo "rechazado";
						?>
					</td>
						<td><?php if ($row[9]==0) { ?>
                        		<a href='reservasConfirmadas.php?idhor=<?php echo $row[8];?>' target='_new'>recomendar</a> 
                            <?php } ?>    
                                </td>
				
					<td><a href='DetalleHistorial.php?id=<?php echo $row[6]?>' target='_new'>Ver</a> 
					</td>
				</tr>
				<?php	
				}	//while	
				
				?>	
				</table></div>
          
              
              
              
            </div>
            <!-- searchContainerBox_background DIV *** END -->
            <div class="clearing">&nbsp;</div>
          </div>
          <!-- DIV close sa_products -->
         <div id="pg_pagination">
				
				<div class="clearing">&nbsp;</div>
				<div id="pg_paginationRight"></div>
			</div>

 
        </div>
        <!-- DIV close listTop -->
      </form>
     
    </div>
    <!-- DIV close sa_content -->

  </div>
      <!-- DIV close sa_content_wrapper -->
      <div class="clearing">&nbsp;</div>
      <div style="clear:both"></div>
    </div>
    <!-- DIV close sa_wrapper -->
    </div>
    <!-- DIV close pgContent Body -->
    <div class="bottom"></div>
  </div>
  <!-- End pgPageContent -->
  <br>
</div>
<!-- End pgSiteContainer -->

<div id="footer">
 </div>	

</div>
<!-- End Nubes -->


</div>
<!-- End Todo -->
</body>
</html>
