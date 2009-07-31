<?php 
    session_start();
    require ('funciones.php'); 
    require ('Conexion.php');
    require ('php-captcha.inc.php');

    $link = mysql_connect($MySQL_Host,$MySQL_Usuario,$MySQL_Pass);
    mysql_select_db($MySQL_BaseDatos, $link);
    
    if (!isset($_SESSION['op'])) 
    {
        $_SESSION['op']=1; 
    }
	
	if (!isset($_SESSION['op2'])) 
    {
        $_SESSION['op2']=1; 
    }
     
    $usuario="";
    $clave="";
    
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
        else $_SESSION['op']=2;
           
    }
	
	if ($_POST['action'] == "registrar")
		{
			$email=$_POST["email"];
			$nombre=$_POST["nombre"];
			$apellido=$_POST["apellido"];
			$pass=$_POST["pass2"];
			$pass2=$_POST["pass3"];
			$distrito=$_POST["distrito"];
			$fechas=$_POST["dia"]."-".$_POST["mes"]."-".$_POST["anio"];

			if (PhpCaptcha::Validate($_POST['cod_captcha'],false)==false)
			{
			if ($pass==$pass2)
				{
					$result = mysql_query("SELECT ID_Usuario FROM usuario WHERE T_Email='".$email."'");
			        $row = mysql_fetch_row($result);
					
					if ($row==false)
					{
						$result = mysql_query("INSERT INTO usuario(N_Nombre, N_Apellido, T_Email, T_Pass, D_FechaNacimiento, ID_Distrito,F_Estado) VALUES ('".$nombre."','".$apellido."','".$email."','".$pass."','".cambiaf_a_mysql($fechas)."',".$distrito.",1) " );						
						if ($result!=false)
							$_SESSION['op2']=4; 
					}
					else $_SESSION['op2']=3; 
				}
			else  $_SESSION['op2']=2;			
			}
			else $_SESSION['op2']=5;			
		}
		
    $ver=$_SESSION['op'];
	$chekreg=$_SESSION['op2'];
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
<title>CanchasOnline.com | Bienvenido</title>
<script src="SpryAssets/SpryValidationTextField.js"       type="text/javascript"      xml:space="preserve"></script>
<script src="SpryAssets/SpryValidationSelect.js"      type="text/javascript"      xml:space="preserve"></script>
<script src="SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css"          rel="stylesheet"          type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css"           rel="stylesheet"          type="text/css" />
<link href="SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />

</head>
<body >

<div id="todo">
<div id="nubes">

<div id="todoIndex">
<div id="bienve">
<img src="images/bienvenidos.gif" border="0" usemap="#Map" /> <map name="Map" id="Map">
<area shape="rect" coords="244,62,305,82" href="#" target="_blank" />
</map> </div>

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
              <span style="color:red; font-size=11px;">
            <?php                                                                
                                                                    $msg="";
                                                                    
                                                                    if ($ver==2)
                                                                    {
                                                                        $msg="usuario incorrecto o no existe.";
                                                                    }
                                                                    else if ($ver==3)
                                                                    {
                                                                        $msg="clave incorrecta.";
                                                                    }
                                                                    
                                                                    $salida=$msg;
                                                                    
                                                                    print($salida);
                                                                ?>
            </span>
                  <input type="Submit"
                                         class="boton"
                                         name="BtnIngresar"
                                         id="BtnIngresar"
                                         value="Ingresar" />
                  <input name=
                                         "action"
                                         type="hidden"
                                         value="login" />
                  <br />
                </div></td>
            </tr>
            <tr>
              <td>&#160;</td>
              <td>&#160;</td>
              <td><div align="right"><a href="recuperar_pass.php" target="_self" style="font-size:11px;">¿Olvid&oacute; su contraseña?</a>
                  <br />
                </div></td>
            </tr>
           
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
    <form action="index.php" method="post">
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
            <td>Nombres</td>
            <td>:</td>
            <td><span id="sprytextfield4"> <input type="text"
                               name="nombre"
                               id="nombre"
                               class="edit" value="<?php if ($chekreg==2 || $chekreg==3 || $chekreg==5) echo $nombre; ?>"/>
              <span class=
                               "textfieldRequiredMsg">Valor
                requerido.</span></span></td>
          </tr>
          <tr>
            <td>Apellidos</td>
            <td>:</td>
            <td> 
              <span id="sprytextfield8"><input type="text"
                               name="apellido"
                               id="apellido"
                               class="edit" value="<?php if ($chekreg==2 || $chekreg==3 || $chekreg==5) echo $apellido; ?>"/>
              <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
          </tr>
          <tr>
            <td width="142">E-Mail</td>
            <td width="3">:</td>
            <td width="350"><span id="sprytextfield3"> <input type=
                        "text"
                               name="email"
                               id="email"
                               class="edit" value="<?php if ($chekreg==2 || $chekreg==3 || $chekreg==5) echo $email; ?>"/>
              <span class=
                               "textfieldRequiredMsg">Valor
                requerido.</span></span></td>
          </tr>
          <tr>
            <td>Password</td>
            <td>:</td>
            <td><span id="sprytextfield5"> <input type="password"
                               name="pass2"
                               id="pass2"
                               class="edit" value="<?php if ($chekreg==2 || $chekreg==3 || $chekreg==5) echo $pass; ?>"/>
              <span class=
                               "textfieldRequiredMsg">Valor
                requerido.</span></span></td>
          </tr>
          <tr>
            <td>Confirmar Password</td>
            <td>:</td>
            <td><span id="sprytextfield6"> <input type="password" name="pass3" id="pass3"
                               class="edit" value="<?php if ($chekreg==2 || $chekreg==3 || $chekreg==5) echo $pass2; ?>"/>
              <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
          </tr>
          <tr>
            <td>Fecha de Nacimiento</td>
            <td>:</td>
            <td><span id="spryselect1">
              <select name="dia" >
                <option> D&#237;a: </option>
                <?php 
                                                                        for ($i=1;$i<=31; $i++){
                                                                            printf("<option value='".$i."'>".$i."</option>");                   
                                                                            }
                                                                      ?>
              </select>
              </span> <span id="spryselect2">
                <select name="mes" >
                  <option> Mes: </option>
                  <?php 
                                                                        for ($i=1;$i<=12; $i++){
                                                                            printf("<option value='".$i."'>".$i."</option>");               
                                                                            }
                                                                      ?>
                </select>
                </span> <span id="spryselect3">
                  <select name="anio" >
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
              <select name="distrito">
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
          <td><img src="captcha.php" width="140" height="50" alt="Visual CAPTCHA" /></td>
          <td>:</td>
          <td><span id="sprytextfield7"><input type="text" name="cod_captcha" id="cod_captcha" class="edit"/>
              <span class="textfieldRequiredMsg">Valor requerido.</span></span></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td><span id="sprycheckbox1" style="font-weight:normal; color:#2B2700"> <input type="checkbox" name="checkbox1" id="checkbox1" />
              Acepto los <a href="#" title="Garantizamos que tu información privada no será compartida." >términos y condiciones de uso.</a> <br/>
              <span class="checkboxRequiredMsg">Por favor, acepte los términos y condiciones.</span></span></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td><input name="registrar"
                               type="submit"
                               value="registrar"
                               class="boton"
                               onclick="return isEmailAddress(email,'email')" />
              <input type="reset"
                               class="boton"
                               name="BtnCancelar2"
                               id="BtnCancelar2"
                               value="Cancelar" />
              <input name="action"
                               type="hidden"
                               value="registrar" /></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td  align="left"><span style="color:red; font-size=11px;">
              <?php 
                                                                
                                                                    $msg="";
                                                                    
                                                                    if ($chekreg==2)
                                                                    {
                                                                        $msg="Por favor, asegurese de que sus claves coincidan";
                                                                    }
                                                                    elseif ($chekreg==3)
                                                                    {
                                                                        $msg="El email ingresado ya existe. Por favor ingrese otro.";
                                                                    }
																	elseif ($chekreg==4)
                                                                    {
                                                                        $msg="Se ha registrado satisfactoriamente";
                                                                    }
																	elseif ($chekreg==5)
                                                                    {
                                                                        $msg="Por favor, reingrese el código de validación.";
                                                                    }
                                                                    print($msg);
                                                                ?>
            </span></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
  <div class="clearing">&nbsp;</div>
</div>

</div>

<div id="footer">
</div>

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
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
</script>
<?php } ?>

 
</body>
</html>