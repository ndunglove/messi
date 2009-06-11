<?php 
	session_start();
	require('conexion.php');
	require('config.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	if (!isset($_SESSION["deporte"]))
	{
			$_SESSION["deporte"]=1;
	}
	
	$dep=$_SESSION["deporte"];

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


</head>

<body>
<div id="deporte">
<img src="images/banner_deportes.jpg" border="0" usemap="#Map" />
<map name="Map" id="Map">
  <area shape="rect" coords="271,388,476,676" href="deporte_index.php?deporte=1" target="_self" alt="fútbol" />
  <area shape="rect" coords="534,388,734,676" href="deporte_index.php?deporte=2" target="_self" alt="Tenis" />
</map>
</div>
</body>
</html>