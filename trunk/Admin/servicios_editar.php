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
					
					$query="SELECT s.ID_Servicio, s.N_Nombre, s.ID_Deporte, sc.F_Recargo FROM servicio s JOIN servicioxclub sc ON s.ID_Servicio=sc.ID_Servicio WHERE s.ID_Servicio=".$valor." AND sc.ID_CLub=".$_SESSION['ID_club'];
					$result = mysql_query($query);
					$row = mysql_fetch_row($result)
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
        <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
							<span class="menu-mid">Editar Servicio</span>
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
		    <th colspan="3" >Editar Servicio </th>
          </tr>
         </thead>
		<form action="acciones.php" method="post">
         <tbody>
		  <tr>
		    <td width="200">Nombre</td>
		    <td width="10">:</td>
		    <td width="490"><span id="sprytextfield1"><input type="text" name="text1" id="text1" class="edit"  value="<?php print($row[1]);?>" disabled="disabled"/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Deporte</td>
		    <td>:</td>
		    <td><span id="sprytextfield4">
		      <select name="select3" id="select3" class="edit" disabled="disabled">
		        <option>Seleccione un Deporte</option>
		        <?php 
										
					$query="SELECT ID_Deporte, N_Nombre FROM deporte";
					
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
						$sel = "";	
						if ($row[2]==$row2[0])
							$sel="selected='selected'";
						$salida = '<option value="'.$row2[0].'" '.$sel.'>'.$row2[1].'</option>';						
						print ($salida);
						}
				?>
		        </select>
		      <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Precio</td>
		    <td>:</td>
		    <td><span id="sprytextfield5"><input name="precio" type="text" class="edit" value="<?php print($row[3]);?>" />
		      <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
	      <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td><input type="submit" name="button" value="Guardar cambios" />
            	<input type="hidden" name="action" value="servicio_editar" />
                <input type="hidden" name="id" value="<?php echo $valor; ?>" /></td>
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
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
//-->
        </script>
        </body>
</html>
