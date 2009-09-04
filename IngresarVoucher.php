<?php 
	session_start();
	require('conexion.php');
	require('config.php');
	require('funciones.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	if (!isset($_SESSION["deporte"]))
	{
			$_SESSION["deporte"]=1;
	}
	
	$dep=$_SESSION["deporte"];
	
	if (isset($_GET['id']))
	{	$res=$_GET['id'];
		$_SESSION['temp']=$res;
	}
	
	$res=$_SESSION['temp'];
	
	if (!isset($_POST['action']))
		$_POST['action']="undefine";
	
	$redir=0;
	if ($_POST['action']=="registrar")
	{
		$fecha_aux=explode('/',$fecha);
		$fecha_aux=$fecha_aux[0].'-'.$fecha_aux[1].'-'.$fecha_aux[2];
		
		$query="INSERT INTO pago (D_FechaPago,C_Voucher,D_FechaVoucher,D_HoraVoucher) 
					 VALUES ('".$fecha_aux."',".$_POST['voucher'].",'".cambiaf_a_mysql($_POST['fecha'])."','".$_POST['hora']."')";	
		
		mysql_query($query);
		$pago_id=mysql_insert_id();
		
		
		$query="UPDATE reserva SET ID_Pago=".$pago_id." WHERE ID_Reserva=".$res;
		mysql_query($query);
		$redir=1;
		
		
		
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CanchasOnline.com | B&uacute;squeda avanzada</title>
<!-- meta, js and css for PG only -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php 
	if ($dep==1)
		print('<link rel="shortcut icon" href="images/pelota_futbol.ico">');
	else if ($dep==2)
			print('<link rel="shortcut icon" href="images/pelota_tenis.ico">');
			
	if ($redir==1)
		print('<script LANGUAGE="JavaScript">
var pagina="reservasPorConfirmar.php"
function redireccionar() 
{
location.href=pagina
} 
setTimeout ("redireccionar()", 0);
</script>');
?>
<link rel="stylesheet" type="text/css" href="estilos/horario.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo2.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo.css" >

<script type='text/javascript' src='js/voucherAJAX.js'></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie6.css" />
  
<![endif]-->
<!--[if gte IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie7.css" />
<![endif]-->
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="todo">
<div id="nubes">
<div id="pgSiteContainer" >
<div id="banner">
<div class="logo">
</div>

<?php include('topmenu.php') ?>

<?php 
	if ($dep==1)
		print('<div class="top_futbol"> </div>');
	else if ($dep==2)
			print('<div class="top_tenis"> </div>');
?>

<div class="clearing">&nbsp;</div>
</div>

<div id="pgPageContent">
<div class="top">
</div>
<div class="cuerpo">
<div id="sa_wrapper">
  <!-- DIV open "sa_wrapper" -->
  <div class="clearing">&nbsp;</div>
 
  <div id="sa_filters">
    <div id="featuredStores">
      <div id="featuresStoresContainer">
        <span style="font-family:Verdana; color:#666; font-size:12px; font-weight:bold; text-align:center;">Busqueda Avanzada</span>
      </div>
    </div>
    <!-- End featuredStores -->
  
     <?php include('menu_izq.php'); ?>
    <div height="10">&nbsp;</div>
  
  </div>
  <!-- End SA_FILTERS -->
  
  <div id="sa_content_wrapper">
    <div id="sa_content">
      <p class="spacer">&nbsp;</p>
     
        <div id="sa_listTop">
        <div id="sortBy">
            <ul>
                
                <li ><em>Pago de reserva</em></li>

    
            </ul>
        </div>
          <div id="sa_products">     	
          	<div id="searchContainerBox_background">
          		
          	
            <form action="IngresarVoucher.php" method="post">
         <table width="480" class="horario" align="center">
          
          <tr>
            <td colspan="3">Por favor, ingrese solo los números que aparecen en el<br/> voucher, 
            				sin guiones, puntos u otro caracter especial.</td>
           
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
          	<td width="102">
	Nro. Voucher</td><td width="10">:</td><td width="232" align="left"> <span id="sprytextfield1"><input type="text" name="voucher" class="edit"/>
	    <span class="textfieldRequiredMsg">Valor requerido</span></span></td>
    	</tr>
        <tr>
        	<td>Fecha</td>
            <td>:</td>
            <td><span id="sprytextfield2"><input type="text" name="fecha" class="edit" />
            <span style="font-size:10px;">(DD/MM/AAAA)</span>
                <span class="textfieldRequiredMsg">Valor requerido</span></span></td>
        <tr>
        	<td>Hora</td>
            <td>:</td>
            <td align="left"><span id="sprytextfield3"><input type="text" name="hora" class="edit" /><span style="font-size:10px;">(HH:MM am/pm)</span>
                <span class="textfieldRequiredMsg">Valor requerido</span></span></td>
    </tr>
        <tr>
          <td></td>
          <td></td>
          <td align="left"><input type="submit" value="registrar" name="submit" class="boton" />
            <input type="hidden" value="registrar" name="action" /></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td align="left"><div id="mensajeVoucher" name='aa' align='center'></div></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td align="left">(*) Las confirmaciones se har&aacute;n por correo electr&oacute;nico.</td>
        </tr>
         </table>
	
	</form>
          
        
              
              
            </div>
            <!-- searchContainerBox_background DIV *** END -->
            <div class="clearing">&nbsp;</div>
          </div>
          <!-- DIV close sa_products -->
         <div id="pg_pagination">
				
				<div class="clearing">&nbsp;</div>
				<div id="pg_paginationRight"></div>
			</div>

 
        </div>
        <!-- DIV close listTop -->
      
    </div>
    <!-- DIV close sa_content -->

  </div>
      <!-- DIV close sa_content_wrapper -->
      <div class="clearing">&nbsp;</div>
      <div style="clear:both"></div>
    </div>
    <!-- DIV close sa_wrapper -->
    </div>
    <!-- DIV close pgContent Body -->
    <div class="bottom"></div>
  </div>
  <!-- End pgPageContent -->
  <br>
</div>
<!-- End pgSiteContainer -->
<div id="footer">
 </div>	

</div>
<!-- End Nubes -->


</div>
<!-- End Todo -->
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
//-->
</script>
</body>
</html>
