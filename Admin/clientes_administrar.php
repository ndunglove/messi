<?php 
	session_start();
	require('Conexion.php');
	require('funciones.php');
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
	mysql_select_db($MySQL_BaseDatos, $link);
	
	if (!isset($_SESSION['op'])) 
    {
        $_SESSION['op']=1; 
    }
	
	if (!isset($_POST['action'])) 
	{
       	$_POST['action'] = "undefine"; 
	}
	
	if ($_POST['action'] == "guardar") 
	{
    
        $clave1=$_POST['pass1'];
        $clave2=$_POST['pass2'];
		$clave3=$_POST['pass3'];
        
		$query="SELECT T_Pass FROM administrador WHERE ID_Usuario=".$_SESSION['ID_admin'];
        $result = mysql_query($query);
        $row = mysql_fetch_row($result);
        
        if ($row!=false)
        {
            if ($row[0]==$clave1)
               {
                    if ($clave2==$clave3)
                	{
               			$query="UPDATE administrador SET T_Pass='".$clave2."' WHERE ID_Usuario=".$_SESSION['ID_admin'];     	
                 		mysql_query($query);
                	}  
					else $_SESSION['op']=4; 
               }
            else $_SESSION['op']=3; 
        }
        else $_SESSION['op']=2;
    }
	
	$ver=$_SESSION['op'];	
?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
               
                <style media="all" type="text/css">@import "menu_style.css";</style>
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="ie6.css" media="screen"/>
	<![endif]-->
    		<title>Distancias::Manejador de contenido v1.0</title>
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
				 <li class="#">
						<a href="clientes_administrar.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Configuraci&oacute;n</span>
							<span class="menu-right"></span>
						</a>
				  </li>
					<li  class="active">
						<a href="clientes.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Club</span>
							<span class="menu-right"></span>
						</a>
                        <?php if ($cant==0) { ?>
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
                    <li class="#">
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
		<table width="700" border="0" class="cuerpo" >
        <thead>              
		  <tr>
		    <th colspan="5" >Cambiar Contrase&ntilde;a</th>
		    
	      </tr>
         </thead>
         <tbody>
		  <tr>
		    <td width="5%">&nbsp;</td>
		    <td width="27%">Usuario</td>
		    <td width="1%">:</td>
		    <td width="63%"><label>
		      <input type="text" name="textfield" id="textfield" size="50" class="edit" value="<?php echo $_SESSION['N_admin']; ?>" disabled="disabled"/>
		    </label></td>
		    <td width="4%">&nbsp;</td>
	      </tr>
		  <form method="post" action="admin_administrar.php" >
          <tr>
		    <td>&nbsp;</td>
		    <td>Contrase&ntilde;a actual</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="pass1"  class="edit"/>
	          <span class="textfieldRequiredMsg">Valor requerido</span></span></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>Contrase&ntilde;a nueva</td>
		    <td>:</td>
		    <td><span id="sprytextfield2"><input type="text" name="pass2"  class="edit"/>
	          <span class="textfieldRequiredMsg">Valor requerido</span></span></td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>Repetir contrase&ntilde;a nueva</td>
		    <td>:</td>
		    <td><span id="sprytextfield3"><input type="text" name="pass3"  class="edit" />
	          <span class="textfieldRequiredMsg">Valor requerido</span></span></td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td></td>
		    <td></td>
		    <td>&nbsp;</td>
		    <td><span style="color:red; font-size=11px;">
				 <?php                                                                
                       $msg="";
                             
                       if ($ver==2)
                       {
                          $msg="usuario incorrecto o no existe.";
                       }
                       else if ($ver==3)
                       {
                          $msg="Contrase&ntilde;a actual no coincide.";
                       }
					   else if ($ver==4)
                       {
                          $msg="Las contrase&ntilde;as nuevas no coinciden.";
                       }
                                      
                       $salida=$msg."<br/>";
                                                                   
                       print($salida);
                 ?>
             </span>
		      <input type="submit" name="guardar" value="Guardar Cambios" />
              <input type="reset" name="cancelar" value="Cancelar" />
              <input type="hidden" name="action" value="guardar" />
	        </td>
		    <td>&nbsp;</td>
	      </tr>
          </form>
          </tbody>
	    </table>
        </div>
	  </div>
	</div>
</div>
       <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
//-->
       </script>
        </body>
</html>

