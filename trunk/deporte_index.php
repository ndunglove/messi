<?php 
	session_start();
	require('conexion.php');
	require('config.php');
	
	$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
	
	if (!isset($_GET["deporte"]))
	{
			$_GET["deporte"]=1;
	}
	
	$_SESSION["cancha"]=0;
	$dep=$_GET["deporte"];
	$_SESSION["deporte"]=$dep;
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

<link rel="stylesheet" type="text/css" href="estilos/Estilo2.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo.css" >


<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie6.css" />
  
<![endif]-->
<!--[if gte IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie7.css" />
<![endif]-->
<script type="text/javascript" src="js/21EE.js" ></script>
<script type="text/javascript" src="js/listarAJAX.js" ></script>

</head>

<body>
<script language="Javascript">
	function abrir(texto) 
	{ 
		window.open(texto, 'window','dependent=1,location=0,menubar=0,resizable=0,toolbar=0,status=1,scrollbars=0,width=568,height=414'); 
	}
</script>
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
        <span style="font-family:Verdana; color:#666; font-size:12px; font-weight:bold; text-align:center;">B&uacute;squeda Avanzada</span>
      </div>
    </div>
    <!-- End featuredStores -->
  
     <form id="sa_filters_form" name="filters" method="GET" action="deporte_index.php"> 
    <!-- <form name="form2" action="" method="post" onsubmit="return false;" > -->
    	<input type="hidden" name="deporte" id="deporte" value="<?php echo $dep; ?>"/>
    	
      <div id="sa_filters_nav">
        <ul id="sa_filters_main">
        
          <!-- Manufacture/Vendor -->
          <li class="off">
            <h3 onclick="javascript:toggleFilter(this);" style="cursor:pointer;">Ubicación</h3>
            <ul id="vendorFilters" class="sa_filters_sub" style="overflow:auto; height:200px; width:160px;">
            <?php 
			
				$result = mysql_query("SELECT * FROM distrito ORDER BY C_Prioridad DESC");
				$cont=0;
		 		while ($row = mysql_fetch_array($result)){
				$cont++;
				if ($cont<=5)
					$salida = ' <li id="'.$row["ID_Distrito"].'">
								<input disabled="disabled" name="vendorIds'.$cont.'" type="checkbox" value="'.$row["ID_Distrito"].'" onclick="consulta(this.form.name); " >
 								'.$row["N_Nombre"].'</li> ';
				else $salida = ' <li id="'.$row["ID_Distrito"].'" >
								<input disabled="disabled" name="vendorIds'.$cont.'" type="checkbox" value="'.$row["ID_Distrito"].'" onclick="consulta(this.form.name); " >
 								'.$row["N_Nombre"].'</li> ';									
				printf ($salida);}
			
			?>
              
             
            </ul>
          </li>  
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Canchas Recomendadas</h3>
            <ul class="sa_filters_sub">
              <li>
                <input disabled="disabled" type="checkbox" name="rank" value="0" onclick="consulta(this.form.name);">
               + Recomendados</li>
            </ul>
          </li>       
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer;">Tipo de cancha</h3>
            <ul class="sa_filters_sub">
              <?php 
			$cont=0;
				$result = mysql_query("SELECT * FROM tipocancha WHERE ID_Deporte=".$dep);
		 		while ($row = mysql_fetch_array($result)){
				$cont++;
				$salida = ' <li id="'.$row["ID_TipoCancha"].'">
							<input disabled="disabled" name="popup3'.$cont.'" type="checkbox" value="'.$row["ID_TipoCancha"].'" onclick="consulta(this.form.name); ">
 							'.$row["N_Tipo"].'</li> ';								
				printf ($salida);				
				}
				
				
			?>
            </ul>
          </li>
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer;">Tamaño de Cancha</h3>
            <ul class="sa_filters_sub">
             <?php 
				$cont=0;
				$result = mysql_query("SELECT * FROM tamcancha WHERE ID_Deporte=".$dep);
		 		while ($row = mysql_fetch_array($result)){
				$cont++;
				$salida = ' <li id="'.$row["ID_TamanoCancha"].'">
							<input disabled="disabled" name="popup5'.$cont.'" type="checkbox" value="'.$row["ID_TamanoCancha"].'" onclick="consulta(this.form.name);">
 							'.$row["N_Nombre"].'</li> ';								
				printf ($salida);}
				
				
			?>
            </ul>
          </li>
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Rango de precios</h3>
            <ul class="sa_filters_sub">            
              <li>S/.
                <input name="lo_p" id="lo_p" value="0" class="priceRange" type="text" onkeyup="consulta(this.form.name);">
                a
                <input name="hi_p" id="hi_p" value="0" class="priceRange" type="text" onkeyup="consulta(this.form.name);">
              </li>
              <li><img src="images/sa_filters_hideArrow.gif" class="vMiddle"> <a onclick="togglePriceRangeFilter(this);" href="javascript:void(0);" class="seemore">Esconder</a></li>
            </ul>
          </li>
          
          
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Servicios Adicionales</h3>
            <ul class="sa_filters_sub">
            <?php 
				$cont=0;
				$result = mysql_query("SELECT * FROM servicio WHERE F_Opcional=1 AND ID_Deporte=".$dep);
		 		while ($row = mysql_fetch_array($result)){
				$cont++;
				$salida = ' <li id="'.$row["ID_Servicio"].'">
							<input disabled="disabled" name="popup4'.$cont.'" type="checkbox" value="'.$row["N_Nombre"].'" onclick="consulta(this.form.name);">
 							'.$row["N_Nombre"].'</li> ';								
				printf ($salida);}				
				
			?>
			     </ul>
          </li>
          
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Estacionamiento</h3>
            <ul class="sa_filters_sub">
            	<li>
                <input disabled="disabled" type="checkbox" name="estacionamiento1" value="1" id="1" onclick="consulta(this.form.name); ">
               Pagado</li>
              <li>
                <input disabled="disabled" type="checkbox" name="estacionamiento2" value="1" id="1" onclick="consulta(this.form.name); ">
                Gratis</li>
              <li>
                <input disabled="disabled" type="checkbox" name="estacionamiento3" value="1" id="1" onclick="consulta(this.form.name); ">
                Vigilado</li>
            </ul>
          </li>
          
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Duchas</h3>
            <ul class="sa_filters_sub">
              
              <li>
                <input disabled="disabled" type="checkbox" name="duchas1" value="0" id="0" onclick="consulta(this.form.name); ">
                Agua Fr&iacute;a</li>
              <li>
                <input disabled="disabled" type="checkbox" name="duchas2" value="1" id="1" onclick="consulta(this.form.name); ">
                Agua Caliente</li>
            </ul>
          </li>
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Kiosko</h3>
            <ul class="sa_filters_sub">
              <li>
                <input disabled="disabled" type="checkbox" name="kiosko1" value="0" id="0" onclick="consulta(this.form.name);">
               Variado</li>
              <li>
                <input disabled="disabled" type="checkbox" name="kiosko2" value="1" id="1" onclick="consulta(this.form.name);">
              Variado con Chelas</li>
            </ul>
          </li>
          
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Buscar</h3>
            <ul class="sa_filters_sub">
              <li>
                <input type="text" value="" class="pg_search2" name="buscar" />
              </li>
            </ul>
          </li>
        </ul>
        <div id="updateFilterLink">
        	<input type="hidden" name="buscar2" value="si">
        	<input type="submit" value="Actualizar Resultados">
        </div>
      </div>
      <!--END FILTER NAV CONTAINER-->
    </form>
    <script type="text/javascript">
		initFilters();
	</script>
    <div height="10">&nbsp;</div>
  
  </div>
  <!-- End SA_FILTERS -->
  
  <div id="sa_content_wrapper">
    <div id="sa_content">
      <p class="spacer">&nbsp;</p>
      <form  id="productCompareForm" method="get" action="/laptop/p/13/compare/"  name="compare">
        <div id="sa_listTop">
        <div id="sortBy">
            <ul>
                
                <li ><em>Paso 1 de 4</em></li>

    
            </ul>
        </div>
          <div id="sa_products">     	
          	<div id="searchContainerBox_background"><br/>
          		
          		<?php /*EL RESULTADO DE LA BUSQUEDA  */
              
              
              ?>            
              
              
              
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
      </form>
     
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
</body>
</html>