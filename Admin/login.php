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
	
	if ($_POST['action'] == "login") 
	{
    
        $usuario=$_POST['user'];
        $clave=$_POST['pass'];
        
        $result = mysql_query("SELECT ID_Administrador, T_Pass, ID_Privilegio, N_Nombre FROM administrador WHERE N_Usuario='".$usuario."'");
        $row = mysql_fetch_row($result);
        
        if ($row!=false)
        {
            if ($row[1]==$clave)
                {
                    $_SESSION['ID_admin']=$row[0];
					$_SESSION['privi']=$row[2];
					$_SESSION['N_admin']=$row[3];
                    $_SESSION['op']=0;  
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
<?php
    if (isset($_SESSION['ID_admin'])) 
	{
        if ($_POST['action'] != "login"){
		echo '<center><p>Usted esta autenticado,</p></center><center><p>cierre sesion para iniciar con otra cuenta</p></center>';
		}
		if ($_SESSION['privi']==1){
?>
		<script language="javascript"
        type="text/javascript"
        xml:space="preserve">
		//<![CDATA[
        function redireccionar()
        {
           location.href="admin_administrar.php";
        }
           setTimeout ("redireccionar()", 0);
		//]]>
		</script>

<?php  }
		elseif ($_SESSION['privi']==2){
?>	
		<script language="javascript"
        type="text/javascript"
        xml:space="preserve">
		//<![CDATA[
        function redireccionar()
        {
           location.href="clientes_administrar.php";
        }
           setTimeout ("redireccionar()", 0);
		//]]>
		</script>
<?php
		}
	}
?>     
           
           
           
             
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
							<span class="menu-mid">Login</span>
							<span class="menu-right"></span>
						</a>
				  </li>
					
		   	  </ul>
			</div>
		<div class="nav-right"></div> 
        
		<div id="tabla">
        <form method="post" action="login.php">
		<table width="300" border="0" class="cuerpo2" align="center">
        <thead>              
		  <tr>
		    <th colspan="3" >Login</th>
          </tr>
         </thead>

         <tbody>
		  <tr>
		    <td>Usuario</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="user" class="edit" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
          	<td width="200">Password</td>
		    <td width="10">:</td>
		    <td width="490"><span id="sprytextfield2"><input type="password" name="pass" class="edit"/>
	          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
	      </tr>
	      <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td align="right"> 
   		    <span style="color:red; font-size=11px;">
				 <?php                                                                
                       $msg="";
                             
                       if ($ver==2)
                       {
                          $msg="usuario incorrecto o no existe.";
                       }
                       else if ($ver==3)
                       {
                          $msg="clave incorrecta.";
                       }
                                      
                       $salida=$msg."<br/>";
                                                                   
                       print($salida);
                 ?>
             </span>
                 <input type="submit" name="button" id="button" value="Entrar" /><input type="hidden" name="action" value="login" />
            
            </td>
          </tr>
          </tbody>

	    </table>
       </form>
        </div>
       
	  </div>
	</div>
</div>
        <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
        </script>
        </body>
</html>
