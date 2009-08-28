<?php 
	   
	   		session_start();
			require('Conexion.php');
			require('funciones.php');
			
			$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
	        mysql_select_db($MySQL_BaseDatos, $link);
			
			
			
			
			
		?>
      
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
						<a href="clientes_administrar.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Configuraci&oacute;n</span>
							<span class="menu-right"></span>
						</a>
				  </li>
					<li  class="#">
						<a href="clientes.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Club</span>
							<span class="menu-right"></span>
						</a>
                     
				  </li>
 					
					
					<li class="active">
						<a href="servicios.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Servicios</span>
							<span class="menu-right"></span>
						</a>
                     
					</li>
                    <li class="#">
						<a href="buscar2.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Buscar</span>
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
		    <th colspan="3" >Servicios registrados</th>
           </tr>
           <tr>
             <th colspan="3" align="right"><a href="servicios_nuevo.php" target="_blank" style="text-decoration:underline;">Nuevo servicio</a></th>
          </tr>
		  <tr>
          	<th width="50">ID</th>
		    <th >Nombre</th>
		    <th width="120">Opciones</th>
	      </tr>
         </thead>
         <tbody>
         <?php
	

			$query="SELECT s.ID_Servicio, s.N_Nombre  FROM servicio s JOIN servicioxclub sc ON s.ID_Servicio=sc.ID_Servicio JOIN club c ON sc.ID_Club=c.ID_Club WHERE c.ID_Club=".$_SESSION['ID_club']." AND s.N_Nombre!='luz' GROUP BY s.N_Nombre ORDER BY s.N_Nombre ASC ";
			
         	$result = mysql_query($query);
		
		 	while ($row = mysql_fetch_array($result)){
				
				$salida = '<tr>
		    				<td align="center">'.$row[0].'</td>
		    				<td >'.$row[1].'</td>		
		    				<td align="center"><a href="servicios_ver.php?id='.$row[0].'" target="_blank"><img src="images/ver.png" alt="ver" border="0" /></a><a href="servicios_editar.php?id='.$row[0].'" target="_blank"><img src="images/editar.png" alt="editar" border="0" /></a><a href="#"><img src="images/eliminar.png" alt="eliminar" border="0" /></a></td>
	      			   </tr>';
					   
				printf ($salida);}
				
		 ?>

		  <tr>
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
