<?php
require_once( "recursos.php" );
fnSessionStart();

$voucher=getPageParameter("voucher","");

$cn = fnConnect($msg);
if($voucher!="")
if(!$cn) {
	fnShowMsg("Error",$msg);
	echo "errrorr";
	return;
} else {	
				$sql="select * from pago where C_Voucher='".$voucher."'";
				//echo $sql;
				$resultado=mysql_query($sql,$cn) or die ("error al validar voucher");
				if (mysql_num_rows($resultado)>0)
				{
				echo "ya existe";
				} else {
				echo "No Existe";
				
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