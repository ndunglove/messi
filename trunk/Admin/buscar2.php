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
                        <?php
					
						$cant=0;
						if ($_SESSION['ID_admin']!=0)
						{
							$query="SELECT c.ID_Club, c.N_Nombre, a.N_Usuario, d.N_Nombre FROM club c JOIN administrador a ON c.ID_Administrador = a.ID_Administrador JOIN distrito d ON c.ID_Distrito=d.ID_Distrito WHERE c.ID_Administrador=".$_SESSION['ID_Admin'];
							$result = mysql_query($query);
							$cant=mysql_num_rows($result);
						}
						if ($cant==0) { 
						
						
						?>
	                         <div class="sub">
			   				<ul>
         			   					<li>
									<a href="club_nuevo.php" target="_blank">Nuevo</a>
								</li>
         			   					<li>
									<a href="clientes.php" target="_self">Listar</a>
								</li>
			   				</ul></div>
                         <?php } ?>
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
		    <th colspan="3" >Buscar</th>
          </tr>
         </thead>
		<form action="resultado2.php" method="post">
         <tbody>
		  <tr>
		    <td>Texto</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="buscar" class="edit"  value=""/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
          	<td width="200">Tabla</td>
		    <td width="10">:</td>
		    <td width="490"><span id="spryselect1">
		      <select name="tabla" class="edit" >
              <option>Seleccione una tabla</option>
	          <option value="2" >Usuarios</option>

	          <option value="4" >Canchas</option>                                                       
		        </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
	      </tr>
           <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td><input type="submit" name="button" id="button" value="Buscar" />
             	 <input type="hidden" name="action" value="1"/>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
        </script>
        </body>
</html>
