<?php 
/*
	echo "<br>".disminuye_fecha("6/5/2009",7);
	echo "<br>".disminuye_fecha("1/4/2009",7);
	echo "<br>".disminuye_fecha("4/3/2009",7);
	echo "<br>".disminuye_fecha("4/2/2009",7);
	echo "<br>".disminuye_fecha("7/1/2009",7);
	echo "<br>".disminuye_fecha("3/12/2008",7);	
	*/
	/*
	for($i=1;$i<=40;$i++){
	//echo "<br>".aumenta_fecha("11/6/2009",7*$i);		
	//echo "<br>".disminuye_fecha("11/6/2009",7*$i);		
		}
	*/
	

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
	{		$fecha_aux = split('/',$fecha_Inicio);	
			$dia=$fecha_aux[0];
			$mes=$fecha_aux[1];
			$anio=$fecha_aux[2];
		
        
        if ($dia + $inc <= DaysInMonth($mes,$anio))
        {
            $dia=$dia+$inc;
        }
        else if ($dia + $inc > DaysInMonth($mes,$anio))
        { $nuevoInc=$dia+$inc-DaysInMonth($mes,$anio);
        	
        	$contMes=0;
        	$contAnio=0;
        	$mesSgte=$mes+1;
        	
        	for($i=1;$i<=$nuevoInc;$i++){
			        		if($mesSgte==13){
			        				$mesSgte=1;
			        				$anio++;
			        				}
        		if($i==DaysInMonth($mesSgte,$anio)){
        			$contMes++;
        			$nuevoInc=$nuevoInc-$i;
        			$mesSgte++;        			
        				$i=1;
        			}//if        		
        		}//for
        		
        		
        		if($nuevoInc==0 && $mesSgte==1) {
        		$mesSgte=12;
        		$anio=$anio-1;
        		$nuevoInc=DaysInMonth($mesSgte,$anio);        		
        		}	        		
        		if($nuevoInc==0) {
        			$mesSgte=$mesSgte-1;
        			$nuevoInc=DaysInMonth($mesSgte,$anio);}
        		
        		$dia=$nuevoInc;        		
        		$mes=$mesSgte;        		
       }//if
       
       $fech=$dia."/".$mes."/".$anio;
		return $fech;
        	
        	
	}//aumenta fecha
	
	/*
	$c=352;
	$f="11/6/2009";
	echo "<br>".aumenta_fecha($f,50);	
	for($i=1;$i<=$c;$i++){
		echo "<br>".aumenta_fecha($f,$i*7);
		}
		*/
	
		
	
	function aumenta_fecha22222222($fecha_Inicio,$inc)
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
	}//aumenta fecha
	
	/*
	
	for($i=1;$i<=710;$i++){
	echo "<br>".disminuye_fecha("3/2/2009",$i);
}*/
	
	
	function disminuye_fecha($fecha_Inicio,$inc)
	{		$fecha_aux = split('/',$fecha_Inicio);	
			$dia=$fecha_aux[0];
			$mes=$fecha_aux[1];
			$anio=$fecha_aux[2];
		
        
        if ($dia - $inc > 0)
        {
            $dia=$dia-$inc;
        }
        else if ($dia - $inc <= 0)
        {         	
        	$mesAnt=$mes-1;
        	$nuevoInc=$inc-$dia;
        	       	
        	for($i=1;$i<=$nuevoInc;$i++){
			        		if($mesAnt==0){
			        				$mesAnt=12;
			        				$anio=$anio-1;
			        				}
        		if($i==DaysInMonth($mesAnt,$anio)){
        			$nuevoInc=$nuevoInc-$i;
        			$mesAnt=$mesAnt-1;        			
        				$i=-1;
        			}//if        		
        		}//for
        		        		
        		/*
        		if($nuevoInc==0 && $mesAnt==0) {
        		$mesAnt=12;
        		$anio=$anio-1;
        		//$nuevoInc=DaysInMonth($mesAnt,$anio);        		
        		}	  
        		else if($nuevoInc==0) {
        			$mesAnt=$mesAnt+1;
        			//$nuevoInc=DaysInMonth($mesAnt,$anio);
        			}
        			*/
        		        		    		
        		$mes=$mesAnt;        		        		
        		$dia=DaysInMonth($mes,$anio)-$nuevoInc;    
       }//if
       
       $fech=$dia."/".$mes."/".$anio;
		return $fech;
        	
        	
	}//disminuye fecha
	
	function disminuye_fecha222222222222222($fecha_Inicio,$inc)
	{
		$fecha_aux = split('/',$fecha_Inicio);	
		$mesAnterior=$fecha_aux[1]-1;
		$anioAnterior=$fecha_aux[2]-1;
        
        //if ($fecha_aux[0] + $inc <= DaysInMonth($fecha_aux[1],$fecha_aux[2]))
        if ($fecha_aux[0] - $inc > 0)
        {       	
            $fecha_aux[0]=$fecha_aux[0]-$inc;
        }
       // else if ($fecha_aux[0] + $inc > DaysInMonth($fecha_aux[1],$fecha_aux[2]))
        else if ($fecha_aux[0] - $inc <= 0)
        {
        	//DaysInMonth($mesAnterior,$fecha_aux[2])
            //if ($fecha_aux[1] + 1 < 13)
            if ($fecha_aux[1] - 1 > 0)
            {                    
          $aux=$fecha_aux[0]-$inc+DaysInMonth($mesAnterior,$fecha_aux[2]);
					$fecha_aux[1]=$fecha_aux[1]-1;
					$fecha_aux[0]=$aux;
                }
            //else if ($fecha_aux[1] + 1 >= 13)
             else if ($fecha_aux[1] - 1 <= 0)
                {
					$aux=$fecha_aux[0]-$inc+DaysInMonth(12,$anioAnterior);
                    $fecha_aux[2]=$anioAnterior;
                    $fecha_aux[1]=12;
                    $fecha_aux[0]=$aux;
                }                
        }        
		$fecha=$fecha_aux[0]."/".$fecha_aux[1]."/".$fecha_aux[2];
		return $fecha;
	}//reduce fecha
		
	
	//FIN fechas
	
	
	
	



/* function getPageParameter($nombre, $defaultvalue, $debug=false):
 * Función que busca y devuelve un parametro '$nombre' de Pagina 
 * en el caso que no la encuentre le asigna un valor por defecto '$defaultvalue'.
 * $debug=true nos sirve para saber si el parametro es mediante post o get
*/

function getPageParameter($nombre, $defaultvalue, $debug=false) {   
   $pageparameter = isset($_GET[$nombre])?$_GET[$nombre]:$defaultvalue;
   if ($debug) echo "P0 ".$nombre.": ".$pageparameter."<br/>\n";
   $pageparameter = ($pageparameter==$defaultvalue && isset($_POST[$nombre]))?$_POST[$nombre]:$pageparameter;
   if ($debug) echo "P1 ".$nombre.": ".$pageparameter."<br/>\n";
   $pageparameter = ($pageparameter=="")?$defaultvalue:$pageparameter;
   if ($debug) echo "P2 ".$nombre.": ".$pageparameter."<br/>\n";
   if ($debug) echo "***<br/>\n";
   if (is_array($pageparameter)) {
      return $pageparameter;
   } else {
      return trim($pageparameter);
   }
}



function fecha1MenorFecha2($fecha1,$fecha2)
	{$bandera=false;
		$fecha1_aux = split('/',$fecha1);	
		$fecha2_aux = split('/',$fecha2);	
		
		$dia1=$fecha1_aux[0];
		$mes1=$fecha1_aux[1];
		$anio1=$fecha1_aux[2];
		
		$dia2=$fecha2_aux[0];
		$mes2=$fecha2_aux[1];
		$anio2=$fecha2_aux[2];
		
		if($anio1 < $anio2)
			$bandera=true;
		else if($anio1 > $anio2)
						$bandera=false;
				 else if($anio1 == $anio2){
				 				if($mes1 < $mes2)
									$bandera=true;
								else if($mes1 > $mes2)
												$bandera=false;
										 else if($mes1 == $mes2){
										 				if($dia1 < $dia2)
										 				$bandera=true;		
										 				else $bandera=false;
										 	}
				 			}
		return $bandera;						
	}

?>
