<?php 
	require ("funciones.php");
	require('conexion.php');
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);

	$idReserva=getPageParameter("id","");
	
	if ($idReserva!=""){				
	
			/*  $sql="SELECT tr.*, tp.C_Voucher, tc.N_Nombre NombreCancha, tcl.N_Nombre NombreClub, td.N_Nombre NombreDistrito, 
				DATE_FORMAT(CONVERT_TZ(tr.D_FechaReserva,'SYSTEM','-5:00'), '%e de %M del %Y a las %h:%i:%s %p') as fechaReserva 
				FROM reserva tr, pago tp, horario th, cancha tc, canchaxclub tcc, club tcl, distrito td 
				WHERE tr.ID_Pago=tp.ID_Pago 
				AND tr.ID_Reserva=th.ID_Reserva 
				AND th.ID_Cancha=tc.ID_Cancha 
				AND tc.ID_Cancha=tcc.ID_Cancha 
				AND tcc.ID_Club=tcl.ID_Club 
				AND tcl.ID_Distrito=td.ID_Distrito 
				AND tr.ID_Reserva=".$idReserva;*/
									
				$sql="SELECT tr.*, tp.C_Voucher, tc.N_Nombre NombreCancha,
				DATE_FORMAT(CONVERT_TZ(tr.D_FechaReserva,'SYSTEM','-5:00'), '%e de %M del %Y a las %h:%i:%s %p') as fechaReserva
				FROM reserva tr, pago tp, horario th, cancha tc
				WHERE tr.ID_Pago=tp.ID_Pago
				AND tr.ID_Reserva=th.ID_Reserva
				AND th.ID_Cancha=tc.ID_Cancha
				AND tr.ID_Reserva=".$idReserva;
				;
				$rs = mysql_query($sql,$link) or die("error en consulta de Reserva");
					$idUsuario="";
					$nombreClub="&nbsp;";
					$distrito="&nbsp;";
					$nombreCancha="&nbsp;";
					$fechaReserva="&nbsp;";
					$nroVoucher="&nbsp;";
					$detalles="&nbsp;";
				if($row = mysql_fetch_array($rs)){
					$nombreCancha=$row["NombreCancha"];
					$fechaReserva=$row["fechaReserva"];
					$nroVoucher=$row["C_Voucher"];
					$detalles=$row["T_DetallesAdicionales"];
					$idUsuario=$row["ID_Usuario"];
				}
			
				?>
				
	<table border='1' cellpadding='4' align="center">
				<tr>
					<th colspan='2'> Reserva <?php echo $idReserva; ?>
					</th>
				</tr>
				<tr>
					<td>Club
					</td>
					<td>Club
					</td>
				<tr>
					<td>Distrito	
					</td>
					<td>Distrito	
					</td>
				<tr>
					<td>Cancha
					</td>
					<td><?php echo $nombreCancha ;?>
					</td>
				<tr>
					<td>Fecha
					</td>
					<td><?php echo $fechaReserva; ?>
					</td>
				<tr>
					<td>Nro vaucher
					</td>
					<td><?php echo $nroVoucher; ?>
					</td>
				<tr>
					<td>Detalles
					</td>
					<td><?php echo $detalles; ?>
					</td>
					
				</tr>
				</table>
						
	<?php 
				if ($idUsuario!=""){
					
					$nombreUsuario="&nbsp;";
					$correo="&nbsp;";
					$telefono="&nbsp;";
					$direccion="&nbsp;";
					$puntos="&nbsp;";
					
				$sql="SELECT * FROM usuario WHERE ID_Usuario=".$idUsuario;				
				$rs = mysql_query($sql,$link) or die("error en consultar Usuario");					
					
				if($row = mysql_fetch_array($rs)){
					$nombreUsuario=$row["N_Nombre"];
					$correo=$row["T_Email"];
					$telefono=$row["C_Telefono"];
					$direccion=$row["T_Direccion"];
					$puntos=$row["C_Puntos"];
				}
					
				?>
					<table border='1' cellpadding='4' align="center" >
				<tr>
					<th colspan='2'> Usuario <?php echo $idUsuario; ?>
					</th>
				</tr>
				<tr>					
					<td> Nombre:
					</td>					
					<td> <?php echo $nombreUsuario; ?>
					</td>					
				</tr>
				<tr>					
					<td> Correo:
					</td>					
					<td> <?php echo $correo; ?>
					</td>					
				</tr>
				<tr>					
					<td> Telefono:
					</td>					
					<td> <?php echo $telefono; ?>
					</td>					
				</tr>
				<tr>					
					<td> Direccion:
					</td>					
					<td> <?php echo $direccion; ?>
					</td>					
				</tr>
				<tr>					
					<td> Puntos:
					</td>					
					<td> <?php echo $puntos; ?>
					</td>					
				</tr>
				
				</table>
				
				<?php 
				
				}//if ($idUsuario!="&nbsp;")
	
	}//if ($idReserva!="")
	else {echo "no hay reserva ";}
?>
