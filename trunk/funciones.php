<?php 
	require ("config.php");
	
	
	//manejo de fechas
		$Dia=date("j",time());
		$NDia=date("l",time());
		$Mes=date("n",time());
		$Anio=date("Y",time());

		$aux="";
		$aux3="";
		Switch ($NDia) {
		case "Monday": 	$aux="Lunes"; 
						$aux3=1;
						break;
		case "Tuesday":	$aux="Martes"; 
						$aux3=2;
						break;
		case "Wednesday":$aux="Mi&eacute;rcoles"; 
						$aux3=3;
						break;
		case "Thursday":$aux="Jueves"; 
						$aux3=4;
						break;
		case "Friday":	$aux="Viernes"; 
						$aux3=5;
						break;
		case "Saturday":$aux="S&aacute;bado"; 
						$aux3=6;
						break;
		case "Sunday":	$aux="Domingo"; 
						$aux3=7;
						break;
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

		/*if (strlen($Dia)==1)
			{$Dia="0".$Dia;}*/

		$NMes=$aux2;
		$NDia=$aux;
		$CDia=$aux3;
	
	$fechaN=$Dia."/".$NMes."/".$Anio;
	$fecha=$Dia."/".$Mes."/".$Anio;
	
	function get_NDia($id)
	{
		$nombre="";
		Switch ($id) {
		case 1: $nombre="Lunes"; 
						break;
		case 2:	$nombre="Martes"; 		
						break;
		case 3:	$nombre="Mi&eacute;rcoles"; 
						break;
		case 4:	$nombre="Jueves"; 
						break;
		case 5:	$nombre="Viernes"; 
						break;
		case 6:	$nombre="S&aacute;bado"; 
						break;
		case 7:	$nombre="Domingo"; 
						break;
		}
		
		return $nombre;
	}
	
	function DaysInMonth($mes,$anio)
    {
		$dias=31;	
    	 if ( $mes==4 || $mes==6 || $mes==9 || $mes==11)
		  	  $dias=30;
         else if ($mes==2)
		 	  {	if ((($anio % 4 == 0) && ($anio % 100 != 0)) || ($anio % 400==0))
                   $dias=29;
                else $dias=28;
			  }               
         
         return $dias;
    }
	
	function aumenta_fecha($fecha_Inicio,$inc)
	{
		$fecha_aux = split('/',$fecha_Inicio);		
        
        if ($fecha_aux[0] + $inc <= DaysInMonth($fecha_aux[1],$fecha_aux[2]))
        {
            $fecha_aux[0]=$fecha_aux[0]+$inc;
        }
        else if ($fecha_aux[0] + $inc > DaysInMonth($fecha_aux[1],$fecha_aux[2]))
        {
            if ($fecha_aux[1] + 1 < 13)
                {                    
                    $aux=$fecha_aux[0]+$inc-DaysInMonth($fecha_aux[1],$fecha_aux[2]);
					$fecha_aux[1]=$fecha_aux[1]+1;
					$fecha_aux[0]=$aux;
                }
            else if ($fecha_aux[1] + 1 >= 13)
                {
					$aux=$fecha_aux[0]+$inc-DaysInMonth($fecha_aux[1],$fecha_aux[2]);
                    $fecha_aux[2]=$fecha_aux[2]+1;
                    $fecha_aux[1]=1;
                    $fecha_aux[0]=$aux;
                }                
        }        
		$fecha=$fecha_aux[0]."/".$fecha_aux[1]."/".$fecha_aux[2];
		return $fecha;
	}
	
	
	//FIN fechas



?>