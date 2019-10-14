$(document).ready(function(){

    $.ajaxSetup({ cache: false });
    

})


function sair(){
    $.ajax({			//Função AJAX
              url:"./php/controle/usuarioControle.php",			//Arquivo php
              type:"get",				//Método de envio
              data: "acao=logoff",
                 success: function (result){			//Sucesso no AJAX
                  if (result == 1){
                    window.location.href = "login.html";
                  }
                }
            })
}


    function GetURLParameter(sParam){
        var sPageURL = window.location.search.substring(1);
	    var sURLVariables = sPageURL.split('&');
	    for (var i = 0; i < sURLVariables.length; i++)
	    {
	        var sParameterName = sURLVariables[i].split('=');
	        if (sParameterName[0] == sParam)
	        {
	            return sParameterName[1];
	        } else {
                return "Parametro não encontrado";
            }
        }
	}
