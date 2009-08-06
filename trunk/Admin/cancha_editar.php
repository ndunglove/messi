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
							<span class="menu-mid">Editar Cancha</span>
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
		    <th colspan="3" >Editar Cancha</th>
          </tr>
         </thead>
		<form method="post" action="acciones.php">
          <tbody>
		  <tr>
		    <td>Nombre</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="nombre"  class="edit" value="<?php print($row[1]); ?>"/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		 	<tr>
	        <td>Precio</td>
	        <td>:</td>
	        <td><span id="sprytextfield3"><input type="text" name="precio" class="edit" value="<?php echo $row2[0]; ?>" />
              <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
	        </tr>
             <tr>
          	<td width="200">Tama&ntilde;o</td>
		    <td width="10">:</td>
		    <td width="490"><span id="spryselect1">
		      <select name="tamano" class="edit">
              <option>Seleccione un tamaño</option>
	          <?php 
										
					$query="SELECT ID_TamanoCancha, N_Nombre FROM tamCancha";
					$sel = "";	
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
						if ($row2[0]==$row[2])
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
		    <td>Tipo</td>
		    <td>:</td>
		    <td><span id="spryselect2">
		      <select name="tipo" class="edit">
		      <option>Seleccione un tipo</option>
	          <?php 
										
					$query="SELECT ID_TipoCancha, N_Tipo FROM tipocancha";
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
		    <td>Deporte</td>
		    <td>:</td>
		    <td><span id="spryselect3">
		      <select name="deporte" class="edit">
		      <option>Seleccione un deporte</option>
	          <?php 
										
					$query="SELECT ID_Deporte, N_Nombre FROM deporte";
					$sel = "";	
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
						if ($row2[0]==$row[6])
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
	          <select name="techado" class="edit">
               <option>Seleccione un tipo</option>
               <?php
			   	 $des1="";
				 $des2="";
			   	 if ($row[3]==0)
				 	 $des1='selected="selected"';
				 elseif ($row[3]==1)
			   		   $des2='selected="selected"';
				
			   ?>
	         	<option value="1" <?php echo $des1; ?> >No posee techado</option>
                <option value="2" <?php echo $des2; ?> >Posee techado</option>
                </select>
	          <span class="selectRequiredMsg">Valor requerido.</span></span></td>
	        </tr>
	      
	      <tr>
		    <td>Estado</td>
		    <td>:</td>
		    <td><span id="spryselect5">
		      <select name="estado" class="edit">
              <option> Seleccione un estado</option>
              <?php 
				 $des1="";
				 $des2="";
				 if ($row[8]==1)
				 	 $des1='selected="selected"';
				 elseif ($row[8]==2)
			   		   $des2='selected="selected"';
			  ?>
              <option value="1" <?php echo $des1; ?> >Habilitado</option>
                <option value="2" <?php echo $des2; ?> >Deshabilitado</option>
		        </select>
		      <span class="selectRequiredMsg">Please select an item.</span></span></td>
	      </tr>
	      <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td><input type="submit" name="button" value="Guardar Cambios" />
            	<input type="hidden" name="action" value="cancha_editar" />
                <input type="hidden" name="id" value="<?php print($valor); ?>" />
                <input type="hidden" name="id_club" value="<?php print($club); ?>" />
            </td>
	        </tr>
          </tbody>
		</form>
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
