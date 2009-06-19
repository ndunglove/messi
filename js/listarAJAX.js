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
		var mensaje=document.getElementById("mensaje");
		
		texto="<img src='loading.gif'/><br/><br/><b>Procesando. Por favor espere.</b><br/>";
    mensaje.innerHTML=texto;  
    
    http.open("POST", "listar.php", true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    if (nombreForm=="1"){         
    http.send(""); 
    }//if (nombreForm=="1")
    
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
		       //cadena=cadena+nombreCk+j+"="+nombreCk+"&";
		    }
		    j++;
		}//while
    
    precioMin=document.getElementById("precioMinimo").value;
    precioMax=document.getElementById("precioMaximo").value;
    
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

function validaVoucher(nroVoucher){
		var mensaje=document.getElementById("mensajeVoucher");
		
		texto="<img src='loading.gif'/><br/><br/><b>Procesando. Por favor espere.</b><br/>";
    mensaje.innerHTML=texto;  
    
    http.open("POST", "validarVoucher.php", true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    voucher=nroVoucher
    http.send(voucher);
	
	http.onreadystatechange=function(){ 			
        if (http.readyState==4){
            mensaje.innerHTML=http.responseText;
				}//if (http.readyState==4)
    	} 
}




onload=function(){
    consulta('1');
}
