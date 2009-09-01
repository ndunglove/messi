<?php
session_start();
require('conexion.php');
require('config.php');

$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
mysql_select_db($MySQL_BaseDatos, $link);

$query="SELECT b.N_Nombre, c.T_Imagen, c.N_Nombre, ta.N_Nombre, ti.N_Tipo, d.N_Nombre, cc.C_Precio, c.T_Detalle, cc.C_Reputacion FROM cancha c JOIN canchaxclub cc ON c.ID_Cancha=cc.ID_Cancha JOIN club b ON cc.ID_Club=b.ID_Club JOIN tamcancha ta ON c.ID_TamanoCancha=ta.ID_TamanoCancha JOIN tipocancha ti ON c.ID_TipoCancha=ti.ID_TipoCancha JOIN deporte d ON c.ID_Deporte=d.ID_Deporte WHERE b.ID_Club=".$_GET['club']." AND c.ID_Cancha=".$_GET['id'];

$result = mysql_query($query);

$row=mysql_fetch_row($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Canchas Online | Ver cancha</title>
<link rel="stylesheet" type="text/css" href="estilos/Estilo4.css" >

</head>

<body style="background-image:url(images/fondo_cancha.gif); background-repeat:no-repeat;">

<table width="500" height="338" border="0" style="margin-left:22px; margin-top:25px;">
	<tr>
    	<td width="170" rowspan="9" valign="top"><img src="<?php print($row[1]); ?>"  width="150" height="150"  border="0"></td>
        <td colspan="3" height="42"><span class="titulo"><?php print($row[2]); ?></span></td>
    </tr>
    <tr>
    	<td width="101" height="22"><span class="tit">Club</span></td>
        <td width="3">:</td>
        <td width="268"><?php print($row[0]); ?></td>
    </tr>
    <tr>
    	<td height="25"><span class="tit">Tamaño</span></td>
        <td>:</td>
        <td><?php print($row[3]); ?></td>
    </tr>
     <tr>
    	<td height="25"><span class="tit">Tipo</span></td>
        <td>:</td>
        <td><?php print($row[4]); ?></td>
    </tr>
    <tr>
    	<td height="25"><span class="tit">Deporte</span></td>
        <td>:</td>
        <td><?php print($row[5]); ?></td>
    </tr>
    <tr>
    	<td height="25"><span class="tit">Precio</span></td>
        <td>:</td>
        <td>desde S/. <?php print($row[6]); ?></td>
    </tr>
   <tr>
    	<td height="25"><span class="tit">Reputaci&oacute;n</span></td>
        <td>:</td>
        <td><img src="images/rating_<?php 
				$tempor=$row[8];
				$rank="";
				switch ($tempor) {
					case 1:   $rank="1"; break;
					case 1.5: $rank="1_5"; break;
					case 2:   $rank=2; break;
					case 2.5: $rank="2_5"; break;
					case 3:	  $rank=3; break;
					case 3.5: $rank="3_5"; break;
					case 4:   $rank=4; break;
					case 4.5: $rank="4_5"; break;
					case 5:   $rank=5; break;
					default:  $rank=0; break;
					}
				echo $rank;			
			?>.gif" height=11 width=60 border=0></td>
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