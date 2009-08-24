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
    		<title>CanchasOnline::Manejador de contenido v1.0</title>
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
					<li  class="Active">
						<a href="clientes.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Club</span>
							<span class="menu-right"></span>
						</a>
                     
				  </li>
 					
					
					<li class="#">
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
		    <th colspan="5" >Club</th>
           </tr>
           <tr>
           	<th colspan="5" align="right">
               <?php
					
						$cant=0;
						$result='';
						if ($_SESSION['ID_admin']!=0)
						{
							$query="SELECT c.ID_Club, c.N_Nombre, a.N_Usuario, d.N_Nombre FROM club c JOIN administrador a ON c.ID_Administrador = a.ID_Administrador JOIN distrito d ON c.ID_Distrito=d.ID_Distrito WHERE c.ID_Administrador=".$_SESSION['ID_admin'];
							
							$result = mysql_query($query);
							$cant=mysql_num_rows($result);
						}
						if ($cant==0) { 
						
						
						?>
	                   		<a href="club_nuevo.php" target="_blank" style="text-decoration:underline;">Nuevo club</a>
						
                         <?php } ?>
                        </th>
          </tr>
		  <tr>
          	<th width="50">ID</th>
		    <th width="230">Nombre</th>
            <th width="200">Administrador</th>
		    <th width="100">Distrito</th>
		  
		    <th width="120">Opciones</th>
	      </tr>
         </thead>
         <tbody>
         <?php         	
			if ($result!='')
		 	while ($row = mysql_fetch_array($result)){
				
				$salida = '<tr>
		    				<td align="center">'.$row[0].'</td>
		    				<td >'.$row[1].'</td>
		    				<td >'.$row[2].'</td>
							<td >'.$row[3].'</td>
		    				<td align="center"><a href="club_ver2.php?id='.$row[0].'" target="_blank"><img src="images/ver.png" alt="ver" border="0" /></a><a href="club_editar2.php?id='.$row[0].'" target="_blank"><img src="images/editar.png" alt="editar" border="0" /></a><a href="#"><img src="images/eliminar.png" alt="eliminar" border="0" /></a></td>
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
