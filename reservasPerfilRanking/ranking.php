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
	
<?php	/*
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
  KEY `FK_usuario_1` (`ID_Distrito`),
  CONSTRAINT `FK_usuario_1` FOREIGN KEY (`ID_Distrito`) REFERENCES `distrito` (`ID_Distrito`)
  
  es una lista de jugadores ordenada descendentemente por puntos que poseen.
  encima de esa lista se debe mostrar el nombre del usuario con su puesto y puntos respectivos.    */
	$idUsuario="1";
	
	$cn = fnConnect($msg);
			if(!$cn) {
			fnShowMsg("Error",$msg);
			return;
			} else {							
				$sql="SELECT * FROM usuario
							 order by C_Puntos desc";
	 
				$rs = mysql_query($sql,$cn) or die("Error al listar historial de reservas");
			}		
				?>		
				
<table border='1' cellpadding='4'>
				<tr>
					<td colspan='3'>RANKING
					</td>
				</tr>
				<tr>
					<td>Puesto
					</td>
					<td>Jugador
					</td>
					<td>Puntos
					</td>
				</tr>
				
				<?php 
				$puesto=0;
				while($row = mysql_fetch_array($rs,MYSQL_ASSOC)) { ?>
				<tr>
					<td><?php echo ++$puesto;?>
					</td>
					<td> <?php echo $row["N_Nombre"]; ?>
					</td>
					<td> <?php echo $row["C_Puntos"]; ?>
					</td>
					
				</tr>
				<?php	
				}	//while	
				?>	
				</table>
</div>



</body>
</html>
