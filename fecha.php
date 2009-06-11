<?php
		$Dia=date("j",time());
		$NDia=date("l",time());
		$Mes=date("n",time());
		$Anio=date("Y",time());

		$aux="";
		Switch ($NDia) {
		case "Monday": $aux="Lunes"; break;
		case "Tuesday":$aux="Martes"; break;
		case "Wednesday":$aux="Mi&eacute;rcoles"; break;
		case "Thursday":$aux="Jueves"; break;
		case "Friday":$aux="Viernes"; break;
		case "Saturday":$aux="S&aacute;bado"; break;
		case "Sunday":$aux="Domingo"; break;
		}

		$aux2="";
		Switch ($Mes) {
		case 1: $aux2="Enero"; break;
		case 2:$aux2="Febrero"; break;
		case 3:$aux2="Marzo"; break;
		case 4:$aux2="Abril"; break;
		case 5:$aux2="Mayo"; break;
		case 6:$aux2="Junio"; break;
		case 7:$aux2="Julio"; break;
		case 8:$aux2="Agosto"; break;
		case 9:$aux2="Septiembre"; break;
		case 10:$aux2="Octubre"; break;
		case 11:$aux2="Noviembre"; break;
		case 12:$aux2="Diciembre"; break;
		}

		If (strlen($Dia)==1)
			{$Dia="0".$Dia;}

		$Mes=$aux2;
		$NDia=$aux;

		echo $NDia.", ".$Dia." de ".$Mes." del ".$Anio;
?>