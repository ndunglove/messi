<?php
require_once( "recursos.php" );
fnSessionStart();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="es-ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>


<script type='text/javascript' src='js/voucherAJAX.js'></script>
</head>

<body>
	<div align='center'>
	<form action="">
	Nro. Voucher: <input name='voucher' type='text' onkeyup="validaVoucher(this.value);"/>
	<div id="mensajeVoucher" name='aa' align='center'></div>
	</form>
</div>
</body>
</html>
