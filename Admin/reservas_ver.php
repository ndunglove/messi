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
					
					$query="SELECT club.N_Nombre nclub,cancha.N_Nombre ncancha, horario.D_Fecha nfecha, hora.D_HoraInicio nhora, distrito.N_Nombre ndistrito, reserva.T_DetallesAdicionales nadicionales, cancha.C_Precio nprecio, servicioxclub.F_Recargo recargo, club.T_Banco banco, club.T_CuentaBanco cuenta, reserva.C_MontoTotal total, reserva.T_Estado estado FROM reserva, horario, canchaxclub, club, cancha, distrito, hora, servicioxclub, servicio WHERE reserva.ID_Reserva=horario.ID_Reserva AND horario.ID_Club=canchaxclub.ID_Club AND horario.ID_Cancha=canchaxclub.ID_Cancha AND canchaxclub.ID_Club=club.ID_Club AND club.ID_Club=servicioxclub.ID_Club AND servicioxclub.ID_Servicio=servicio.ID_Servicio AND servicio.N_Nombre='luz' AND club.ID_Distrito=distrito.ID_Distrito AND canchaxclub.ID_Cancha=cancha.ID_Cancha AND horario.ID_Hora=hora.ID_Hora AND reserva.ID_Reserva=".$valor;
				$result=mysql_query($query);
				
				$row=mysql_fetch_array($result);
				$cant=mysql_num_rows($result); 
				$tot=0;
				$tot=$cant*$row['nprecio'];
				
				
				
			
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
				 <li class="active">
						<a>
							<span class="menu-left"></span>
							<span class="menu-mid">Ver Reserva</span>
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
		    <th colspan="3" >Ver Reserva </th>
          </tr>
         </thead>

         <tbody>
	      <tr>
	        <td width="216"><span style="font-weight:bold;">Club</span></td>
	        <td width="38">:</td>
	        <td width="430"><span style="font-weight:normal;"><?php print($row['nclub']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Cancha</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print($row['ncancha']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Fecha</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print(cambiaf_a_normal($row['nfecha'])); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Hora(s)</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;">
	          <?php 
						    $horasluz=0;
							print($row['nhora'].':00; ');
							if ($row['nhora']>=18)
								$horasluz=$horasluz + 1;
								
							while ($row2 = mysql_fetch_array($result)){
									print($row2['nhora'].':00; ');
									if ($row2['nhora']>=18)
										$horasluz=$horasluz + 1;
									
									} 
							$tot2=$horasluz*$row['recargo'];	
							$TOTAL=$tot+$tot2;
						
						
									?>
	        </span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Distrito</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print($row['ndistrito']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Servicios Adicionales</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print($row['nadicionales']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Sub Total</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print('S/.'.$row['nprecio'].' x '.$cant.' = S/.'.$tot); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Recargo por hora de luz</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print('S/.'.$row['recargo'].' x '.$horasluz.' = S/.'.$tot2); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Monto Total</span></td>
	        <td>:</td>
	        <td><span style="font-weight:normal;"><?php print('S/.'.$row['total']); ?></span></td>
	        </tr>
	      <tr>
	        <td><span style="font-weight:bold;">Estado</span></td>
	        <td>:</td>
	        <td><?php 
				
				if ($row['estado']==0)
					$est="en espera";
				elseif ($row['estado']==1)
						$est="aprobado";
				elseif ($row['estado']==2)
						$est="no aprobado";
			print($est);
			?>
			</td>
	        </tr>
          </tbody>

	    </table>
        </div>
	  </div>
	</div>
</div>
</body>
</html>
