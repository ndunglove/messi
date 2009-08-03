<?php 
		session_start();
					require('Conexion.php');
					require('funciones.php');
					$link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
	    		    mysql_select_db($MySQL_BaseDatos, $link);
					
					if (!isset($_GET['id'])) 
					{
						$_GET['id'] = "0"; 
					}
					$valor = $_GET['id']; 
					
					$query="SELECT * FROM administrador WHERE ID_Administrador=".$valor;
					$result = mysql_query($query);
					$row = mysql_fetch_row($result);
	
	//verifica si en la fecha y hora dada 
	function es_reservado($fecha,$hora_inicio,$id_cancha,$link){
		$finn=$hora_inicio+1;
				$fecha=split("/",$fecha);
				$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
				$result = mysql_query("SELECT * FROM horario h1, hora h2 WHERE h1.ID_Hora=h2.ID_Hora AND ID_Cancha=".$id_cancha." AND h1.D_Fecha='".$fecha."' AND h2.D_HoraInicio<=".$hora_inicio." AND h2.D_HoraFin>=".$finn,$link);
				
				//echo ("SELECT * FROM horario h1, hora h2 WHERE h1.ID_Hora=h2.ID_Hora AND ID_Cancha=".$id_cancha." AND h1.D_Fecha='".$fecha."' AND h2.D_HoraInicio<=".$hora_inicio." AND h2.D_HoraFin>=".$finn);
				
		 		$row = mysql_fetch_row($result);
				if ($row==false)
					return false;
				else return true;
		}
	function es_reservado2($fecha,$hora_inicio,$id_cancha,$link){
		$finn=$hora_inicio+1;
				$fecha=split("/",$fecha);
				$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
				$result = mysql_query("SELECT * FROM horario h1, hora h2 WHERE h1.ID_Hora=h2.ID_Hora AND ID_Cancha=".$id_cancha." AND h1.D_Fecha='".$fecha."' AND h2.D_HoraInicio<=".$hora_inicio." AND h2.D_HoraFin>=".$finn,$link);
				//echo ("SELECT * FROM horario h1, hora h2 WHERE h1.ID_Hora=h2.ID_Hora AND ID_Cancha=".$id_cancha." AND h1.D_Fecha='".$fecha."' AND h2.D_HoraInicio<=".$hora_inicio." AND h2.D_HoraFin>=".$finn);
				$row = mysql_fetch_array($result);
				if ($row==false)
					return "";
				else return $row["ID_Reserva"];
		}
	
	//regresa un row con todos los datos de la chancha
	function dame_Cancha($id_cancha,$link,$depo)
	{
		$result = mysql_query("SELECT cancha.ID_Cancha, cancha.N_Nombre, cancha.F_Techado, tamcancha.N_Nombre, tipocancha.N_Tipo, cancha.C_Precio
							   FROM cancha, tamcancha, tipocancha 
							   WHERE cancha.ID_TamanoCancha=tamcancha.ID_TamanoCancha AND cancha.ID_TipoCancha=tipocancha.ID_TipoCancha AND cancha.ID_Deporte=".$depo." AND cancha.ID_Cancha=".$id_cancha.";",$link);
		$row = mysql_fetch_array($result);
		return $row;			
	}	
	
	//variable de navegación del horario
	if(!isset($_GET["pg"]))
	{
		$pg=1;	
	}
	else $pg=$_GET["pg"];
	//$pg=getPageParameter("pg","1");
	
	//variable de deporte
	
	//$dep=$_SESSION["deporte"];
	$dep=1;
	//$club=$_SESSION["club"];
	$club=1;
	
	//query de prueba	
	
	

	
	if (!isset($_POST['action'])) 
	{
		$_POST['action'] = "undefine";
	}

	if ($_POST["action"] == "sel_cancha")
	{
		if (isset($_POST["canchas"]))
		{
			$_SESSION["cancha"]=$_POST["canchas"];
		}
	}
	
	
//	$action=getPageParameter("action","undefine");
	if($_POST["action"]=="sel_cancha"){
			$canchas=getPageParameter("canchas","");
			if($canchas!="")
			{
				$_SESSION["cancha"]=$canchas;
				}
	}
	

	if (!isset($_SESSION["cancha"]))
		$cancha=0;
	else $cancha=$_SESSION["cancha"];
	$cancha=2;
	
?>

?>    

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
             
                <style media="all" type="text/css">@import "menu_style.css";</style>
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="ie6.css" media="screen"/>
	<![endif]-->
    		<title>CanchasOnline::Manejador de contenido v1.0</title>
        <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
        <script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
        <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
        <link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
						<a>
							<span class="menu-left"></span>
							<span class="menu-mid">Ver Cancha</span>
							<span class="menu-right"></span>
						</a>
				  </li>
					
		   	  </ul>
			</div>
		<div class="nav-right"></div> 
        
		<div id="tabla">
		<table width="700" border="0" class="cuerpo2" >
        <thead>              
		  <tr>
		    <th colspan="3" >Ver Cancha</th>
          </tr>
         </thead>

         <tbody>
		  <tr>
		    <td>Nombre</td>
		    <td>:</td>
		    <td><span id="sprytextfield1"><input type="text" name="text1" id="text1" class="edit" disabled="disabled" value="<?php print($row[1]); ?>"/>
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
          	<td width="200">Privilegios</td>
		    <td width="10">:</td>
		    <td width="490"><span id="spryselect1">
		      <select name="select1" id="select1" class="edit" disabled="disabled">
              <option>Seleccione un privilegio</option>
	          <?php 
										
					$query="SELECT ID_Privilegio, N_Nombre FROM privilegio";
					$sel = "";	
					$result = mysql_query($query);
						while ($row2 = mysql_fetch_array($result)){
						if ($row2[0]==$row[2])
							$sel='selected="selected"';
						else $sel="";
						$salida = '<option value="'.$row2[0].'" '.$sel.'>'.$row2[1].'</option>';						
						print ($salida);
						}
				?>     
		        </select>
		      <span class="selectRequiredMsg">Valor requerido.</span></span></td>
	      </tr>
		  <tr>
		    <td>Nombre de Usuario</td>
		    <td>:</td>
		    <td><span id="sprytextfield3"><input type="text" name="text3" id="text3" class="edit" disabled="disabled" value="<?php print($row[3]); ?>" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
		  <tr>
		    <td>Password</td>
		    <td>:</td>
		    <td><span id="sprytextfield4"><input type="text" name="text4" id="text4" class="edit" disabled="disabled" value="<?php print($row[4]); ?>" />
	          <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
		    </tr>
	      <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
          </tbody>

	    </table>
       
        </div>
        <div id="tabla">
        <table width="700" border="0" class="cuerpo" >
        <thead>              
		  <tr>
		    <th colspan="1" >Reservas</th>
          </tr>
          </thead>
          <tbody>
		  <tr>
          <td>
          <form action="deporte_horario.php" method="post">
			<?php 
				//lista las canchas resultantes del query.
				$query="SELECT cancha.ID_Cancha, cancha.N_Nombre NombreCancha 
							FROM cancha, canchaxclub, club 
							WHERE cancha.ID_Cancha=canchaxclub.ID_Cancha AND canchaxclub.ID_Club=club.ID_Club AND club.ID_Club=".$club." 
							AND cancha.ID_Deporte=".$dep." 
							GROUP BY cancha.ID_Cancha"; 
						$result = mysql_query($query,$link);
						$cantCanchasEncontradas=mysql_num_rows($result);
						
						
						printf('<select name="canchas" id="canchas" onchange="this.form.submit();" >');	
						if($cantCanchasEncontradas > 0){
								printf('<option value="0" >Escoge una Cancha</option>');	
								while($row = mysql_fetch_array($result)){
									?>									
									<option value='<?php echo $row["ID_Cancha"];?>'<?php echo (($row["ID_Cancha"]==getPageParameter("canchas",""))?" selected='selected'":"");?>><?php echo $row["NombreCancha"];?></option>
									<?php
								//printf('<option value="'.$row["ID_Cancha"].'">'.$row["NombreCancha"].'</option>');	
								//echo "<br>".$row["ID_Cancha"].$row["NombreCancha"];
								}//while		
							}//if
						else
						printf('<option value="0" selected>No hay Canchas</option>');
						
  					printf('</select>');
				
				
				
				/*
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result))
				{
					$fila=dame_Cancha($row["ID_Cancha"],$link,$dep);
					$techado="No";
					if ($fila[2]==1)
						$techado="Si";
					if ($cancha!=0 && $fila[0]==$cancha)
						$temp='checked="checked"';
					else $temp="";
					
					printf('<span><input type="radio" name="canchas" value="'.$fila[0].'" '.$temp.' />'.$fila[1].' (Tama&ntilde;o: '.$fila[3].', Tipo: '.$fila[4].', Techado: '.$techado.')</span> <br/>');	
				}*/
			?>
				<input type="submit" name="reservar" id="reservar" value="Reservar" />
	        	<input type="hidden" name="action" value="sel_cancha" />          
			</form>
			<?php if($cancha!=""){
				$detalleCancha=dame_Cancha($cancha,$link,$dep);
					if ($detalleCancha[2]==1) $techado="Si";
					else $techado="No";
				printf('<span>'.$detalleCancha[0].' '.$detalleCancha[1].' (Tama&ntilde;o: '.$detalleCancha[3].', Tipo: '.$detalleCancha[4].', Techado: '.$techado.') --> S/. '.$detalleCancha["C_Precio"].'</span>');
			}
			?>
          </td>
          </tr>
          </tbody>
	    </table>
        </div>
	  </div>
	</div>
</div>
        <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
        </script>
        </body>
</html>
