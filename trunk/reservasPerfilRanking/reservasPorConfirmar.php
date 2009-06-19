<?php
require_once( "recursos.php" );
fnSessionStart();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="es-ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>..:: Busqueda ::..</title>


</head>
<body class="wp-admin">

<div class="wrap" align='center'>
	
<?php	
	$idUsuario="1";
	/*
	-reservas actuales: se muestra un sub-menú: 1. reservas confirmadas, 2. reservas por confirmar. 
	Cada una muestra un listado con los sgtes datos (**cabe resaltar que deben estar ordenadas de manera descendente por fecha y hora): 
	Club, cancha, fecha, hora, opciones: ver detalles (para ver detalles más específicos como en historial), 
	pagado (muestra "si" o "no" dependiendo del atributo ID_Pago en la tabla reserva, si es 0 o null entonces es "no"), 
	estado (que muestra si esta confirmado o no). para saber si una reserva esta confirmada o no, 
	basta ver en la reserva si el atributo T_Estado; si es 0 => no confirmada. 
	A diferencia de la pagina de "reservas por confirmar" si la opción pagado dice "no", 
	este será un link que lo lleve a una ventana en la que tenga que ingresar el código del Boucher con el que pago la reserva, 
	después de esto tiene que esperar a que el administrador verifique el código y cambie el flag estado dentro de la tabla de reserva a 1. 
	Por favor, validar que el código de Boucher sea único y no haya otro registrado anteriormente en la base de datos.
	[ID_Reserva] => 1
    [ID_Usuario] => 1
    [D_FechaReserva] => 2009-04-29 00:00:00
    [ID_Pago] => 1
    [T_DetallesAdicionales] => deteallee 1
    
    `reserva` (
  `ID_Reserva` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Usuario` int(10) unsigned NOT NULL,
  `D_FechaReserva` datetime NOT NULL,
  `ID_Pago` int(10) unsigned DEFAULT NULL,
  `T_DetallesAdicionales` varchar(200) DEFAULT NULL,
  `T_Estado` smallint(5) unsigned DEFAULT '0',
  `T_Ranking` smallint(5) unsigned DEFAULT '0',
	*/
	
	$fechaActual=date("Ymd");	
	
		$cn = fnConnect($msg);
			if(!$cn) {
			fnShowMsg("Error",$msg);
			return;
			} else {
				$sql="SELECT tr.*, tp.C_Voucher, tc.N_Nombre NombreCancha, tcl.N_Nombre NombreClub, td.N_Nombre NombreDistrito, 
				DATE_FORMAT(CONVERT_TZ(tr.D_FechaReserva,'SYSTEM','-5:00'), '%e de %M del %Y') as fechaReserva 
				FROM reserva tr, pago tp, horario th, cancha tc, canchaxclub tcc, club tcl, distrito td 
				 WHERE
				  tr.T_Estado='0'
				 AND (tr.ID_Pago is null  OR tr.ID_Pago='0')				 
				AND tr.ID_Reserva=th.ID_Reserva 
				AND th.ID_Cancha=tc.ID_Cancha 
				AND tc.ID_Cancha=tcc.ID_Cancha 
				AND tcc.ID_Club=tcl.ID_Club 
				AND tcl.ID_Distrito=td.ID_Distrito 
				AND tr.ID_Usuario=".$idUsuario. " 
				AND DATE_FORMAT(CONVERT_TZ(tr.D_FechaReserva,'SYSTEM','-5:00'), '%Y%m%e') = ".$fechaActual."
				 order by tr.D_FechaReserva desc";
				 
							//echo $sql;			
							
				$rs = mysql_query($sql,$cn) or die("Error al listar reservas CONFIRMADAS");
			}		
				?>						
				<br/>RESERVAS ACTUALES
				<br/> 
				* NO CONFIRMADAS *
                <table border='1' cellpadding='4'>
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
				<?php while($row = mysql_fetch_array($rs,MYSQL_ASSOC)) { ?>
				<tr>
					<td> <?php echo $row["NombreClub"]; ?>
					</td>
					<td> <?php echo $row["NombreCancha"]; ?>
					</td>
					<td> <?php echo $row["fechaReserva"]; ?>
					</td>
					<td> <?php echo $row["T_DetallesAdicionales"]; ?>
					</td>
					<td> <?php 
						if($row["ID_Pago"]==null || $row["ID_Pago"]=="0") {
							?>
							<a href='IngresarVoucher.php?idReserva=<?php echo $row["ID_Reserva"]; ?>'>no
							</a>							
							<?php							
							}							
						else
							echo "si";
						?>
					</td>
						<td> <?php 
						if($row["T_Estado"]=="0") 
							echo "no confirmada";
						else
							echo "confirmada";
						?>
					</td>
					
						
					</td>
					<td><a href='DetalleHistorial.php?id=<?php echo $row["ID_Reserva"]?>' target='_new'> Ver</a> 
					</td>
				</tr>
				<?php	
				}	//while	
				?>	
				</table>
</div>



</body>
</html>
