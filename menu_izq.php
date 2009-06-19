<form id="sa_filters_form" name="filters" method="GET" action="deporte_index.php"> 
    <!-- <form name="form2" action="" method="post" onsubmit="return false;" > -->
    	<input type="hidden" name="deporte" id="deporte" value="<?php echo $dep; ?>"/>
    	
      <div id="sa_filters_nav">
        <ul id="sa_filters_main">
        
          <!-- Manufacture/Vendor -->
          <li class="off">
            <h3 ><a href="reservas.php" style="text-decoration:none; color:#483800; padding-left:5px; cursor:hand;">Historial Reservas</a></h3>     
          </li>         
          <li class="off">
           <h3 ><a href="reservasConfirmadas.php" style="text-decoration:none; color:#483800; padding-left:5px; cursor:hand;">Reservas confirmadas</a></h3>  
		  </li>
          <li class="off">
            <h3 ><a href="reservasPorConfirmar.php" style="text-decoration:none; color:#483800; padding-left:5px; cursor:hand;">Reservas No confirmadas</a></h3>  
          </li>
          <li class="off">
           <h3 ><a href="ranking.php" style="text-decoration:none; color:#483800; padding-left:5px; cursor:hand;">Ranking de Usuarios</a></h3>  
          </li>   
          
        </ul>
        <div id="updateFilterLink">
        	<input type="hidden" name="buscar2" value="si">
            <input type="submit" value="" />
        </div>
      </div>
      <!--END FILTER NAV CONTAINER-->
    </form>