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
<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie6.css" />
<![endif]-->
<!--[if gte IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie7.css" />
<![endif]-->

</head>

<body>
<div id="todo">
<div id="nubes">

<div id="todoDeporte">
<div class="logo">
</div>

<?php include('topmenu.php') ?>

  <div class="clearing">&nbsp;</div>
  <div class="tenis">
   		<a href="deporte_index.php?deporte=2"><img src="images/tenis.gif" /></a>
    </div>
	<div class="futbol">
    	<a href="deporte_index.php?deporte=1"><img src="images/futbol.gif" /></a>
    </div>
    


</div> <!-- fin todo deporte --> 
<div id="anuncios">
 </div>	
<div id="footer">
 </div>	

</div> <!-- fin nubes -->
 
</div>
</body>
</html>