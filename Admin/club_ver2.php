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
					
					$query="SELECT ID_Club, N_Nombre, ID_Distrito, T_Direccion, C_Telefono, ID_Estacionamiento, ID_Kiosko, ID_Ducha, F_Estado, T_Descripcion FROM club WHERE ID_Club=".$valor;
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
							<span class="menu-mid">Ver Club</span>
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
		    <th colspan="3" >Ver Club</th>
          </tr>
         </thead>

         <tbody>
		  <tr>
		    <td>Nombre</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="text1" id="text1" class="edit" disabled="disabled" value="<?php print($row[1]); ?>"/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
          	<td width="200">Distrito</td>
		    <td width="10">:</td>
		    <td width="490"><span id="spryselect1">
		      <select name="select1" id="select1" class="edit" disabled="disabled">
              <option>Seleccione un distrito</option>
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
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
	      </tr>
		  <tr>
		    <td>Direcci&oacute;n</td>
		    <td>:</td>
		    <td><span id="sprytextfield3"><input type="text" name="text3" class="edit" disabled="disabled" value="<?php print($row[3]); ?>" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Tel&eacute;fono</td>
		    <td>:</td>
		    <td><span id="sprytextfield4"><input type="text" name="text4"  class="edit" disabled="disabled" value="<?php print($row[4]); ?>" /><span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
           <tr valign="top">
             <td>Detalles adicionales</td>
             <td>:</td>
             <td><textarea name="detalles" cols="36" rows="8" disabled="disabled" class="edit"><?php print($row[9]);?></textarea></td>
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
             
               <input type="checkbox" name="estacionamiento[]" value="1" <?php if ($row2[1]==1) print('checked="checked"')?> disabled="disabled"/>Pagado<br/>
               <input name="estacionamiento[]" type="checkbox" value="2" <?php if ($row2[2]==1) print('checked="checked"')?> disabled="disabled"/>Gratis<br/>
               <input type="checkbox" name="estacionamiento[]" value="3" <?php if ($row2[3]==1) print('checked="checked"')?> disabled="disabled"/>Vigilado</td>
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
               <input type="checkbox" name="kiosko[]" value="1" <?php if ($row2[1]==0) print('checked="checked"')?> disabled="disabled"/>Kiosko<br/>
               <input type="checkbox" name="kiosko[]" value="2" <?php if ($row2[1]==1) print('checked="checked"')?> disabled="disabled"/>Kiosko con chelas</td>
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
               
               <input type="checkbox" name="ducha[]" value="1" <?php if ($row2[1]==0) print('checked="checked"')?> disabled="disabled"/>Duchas<br/>
               <input type="checkbox" name="ducha[]" value="2" <?php if ($row2[1]==1) print('checked="checked"')?> disabled="disabled"/>Duchas con agua caliente</td>
           </tr>
           <tr>
        <td>Estado</td>
		    <td>:</td>

		    <td><span id="spryselect2">
		      <?php 
			  
				  $sel1="";
				  $sel2="";
                  if ($row[8]==1)
					  $sel1='selected="selected"';
                  elseif ($row[8]==2)
					  $sel2='selected="selected"';
				  
                  ?>
             
	           <select name="estado" class="edit" disabled="disabled">
                    <option>Seleccione un estado</option>
                    <option value="1" <?php echo $sel1; ?> >Habilitado</option>
                    <option value="2" <?php echo $sel2; ?> >Deshabilitado</option>
	              </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
           </tr>
	      <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
          </tbody>

	    </table>
        
        
        </div>
        
        <div id="tabla">
		<table width="700" border="0" class="cuerpo" >
        <thead>              
		  <tr>
		    <th colspan="5" >Ver canchas del club</th>
          </tr>
          <tr>
		    <th colspan="5" align="right"><a href="cancha_nuevo.php?club=<?php echo $valor; ?>" target="_blank" style="text-decoration:underline">Nueva cancha</a></th>
          </tr>
		  <tr>
          	<th width="50">ID</th>
		    <th width="230">Nombre</th>
            <th width="200">Tipo</th>
		    <th width="100">Deporte</th>
		  
		    <th width="120">Opciones</th>
	      </tr>
         </thead>
         <tbody>
         <?php
         	$result = mysql_query("SELECT c.ID_Cancha, c.N_Nombre, t.N_Tipo, d.N_Nombre FROM cancha c JOIN tipocancha t ON c.ID_TipoCancha = t.ID_TipoCancha JOIN deporte d ON c.ID_Deporte=d.ID_Deporte JOIN canchaxclub cc ON c.ID_Cancha=cc.ID_Cancha WHERE cc.ID_Club =".$valor);
			
		 	while ($row = mysql_fetch_array($result)){
				
				$salida = '<tr>
		    				<td align="center">'.$row[0].'</td>
		    				<td >'.$row[1].'</td>
		    				<td >'.$row[2].'</td>
							<td >'.$row[3].'</td>
		    				<td align="center"><a href="cancha_ver.php?id='.$row[0].'&club='.$valor.'" target="_blank"><img src="images/ver.png" alt="ver" border="0" /></a><a href="cancha_editar.php?id='.$row[0].'&club='.$valor.'" target="_blank"><img src="images/editar.png" alt="editar" border="0" /></a><a href="#"><img src="images/eliminar.png" alt="eliminar" border="0" /></a></td>
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
        <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
        </script>
        </body>
</html>
