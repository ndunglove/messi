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
					
					$query="SELECT * FROM administrador WHERE ID_Administrador=".$valor;
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
							<span class="menu-mid">Nuevo Servicio</span>
							<span class="menu-right"></span>
						</a>
				  </li>
					
		   	  </ul>
			</div>
		<div class="nav-right"></div> 
        
		<div id="tabla">
        Los servicios de <strong>estacionamiento, duchas y kiosko</strong> los puede agregar desde la opci&oacute;n "editar club".<br/><br/>
        
        <table width="700" border="0" class="cuerpo2" >
        <thead>              
		  <tr>
		    <th colspan="3" >Agregar servicio a club</th>
          </tr>
         </thead>
		<form action="acciones.php" method="post">
         <tbody>
		  <tr>
		    <td width="200">Nombre</td>
		    <td width="10">:</td>
		    <td width="490"><span id="spryselect1">
		      <select name="servicio" class="edit">
              <option>Seleccione un servicio</option>
              <?php 
										
					$query="SELECT s.ID_Servicio, s.N_Nombre, d.N_Nombre FROM servicio s JOIN deporte d ON s.ID_Deporte=d.ID_Deporte GROUP BY s.N_Nombre ORDER BY d.N_Nombre ASC";
			
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
						$salida = '<option value="'.$row2[0].'" >'.$row2[2].' - '.$row2[1].'</option>';						
						print ($salida);
						}
				?>
		        </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Precio</td>
		    <td>:</td>
		    <td><span id="sprytextfield5"><input type="text" name="precio" class="edit"  value=""/>
		      <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
           <tr>
        <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td><input type="submit" name="button" id="button" value="Registrar" />
            	<input type="hidden" name="action" value="servicio_agregar" />
                <input type="hidden" name="club_id" value="<?php echo $_SESSION['ID_club']; ?>" />
            </td>
           </tr>
	      <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
          </tbody>
		</form>
	    </table>
        <br/>
		<table width="700" border="0" class="cuerpo2" >
        <thead>              
		  <tr>
		    <th colspan="3" >Registrar nuevo servicio </th>
          </tr>
         </thead>
		<form action="acciones.php" method="post">
         <tbody>
		  <tr>
		    <td width="200">Nombre</td>
		    <td width="10">:</td>
		    <td width="490"><span id="sprytextfield1"><input type="text" name="nombre" class="edit"  value=""/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Deporte</td>
		    <td>:</td>
		    <td><span id="sprytextfield4">
		      <select name="deporte" class="edit" >
		        <option>Seleccione un deporte</option>
		        <?php 
										
					$query="SELECT ID_Deporte, N_Nombre FROM deporte";
					$sel = "";	
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
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
		    <td><span id="sprytextfield5"><input type="text" name="precio" class="edit"  value=""/>
		      <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
           <tr>
        <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td><input type="submit" name="button" id="button" value="Registrar" />
            	<input type="hidden" name="action" value="servicio_nuevo" />
                <input type="hidden" name="club_id" value="<?php echo $_SESSION['ID_club']; ?>" />
            </td>
           </tr>
	      <tr>
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
        <script type="text/javascript">
<!--
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
        </script>
        </body>
</html>
