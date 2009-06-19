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

<div id="topmenu">
		<ul>
			<li><a href="perfil.php" id="topmenu1" accesskey="1" ><img src="images/perfil.gif" /></a></li>
			<li><a href="reservas.php" id="topmenu3" accesskey="2" ><img src="images/reservas.gif" /></a></li>
			<li><a href="logout.php" id="topmenu2" accesskey="3" ><img src="images/logout.gif" /></a></li>
		</ul>

	</div>

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
            <h3 ><a href="reservasPorConfirmar.php" style="text-decoration:none; color:#483800; padding-left:5px; cursor:hand;">Reservas No confirmar</a></h3>  
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
          		
         <div align='center'>
	
<?php	
	$idUsuario="1";// SE SUPONE QUE TIENE Q SER UNA VARIABLE DE SESSION
	$idReserva=getPageParameter("id","0");
	/*
	historial de reservas: se muestra una lista con cada una de las reservas pasadas (refiérase a reservas anteriores a la fecha actual de consulta) 
	realizadas por el usuario que posee la opción "ver" que a su vez sale una ventana nueva mostrando información de la reserva como: 
	Lugar club, lugar cancha, fecha, hora, nro. de Boucher por pago realizado, Detalles adicionales (de la tabla reserva).
	[ID_Reserva] => 1
    [ID_Usuario] => 1
    [D_FechaReserva] => 2009-04-29 00:00:00
    [ID_Pago] => 1
    [T_DetallesAdicionales] => deteallee 1
	*/
	$sql="";	
		$cn = fnConnect($msg);
			if(!$cn) {
			fnShowMsg("Error",$msg);
			return;
			} else {							
				$sql="SELECT tr.*, tp.C_Voucher, tc.N_Nombre NombreCancha, tcl.N_Nombre NombreClub, td.N_Nombre NombreDistrito, 
				DATE_FORMAT(CONVERT_TZ(tr.D_FechaReserva,'SYSTEM','-5:00'), '%e de %M del %Y a las %h:%i:%s %p') as fechaReserva 
				FROM reserva tr, pago tp, horario th, cancha tc, canchaxclub tcc, club tcl, distrito td 
				 WHERE tr.ID_Pago=tp.ID_Pago 
				AND tr.ID_Reserva=th.ID_Reserva 
				AND th.ID_Cancha=tc.ID_Cancha 
				AND tc.ID_Cancha=tcc.ID_Cancha 
				AND tcc.ID_Club=tcl.ID_Club 
				AND tcl.ID_Distrito=td.ID_Distrito 
				AND tr.ID_Usuario=".$idUsuario. "
				AND tr.ID_Reserva=".$idReserva;
				;
				$rs = mysql_query($sql,$cn) or die("MALLL");
			}
				?>
				
<table border='1' cellpadding='4'>
				<tr>
					<th colspan='6'> Reserva <?php echo $idReserva; ?>
					</th>
				</tr>
				<tr>
					<td>Club
					</td>
					<td>Distrito	
					</td>
					<td>Cancha
					</td>
					<td>Fecha
					</td>
					<td>Nro vaucher
					</td>
					<td>Detalles
					</td>
					
				</tr>
				
				<?php while($row = mysql_fetch_array($rs,MYSQL_ASSOC)) { ?>
				<tr>
					<td><?php echo $row["NombreClub"]; ?>
					</td>
					<td><?php echo $row["NombreDistrito"]; ?>
					</td>
					<td><?php echo $row["NombreCancha"]; ?>
					</td>
					<td><?php echo $row["fechaReserva"]; ?>
					</td>
					<td><?php echo $row["C_Voucher"]; ?>
					</td>
					<td><?php echo $row["T_DetallesAdicionales"]; ?>
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
<div id="footer">
 </div>	

</div>
<!-- End Nubes -->


</div>
<!-- End Todo -->
</body>
</html>