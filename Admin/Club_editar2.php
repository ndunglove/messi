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
					
					$query="SELECT * FROM club WHERE ID_Club=".$valor;
					$result = mysql_query($query);
					$row = mysql_fetch_row($result);
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
							<span class="menu-mid">Editar Club</span>
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
		    <th colspan="3" >Editar Club </th>
          </tr>
         </thead>
		<form action="acciones.php" method="post">
         <tbody>
		  <tr>
		    <td>Nombre</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="nombre" class="edit"  value="<?php print($row[1]); ?>" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
          	<td width="200">Direcci&oacute;n</td>
		    <td width="10">:</td>
		    <td width="490"><span id="sprytextfield5"><input type="text" name="direccion" class="edit"  value="<?php print($row[3]); ?>" />
		        <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
	      </tr>
		  <tr>
		    <td>Tel&eacute;fono</td>
		    <td>:</td>
		    <td><span id="sprytextfield3"><input type="text" name="telefono"  class="edit" value="<?php print($row[4]); ?>" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Distrito</td>
		    <td>:</td>
		    <td><span id="spryselect3">
		      <select name="distrito" class="edit"  >
		        <option >Seleccione un distrito</option>
		        <?php 
										
					$query="SELECT ID_Distrito, N_Nombre FROM distrito";
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
		      <span class="selectRequiredMsg">Please select an item.</span></span></td>
		    </tr>
           
           <tr valign="top">
             <td>Detalles adicionales</td>
             <td>:</td>
             <td><textarea name="detalles" cols="37" rows="8" class="edit"><?php print($row[13]);?></textarea></td>
           </tr>
           <tr valign="top">
             <td>Estacionamiento</td>
             <td>:</td>
             <td>
             	<?php 
				$row2[1]=0;
				$row2[2]=0;
				$row2[3]=0;
				if ($row[5]!=NULL)					
				{
					$query="SELECT * FROM estacionamiento WHERE ID_Estacionamiento=".$row[5];
					$result = mysql_query($query);
					$row2 = mysql_fetch_row($result);				
				}
				?>
             
               <input type="checkbox" name="estacionamiento[]" value="1" <?php if ($row2[1]==1) print('checked="checked"')?>/>Pagado<br/>
               <input name="estacionamiento[]" type="checkbox" value="2" <?php if ($row2[2]==1) print('checked="checked"')?>/>Gratis<br/>
               <input type="checkbox" name="estacionamiento[]" value="3" <?php if ($row2[3]==1) print('checked="checked"')?>/>Vigilado</td>
           </tr>
           <tr>
             <td>Kiosko</td>
             <td>:</td>
             <td>
                <?php 
				$row2[1]=-1;
				if ($row[6]!=NULL)					
				{
					$query="SELECT * FROM kiosko WHERE ID_Kiosko=".$row[6];
					$result = mysql_query($query);
					$row2 = mysql_fetch_row($result);				
				}
				?>
               <input type="checkbox" name="kiosko[]" value="1" <?php if ($row2[1]==0) print('checked="checked"')?>/>Kiosko<br/>
               <input type="checkbox" name="kiosko[]" value="2" <?php if ($row2[1]==1) print('checked="checked"')?>/>Kiosko con chelas</td>
           </tr>
           <tr>
             <td>Ducha</td>
             <td>:</td>
             <td>
               <?php 
				$row2[1]=-1;
				if ($row[7]!=NULL)					
				{
					$query="SELECT * FROM ducha WHERE ID_Ducha=".$row[7];
					$result = mysql_query($query);
					$row2 = mysql_fetch_row($result);				
				}
				?>  
               
               <input type="checkbox" name="ducha[]" value="1" <?php if ($row2[1]==0) print('checked="checked"')?>/>Duchas<br/>
               <input type="checkbox" name="ducha[]" value="2" <?php if ($row2[1]==1) print('checked="checked"')?>/>Duchas con agua caliente</td>
           </tr>
           <tr>
        <td>Estado</td>
		    <td>:</td>

		    <td><span id="spryselect2">
		      <?php 
			  
				  $sel1="";
				  $sel2="";
                  if ($row[12]==1)
					  $sel1='selected="selected"';
                  elseif ($row[12]==2)
					  $sel2='selected="selected"';
				  
                  ?>
             
	           <select name="estado" class="edit" >
                    <option>Seleccione un estado</option>
                    <option value="1" <?php echo $sel1; ?> >Habilitado</option>
                    <option value="2" <?php echo $sel2; ?> >Deshabilitado</option>
	              </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
           </tr>
	      <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td><input type="submit" name="button" value="Guardar cambios" />
            	<input type="hidden" name="action" value="club_editar2" />
                <input type="hidden" name="id" value="<?php echo $valor; ?>" />
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
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
//-->
        </script>
        </body>
</html>
