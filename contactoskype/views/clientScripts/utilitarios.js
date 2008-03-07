usuariosSkype = new Array();
var j = 0;
Event.observe(window, 'load', cargar); 


function cargar ()
{

	
		for (i = 0; i<usuariosSkype.size(); i++)
		{
			$("divChat"+usuariosSkype[i]).innerHTML = dibujoChat(usuariosSkype[i]);
			
		}
	setTimeout(cargar,1000);
}

function dibujoLlamar (usuarioSkype)
{
txt = '<a href="skype:'+usuarioSkype+'?call"  onclick="return skypeCheck();"><img src="http://mystatus.skype.com/bigclassic/'+usuarioSkype+'" style="border: none;" width="182" height="44" alt="Estado online" /></a>';
return txt;
}

function dibujoChat (usuarioSkype)
{
txt = '<a href="skype:'+usuarioSkype+'?chat" onclick="return skypeCheck();"><img src="http://download.skype.com/share/skypebuttons/buttons/chat_green_white_164x52.png" style="border: none;" width="164" height="52" alt="Conversacion de chat" /></a>';
return txt;
}
function insertoScript()
{
txt = '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
return txt;
}

function insertoSrcImg(usuarioSkype)
{
txt= 'http://mystatus.skype.com/bigclassic/'+usuarioSkype;
return txt;
}

