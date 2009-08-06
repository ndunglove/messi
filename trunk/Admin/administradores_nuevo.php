<?php 
	session_start();
	require('Conexion.php');
	require('funciones.php');
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
	mysql_select_db($MySQL_BaseDatos, $link);
	
	if (!isset($_POST['action'])) 
	{
       	$_POST['action'] = "undefine"; 
	}
	
	if ($_POST['action'] == "registrar")
		{
			$nombre=$_POST["nombre"];
			$privilegios=$_POST["privilegio"];
			$usuario=$_POST["user"];
			$pass=$_POST["pass"];
			$pass2=$_POST["pass2"];

			if ($pass==$pass2)
				{
					$result = mysql_query("SELECT N_Usuario FROM administrador WHERE N_Usuario='".$usuario."'");
			        $row = mysql_fetch_row($result);
					
					if ($row==false)
					{
						$result = mysql_query("INSERT INTO administrador (N_Nombre, ID_privilegio, N_Usuario, T_Pass) VALUES ('".$nombre."',".$privilegios.",'".$usuario."','".$pass."') " );						
						if ($result!=false)
							$_SESSION['op']=4; 
					}
					else $_SESSION['op']=3; 
				}
			else  $_SESSION['op']=2;			
		
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
							<span class="menu-mid">Nuevo Administrador</span>
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
		    <th colspan="3" >Nuevo Administrador</th>
          </tr>
         </thead>
         <form action="acciones.php" method="post">
         <tbody>
		  <tr>
		    <td>Nombre</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="nombre" class="edit"/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
          	<td width="200">Privilegios</td>
		    <td width="10">:</td>
		    <td width="490"><span id="spryselect1">
		      <select name="privilegio"  class="edit">
              <option>Seleccione un privilegio</option>
	            <?php 
				
					
					$query="SELECT ID_Privilegio, N_Nombre FROM privilegio";
					$result = mysql_query($query);
						while ($row = mysql_fetch_array($result)){
						$salida = '<option value="'.$row[0].'">'.$row[1].'</option>';						
						print ($salida);
						}
				?>           
		        </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
	      </tr>
		  <tr>
		    <td>Nombre de Usuario</td>
		    <td>:</td>
		    <td><span id="sprytextfield3"><input type="text" name="user" class="edit"/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Contrase&ntilde;a</td>
		    <td>:</td>
		    <td><span id="sprytextfield4"><input type="password" name="pass" class="edit" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Confirme contrase&ntilde;a</td>
		    <td>:</td>
		    <td><span id="sprytextfield2"><input type="password" name="pass2" class="edit"/>
		        <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>
            <input type="submit" name="enviar" value="Registrar" />
            <input type="reset" name="cancelar" value="Cancelar" />
              <input type="hidden" name="action" value="administradores_nuevo" />
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
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
        </script>
        </body>
</html>
