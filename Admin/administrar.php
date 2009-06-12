
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
               
                <style media="all" type="text/css">@import "menu_style.css";</style>
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="ie6.css" media="screen"/>
	<![endif]-->
    		<title>Distancias::Manejador de contenido v1.0</title>
        </head>
        <body>
        
       <div id="wrapper1">
       <?php include('cabecera.php'); ?>
	<div class="wrapper">
	  <div class="nav-wrapper">
			<div class="nav-left"></div>
			<div class="nav">
				<ul id="navigation" >
				 <li class="active">
						<a href="administrar.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Configuraci&oacute;n</span>
							<span class="menu-right"></span>
						</a>
				  </li>
					<li class="#">
						<a href="club.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Clubs</span>
							<span class="menu-right"></span>
						</a>
				  </li>
 					<li class="#">
						<a href="usuarios.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Usuarios</span>
							<span class="menu-right"></span>
						</a>
            	   	    <div class="sub">
			   				<ul>
         			   					<li>
									<a href="articulo_nuevo.php" target="_blank">Nuevo</a>
								</li>
         			   					<li>
									<a href="articulo.php" target="_self">Listar</a>
								</li>
			   				</ul></div>
					</li>
					<li class="#">
						<a href="administradores.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Administradores</span>
							<span class="menu-right"></span>
						</a>
            	   	    <div class="sub">
			   				<ul>
         			   					<li>
									<a href="desayuno_nuevo.php" target="_blank">Nuevo</a>
								</li>
         			   					<li>
									<a href="desayuno.php" target="_self">Listar</a>
								</li>
			   				</ul></div>
					</li>
 
					
 
					<li class="#">
						<a href="notificaciones.php" target="_self">
							<span class="menu-left"></span>
							<span class="menu-mid">Notificaciones</span>
							<span class="menu-right"></span>
						</a>
            	   	    <div class="sub">
			   				<ul>
         			   					<li>
									<a href="evento_nuevo.php" target="_blank">Nuevo</a>
								</li>
         			   					<li>
									<a href="evento.php" target="_self">Listar</a>
								</li>
			   				</ul></div>
					</li>
 
					

			   	</ul>
			</div>
		<div class="nav-right"></div> 
        
		<div id="tabla">
		<table width="700" border="0" class="cuerpo" >
        <thead>              
		  <tr>
		    <th colspan="5" >Opciones de Configuraci&oacute;n</th>
		    
	      </tr>
         </thead>
         <tbody>
		  <tr>
		    <td width="5%">&nbsp;</td>
		    <td width="27%">Usuario</td>
		    <td width="1%">:</td>
		    <td width="63%"><label>
		      <input type="text" name="textfield" id="textfield" size="50"/>
		    </label></td>
		    <td width="4%">&nbsp;</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>Contrase&ntilde;a</td>
		    <td>:</td>
		    <td><label>
		      <input type="text" name="textfield2" id="textfield2" size="50" />
		    </label></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td><label>
		      <input type="button" id="guardar" value="Guardar Cambios" />
	        </label></td>
		    <td>&nbsp;</td>
	      </tr>
          </tbody>
	    </table>
        </div>
	  </div>
	</div>
</div>
</body>
</html>

