        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
             
                <style media="all" type="text/css">@import "menu_style.css";</style>
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="ie6.css" media="screen"/>
	<![endif]-->
    		<title>Distancias::Manejador de contenido v1.0</title>
        </head>
        <body>
          <div id="wrapper1">
        <?php include('cabecera.php'); ?>

	<div class="wrapper">
	  <div class="nav-wrapper">
			<div class="nav-left"></div>
			<div class="nav">
				<ul id="navigation" >
				 <li class="#">
						<a href="configurar.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Configuraci&oacute;n</span>
							<span class="menu-right"></span>
						</a>
				  </li>
					<li  class="#">
						<a href="administradores.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Administradores</span>
							<span class="menu-right"></span>
						</a>
                         <div class="sub">
			   				<ul>
         			   					<li>
									<a href="administradores_nuevo.php" target="_blank">Nuevo</a>
								</li>
         			   					<li>
									<a href="administradores.php" target="_self">Listar</a>
								</li>
			   				</ul></div>
				  </li>
 					<li class="active">
						<a href="usuarios.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Usuarios</span>
							<span class="menu-right"></span>
						</a>
					</li>
					<li class="#">
						<a href="club.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Clubs</span>
							<span class="menu-right"></span>
						</a>
					</li> 
					<li class="#">
						<a href="notificaciones.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Notificaciones</span>
							<span class="menu-right"></span>
						</a>
					</li>
			   	</ul>
			</div>
		<div class="nav-right"></div> 
        
		<div id="tabla">
		<table width="700" border="0" class="cuerpo" >
        <thead>              
		  <tr>
		    <th colspan="5" >Usuarios Registrados</th>
          </tr>
		  <tr>
          	<th width="50">ID</th>
		    <th width="200">Nombres</th>
            <th width="200">Apellidos</th>
		    <th width="130">Correo</th>
		  
		    <th width="120">Opciones</th>
	      </tr>
         </thead>
         <tbody>
         <?php
		
		require('Conexion.php');
		require('funciones.php');
		$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
        mysql_select_db($MySQL_BaseDatos, $link);

		
         	$result = mysql_query("SELECT ID_Usuario, N_Nombre, N_Apellido, T_Email FROM usuario ORDER BY N_Nombre");
		 	while ($row = mysql_fetch_array($result)){
				
				$salida = '<tr>
		    				<td align="center">'.$row[0].'</td>
		    				<td >'.$row[1].'</td>
		    				<td >'.$row[2].'</td>
							<td >'.$row[3].'</td>
		    				<td align="center"><a href="usuario_ver.php?id='.$row[0].'" target="_blank"><img src="images/ver.png" alt="ver" border="0" /></a><a href="usuario_editar.php?id='.$row[0].'" target="_blank"><img src="images/editar.png" alt="editar" border="0" /></a><a href="#"><img src="images/eliminar.png" alt="eliminar" border="0" /></a></td>
	      			   	   </tr>';
					   
				printf ($salida);}
				
		 ?>

		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		     <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
          </tbody>
	    </table>
        </div>
	  </div>
	</div>
</div>
</body>
</html>
