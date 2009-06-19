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
	$idReserva="3";
	
	if($idUsuario!=0 || $idUsuario!=null)
	{
		$cn = fnConnect($msg);
			if(!$cn) {
			fnShowMsg("Error",$msg);
			return;
			} else {							
				$sql="SELECT * FROM usuario tu, reserva tr
							 WHERE tu.ID_Usuario=$idUsuario AND tu.ID_Usuario=tr.ID_Usuario 
							  AND tr.ID_Reserva=$idReserva";	 
							 // echo $sql;
				$rs = mysql_query($sql,$cn) or die("Error al listar historial de reservas");
			}		
			?>						
				
<?php 
	/*
				usuario` (
  `ID_Usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(100) NOT NULL,
  `C_Telefono` varchar(12) NOT NULL,
  `D_FechaNacimiento` datetime NOT NULL,
  `T_Imagen` varchar(200) DEFAULT NULL,
  `ID_Distrito` int(10) unsigned NOT NULL,
  `T_Direccion` varchar(100) NOT NULL,
  `C_Puntos` int(10) unsigned NOT NULL,
  `T_Email` varchar(100) NOT NULL,
  `T_Pass` varchar(16) NOT NULL,
  `F_Estado` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`ID_Usuario`),
  
  En perfil se muestra: foto, nombre, correo, teléfono, dirección, Puntos
  */
				if($row = mysql_fetch_array($rs,MYSQL_ASSOC)) { ?>
					<table border='1' cellpadding='4'>
				<tr>					
					<td> Nombre:
					</td>					
					<td> <?php echo $row["N_Nombre"]; ?>
					</td>					
				</tr>
				<tr>					
					<td> Correo:
					</td>					
					<td> <?php echo $row["T_Email"]; ?>
					</td>					
				</tr>
				<tr>					
					<td> Telefono:
					</td>					
					<td> <?php echo $row["C_Telefono"]; ?>
					</td>					
				</tr>
				<tr>					
					<td> Direccion:
					</td>					
					<td> <?php echo $row["T_Direccion"]; ?>
					</td>					
				</tr>
				<tr>					
					<td> Puntos:
					</td>					
					<td> <?php echo $row["C_Puntos"]; ?>
					</td>					
				</tr>
				
				</table><br/><br/>
				
				<?php	
				if($row["T_Ranking"]==0){
					echo "Asignar Ranking : <input type='tex' />"."<br/>";					
					}
				
				
				}	//if
				?>	

<?php
	}//if($idUsuario!=0 || $idUsuario!=null)
	
	
	
	
?>
</div>

</body>
</html>
