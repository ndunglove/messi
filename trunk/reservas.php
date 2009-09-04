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

	if (isset($_GET["idres"]))
	{
		$query="UPDATE reserva SET F_Califica=1 WHERE ID_Reserva=".$_GET["idres"];
		mysql_query($query);
		
		$query="SELECT ID_Club, ID_Cancha FROM horario WHERE ID_Reserva=".$_GET["idres"];
		$result=mysql_query($query);
		$row=mysql_fetch_row($result);
		
		$query="SELECT C_Reputacion FROM canchaxclub WHERE ID_Cancha=".$row[1]." AND ID_Club=".$row[0];
		$result2=mysql_query($query);
		$row2=mysql_fetch_row($result2);
		
		$aux=$row2[0]+$_GET['v'];
		$aux=$aux/2;
		
		if ($aux<=0.5) $aux=0;
		if ($aux>0.5 && $aux<1) $aux=1;
		if ($aux>1 && $aux<=1.25) $aux=1;
		if ($aux>1.25 && $aux<1.5) $aux=1.5;
		if ($aux>1.5 && $aux<=1.75) $aux=1.5;
		if ($aux>1.75 && $aux<2) $aux=2;
		
		if ($aux>2 && $aux<=2.25) $aux=2;
		if ($aux>2.25 && $aux<2.5) $aux=2.5;
		if ($aux>2.5 && $aux<=2.75) $aux=2.5;		
		if ($aux>2.75 && $aux<3) $aux=3;
		
		if ($aux>3 && $aux<=3.25) $aux=3;
		if ($aux>3.25 && $aux<3.5) $aux=3.5;
		if ($aux>3.5 && $aux<=3.75) $aux=3.5;		
		if ($aux>3.75 && $aux<4) $aux=4;
		
		if ($aux>4 && $aux<=4.25) $aux=4;
		if ($aux>4.25 && $aux<4.5) $aux=4.5;
		if ($aux>4.5 && $aux<=4.75) $aux=4.5;		
		if ($aux>4.75 && $aux<5) $aux=5;
		
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
                
                <li ><em>Historial de reservas</em></li>

    
            </ul>
        </div>
          <div id="sa_products">     	
          	<div id="searchContainerBox_background"><br/>
          		
          	<div class="wrap" align='center'>
            <div align='left' style="padding-left:140px; font-size:14px;">
             Aqu&iacute; podr&aacute;s ver tus reservas pasadas.<br/>
             Puedes recomendar la cancha seleccionando un valor del 1 al 5.</div>
	
<?php	
	$idUsuario=$_SESSION["ID"];
	require('funciones.php');
	$fecha_aux=split('/',$fecha);
	$fecha_aux=$fecha_aux[0].'-'.$fecha_aux[1].'-'.$fecha_aux[2];
	
		$cn = fnConnect($msg);
			if(!$cn) {
			fnShowMsg("Error",$msg);
			return;
			} else {							
				$sql="SELECT reserva.D_FechaReserva, reserva.ID_Reserva, reserva.F_Califica 
				 FROM reserva JOIN horario ON reserva.ID_Reserva=horario.ID_Reserva WHERE horario.D_Fecha < '".cambiaf_a_mysql($fecha_aux)."' 
				  AND reserva.ID_Usuario=".$idUsuario." AND reserva.T_Estado=1 ORDER BY reserva.ID_Reserva DESC";				 
				$rs = mysql_query($sql) or die("Error al listar historial de reservas");
			}		
	?>		
				
		<table id="horario2" width="480">
				<thead>
                <tr>
                	<th colspan="4" align="center">RESERVAS CONFIRMADAS</th>
                </tr>
				<tr><th width="102" >Nro Reserva</th>
					<th width="125" >Fecha de reserva</th>
                    
                    <th width="126" >Recomendar </th>
                    <th width="50" >Opciones</th>
				</tr>
				</thead>
                <tbody>
				<?php while($row = mysql_fetch_array($rs)) { ?>
				<tr>					
                    <td><?php printf("%05d",$row[1]);?></td>
                    <td><?php echo cambiaf_a_normal($row[0]); ?></td>
     				<td> <?php if ($row[2]==0) { ?>
                        		<a href='reservas.php?idres=<?php echo $row[1];?>&v=1' >1</a> 
                                <a href='reservas.php?idres=<?php echo $row[1];?>&v=2' >2</a> 
                                <a href='reservas.php?idres=<?php echo $row[1];?>&v=3' >3</a> 
                                <a href='reservas.php?idres=<?php echo $row[1];?>&v=4' >4</a> 
                                <a href='reservas.php?idres=<?php echo $row[1];?>&v=5' >5</a>
                            <?php } 
							else print('-');
							?> 
                    </td>               
					<td><a href='DetalleHistorial.php?id=<?php echo $row[1]?>' target='_new'><img src="images/ver.png" alt="ver" border="0" /></a></td>
				</tr>
				<?php	
				}	//while	
				?>	
                <tr>
                	<td colspan="4"> </td>
                </tr>
             	</tbody>
				</table>
              
                <table id="horario2" width="480">
				<thead>
                <tr><th colspan="4" align="center">RESERVAS  RECHAZADAS</th></tr>
				<tr><th >Nro Reserva</th>
					<th >Fecha de reserva</th>                    
                    <th >Estado </th>
                    <th >Opciones</th>
				</tr>
				</thead>
                <tbody>
				<?php 
				$sql="SELECT D_FechaReserva, ID_Reserva, T_Estado 
				 FROM reserva WHERE D_FechaReserva < '".cambiaf_a_mysql($fecha_aux)."' 
				  AND ID_Usuario=".$idUsuario." AND T_Estado=2 ORDER BY ID_Reserva DESC";				 
				$rs = mysql_query($sql) or die("Error al listar historial de reservas");
				
				while($row = mysql_fetch_array($rs)) { 
				
				?>
				<tr>					
                    <td><?php printf("%05d",$row[1]);?></td>
                    <td><?php echo cambiaf_a_normal($row[0]); ?></td>
     				<td> <?php 
						if($row[2]==0) 
							echo "desatendido";
						elseif($row[2]==1) 
							echo "aprobado";
						elseif($row[2]==2) 
							echo "rechazado";
						?> 
                    </td>               
					<td><a href='DetalleHistorial.php?id=<?php echo $row[1]?>' target='_new'><img src="images/ver.png" alt="ver" border="0" /></a></td>
				</tr>
				<?php	
				}	//while	
				?>	
                <tr>
                	<td colspan="4"> </td>
                </tr>
                </tbody>
				</table>
                
                <table id="horario2" width="480">
				<thead>
                <tr>
                  <th colspan="4" align="center">RESERVAS NO CONFIRMADAS</th></tr>
				<tr><th >Nro Reserva</th>
					<th >Fecha de reserva</th>                    
                    <th >Estado </th>
                    <th >Opciones</th>
				</tr>
				</thead>
                <tbody>
				<?php 
				$sql="SELECT D_FechaReserva, ID_Reserva, T_Estado 
				 FROM reserva WHERE D_FechaReserva < '".cambiaf_a_mysql($fecha_aux)."' 
				  AND ID_Usuario=".$idUsuario." AND T_Estado=0 ORDER BY ID_Reserva DESC";				 
				$rs = mysql_query($sql) or die("Error al listar historial de reservas");
				
				while($row = mysql_fetch_array($rs)) { 
				
				?>
				<tr>					
                    <td><?php printf("%05d",$row[1]);?></td>
                    <td><?php echo cambiaf_a_normal($row[0]); ?></td>
     				<td> <?php 
						if($row[2]==0) 
							echo "en espera";
						elseif($row[2]==1) 
							echo "aprobado";
						elseif($row[2]==2) 
							echo "rechazado";
						?> 
                    </td>               
					<td><a href='DetalleHistorial.php?id=<?php echo $row[1]?>' target='_new'><img src="images/ver.png" alt="ver" border="0" /></a></td>
				</tr>
				<?php	
				}	//while	
				?>	
                <tr>
                	<td colspan="4"> </td>
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