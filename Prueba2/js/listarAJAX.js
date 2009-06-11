	//cargado de ajax
function getXMLHTTPRequest() {
    try{
        req = new XMLHttpRequest();
    }catch(err1){
        try{
            req = new ActiveXObject("Msxml2.XMLHTTP");
  	}catch(err2){
            try{
                req = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                req = false;
            }
  	}
    }
    return req;
}
var http = getXMLHTTPRequest();
//fin cargado de ajax
function consulta(nombreForm){
		var mensaje=document.getElementById("searchContainerBox_background");
		
		texto="<img src='loading.gif'/><br/><br/><b>Procesando. Por favor espere.</b><br/>";
    mensaje.innerHTML=texto;  
    
    http.open("POST", "listar.php", true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    if (nombreForm=="0"){         
    http.send(""); 
    }//if (nombreForm=="0")
    
    else{ 
    cadena="";
    var d=document;
		var formt=d.forms[nombreForm].length;
		//var deport=document.getElementById("deporte").value;
		var j=0;
		while(j<formt){
		    if(d.forms[nombreForm].elements[j].type=='checkbox' 
		    		&& d.forms[nombreForm].elements[j].checked==true){        
		       nombreCk=d.forms[nombreForm].elements[j].name;
		       valueCk=d.forms[nombreForm].elements[j].value;
		       cadena=cadena+nombreCk+"="+valueCk+"&";
		       
		    }
		    j++;
		}//while
		/*
		if(cadena=="")
			cadena=cadena+"&"+iddeporte+"="+"Avacio";
		else
			cadena=cadena+iddeporte+"="+"Avacio";
    */
    
    precioMin=document.getElementById("lo_p").value;
    precioMax=document.getElementById("hi_p").value;
    
    cadena=cadena+"precioMinimo="+precioMin+"&precioMaximo="+precioMax;
    
    
   /*
   precioMin=d.forms[nombreForm].elements[precioMinimo].value;
    ee=formr-1;
    precioMax=d.forms[nombreForm].elements[ee].value;
    cadena=cadena+"precioMin="+precioMin+"&precioMax="+precioMax;
   */
    http.send(cadena);
    //http.send("dato="+nombreForm+"&dato2=qqqq");
            
 
	}//else mayor
	
	http.onreadystatechange=function(){ 			
        if (http.readyState==4){
            mensaje.innerHTML=http.responseText;
				}//if (http.readyState==4)
    	} 
}


onload=function(){
    consulta('0');
}
