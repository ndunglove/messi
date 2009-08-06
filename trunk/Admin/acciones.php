<?php 

 	require('Conexion.php');
	require('funciones.php');
 	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);	
	
	$estado=0;
	$tipo=1;
	$link1="";//nuevo
	$link2="";//editar	
	$link3="";//ver	

if (!isset($_POST['action'])) {
		$_POST['action'] = "undefine";
	}

if ($_POST["action"] == "administradores_nuevo") {
					
		$nombre=$_POST["nombre"];
		$privilegios=$_POST["privilegio"];
		$usuario=$_POST["user"];
		$pass=$_POST["pass"];
		$pass2=$_POST["pass2"];

		$query="";
		if ($pass==$pass2)
		{
			$result = mysql_query("SELECT N_Usuario FROM administrador 
			 		  							    WHERE N_Usuario='".$usuario."'");
	        $row = mysql_fetch_row($result);
			if ($row==false)
			{
				$query="INSERT INTO administrador (N_Nombre, 
						 						   ID_privilegio, 
												   N_Usuario, 
												   T_Pass) 
									       VALUES ('".$nombre."',
												   ".$privilegios.",
												   '".$usuario."',
												   '".$pass."')";	
										   
				$chek = mysql_query($query);
			}
			else $chek=false;		
			
		}
		else $chek=false;	
		
		$link1="administradores_nuevo.php";	
		
		if ($chek!=false)
			{
				$estado=1;
				$link2="administradores_editar.php?id=".mysql_insert_id();
				$link3="administradores_ver.php?id=".mysql_insert_id();
			}
		
	}
elseif ($_POST["action"] == "administradores_editar") {
	$tipo=2;	
			
		$query= "UPDATE administrador SET N_Nombre='".$_POST['nombre']."',
									  	  ID_privilegio=".$_POST['privilegio'].",
									  	  T_Pass='".$_POST['pass']."' 
							        WHERE ID_Administrador=".$_POST['id'];
							 
		$chek = mysql_query($query);
		
		$link2="administradores_editar.php?id=".$_POST['id'];
		$link3="administradores_ver.php?id=".$_POST['id'];
		
		if ($chek!=false)
			{
				$estado=1;				
			}
		
	
	}
elseif ($_POST["action"] == "usuarios_editar") {
	$tipo=2;
		$query=     "UPDATE usuario SET N_Nombre='".$_POST['nombre']."',
									    N_Apellido='".$_POST['apellido']."',
									    T_Direccion='".$_POST['direccion']."',
									    C_Telefono='".$_POST['telefono']."',
									    D_FechaNacimiento='".cambiaf_a_mysql($_POST['fecha'])."',
									    ID_Distrito=".$_POST['distrito'].",
									    T_Pass='".$_POST['pass']."',
										F_Estado=".$_POST['estado']." 
							      WHERE ID_Usuario=".$_POST['id'];
						 
		$chek = mysql_query($query);
		
		$link2="usuarios_editar.php?id=".$_POST['id'];
		$link3="usuarios_ver.php?id=".$_POST['id'];
		
		if ($chek!=false)
			{
				$estado=1;
			}		
	
	}
elseif ($_POST["action"] == "club_nuevo") {//falta

		$query=   "INSERT INTO evento (N_Nombre,
									   D_Fecha,
									   N_Lugar,
									   T_Detalle,
									   T_URL)
							   VALUES ('".$_POST['nombre']."',
									   '".cambiaf_a_mysql($_POST['fecha'])."',
									   '".$_POST['lugar']."',
									   '".$_POST['detalle']."',
									   '".$_POST['url']."')";
		$chek = mysql_query($query);
		
		$link1="club_nuevo.php";

		if ($chek!=false)
			{
				$estado=1;
				$link2="evento_editar.php?id=".mysql_insert_id();
				$link3="evento_ver.php?id=".mysql_insert_id();
			}
	
	}
elseif ($_POST["action"] == "club_editar") {
	$tipo=2;
		$query=   "UPDATE club SET N_Nombre='".$_POST['nombre']."',
								   T_Direccion='".$_POST['direccion']."',
								   C_Telefono='".$_POST['telefono']."',
								   C_Relevancia=".$_POST['relevancia'].",
								   ID_Distrito=".$_POST['distrito'].",
								   F_Estado=".$_POST['estado']." 
  						     WHERE ID_Club=".$_POST['id'];
							
		$chek = mysql_query($query);
		
		$link2="club_editar.php?id=".$_POST['id'];
		$link3="club_ver.php?id=".$_POST['id'];
		
		if ($chek!=false)
			{
				$estado=1;				
			}
	
	}
elseif ($_POST["action"] == "cancha_nuevo") {
		$query= " ";
		
		
		$chek = mysql_query($query);
		
  		$link1="cancha_nuevo.php";
		
		if ($chek!=false)
			{
				$estado=1;
				$link2="cancha_editar.php?id=".mysql_insert_id();
				$link3="cancha_ver.php?id=".mysql_insert_id();
			}
		else 
			{
				unlink($_POST['url_img']);
				unlink($_POST['url_pdf']);			
			}
	
	}
elseif ($_POST["action"] == "cancha_editar") {
	$tipo=2;
		$tec=$_POST['techado']-1;
		
		$query=   "UPDATE cancha SET N_Nombre='".$_POST['nombre']."',
								     ID_TamanoCancha=".$_POST['tamano'].",
								     ID_TipoCancha=".$_POST['tipo'].",
								     ID_Deporte=".$_POST['deporte'].",
									 F_Techado=".$tec.",
								     F_Estado=".$_POST['estado']." 
  						       WHERE ID_Cancha=".$_POST['id'];
							 
		$chek = mysql_query($query);
		
		$query=   "UPDATE canchaxclub SET C_Precio=".$_POST['precio']." 
                				   WHERE ID_Cancha=".$_POST['id']." AND ID_Club=".$_POST['id_club'];
	
		$chek3 = mysql_query($query);
		
		$link2="cancha_editar.php?id=".$_POST['id']."&club=".$_POST['id_club'];
		$link3="cancha_ver.php?id=".$_POST['id']."&club=".$_POST['id_club'];
		
		if (($chek!=false) && ($chek3!=false))
			{
				$estado=1;				
			}
	
	}
elseif ($_POST["action"] == "video_nuevo") {
		
		$query=    "INSERT INTO video (N_Nombre,
									   D_Fecha,
									   T_Detalle,
									   T_URL)
							   VALUES ('".$_POST['nombre']."',
									   '".cambiaf_a_mysql($_POST['fecha'])."',
									   '".$_POST['detalle']."',
									   '".$_POST['url_video']."'											 
									  )";
		$chek = mysql_query($query);
		
		$link1="video_nuevo.php";

		if ($chek!=false)
			{
				$estado=1;
				$link2="video_editar.php?id=".mysql_insert_id();
				$link3="video_ver.php?id=".mysql_insert_id();
			}
		else { unlink($_POST['url_video']); }
	
	}
elseif ($_POST["action"] == "video_editar") {
	$tipo=2;		
		$query=    "UPDATE video SET N_Nombre='".$_POST['nombre']."',
									  N_Apellido='".cambiaf_a_mysql($_POST['fecha'])."',
									  T_Direccion='".$_POST['detalle']."'
									  C_Telefono=
									  D_FechaNacimiento=
									  ID_Distrito=
									  T_Pass=		  
									  
							    WHERE ID_usuario=".$_POST['id'];
							 
		$chek = mysql_query($query);
		
		$link2="usuarios_editar.php?id=".$_POST['id'];
		$link3="usuarios_editar_ver.php?id=".$_POST['id'];
		
		if ($chek!=false)
			{
				$estado=1;	
			}
	
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
             
                <style media="all" type="text/css">@import "menu_style.css";</style>
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="ie6.css" media="screen"/>
	<![endif]-->
    		<title>Distancias::Manejador de contenido v1.0</title>
        <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
 <?php include('cabecera.php'); ?>
 <?php 
 
	$salida = "";
	
	if ($estado==0){
 		$salida= '
		<div id="mensaje">
		  <div class="error">
                  	<strong>Error 134.1, </strong>lamentablemente su petici&oacute;n no ha podido <br/>ser procesada.<br/>
                	Por favor, <a href="';
					
		if ($tipo==2)
			{$salida.=$link2;}
		else {$salida.=$link1;}
			
		$salida.='"> clic aqui <img src="images/link.gif" alt="ver" border="0" /></a> para regresar.
			</div>
		</div>';
	
	}	
	else {    
	$salida= '
        <div id="mensaje">
		  <div class="normal">              
                	Los datos han sido guardados satisfactoriamente.<br/>
                    Ahora, usted puede:<br/>
                    <table width="366" border="0" >
  					<tr>
					    <td width="98"><a href="'.$link3.'">Ver cambios <img src="images/link.gif" alt="ver" border="0" /></a></td>
					    <td width="144"><a href="'.$link2.'">Editar nuevamente <img src="images/link.gif" alt="ver" border="0" /></a></td>';
    
	if ($tipo==1){	
	$salida.='			<td width="110"><a href="'.$link1.'">Nuevo Registro <img src="images/link.gif" alt="ver" border="0" /></a></td>
	  		  		</tr>
			  		</table>

		  </div>
		</div>';}
	}
	
	printf($salida);
	
?>	

</div>
</body>
</html>