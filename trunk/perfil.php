<?php 
	session_start();
	require('conexion.php');
	require('config.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	if (isset($_GET["cancelar"]))
	{
		if ($_GET["cancelar"]==1)
			{
				$query="DELETE FROM reserva WHERE ID_Reserva=".$_SESSION["reserva"];
				mysql_query($query);
				
				$_SESSION["reserva"]=-1;
				$_GET["cancelar"]=0;
				
				?>

					<script language="javascript"
				      type="text/javascript"
			    	  xml:space="preserve">
					  //<![CDATA[
            		  function redireccionar()
 	                  {
       	                 location.href="perfil.php";
        		      }
                      setTimeout ("redireccionar()", 0);
			 		  //]]>
					</script>

				<?php
			}
	}
	
	if (!isset($_SESSION["deporte"]))
	{
			$_SESSION["deporte"]=1;
	}
	
	if (!isset($_POST['action'])) {
		$_POST['action'] = "undefine";
	}
	
	$_SESSION["cancha"]=0;
	
	$dep=$_SESSION["deporte"];
	$estado = 0;
	$estado2=0;
	$status='';
	
	if ($_POST["action"] == "upload") 
	{
	
		$prefijo = substr(md5(uniqid(rand())),0,6);

    	// obtenemos los datos del archivo pdf
		$archivo = $_FILES["archivo"]['name'];
	
		if ($archivo != "") 
		{
			// guardamos el archivo a la carpeta files
			$destino =  "Files/fotos/".$prefijo."_".$archivo;
			$img_mime=array("image/jpeg","image/jpg","image/png","image/gif","image/pjpeg"); 
			if ( (in_array($_FILES['archivo']['type'],$img_mime)) )
			{		
				if (copy($_FILES['archivo']['tmp_name'],$destino))
				{
					$status = $destino;
					$query="UPDATE usuario SET T_Imagen='".$destino."' WHERE ID_Usuario=".$_SESSION['ID'];
					$chek = mysql_query($query);
					if ($chek!=false)
						$estado2=1;				
					else  $estado2=0; 
				} else {
					$status = "Error al subir el archivo";
				}
			} else {
				$status = "Error: Tipo de archivo no permitido";
			}
		} else {
			$status = "Error al subir archivo";
		}
	}
	elseif ($_POST["action"] == "eliminar") {
		
		$query="SELECT T_Imagen FROM usuario WHERE ID_Usuario=".$_SESSION['ID'];					 
		$res = mysql_query($query);
		if (is_file('"'.$res[0].'"'))
			unlink('"'.$res[0].'"');
		
		$query="UPDATE usuario SET T_Imagen='' WHERE ID_Usuario=".$_SESSION['ID'];
		$chek = mysql_query($query);
		if ($chek!=false)
			$estado=0;				
		else  $estado=1;
	}
	elseif ($_POST["action"] == "cambios") {
		
		$query="UPDATE usuario SET C_Telefono='".$_POST['telefono']."', T_Direccion='".$_POST['direccion']."' WHERE ID_Usuario=".$_SESSION['ID'];
		mysql_query($query);
	}
	//-------------------------------------------------------
	
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
?>
<link rel="stylesheet" type="text/css" href="estilos/horario.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo2.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo.css" >


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
                
                <li ><em>Perf&iacute;l</em></li>
	<?php	
		$query ="SELECT usuario.T_Imagen, usuario.N_Nombre, usuario.T_Email, usuario.C_Puntos, distrito.N_Nombre, usuario.C_Telefono, usuario.T_Direccion FROM usuario, distrito WHERE usuario.ID_Distrito=distrito.ID_Distrito AND usuario.ID_Usuario=".$_SESSION['ID'];
		$result = mysql_query($query);

		$row = mysql_fetch_row($result);
		if ($_POST['action'] == "undefine")
			$status=$row[0];

		if ($row[0]!=NULL && $row[0]!='')
			$estado = 1;
		
	?>
    
            </ul>
        </div>
          <div id="sa_products">     	
          	<div id="searchContainerBox_background">
            
          		<table align="center" id="horario2">
                	<tr>
                	  <td width="140" rowspan="5" ><span class="foto"><?php if ($estado==1) print('<img src="'.$row[0].'" width="140" height="185" />'); ?></span></td>
                	  <td width="10">&nbsp;</td>
                	  <td width="320"><h4><?php echo $row[1];?></h4></td>
              	  </tr>
                	<tr>
                	  <td>&nbsp;</td>
                	  <td><?php echo $row[2];?></td>
              	  </tr>
                	<tr>
                	  <td>&nbsp;</td>
                	  <td>Puntos acumulados: <?php echo $row[3];?></td>
              	  </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><?php echo $row[4];?></td>

                    </tr>
                    <tr>
                      <td></td>
                      <td>&nbsp;</td>
                    </tr>
     
               </table>
               <form action="perfil.php" method="post">
               <table align="center" id="horario2">
                    <tr>
                      <td width="140">Teléfono</td>
                      <td width="10">:</td>
                      <td width="320"><span id="sprytextfield1"><input type="text" name="telefono" class="edit" value="<?php echo $row['5']; ?>"/>
                          <span class="textfieldRequiredMsg">valor requerido.</span></span></td>
                    </tr>
                    <tr>
                      <td>Dirección</td>
                      <td>:</td>
                      <td><span id="sprytextfield2"><input type="text" name="direccion" class="edit" value="<?php echo $row['6']; ?>"/>
                          <span class="textfieldRequiredMsg">valor requerido.</span></span></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><input type="submit" name="guardar" value="Guardar cambios" class="boton"/>
                       <input name="action" type="hidden" value="cambios" />
                      </td>
                    </tr>
       
                </table>
               
               </form>
                
                
                <table  border="0" align="center" id="horario2">
                 <thead>
                   <tr>
                     <th colspan="3" >Subir  Foto</th>
                   </tr>
                 </thead>
                 <tbody>
				<form action="perfil.php" method="post" enctype="multipart/form-data">
                 
                 <tr>

                   <td width="140">Especificar fotograf&iacute;a </td>
                   <td width="10">:</td>
                   <td width="320"><span id="sprytextfield3">
                     <label> <input type="file" name="archivo" id="archivo" size="30" <?php if ($estado==1) print ('disabled="disabled"');  ?> style="background-color:white;" />
                     </label>
                     <span class="textfieldRequiredMsg">ruta requerida</span></span></td>
                  
                 </tr>
				<tr>

                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td><input name="enviar" type="submit" id="enviar" value="Subir" <?php if ($estado==1) print ('disabled="disabled"'); ?> class="boton"/>
                     <input name="action" type="hidden" value="upload" />
                     <label class="info">(jpg, gif, png -&gt; max 1 MB)</label></td>
                   
                 </tr>
                 </form>    
                 <tr>

                   <td>URL foto</td>
                   <td>:</td>
                   <td><?php if ($status!='') print($status); ?></td>
                  
                 </tr>
                 <form action="perfil.php" method="post">            
                 <tr>

                   <td></td>
                   <td></td>
                   <td><input name="enviar" type="submit" id="enviar" value="eliminar" <?php if ($estado==0) print ('disabled="disabled"'); ?> class="boton"/>
                     <input name="action" type="hidden" value="eliminar" /></td>
                 
                 </tr>
                 </form>
            
                 </tbody>
               </table>
                
    		
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
//-->
</script>
</body>
</html>