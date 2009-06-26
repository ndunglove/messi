	<div id="topmenu">
		<ul>
			<li><a href="perfil.php" id="topmenu1" accesskey="1" ><img src="images/perfil.gif" /></a></li>
			<li><a href="reservas.php" id="topmenu3" accesskey="2" ><img src="images/reservas.gif" /></a></li>
			<li><a href="logout.php" id="topmenu2" accesskey="3" ><img src="images/logout.gif" /></a></li>
		</ul>

	</div>
   
   <div id="topmenu">
		<ul>
			<li ><a href="deporte.php" class="topmenu4" accesskey="1" ><img src="images/reservar.gif" style="margin-left:84px;"/></a></li>
		</ul>

	</div>
    
    <div id="bienvenido">
    	<?php 
		
		$query="SELECT N_Nombre FROM usuario WHERE ID_Usuario=".$_SESSION["ID"];		
		$result=mysql_query($query);
		$row=mysql_fetch_row($result);
		
		print('<div class="texto">Bienvenido, '.$row[0].'</div>');
		
		
		?>
    </div>