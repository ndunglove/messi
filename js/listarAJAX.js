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
    
    var deport=document.getElementById("deporte").value;
    
    if (nombreForm=="0"){     
    	cadena="";    
    	cadena="iddeporte="+deport;
    http.send(cadena); 
    }//if (nombreForm=="0")
    
    else{ 
    cadena="";
    var d=document;
		var formt=d.forms[nombreForm].length;
		
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
			
		else
			cadena=cadena+iddeporte+"="+"Avacio";
    */
    
    precioMin=document.getElementById("lo_p").value;
    precioMax=document.getElementById("hi_p").value;
    
    cadena=cadena+"precioMinimo="+precioMin+"&precioMaximo="+precioMax;
    cadena=cadena+"&iddeporte="+deport;
      
    http.send(cadena);   
 
	}//else mayor
	
	http.onreadystatechange=function(){ 			
        if (http.readyState==4){
            mensaje.innerHTML=http.responseText;
				}//if (http.readyState==4)
    	} 
}

/*
onload=function(){
    consulta('0');
}
*/