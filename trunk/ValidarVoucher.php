<?php
session_start();

require_once("funciones.php");
$voucher=getPageParameter("voucher","");

$cn = fnConnect($msg);
if($voucher!="")
if(!$cn) {
	fnShowMsg("Error",$msg);
	echo "error";
	return;
} else {	
				$sql="select * from pago where C_Voucher='".$voucher."'";
				//echo $sql;
				$resultado=mysql_query($sql,$cn) or die ("error al validar voucher");
				if (mysql_num_rows($resultado)>0)
				{
				echo "<span style='color:red;'>Nro. de voucher Inv&aacute;lido.</span>";
				} else {
				echo "<span style='color:green;'> Nro. de voucher V&aacute;lido</span>";
				
				}
	
}//else
/*
if(!$cn) {
	fnShowMsg("Error",$msg);
	return;
} else {	
	$rs = mysql_query("select * from tamcancha",$cn) or die("MALLL");
	while($row = mysql_fetch_array($rs,MYSQL_ASSOC)) { ?>
		<li><a ><input type="checkbox" name="tamano<?php echo ++$ii ;?>" value="<?php echo $row["ID_TamanoCancha"]?>" onclick="consulta(this.form.name);"/> <?php echo $row["N_Nombre"]?></a></li>
		<?php }//while	
}//else

*/

?>