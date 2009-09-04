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
					
					$query="SELECT * FROM cancha WHERE ID_Cancha=".$valor;
					$result = mysql_query($query);
					$row = mysql_fetch_row($result);
					
					if (!isset($_GET['club'])) 
					{
						$_GET['club'] = "0"; 
					}
					$club=$_GET['club'];
					
					$query="SELECT C_Precio FROM canchaxclub WHERE ID_Cancha=".$valor." AND ID_Club=".$club;
					$result2 = mysql_query($query);
					$row2 = mysql_fetch_row($result2);
					
					if (!isset($_GET['mod'])) 
					{
						$_GET['mod'] = 0; 
					}
					
					if ($_GET['mod']==1)
					{
						$query="UPDATE reserva SET T_Estado='1' WHERE ID_Reserva=".$_GET['re'];
						mysql_query($query);	
					}
					elseif ($_GET['mod']==2)
					{
						$query="UPDATE reserva SET T_Estado='2' WHERE ID_Reserva=".$_GET['re'];
						mysql_query($query);	
					}
?>


        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
             
                <style media="all" type="text/css">@import "menu_style.css";</style>
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="ie6.css" media="screen"/>
	<![endif]-->
    		<title>CanchasOnline::Manejador de contenido v1.0</title>
        <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
        <script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
        <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
        <link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
							<span class="menu-mid">Ver cancha</span>
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
		    <th colspan="3" >Ver cancha</th>
          </tr>
         </thead>

         <tbody>
		  <tr>
		    <td>Nombre</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="text1" class="edit" value="<?php print($row[1]); ?>" disabled="disabled" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		 	<tr>
	        <td>Precio</td>
	        <td>:</td>
	        <td><span id="sprytextfield3"><input type="text" name="text3" class="edit" value="<?php echo $row2[0]; ?>" disabled="disabled" />
              <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
	        </tr>
             <tr>
          	<td width="200">Tama&ntilde;o</td>
		    <td width="10">:</td>
		    <td width="490"><span id="spryselect1">
		      <select name="tamano" class="edit" disabled="disabled">
              <option>Seleccione un tamaño</option>
	          <?php 
							$cont=0;			
					$query="SELECT ID_TamanoCancha, N_Nombre FROM tamCancha";
					$sel = "";	
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
						if ($row2[0]==$row[2])
							{
								$sel='selected="selected"';
								$cont=1;
							}
						else $sel="";
						$salida = '<option value="'.$row2[0].'" '.$sel.'>'.$row2[1].'</option>';						
						print ($salida);
						}
					if ($cont==0)
						print('<option value="99999" selected="selected" >Otro</option> ');
					else print('<option value="99999" >Otro</option>');
				?>     
		        </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
	      </tr>
		  <tr>
		    <td>Tipo</td>
		    <td>:</td>
		    <td><span id="spryselect2">
		      <select name="tipo" class="edit" disabled="disabled">
		      <option>Seleccione un tipo</option>
	          <?php 
										
					$query="SELECT ID_TipoCancha, N_Tipo FROM tipocancha";
					$sel = "";	
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
						if ($row2[0]==$row[4])
							$sel='selected="selected"';
						else $sel="";
						$salida = '<option value="'.$row2[0].'" '.$sel.'>'.$row2[1].'</option>';						
						print ($salida);
						}
				?>     
		        </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Deporte</td>
		    <td>:</td>
		    <td><span id="spryselect3">
		      <select name="deporte" class="edit" disabled="disabled">
		      <option>Seleccione un deporte</option>
	          <?php 
										
					$query="SELECT ID_Deporte, N_Nombre FROM deporte";
					$sel = "";	
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
						if ($row2[0]==$row[5])
							$sel='selected="selected"';
						else $sel="";
						$salida = '<option value="'.$row2[0].'" '.$sel.'>'.$row2[1].'</option>';						
						print ($salida);
						}
				?>     
		        </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
	      <tr>
	        <td>Techado</td>
	        <td>:</td>
	        <td><span id="spryselect4">
	          <select name="techado" class="edit" disabled="disabled">
               <option>Seleccione un tipo</option>
               <?php
			   	 $des1="";
				 $des2="";
			   	 if ($row[3]==0)
				 	 $des1='selected="selected"';
				 elseif ($row[3]==1)
			   		   $des2='selected="selected"';
				
			   ?>
	         	<option id="1" <?php echo $des1; ?> >No posee techado</option>
                <option id="2" <?php echo $des2; ?> >Posee techado</option>
                </select>
	          <span class="selectRequiredMsg">Valor requerido.</span></span></td>
	        </tr>
	      
	      <tr>
		    <td>Estado</td>
		    <td>:</td>
		    <td><span id="spryselect5">
		      <select name="estado" class="edit" disabled="disabled">
              <option> Seleccione un estado</option>
              <?php 
				 $des1="";
				 $des2="";
				 if ($row[7]==1)
				 	 $des1='selected="selected"';
				 elseif ($row[7]==2)
			   		   $des2='selected="selected"';
			  ?>
              <option id="1" <?php echo $des1; ?> >Habilitado</option>
                <option id="2" <?php echo $des2; ?> >Deshabilitado</option>
		        </select>
		      <span class="selectRequiredMsg">Please select an item.</span></span></td>
	      </tr>
          </tbody>

	    </table>
       
        </div>
        
         <div id="tabla">
		<table width="700" border="0" class="cuerpo" >
        <thead>              
		  <tr>
		    <th colspan="5" >Ver reservas de la cancha</th>
          </tr>
		  <tr>
          	<th width="100">Nro Reserva</th>
		    <th width="120">Fecha</th>
		    <th width="180">Usuario</th>
            <th width="60">Estado</th>
		    <th width="160">Opciones</th>
	      </tr>
         </thead>
         <tbody>
         <?php

		$query="SELECT r.ID_Reserva, r.D_FechaReserva, u.T_Email, cl.N_Nombre, r.T_Estado FROM reserva r JOIN horario h ON (r.ID_Reserva=h.ID_Reserva), canchaxclub ch, usuario u, club cl, cancha c, administrador a WHERE ch.ID_Club=h.ID_Club AND ch.ID_Cancha=h.ID_Cancha AND ch.ID_Club=cl.ID_Club AND ch.ID_Cancha=c.ID_Cancha AND c.ID_Cancha=".$valor." AND cl.ID_Club=".$club." AND cl.ID_Administrador=a.ID_Administrador AND r.ID_Usuario=u.ID_Usuario GROUP BY r.ID_Reserva ORDER BY r.D_FechaReserva DESC";	
		
         	$result = mysql_query($query);
		 	while ($row = mysql_fetch_array($result)){
				if ($row[4]==0)
					$estado="en espera";
				elseif ($row[4]==1)
						$estado="aprobado";
				elseif ($row[4]==2)
						$estado="no aprobado";

				if ($row[4]==1)
				    $salida='<tr class="especial2">';
				elseif ($row[4]==2)
				    $salida='<tr class="especial3">';
				else $salida='<tr>';
				$salida .=  '<td align="center">%05d</td>
		    				<td align="center">'.cambiaf_a_normal($row[1]).'</td>		    				
		    				<td >'.$row[2].'</td>	
							<td >'.$estado.'</td>	
		    				<td align="right">';
				if ($_SESSION['privi']==2 && $row[4]==0)
				$salida .=	'<a href="cancha_ver.php?mod=1&id='.$valor.'&club='.$club.'&re='.$row[0].'" ><img src="images/aceptar.gif" alt="aceptar" border="0" /></a><a href="cancha_ver.php?mod=2&id='.$valor.'&club='.$club.'&re='.$row[0].'" ><img src="images/cancelar.gif" alt="cancelar" border="0" /></a>';
				$salida .=	'<a href="reservas_ver.php?id='.$row[0].'" target="_blank"><img src="images/ver.png" alt="ver" border="0" /></a><a href="#"><img src="images/eliminar.png" alt="eliminar" border="0" /></a></td>
	      			   </tr>';
					   
				printf ($salida,$row[0]);}
				
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
        <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");
//-->
        </script>
        </body>
</html>
