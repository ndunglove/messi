<?php
session_start();
session_destroy();
echo '<p class="alerta2">Ha terminado la session.<br><a href="index.php" class="tdlink">index</a></p>';
?>
<SCRIPT LANGUAGE="javascript">
function redireccionar()
{
location.href="index.php";
}
setTimeout ("redireccionar()", 2000);
</SCRIPT>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<link href="Estilos.css" rel="stylesheet" type="text/css" >