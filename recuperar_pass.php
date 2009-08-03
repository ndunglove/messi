<?php 
	session_start();
	require('conexion.php');
	require('config.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Bienvenido | Seleccione un deporte</title>
<!-- meta, js and css for PG only -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- icono barra explo
<slink rel="shortcut icon" href="icono">-->
<link rel="stylesheet" type="text/css" href="estilos/Estilo.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo3.css" >
<link rel="stylesheet" type="text/css" href="estilos/horario.css" >
<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie6.css" />
<![endif]-->
<!--[if gte IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie7.css" />
<![endif]-->

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="todo">
<div id="nubes">

<div id="todoDeporte2">
<div class="logo">
</div>



  <div class="clearing">&nbsp;</div>
  <br />
  <br />
  <br />
  
  <form method="post" action="recuperar_pass.php">
  <table border="0" align="center" id="horario2">
  <thead>
  	<tr>
    	<th colspan="3">Recuperar contraseña</th>
    </tr>
  </thead>
  <tbody>
  <tr>
  	<td>correo</td>
  	<td>:</td>
  	<td><span id="sprytextfield1"><input type="text" name="correo" class="edit"/>
  	    <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
  </tr>
  
  <tr>
  	<td></td>
  	<td></td>
  	<td align="right"><input name="enviar" type="submit" class="boton" value="Enviar pass"/></td>
  </tr>
  <tr>
    <td></td>
  	<td></td>
  	<td align="right"><a href="index.php" target="_self" style="font-size:11px;" >volver al inicio</a></td>
  </tr>
  </tbody>
  </table>  
  </form>
  
</div> 
<!-- fin todo deporte --> 

<div id="footer">
 </div>	

</div> <!-- fin nubes -->
 
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</html>