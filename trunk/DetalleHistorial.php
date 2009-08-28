<?php 
	session_start();
	require('conexion.php');
	require('config.php');
	require('funciones.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	if (!isset($_GET["deporte"]))
	{
			$_GET["deporte"]=1;
	}
	
	$_SESSION["cancha"]=0;
	$dep=$_GET["deporte"];
	$_SESSION["deporte"]=$dep;

					$valor = $_GET['id']; 
					
					$query="SELECT club.N_Nombre nclub,cancha.N_Nombre ncancha, reserva.D_FechaReserva rfecha, horario.D_Fecha nfecha, hora.D_HoraInicio nhora, distrito.N_Nombre ndistrito, reserva.T_DetallesAdicionales nadicionales, canchaxclub.C_Precio nprecio, servicioxclub.F_Recargo recargo, club.T_Banco banco, club.T_CuentaBanco cuenta, reserva.C_MontoTotal total, reserva.T_Estado estado FROM reserva, horario, canchaxclub, club, cancha, distrito, hora, servicioxclub, servicio WHERE reserva.ID_Reserva=horario.ID_Reserva AND horario.ID_Club=canchaxclub.ID_Club AND horario.ID_Cancha=canchaxclub.ID_Cancha AND canchaxclub.ID_Club=club.ID_Club AND club.ID_Club=servicioxclub.ID_Club AND servicioxclub.ID_Servicio=servicio.ID_Servicio AND servicio.N_Nombre='luz' AND club.ID_Distrito=distrito.ID_Distrito AND canchaxclub.ID_Cancha=cancha.ID_Cancha AND horario.ID_Hora=hora.ID_Hora AND reserva.ID_Reserva=".$valor." ORDER BY horario.D_Fecha ASC";
					
				$result=mysql_query($query);
				
				$row=mysql_fetch_array($result);
				$cant=mysql_num_rows($result); 
				$tot=0;
				$tot=$cant*$row['nprecio'];
				
				
				
			
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
  <?php include ("menu_izq.php") ?>
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
				
<table width="400" border="0" id="horario2" >
        <thead>              
		  <tr>
		    <th colspan="3" align="center">Ver Reserva</th>
          </tr>
         </thead>

         <tbody>
	      <tr>
	        <td width="216"><span style="font-weight:bold;">Club</span></td>
	        <td width="38">:</td>
	        <td width="430"><span style="font-weight:normal;"><?php print($row['nclub']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Cancha</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print($row['ncancha']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Fecha de reserva</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print(cambiaf_a_normal($row['rfecha'])); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Hora(s)</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;">
	          <?php 
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
						
						
									?>
	        </span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Distrito</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print($row['ndistrito']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Servicios Adicionales</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print($row['nadicionales']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Sub Total</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print('S/.'.$row['nprecio'].' x '.$cant.' = S/.'.$tot); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Recargo por hora de luz</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print('S/.'.$row['recargo'].' x '.$horasluz.' = S/.'.$tot2); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Monto Total</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print('S/.'.$row['total']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Estado</span></td>
	        <td>:</td>
	        <td><?php 
				
				if ($row['estado']==0)
					$est="en espera";
				elseif ($row['estado']==1)
						$est="aprobado";
				elseif ($row['estado']==2)
						$est="no aprobado";
			print($est);
			?>
			</td>
	        </tr>
          </tbody>

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