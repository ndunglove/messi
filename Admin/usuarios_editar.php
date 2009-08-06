<?php 
					require('Conexion.php');
					require('funciones.php');
					$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
	    		    mysql_select_db($MySQL_BaseDatos, $link);
					
					if (!isset($_GET['id'])) 
					{
						$_GET['id'] = "0"; 
					}
					$valor = $_GET['id']; 
					
					$query="SELECT * FROM usuario WHERE ID_Usuario=".$valor;
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
							<span class="menu-mid">Editar Usuario</span>
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
		    <th colspan="3" >Editar Usuario </th>
          </tr>
         </thead>
		<form action="acciones.php" method="post">
         <tbody>
		  <tr>
		    <td>Nombres</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="nombre"  class="edit"  value="<?php print($row[1]); ?>"/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
          	<td width="200">Apellidos</td>
		    <td width="10">:</td>
		    <td width="490"><span id="sprytextfield2"><input type="text" name="apellido"   class="edit"  value="<?php print($row[11]); ?>"/>
		        <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
	      </tr>
		  <tr>
		    <td>DIreccion</td>
		    <td>:</td>
		    <td><span id="sprytextfield3"><input type="text" name="direccion"  class="edit" value="<?php print($row[6]); ?>" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Telefono</td>
		    <td>:</td>
		    <td><span id="sprytextfield4"><input type="text" name="telefono"  class="edit" value="<?php print($row[2]); ?>" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
           <tr>
        <td>Fecha de Nacimiento</td>
		    <td>:</td>
		    <td><span id="sprytextfield5"><input type="text" name="fecha" class="edit"  value="<?php print(cambiaf_a_normal($row[3])); ?>"/>
		        <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
           </tr>
	       <tr>
	         <td>Disitrito</td>
	         <td>:</td>
	         <td><span id="spryselect1">
	           <select name="distrito" class="edit"  >
               <option >Seleccione un distrito</option>
	           <?php 
										
					$query="SELECT ID_Distrito, N_Nombre FROM distrito";
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
	           <span class="selectRequiredMsg">Please select an item.</span></span></td>
	         </tr>
	       <tr>
	         <td>E-mail</td>
	         <td>:</td>
	         <td><span id="sprytextfield6"><input type="text" name="user"  class="edit"  value="<?php print($row[8]); ?>" disabled="disabled"/>
                <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
	         </tr>
	       <tr>
	         <td>Contrase&ntilde;a</td>
	         <td>:</td>
	         <td><span id="sprytextfield7"><input type="text" name="pass"  class="edit"  value="<?php print($row[9]); ?>"/>
                <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
	         </tr>
	       <tr>
	         <td>Estado</td>
	         <td>&nbsp;</td>
	         <td><span id="spryselect2">
            	 <?php 
				  $sel1="";
				  $sel2="";
                  if ($row[10]==1)
					  $sel1='selected="selected"';
                  elseif ($row[10]==2)
					  $sel2='selected="selected"';
				  
                  ?>
             
	           <select name="estado" class="edit" >
                    <option>Seleccione un estado</option>
                    <option value="1" <?php echo $sel1; ?> >Habilitado</option>
                    <option value="2" <?php echo $sel2; ?> >Deshabilitado</option>
	              </select>
	           <span class="selectRequiredMsg">Please select an item.</span></span></td>
	         </tr>
	       <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td><input type="submit" name="button" value="Guardar Cambios" />
            	<input type="hidden" name="action" value="usuarios_editar" />
                <input type="hidden" name="id" value="<?php print($valor) ?>" />
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
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
//-->
        </script>
        </body>
</html>
