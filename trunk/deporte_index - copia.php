<?php 
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
<title>Bienvenidos</title>
<!-- meta, js and css for PG only -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- icono barra explo
<slink rel="shortcut icon" href="icono">-->
<link rel="stylesheet" type="text/css" href="estilos/Estilo2.css" >
<link rel="stylesheet" type="text/css" href="estilos/Estilo.css" >


<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie6.css" />
<![endif]-->
<!--[if gte IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie7.css" />
<![endif]-->
<script type="text/javascript" src="js/21EE.js" ></script>
</head>

<body>


<div id="pgSiteContainer" >
<div id="banner">

<div id="topmenu">
		<ul>
			<li><a href="perfil.php" id="topmenu1" accesskey="1" title="">Perfil</a></li>
			<li><a href="reservas.php" id="topmenu3" accesskey="2" title="">Reservas Realizadas</a></li>
			<li><a href="logout.php" id="topmenu2" accesskey="3" title="">Logout</a></li>
		</ul>
	</div>

<div class="clearing">&nbsp;</div>
</div>

<div id="pgPageContent">
<div class="top">
</div>
<div class="cuerpo">
<div class="clearing">&nbsp;</div>
<div id="sa_wrapper">
  <!-- DIV open "sa_wrapper" -->
  
 
  <div id="sa_filters">
    <div id="featuredStores">
      <div id="featuresStoresContainer">
        <span style="font-family:Verdana; color:#666; font-size:12px; font-weight:bold; text-align:center;">Busqueda Avanzada</span>
      </div>
    </div>
    <!-- End featuredStores -->
  
    <form id="sa_filters_form" name="filters" method="GET" action="default.php">
      <div id="sa_filters_nav">
        <ul id="sa_filters_main">
        
          <!-- Manufacture/Vendor -->
          <li class="off">
            <h3 onclick="javascript:toggleFilter(this);" style="cursor:pointer;">Ubicación</h3>
            <ul id="vendorFilters" class="sa_filters_sub" style="overflow:auto;">
            <?php 
			
				$result = mysql_query("SELECT * FROM distrito ORDER BY C_Prioridad DESC");
				$cont=0;
		 		while ($row = mysql_fetch_array($result)){
				$cont++;
				if ($cont<=5)
					$salida = ' <li id="'.$row["ID_Distrito"].'">
								<input disabled="disabled" name="vendorIds[]" type="checkbox" value="'.$row["ID_Distrito"].'" >
 								<a onclick="toggleCheckbox(this);">'.$row["N_Nombre"].'</a></li> ';
				else $salida = ' <li id="'.$row["ID_Distrito"].'" style="display:none; ">
								<input disabled="disabled" name="vendorIds[]" type="checkbox" value="'.$row["ID_Distrito"].'" >
 								<a onclick="toggleCheckbox(this);">'.$row["N_Nombre"].'</a></li> ';									
				printf ($salida);}
			
			?>
              
              <li onclick="exposeAllVendors(this);" style="cursor:pointer;"><img src="images/sa_filters_seemoreArrow.gif" class="vMiddle"> <a style="text-decoration:none;color:#999999">Ver más...</a></li>
            </ul>
          </li>         
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer;">Tipo de cancha</h3>
            <ul class="sa_filters_sub">
              <?php 
			
				$result = mysql_query("SELECT * FROM tipocancha WHERE ID_Deporte=".$dep);
		 		while ($row = mysql_fetch_array($result)){
				
				$salida = ' <li id="'.$row["ID_TipoCancha"].'">
							<input disabled="disabled" name="popup3[]" type="checkbox" value="'.$row["ID_TipoCancha"].'" onclick="toggleChildren(this)">
 							<a onclick="toggleCheckbox(this);toggleChildren(this);">'.$row["N_Tipo"].'</a></li> ';								
				printf ($salida);}
				
				
			?>
            </ul>
          </li>
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer;">Tamaño de Cancha</h3>
            <ul class="sa_filters_sub">
             <?php 
			
				$result = mysql_query("SELECT * FROM tamcancha WHERE ID_Deporte=".$dep);
		 		while ($row = mysql_fetch_array($result)){
				
				$salida = ' <li id="'.$row["ID_TamanoCancha"].'">
							<input disabled="disabled" name="popup5[]" type="checkbox" value="'.$row["ID_TamanoCancha"].'" onclick="toggleChildren(this)">
 							<a onclick="toggleCheckbox(this);toggleChildren(this);">'.$row["N_Nombre"].'</a></li> ';								
				printf ($salida);}
				
				
			?>
            </ul>
          </li>
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Rango de precios</h3>
            <ul class="sa_filters_sub">            
              <li>S/.
                <input name="lo_p" value="0" class="priceRange" type="text">
                a
                <input name="hi_p" value="0" class="priceRange" type="text">
              </li>
              <li><img src="images/sa_filters_hideArrow.gif" class="vMiddle"> <a onclick="togglePriceRangeFilter(this);" href="javascript:void(0);" class="seemore">Esconder</a></li>
            </ul>
          </li>
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Servicios Adicionales</h3>
            <ul class="sa_filters_sub">
            <?php 
			
				$result = mysql_query("SELECT * FROM servicio WHERE F_Opcional=1 AND ID_Deporte=".$dep);
		 		while ($row = mysql_fetch_array($result)){
				
				$salida = ' <li id="'.$row["ID_Servicio"].'">
							<input disabled="disabled" name="popup4[]" type="checkbox" value="'.$row["N_Nombre"].'" onclick="toggleChildren(this)">
 							<a onclick="toggleCheckbox(this);toggleChildren(this);">'.$row["N_Nombre"].'</a></li> ';								
				printf ($salida);}				
				
			?>
            </ul>
          </li>
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Estacionamiento</h3>
            <ul class="sa_filters_sub">
            
              <li>
                <input disabled="disabled" type="checkbox" name="estacionamiento" value="0" id="0" >
                <a onclick="toggleCheckbox(this);" >Gratis</a></li>
              <li>
                <input disabled="disabled" type="checkbox" name="estacionamiento" value="1" id="1" >
                <a onclick="toggleCheckbox(this);" >Pagado</a></li>
               <li>
                <input disabled="disabled" type="checkbox" name="estacionamiento" value="2" id="2" >
                <a onclick="toggleCheckbox(this);" >Vigilado</a></li>
            </ul>
          </li>
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Duchas</h3>
            <ul class="sa_filters_sub">
              
              <li>
                <input disabled="disabled" type="checkbox" name="duchas" value="0" id="0" >
                <a onclick="toggleCheckbox(this);" >Agua Fr&iacute;a</a></li>
              <li>
                <input disabled="disabled" type="checkbox" name="duchas" value="1" id="1" >
                <a onclick="toggleCheckbox(this);" >Agua Caliente</a></li>
            </ul>
          </li>
          <li class="on">
            <h3 onclick="toggleFilter(this);" style="cursor:pointer">Kiosko</h3>
            <ul class="sa_filters_sub">
              <li>
                <input disabled="disabled" type="checkbox" name="kiosko" value="0" id="0" >
                <a onclick="toggleCheckbox(this);" >Variado</a></li>
              <li>
                <input disabled="disabled" type="checkbox" name="kiosko" value="1" id="1" >
                <a onclick="toggleCheckbox(this);" >Variado con Chelas</a></li>
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
                
                <li ><em>Clubs</em></li>

    
            </ul>
        </div>
          <div id="sa_products">
            <div class="searchContainerBox_background"><br/>
              <div class="search_gridView_container_box">
                <div class="featuredProduct">&nbsp;</div>
                <div class="productImage">
                
                  
                 <a href="#" ><img src="<?php printf($ruta_img.'1.jpg'); ?>"  width="160" height="160" alt="Nombre Club 1" border="0"></a></div>
                <!-- productImage DIV *** END -->
                <div class="prodTitle"> <a href="#"  class="prod_title" ><b> Nombre Club 1 </b> </a> </div>
                <div class="price" >
                  <p><a rel="nofollow">$629.00</a> </p>
                </div>
                <div class="shopBtn"> <a href="deporte_horario.php?club=1" class="comparePricesBtn" rel="nofollow"  target="_blank"  ><span>Reservar</span> </a> </div>
                <div class="moreInfo"><a >&nbsp;</a></div>
                <div class="search_gridView_containerBottom">
                	&nbsp;
                 <!-- <ul>
                    <li><a href="#" onMouseOver="showDescription(this,'review_Desc_89656464')" onMouseOut="hideDescription('review_Desc_89656464')" ><img src="images/rating_4_5_newr.gif" height=11 width=60 alt="4.5 Star Review" border=0></a></li>
                    
                  </ul> -->
                </div>
                <!-- search_gridView_containerBottom DIV *** END -->
              </div>
              <!-- search_gridView_container_box DIV *** END -->
              <!-- detailsPopup DIV *** END -->
              <div class="search_gridView_container_box">
                <div class="featuredProduct">&nbsp;</div>
                <div class="productImage">
             
                  
                  <a href="#"  ><img src="<?php printf($ruta_img.'3.jpg'); ?>"  width="160" height="160"  border="0"> </a> </div>
                <!-- productImage DIV *** END -->
                <div class="prodTitle"> <a href="#"  class="prod_title"  ><b> Nombre Club 2</b> </a> </div>
                <div class="price" >
                  <p><a href="#" rel="nofollow">$953.99</a> </p>
                </div>
                <div class="shopBtn"> <a href="#" class="comparePricesBtn" rel="nofollow"  target="_blank" ><span>Reservar</span> </a> </div>
                <div class="moreInfo"><a>&nbsp;</a></div>
                <div class="search_gridView_containerBottom">
                  &nbsp;
                 <!-- <ul>
                    <li><a href="#" onMouseOver="showDescription(this,'review_Desc_89656464')" onMouseOut="hideDescription('review_Desc_89656464')" ><img src="images/rating_4_5_newr.gif" height=11 width=60 alt="4.5 Star Review" border=0></a></li>
                    
                  </ul> -->
                </div>
                <!-- search_gridView_containerBottom DIV *** END -->
              </div>
              <!-- search_gridView_container_box DIV *** END -->
              <!-- detailsPopup DIV *** END -->
              <div class="search_gridView_container_box">
                <div class="featuredProduct">&nbsp;</div>
                <div class="productImage">
     
                   <a href="#" ><img src="<?php printf($ruta_img.'1.jpg'); ?>"  width="160" height="160" alt=" Nombre Club 3 " border="0"> </a> </div>
                <!-- productImage DIV *** END -->
                <div class="prodTitle"> <a href="#"  class="prod_title"  onClick="om_singleH_link('pgrabcom,pgrabusops,pgrabglobal','','prop7','merch|fproduct-in|21|13|708802121|2','Merchandising','c80076780d7e0776');" ><b>Nombre Club 3 </b> </a> </div>
                <div class="price" >
                  <p><a   rel="nofollow">$398.90</a> </p>
                </div>
               <!-- <div class="merchantslinks"><a href="#" rel="nofollow">&nbsp;</a></div> -->
                <div class="shopBtn"> <a href="#" class="comparePricesBtn" rel="nofollow"  target="_blank" ><span>Reservar</span> </a> </div>
                <div class="moreInfo"><a>&nbsp;</a></div>
                <div class="search_gridView_containerBottom">
&nbsp;
                 <!-- <ul>
                    <li><a href="#" onMouseOver="showDescription(this,'review_Desc_89656464')" onMouseOut="hideDescription('review_Desc_89656464')" ><img src="images/rating_4_5_newr.gif" height=11 width=60 alt="4.5 Star Review" border=0></a></li>
                    
                  </ul> -->                </div>
                <!-- search_gridView_containerBottom DIV *** END -->
              </div>
              <!-- search_gridView_container_box DIV *** END -->
              <!-- detailsPopup DIV *** END -->
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
    <div class="clearing">&nbsp;</div>
      <div style="clear:both"></div>
    </div>
    <!-- DIV close pgContent Body -->
    <div class="bottom"></div>
  </div>
  <!-- End pgPageContent -->
  <br>
</div>
<!-- End pgSiteContainer -->
</body>
</html>
