
<?php 
	session_start();
	require('conexion.php');
	require('config.php');
	
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	if (!isset($_SESSION["deporte"]))
	{
			$_SESSION["deporte"]=1;
	}
	
	$_SESSION["cancha"]=0;
	$dep=$_SESSION["deporte"];
	
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
    <div id="featuredStores">
      <div id="featuresStoresContainer">
        <span style="font-family:Verdana; color:#666; font-size:12px; font-weight:bold; text-align:center;">Busqueda Avanzada</span>
      </div>
    </div>
    <!-- End featuredStores -->
  
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
                
                <li ><em>Clubs</em></li>

    
            </ul>
        </div>
          <div id="sa_products">     	
          	<div id="searchContainerBox_background"><br/>
          		
          	<div class="wrap" align='center'>
           <?php 
		  $idUsuario=$_SESSION["ID"];
	

				?>						
				
<table id="horario2">
				<tr>
					<th colspan='7'> RESERVAS ACTUALES POR CONFIRMAR</th>
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
					<td>Confirmado
					</td>
					<td>&nbsp;
					</td>
				</tr>				
				<?php 
				require('funciones.php');
				$fecha_aux=split('/',$fecha);
				$fecha_aux=$fecha_aux[0].'-'.$fecha_aux[1].'-'.$fecha_aux[2];
	
				$sql="SELECT club.N_Nombre, cancha.N_Nombre, horario.D_Fecha, reserva.T_DetallesAdicionales, reserva.ID_Pago, reserva.T_Estado, reserva.ID_Reserva FROM horario, reserva, club, cancha, pago WHERE reserva.ID_Usuario=".$idUsuario." AND  horario.ID_Reserva=reserva.ID_Reserva AND horario.ID_Club=club.ID_Club AND cancha.ID_Cancha = horario.ID_Cancha AND reserva.T_Estado=0 AND horario.D_Fecha >= '".cambiaf_a_mysql($fecha_aux)."' GROUP BY reserva.ID_Reserva";
					
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
							echo "<a href='IngresarVoucher.php?id=".$row["6"]."'>no</a>";
						else
							echo "si";
						?>
					</td>
						<td> <?php 
						if($row[5]=="0") 
							echo "no";
						else
							echo "si";
						?>
					</td>
				
					<td><a href='DetalleHistorial.php?id=<?php echo $row[6]?>' target='_new'> Ver</a> 
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
<div id="anuncios2">
 </div>	
<div id="footer">
 </div>	

</div>
<!-- End Nubes -->


</div>
<!-- End Todo -->
</body>
</html>
