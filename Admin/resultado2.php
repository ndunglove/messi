<?php 
					session_start();
					require('Conexion.php');
					require('funciones.php');
					$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
	    		    mysql_select_db($MySQL_BaseDatos, $link);
					
					if (!isset($_GET['id'])) 
					{
						$_GET['id'] = "0"; 
					}
					$valor = $_GET['id']; 
					
					
					
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
			<div class="nav-left"></div>			<div class="nav">
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
 					
					
					<li class="#">
						<a href="servicios.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Servicios</span>
							<span class="menu-right"></span>
						</a>
					</li>
                    <li class="active">
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
		<table width="700" border="0" class="cuerpo2" >
        <thead>              
		  <tr>
		    <th colspan="4" >Resultado de la b&uacute;squeda</th>
          </tr>
         <form action="resultado.php" method="post">
          
		
         
         <?php 
		 	$query="";
			$bu=$_POST['buscar'];

			if ($_POST['tabla']==2)//usuarios
				{	$t1="ID";
					$t2="Nombre";
					$t3="Usuario";
					
					$query="SELECT u.ID_Usuario, u.N_Nombre, u.T_Email 
											   FROM usuario u, distrito d 
				                              WHERE u.ID_Distrito=d.ID_Distrito AND
											  		d.N_Nombre LIKE '%".$bu."%' OR
											  		u.ID_Usuario LIKE '%".$bu."%' OR
													u.N_Nombre LIKE '%".$bu."%' OR
													u.C_Telefono LIKE '%".$bu."%' OR
													u.D_FechaNacimiento LIKE '%".$bu."%' OR
													u.N_Apellido LIKE '%".$bu."%' OR
													u.T_Direccion LIKE '%".$bu."%' OR
													u.T_Email LIKE '%".$bu."%' OR
													u.F_Estado LIKE '%".$bu."%' 
										   GROUP BY u.ID_Usuario";									
				}
			if ($_POST['tabla']==4)//canchas
				{	$t1="ID";
					$t2="Nombre";
					$t3="Club";
					
					
					$query="SELECT c.ID_Cancha, c.N_Nombre, cu.N_Nombre, cu.ID_Club, cu.ID_Administrador 
											   FROM cancha c JOIN canchaxclub ch ON c.ID_Cancha=ch.ID_Cancha JOIN club cu ON ch.ID_Club=cu.ID_Club, tamcancha t, tipocancha ti, deporte d 
				                              WHERE t.ID_TamanoCancha=c.ID_TamanoCancha AND
											  		t.N_Nombre LIKE '%".$bu."%' OR
											  		ti.ID_TipoCancha=c.ID_TipoCancha AND
													ti.N_Tipo LIKE '%".$bu."%' OR
													d.ID_Deporte=c.ID_Deporte AND
													d.N_Nombre LIKE '%".$bu."%' OR													
													
													cu.N_Nombre LIKE '%".$bu."%' OR																										
													c.ID_Cancha LIKE '%".$bu."%' OR
													c.N_Nombre LIKE '%".$bu."%' OR
													c.F_Estado LIKE '%".$bu."%' 
										   GROUP BY c.ID_Cancha";
				}
				
			$result = mysql_query($query);
			
			$imp = '<tr>
				    <th width="80">'.$t1.'</th>
        		    <th width="300">'.$t2.'</th>
		            <th width="180">'.$t3.'</th>
					<th width="140">Opciones</th>
          			</tr>
    		     	</thead>
					<tbody>';
					
			 print($imp);
			$paso=1; 
			while ($row = mysql_fetch_array($result))
			{
				
			
			if ($_POST['tabla']==2)//usuarios
				{$hver='usuarios_ver.php?id='.$row[0];
					$heditar=$hver;
					}
			if ($_POST['tabla']==3)//clubs
				{
					$hver='club_ver.php?id='.$row[0];
					$heditar='club_editar.php?id='.$row[0];
					
					$paso=1;
					if ($row[3]!=$_SESSION['ID_admin'])
						$paso=0;					
				}
			if ($_POST['tabla']==4)//canchas
				{	
					$hver='cancha_ver.php?id='.$row[0].'&club='.$row[3];
					$heditar='cancha_editar.php?id='.$row[0].'&club='.$row[3];
					$paso=1;
					if ($row[4]!=$_SESSION['ID_admin'])
						$paso=0;					
					
					}
			$salida="";
			if ($paso==1)
				{$salida = '<tr>
		    				<td align="center">'.$row[0].'</td>
		    				<td >'.$row[1].'</td>
		    				<td >'.$row[2].'</td>		
		    				<td align="center"><a href="'.$hver.'" target="_blank"><img src="images/ver.png" alt="ver" border="0" /></a><a href="'.$heditar.'" target="_blank"><img src="images/editar.png" alt="editar" border="0" /></a><a href="#"><img src="images/eliminar.png" alt="eliminar" border="0" /></a></td>
	      			   </tr>';
				}
				printf ($salida);	
			}
				
		 ?>
         
	      <tr>
          	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </tbody>
		</form>
	    </table>
        </div>
        
    
        
        
	  </div>
	</div>
</div>
</body>
</html>
