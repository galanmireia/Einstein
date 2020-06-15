function fBerriDatuakBalidatu(){
	strTitulo = document.frmBerria.txtTitulua.value;
	if (strTitulo=="") {alert("Introduzca el título");return;}
	strLead=document.frmBerria.txtLead.value;
	if (strLead=="") {alert("Introduzca el lead");return;}
	strTexto=document.frmBerria.txtTextua.value;
	if (strTexto=="") {alert("Introduzca el texto");return;}
	strPasahitzak=document.frmBerria.txtPasahitzak.value;
	if (strPasahitzak=="") {alert("Introduzca la palabras clave");return;}
	document.frmBerria.submit();
}
//****************************************
function fZiurBerriaEzabatu(){
	intZenbat=document.frmLista.Zenbat.value;
	i=0;
	sw=0;
	strBerriak = "";
	if (intZenbat=="1"){
		if (document.frmLista.chkBerria.checked){
			strBerriak = document.frmLista.chkBerria.value;
			sw=1;
		}
	}else{
		while (i<intZenbat){
			if (document.frmLista.chkBerria[i].checked){
				if(sw==0){
					strBerriak = document.frmLista.chkBerria[i].value;
				}else{
					strBerriak = strBerriak + ',' + document.frmLista.chkBerria[i].value;
				}
				sw=1;
			}
			i++;
		}
	}
	document.frmLista.hdnBerriak.value = strBerriak;
	if (sw=="1"){
		if (confirm("¿Esta seguro/a que desea borrar las noticias seleccionadas?")){document.frmLista.submit();}
		else{return;}
	}else{alert("Seleccione las noticias que desea borrar");return;}
}
//****************************************
function fZiurBerriBatEzabatu(intBerriKodea){if (confirm("¿Esta seguro/a que desea borrar esta noticia?")){location.href='index.php?pg=7&BerriKodea='+intBerriKodea}}
//****************************************
function fZiurIrudiaEzabatu(intBerriKodea){if (confirm("¿Esta seguro/a que desea borar la imagen?")){location.href='index.php?pg=8&BerriKodea='+intBerriKodea;}}
//****************************************
function fValidarBuscar (){
	strData = document.frmBuscar.txtData.value;
	if (strData!=""){if(!fValidarDia(strData)){return;}}
	document.frmBuscar.submit();
}
//****************************************
function fBilatzaileaGarbitu(intMant){
	if (intMant == 1){
		document.frmBuscar.txtLead.value="";
		document.frmBuscar.txtSinadura.value="";
	}
	document.frmBuscar.txtTitulua.value="";
	document.frmBuscar.txtData.value="";
	return;
}
//****************************************
function fAseguraMandarBoletin (){
	if (confirm(fM("SeguroMandarBoletin"))){location.href='index.php?pg=9';}
}
//****************************************
function fHistorikoBilatzaileaBalidatu (){
	strHasieraData = document.frmBuscar.txtHasieraData.value;
	strBukaeraData = document.frmBuscar.txtBukaeraData.value;
	if (strHasieraData!=""){if(!fValidarDia(strHasieraData)){return;}}
	if (strBukaeraData!=""){if(!fValidarDia(strBukaeraData)){return;}}
	if (strHasieraData == "" && strBukaeraData != ""){alert("La fecha de inicio tiene que ser menor que la final");return;}
	if(!fDataBalidatu(strHasieraData,strBukaeraData)){return;}
	document.frmBuscar.submit();
}
//****************************************
function fHistorikoBilatzaileaGarbitu(strIdioma){
	document.frmBuscar.txtTextua.value="";
	document.frmBuscar.txtHasieraData.value="";
	document.frmBuscar.txtBukaeraData.value="";
	return;
}