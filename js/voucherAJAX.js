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


function validaVoucher(nroVoucher){
		var mensajeVoucher=document.getElementById("mensajeVoucher");
		
		texto="<img src='loading.gif'/><br/><br/><b>Procesando  . Por favor espere.</b><br/>";
    mensajeVoucher.innerHTML=texto;  
    
    http.open("POST", "ValidarVoucher.php", true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    voucher=nroVoucher
//    http.send(voucher);
		http.send("voucher="+nroVoucher);
	
	http.onreadystatechange=function(){ 			
        if (http.readyState==4){
            mensajeVoucher.innerHTML=http.responseText;
				}//if (http.readyState==4)
    	} 
}



/*
onload=function(){
    validaVoucher("55");
}
*/