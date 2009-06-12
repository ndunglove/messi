<?php 
    session_start();
    require ('funciones.php'); 
    require ('Conexion.php');
    
    $link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
    
    if (!isset($_SESSION['op'])) 
    {
        $_SESSION['op'] = "1"; 
    }
	
	if (!isset($_SESSION['op2'])) 
    {
        $_SESSION['op2'] = "1"; 
    }
    
    $ver=$_SESSION['op'];
    
    $usuario="";
    $clave="";
	
	$chekreg=$_SESSION['op2'];
    
    if (!isset($_POST['action'])) 
    {
        $_POST['action'] = "undefine"; 
    } 

    if ($_POST['action'] == "login") {
    
        $usuario=$_POST['user'];
        $clave=$_POST['pass'];
        
        $result = mysql_query("SELECT ID_Usuario, T_Pass FROM usuario WHERE T_Email='".$usuario."'");
        $row = mysql_fetch_row($result);
        
        if ($row!=false)
        {
            if ($row[1]==$clave)
                {
                    $_SESSION['ID']=$row[0];
                    $_SESSION['op']=0;  
                }
            else $_SESSION['op']=3; 
        }
        else {
                $_SESSION['op']=2;
             }
    }
	
	if ($_POST['action'] == "registrar")
		{
			$email=$_POST["email"];
			$nombre=$_POST["nombre"];
			$pass=$_POST["pass"];
			$pass2=$_POST["pass2"];
			//$distrito=$_POST["email"];
			//$fecha=$_POST["email"];
			if ($pass==$pass2)
				{
					$result = mysql_query("SELECT ID_Usuario FROM usuario WHERE T_Email='".$email."'");
			        $row = mysql_fetch_row($result);
					
					if ($row==false)
					{
						$result = mysql_query("INSERT INTO usuario(N_Nombre, T_Email, T_Pass) VALUES ('".$nombre."','".$email."','".$pass."') " );						
						if ($result!=false)
							$_SESSION['op2']=4; 
					}
					else $_SESSION['op2']=3; 
				}
			else  $_SESSION['op2']=2;			
			
		}
		
    
?>
<?php
    if (isset($_SESSION['ID'])) {
        if ($_POST['action'] != "login"){
		echo '<center><p>Usted esta autenticado,</p></center><center><p>cierre sesion para iniciar con otra cuenta</p></center>';
        echo '<center><a href="index.php">Regresar</a></center>';
		}
        ?>

<script language="javascript"
      type="text/javascript"
      xml:space="preserve">
//<![CDATA[
                function redireccionar()
                {
                        location.href="deporte.php";
                }
                        setTimeout ("redireccionar()", 0);
//]]>
</script>

<?php
                }
                else{
            
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="estilos/Estilo.css"      rel="stylesheet"        type="text/css" />
<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie6.css" />
<![endif]-->
<!--[if gte IE 7]>
	<link rel="stylesheet" type="text/css" href="Estilos/searchattrib_v2_ie7.css" />
<![endif]-->
<title>DBusiness | Bienvenido</title>
<script src="SpryAssets/SpryValidationTextField.js"       type="text/javascript"      xml:space="preserve"></script>
<script src="SpryAssets/SpryValidationSelect.js"      type="text/javascript"      xml:space="preserve"></script>
<link href="SpryAssets/SpryValidationTextField.css"          rel="stylesheet"          type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css"           rel="stylesheet"          type="text/css" />
</head>
<body>
<div id="todo">
<div id="nubes">
<div id="todoIndex">
<div class="logo">
</div>

  <div class="login">
    <form id="Formulario"
              name="Formulario"
              method="post"
              action="index.php">
      <div align="center">
        <table width="294"
                       border="0"
                       >
          <thead>
            <tr>
              <th colspan="3">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
            </tr>
            <tr>
              <td width="54"
                                class="texto">E-Mail</td>
              <td width="10">:</td>
              <td width="230"
                                align="right"><span id=
                                "sprytextfield1">
                <input name="user"
                                   type="text"
                                   class="edit"
                                   id="user"
                                   value=
                                   "<?php printf($usuario); ?>" />
                </span></td>
            </tr>
            <tr>
              <td>Clave</td>
              <td>:</td>
              <td align="right"><span id=
                            "sprytextfield2">
                <input type="password"
                                   name="pass"
                                   id="pass"
                                   class="edit"
                                   value=
                                   "<?php printf($clave); ?>" />
                </span></td>
            </tr>
            <tr>
              <td>&#160;</td>
              <td>&#160;</td>
              <td><div align="right">
                  <input type="Submit"
                                         class="boton"
                                         name="BtnIngresar"
                                         id="BtnIngresar"
                                         value="Ingresar" />
                  <input type=
                                         "reset"
                                         class="boton"
                                         name="BtnCancelar"
                                         id="BtnCancelar"
                                         value="Cancelar" />
                  <input name=
                                         "action"
                                         type="hidden"
                                         value="login" />
                  <br />
                </div></td>
            </tr>
            <?php 
                                                                
                                                                    $msg="";
                                                                    
                                                                    if ($ver=="2")
                                                                    {
                                                                        $msg="usuario incorrecto\n o no existe.";
                                                                    }
                                                                    else if ($ver=="3")
                                                                    {
                                                                        $msg="clave incorrecta.";
                                                                    }
                                                                    
                                                                    $salida='<tr><td colspan="3" align="right"><span style="color:red; font-size=11px;">'.$msg.'</span></td></tr>';
                                                                    
                                                                    printf($salida);
                                                                ?>
          </tbody>
        </table>
      </div>
    </form>
  </div>
  <div class="registrar">
    <script language="JavaScript"
     type="text/javascript"
     xml:space="preserve">
//<![CDATA[
 
function isEmailAddress(theElement, nombre_del_elemento )
{
var s = theElement.value;
var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
if (s.length == 0 ) return true;
if (filter.test(s))
return true;
else
alert("Ingrese una direcciC3n de correo vC!lida");
theElement.focus();
return false;
}
//]]>
</script>
    <form action="index.php"
              method="post">
      <table width="509"
                   border="0"
                   >
        <thead>
          <tr>
            <th colspan="3">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          
          <tr>
            <td>Nombre</td>
            <td>:</td>
            <td><span id="sprytextfield4">
              <input type="text"
                               name="nombre"
                               id="nombre"
                               class="edit" />
              <span class=
                               "textfieldRequiredMsg">Valor
              requerido.</span></span></td>
          </tr>
          <tr>
            <td width="142">E-Mail</td>
            <td width="3">:</td>
            <td width="350"><span id="sprytextfield3">
              <input type=
                        "text"
                               name="email"
                               id="email"
                               class="edit" />
              <span class=
                               "textfieldRequiredMsg">Valor
              requerido.</span></span></td>
          </tr>
          <tr>
            <td>Password</td>
            <td>:</td>
            <td><span id="sprytextfield5">
              <input type="password"
                               name="pass"
                               id="pass"
                               class="edit" />
              <span class=
                               "textfieldRequiredMsg">Valor
              requerido.</span></span></td>
          </tr>
          <tr>
            <td>Confirmar Password</td>
            <td>:</td>
            <td><span id="sprytextfield5">
              <input type="password"
                               name="pass2"
                               id="pass2"
                               class="edit" />
              <span class=
                               "textfieldRequiredMsg">Valor
              requerido.</span></span></td>
          </tr>
          <tr>
            <td>Fecha de Nacimiento</td>
            <td>:</td>
            <td><span id="spryselect1">
              <select name="dia"
                                id="dia">
                <option> D&#237;a: </option>
                <?php 
                                                                        for ($i=1;$i<=31; $i++){
                                                                            printf("<option value='".$i."'>".$i."</option>");                   
                                                                            }
                                                                      ?>
              </select>
              </span> <span id="spryselect2">
              <select name=
                        "mes"
                                id="mes">
                <option> Mes: </option>
                <?php 
                                                                        for ($i=1;$i<=31; $i++){
                                                                            printf("<option value='".$i."'>".$i."</option>");               
                                                                            }
                                                                      ?>
              </select>
              </span> <span id="spryselect3">
              <select name=
                        "anio"
                                id="anio">
                <option> A&#241;o: </option>
                <?php 
                                                                        for ($i=2009;$i>=2009-100; $i--){
                                                                            printf("<option value='".$i."'>".$i."</option>");                   
                                                                            }
                                                                      ?>
              </select>
              </span></td>
          </tr>
          <tr>
            <td>Distrito</td>
            <td>:</td>
            <td><span id="spryselect4">
              <select name="distrito"
                                id="distrito">
                <option> Distrito: </option>
                <?php 
                                                                    
                                                                        $result = mysql_query("SELECT * FROM distrito ");
                                                                        while ($row = mysql_fetch_array($result)){
                                                                        
                                                                        $salida = ' <option value="'.$row["ID_Distrito"].'">'.$row["N_Nombre"].'</option> ';                                
                                                                        printf ($salida);}
                                                                    
                                                                    ?>
              </select>
              <span class="selectRequiredMsg">Seleccione un
              distrito.</span></span></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td><input name="registrar"
                               type="submit"
                               value="registrar"
                               class="boton"
                               onclick=
                               "return isEmailAddress(email,'email')" />
              <input type="reset"
                               class="boton"
                               name="BtnCancelar2"
                               id="BtnCancelar2"
                               value="Cancelar" />
              <input name="action"
                               type="hidden"
                               value="regitrar" /></td>
          </tr>
          <?php 
                                                                
                                                                    $msg="";
                                                                    
                                                                    if ($chekreg==2)
                                                                    {
                                                                        $msg="Por favor, asegurese de que sus claves coincidan";
                                                                    }
                                                                    else if ($chekreg==3)
                                                                    {
                                                                        $msg="Existe un usuario con el mismo email,<br/> por favor, intente con un email distinto";
                                                                    }
																	else if ($chekreg==4)
                                                                    {
                                                                        $msg="Se ha registrado satisfactoriamente";
                                                                    }
                                                                    
                                                                    $salida='<tr><td colspan="3" align="right"><span style="color:red; font-size=11px;">'.$msg.'</span></td></tr>';
                                                                    
                                                                    printf($salida);
                                                                ?>
        </tbody>
      </table>
    </form>
  </div>

  <div class="clearing">&nbsp;</div>
</div>

 
 <div id="footer">
 	
 </div>
</div> <!-- fin nubes -->
</div>
<script type="text/javascript"
      xml:space="preserve">
//<![CDATA[
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
//-->
//]]>
</script>
<?php } ?>
</body>
</html>