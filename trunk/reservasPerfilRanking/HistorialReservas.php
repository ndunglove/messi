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
	
	echo $fechaActual=date("Ymd");
	
		$cn = fnConnect($msg);
			if(!$cn) {
			fnShowMsg("Error",$msg);
			return;
			} else {							
				$sql="SELECT DATE_FORMAT(CONVERT_TZ(D_FechaReserva,'SYSTEM','-5:00'), '%e de %M del %Y a las %h:%i:%s %p') as fechaReserva, 
				 tr.* 
				 FROM reserva as tr WHERE DATE_FORMAT(CONVERT_TZ(D_FechaReserva,'SYSTEM','-5:00'), '%Y%m%e') < ".$fechaActual." 
				  AND ID_Usuario=".$idUsuario." order by D_FechaReserva desc";				 
				$rs = mysql_query($sql,$cn) or die("Error al listar historial de reservas");
			}		
				?>		
				
<table border='1' cellpadding='4'>
				<tr>
					<td colspan='2'>Fecha de Reserva
					</td>
				</tr>
				
				<?php while($row = mysql_fetch_array($rs,MYSQL_ASSOC)) { ?>
				<tr>
					<td> <?php echo $row["fechaReserva"]; ?> <?php echo $row["ID_Reserva"]; ?> 
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
