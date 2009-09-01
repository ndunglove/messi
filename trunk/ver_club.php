<?php
session_start();
require('conexion.php');
require('config.php');

$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
mysql_select_db($MySQL_BaseDatos, $link);

$query="SELECT c.ID_Club, c.N_Nombre, a.N_Usuario, d.N_Nombre, c.T_Direccion, c.C_Telefono, c.T_Banco, c.T_Descripcion  FROM club c JOIN administrador a ON c.ID_Administrador = a.ID_Administrador JOIN distrito d ON c.ID_Distrito=d.ID_Distrito WHERE c.ID_Club=".$_GET['id'];

$result = mysql_query($query);

$row=mysql_fetch_row($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Canchas Online | Ver club</title>
<link rel="stylesheet" type="text/css" href="estilos/Estilo4.css" >

</head>

<body style="background-image:url(images/fondo_club.gif); background-repeat:no-repeat;">

<table width="500" height="338" border="0" style="margin-left:22px; margin-top:25px;">
	<tr>
    	<td width="130" rowspan="9" valign="top"><img src="<?php print($ruta_img.$row[0].".jpg"); ?>"  width="90" height="90"  border="0"></td>
        <td colspan="3" height="42"><span class="titulo"><?php print($row[1]); ?></span></td>
    </tr>
    <tr>
    	<td width="101" height="22"><span class="tit">Contacto</span></td>
        <td width="3">:</td>
        <td width="268"><?php print($row[2]); ?></td>
    </tr>
    <tr>
    	<td height="25"><span class="tit">Direcci&oacute;n</span></td>
        <td>:</td>
        <td><?php print($row[4]); ?></td>
    </tr>
     <tr>
    	<td height="25"><span class="tit">Distrito</span></td>
        <td>:</td>
        <td><?php print($row[3]); ?></td>
    </tr>
    <tr>
    	<td height="25"><span class="tit">Tel&eacute;fono</span></td>
        <td>:</td>
        <td><?php print($row[5]); ?></td>
    </tr>
    <tr>
    	<td height="25"><span class="tit">Banco</span></td>
        <td>:</td>
        <td><?php print($row[6]); ?></td>
    </tr>
    <tr>
    	<td height="25" colspan="3"><span class="tit">Descripci&oacute;n</span></td>
    </tr>
    <tr>
    	<td height="144"  colspan="3" valign="top"><?php print($row[7]); ?></td>
    </tr>
    <tr>
    	<td height="25"  colspan="3">&nbsp;</td>
    </tr>
</table>

</body>
</html>