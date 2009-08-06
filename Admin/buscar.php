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
			<div class="nav-left"></div><div class="nav">
				<ul id="navigation" >
				 <li class="#">
						<a href="configurar.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Configuraci&oacute;n</span>
							<span class="menu-right"></span>
						</a>
				  </li>
					<li  class="#">
						<a href="administradores.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Administradores</span>
							<span class="menu-right"></span>
						</a>
                         <div class="sub">
			   				<ul>
         			   					<li>
									<a href="administradores_nuevo.php" target="_blank">Nuevo</a>
								</li>
         			   					<li>
									<a href="administradores.php" target="_self">Listar</a>
								</li>
			   				</ul></div>
				  </li>
 					<li class="#">
						<a href="usuarios.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Usuarios</span>
							<span class="menu-right"></span>
						</a>
					</li>
<li class="#">
						<a href="club.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Clubs</span>
							<span class="menu-right"></span>
						</a>
					</li>
					<li class="#">
						<a href="notificaciones.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Notificaciones</span>
							<span class="menu-right"></span>
						</a>
					</li>
                    <li class="active">
						<a href="buscar.php" target="_self">
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
		    <th colspan="3" >Buscar</th>
          </tr>
         </thead>
		<form action="acciones.php" method="post">
         <tbody>
		  <tr>
		    <td>Texto</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="text1" id="text1" class="edit"  value=""/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
          	<td width="200">Tabla</td>
		    <td width="10">:</td>
		    <td width="490"><span id="spryselect1">
		      <select name="select1" id="select1" class="edit" >
              <option>Seleccione una tabla</option>
	          <?php 
										
					$query="SELECT ID_TamanoCancha, N_Nombre FROM TamanoCancha";
					$sel = "";	
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
						$salida = '<option value="'.$row2[0].'" '.$sel.'>'.$row2[1].'</option>';						
						print ($salida);
						}
				?>     
		        </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
	      </tr>
           <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td><input type="submit" name="button" id="button" value="Buscar" /></td>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
        </script>
        </body>
</html>
