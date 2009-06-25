<?php 
	session_start();
	require('conexion.php');
	require('config.php');
	
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	if (!isset($_GET["deporte"]))
	{
			$_GET["deporte"]=1;
	}
	
	$_SESSION["cancha"]=0;
	$dep=$_GET["deporte"];
	$_SESSION["deporte"]=$dep;
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
  
     <form id="sa_filters_form" name="filters" method="GET" action="deporte_index.php"> 
    <!-- <form name="form2" action="" method="post" onsubmit="return false;" > -->
    	<input type="hidden" name="deporte" id="deporte" value="<?php echo $dep; ?>"/>
    	
      <div id="sa_filters_nav">
        <ul id="sa_filters_main">
        
          <!-- Manufacture/Vendor -->
          <li class="off">
            <h3 ><a href="HistorialReservas.php" style="text-decoration:none; color:#483800; padding-left:5px; cursor:hand;">Historial Reservas</a></h3>     
          </li>         
          <li class="off">
           <h3 ><a href="reservasConfirmadas.php" style="text-decoration:none; color:#483800; padding-left:5px; cursor:hand;">Reservas confirmadas</a></h3>  
		  </li>
          <li class="off">
            <h3 ><a href="reservasPorConfirmar.php" style="text-decoration:none; color:#483800; padding-left:5px; cursor:hand;">Reservas No confirmadas</a></h3>  
          </li>
          <li class="off">
           <h3 ><a href="ranking.php" style="text-decoration:none; color:#483800; padding-left:5px; cursor:hand;">Ranking de Usuarios</a></h3>  
          </li>   
          
        </ul>
        <div id="updateFilterLink">
        	<input type="hidden" name="buscar2" value="si">
            <input type="submit" value="" />
        </div>
      </div>
      <!--END FILTER NAV CONTAINER-->
    </form>
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
          		
         <div align='center' >
	
<?php	
	$idUsuario=$_SESSION["ID"];
	$idReserva=$_GET["id"];

	$sql="";	
			
									
				
		
				?>
				
<table id="horario">
				<tr>
					<th colspan='6'> Reserva <?php echo $idReserva; ?>
					</th>
				</tr>
				<tr>
					<td width="74">Club
					</td>
					<td width="100">Distrito	
					</td>
					<td width="74">Cancha
					</td>
					<td width="90">Fecha
					</td>
					<td width="76">Nro vaucher
					</td>
					<td width="100">Detalles
					</td>
					
				</tr>
				
				<?php 
				
				require ('funciones.php');
				
				$sql="SELECT club.N_Nombre, distrito.N_Nombre, cancha.N_Nombre, horario.D_Fecha, pago.C_Voucher, reserva.T_DetallesAdicionales FROM horario, reserva, club, cancha, distrito, pago WHERE reserva.ID_Usuario=".$idUsuario." AND reserva.ID_Reserva=".$idReserva." AND horario.ID_Reserva=reserva.ID_Reserva AND horario.ID_Club=club.ID_Club AND cancha.ID_Cancha = horario.ID_Cancha AND reserva.ID_Pago = pago.ID_Pago AND club.ID_Distrito=distrito.ID_Distrito;";
					
				$result = mysql_query($sql);
				
				while($row = mysql_fetch_array($result)) { ?>
				<tr>
					<td><?php echo $row[0]; ?>
					</td>
					<td><?php echo $row[1]; ?>
					</td>
					<td><?php echo $row[2]; ?>
					</td>
					<td><?php echo cambiaf_a_normal($row[3]); ?>
					</td>
					<td><?php echo $row[4]; ?>
					</td>
					<td><?php echo $row[5]; ?>
					</td>
					
				</tr>
				<?php	
				}	//while	
				?>	
				</table>
	
</div>
              
              
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