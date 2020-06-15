function fValidarAcceso (){
	if(document.frmAcceso.txtEmail.value==""){alert(fM("IntroduzcaEmail"));return;}
	else{if(!fValidarCorreo(document.frmAcceso.txtEmail.value)){return;}}
	if(document.frmAcceso.txtPass.value==""){alert(fM("IntroduzcaClave"));return;}
	document.frmAcceso.submit();
}
//****************************************
function fValidarOlvido (){
	if(document.frmOlvido.txtNombre.value==""){alert(fM("IntroduzcaNombre"));return;}
	if(document.frmOlvido.txtEmail.value==""){alert(fM("IntroduzcaEmail"));return;}
	else{if(!fValidarCorreo(document.frmOlvido.txtEmail.value)){return;}}
	document.frmOlvido.submit();
}
//****************************************
function fValidarAlta (){
	if(document.frmAlta.txtNombre.value==""){alert(fM("IntroduzcaNombre"));return;}
	if(document.frmAlta.txtApellidos.value==""){alert(fM("IntroduzcaApellidos"));return;}
	if(document.frmAlta.txtEmail.value==""){alert(fM("IntroduzcaEmailPersonal"));return;}
	else{if(!fValidarCorreo(document.frmAlta.txtEmail.value)){return;}}
	if(document.frmAlta.txtTelefono.value==""){alert(fM("IntroduzcaTelefono"));return;}
	if(document.frmAlta.txtMedio.value==""){alert(fM("IntroduzcaMedio"));return;}
	if(document.frmAlta.txtLocalizacion.value==""){alert(fM("IntroduzcaDatosLocalizacion"));return;}
	if(document.frmAlta.txtContacto.value==""){alert(fM("IntroduzcaTlfnContacto"));return;}
	if(document.frmAlta.txtEmail2.value==""){alert(fM("IntroduzcaEmail"));return;}
	else{if(!fValidarCorreo(document.frmAlta.txtEmail2.value)){return;}}
	if(document.frmAlta.txtPublicacion.value==""){alert(fM("IntroduzcaPublicacion"));return;}
	if(document.frmAlta.txtCongreso.value==""){alert(fM("IntroduzcaCongreso"));return;}
	document.frmAlta.submit();
}
//****************************************
function fValidarDatosEntrevista (){
	if(document.frmEntrevista.txtNombre.value==""){alert(fM("IntroduzcaNombre"));return;}
	if(document.frmEntrevista.txtApellidos.value==""){alert(fM("IntroduzcaApellidos"));return;}
	if(document.frmEntrevista.txtTelefono.value==""){alert(fM("IntroduzcaTlfnContacto"));return;}
	if(document.frmEntrevista.txtEmail.value==""){alert(fM("IntroduzcaEmail"));return;}
	if(document.frmEntrevista.rdbComo[1].checked){
		if(document.frmEntrevista.txtOtra.value==""){alert(fM("IntroduzcaQueOtra"));return;}
	}else{document.frmEntrevista.txtOtra.value="";}
	if(document.frmEntrevista.txtDia.value==""){alert(fM("IntroduzcaDia"));return;}
	if(document.frmEntrevista.txtMes.value==""){alert(fM("IntroduzcaMes"));return;}
	if(document.frmEntrevista.txtHora.value==""){alert(fM("IntroduzcaHora"));return;}
	document.frmEntrevista.submit();
}
//****************************************
function fSubirCapa()
{	if(document.layers)
	{   document.divSala.style.top=0;
		return;
	}
	if(document.getElementById)
	{   document.getElementById("divSala").style.top=0;
		return;
	}
	if(document.all)
	{   document.all("divSala").style.top=0;
		return;
	}
}