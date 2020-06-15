<?function sCabeceraSala (){?>
<table align="center" width="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=65>
<table valign=top align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="748" height="65" id="ShockwaveFlash1" VIEWASTEXT>
<param name="movie" value="../swf/cabecera.swf">
<param name="quality" value="high">
<param name="menu" value="false">
<embed src="../swf/cabecera.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="748" height="65"></embed></object>
</td></tr>
</table>
</td></tr>
<tr>
<td bgcolor="#787165" height="23"><?
if (!(isset($_SESSION["einstein_privado"]) && $_SESSION["einstein_privado"] == 1))
{	sSubCabecera("../");
}
else
{	?>
<table valign="top" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr>
<td bgcolor="FFFFFF" width=213><img src="../images/titulo.gif"></td>
<td width=583 align="right" class=textognb>&nbsp;&nbsp;&nbsp;</td>
</tr>
</table><?
}?></td>
</tr>
</table>
<?}
function sMenuSala (){
if(isset($_GET["pg"])){$intPg=$_GET["pg"];}else{$intPg="";}?>
<table align="center" width="95%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=20></td></tr>
<tr><td height=15></td></tr>
<?if (isset($_SESSION["einstein_privado"]) && $_SESSION["einstein_privado"] == 1){?>
<tr><td class=textomnb><?echo strtoupper(sEscribir("SalaDePrensa"));?></td></tr>
<tr><td height=15></td></tr>
<tr><td class=textomb><a href="../salaprensa/index.php?pg=9"><?if ($intPg=="9"){?><b><?}?><?echo sEscribir("DossierDePrensa");?><?if ($intPg=="9"){?></b><?}?></a></td></tr>
<tr><td class=textomb><a href="../bancoimages/index.php"><?echo sEscribir("BancoImagenes");?></a></td></tr>
<tr><td class=textomb><a href="../noticias/index.php"><?echo sEscribir("UltimasNoticias");?></a></td></tr>
<tr><td class=textomb><a href="../salaprensa/index.php?pg=10"><?if ($intPg=="10"){?><b><?}?><?echo sEscribir("SoliciteEntrevista");?><?if ($intPg=="10"){?></b><?}?></a></td></tr>
<?}else{?>
<tr><td align="center">
<table bgcolor="000000" valign="top" CELLPADDING="1" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr>
<td rowspan=7 height=7></td>
<td class="textomnb"><a href="../index.php?pg=1&opcion=2"><?echo strtoupper(sEscribir("InformacionGeneral"));?></a></td>
</tr>
<tr><td class="textomnb"><a href="../index.php?pg=1&opcion=20"><?echo strtoupper(sEscribir("Programa"));?></a></td></tr>
<tr><td class="textomnb"><a href="../index.php?pg=1&opcion=3"><?echo strtoupper(sEscribir("Inscripciones"));?></a></td></tr>
<tr><td class="textom2"><b><?echo strtoupper(sEscribir("SalaDePrensa"));?></b></td></tr>
<tr><td class="textomnb"><a href="../index.php?pg=1&opcion=4"><?echo strtoupper(sEscribir("AlbertEinstein"));?></a></td></tr>
<tr><td class="textomnb" height="20"></td></tr>
<tr><td class="textomnb"><a href="javascript:ventana('<?echo sEscribir("VerDiferidoURL");?>',450,776,'yes','diferido');"><?echo strtoupper(sEscribir("VerDiferido"));?></a></td></tr>
</table>
</td></tr>
<?}?>
<tr><td height=30></td></tr>
<?if (isset($_SESSION["einstein_privado"]) && $_SESSION["einstein_privado"] == 1){?>
<tr><td class=textomb><?echo sEscribir("ContactoMenu");?></td></tr>
<tr><td height=20></td></tr>
<tr><td class=textomb align=right><a href="../index.php?pg=1&opcion=2&ini=3&idioma=<?echo $_SESSION["einstein_idioma"];?>"><u><?echo sEscribir("SalirAreaPrivada");?></u></a>&nbsp;</td></tr>
<?}?>
</table>
<?}
function sAcceso (){
$strRaiz="../";?>
<table align="center" width="95%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=20 colspan=3></td></tr>
<tr><td class=textogn colspan=3><?echo sEscribir("SalaDePrensa");?></td></tr>
<tr><td height=10 colspan=3></td></tr>
<tr>
<td class=textom><?echo sEscribir("Texto_Acceso");?></td>
<td>&nbsp;&nbsp;</td>
<td>
<table class=tabla width=250 CELLPADDING="3" CELLSPACING="0" bgcolor=FFFFFF>
<tr><td colspan=2 class=textogn><?echo sEscribir("Acceso");?></td></tr>
<tr><td colspan=2 class=textom><?echo sEscribir("IntroduzcaDatosAcceso");?>:</td></tr>
<tr><td colspan=2>
<table align=center width=200 height=50 bgcolor=E8E8E8 CELLPADDING="2" CELLSPACING="0">
<form name="frmAcceso" id="frmAcceso" method=post action="index.php?pg=4">
<tr>
<td class=textom><?echo sEscribir("Email");?>:</td>
<td><input type="text" name="txtEmail" id="txtEmail" class=textoinput></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("Clave");?>:</td>
<td><input type="password" name="txtPass" id="txtPass" class=textoinput></td>
</tr>
</form>
</table>
</td></tr>
<tr><td height=5 colspan=2></td></tr>
<tr>
<td class=textom><a href="index.php?pg=3"><u><?echo sEscribir("OlvidoClave");?></u></a></td>
<td><?Boton($strRaiz,"javascript:fValidarAcceso();",sEscribir("Entrar"),sEscribir("Entrar"),0,3);?></td>
</tr>
<tr><td height=5 colspan=2></td></tr>
</table>
</td>
</tr>
<tr><td colspan=3 height=20></td></tr>
<tR><td class=textogn colspan=3><?echo sEscribir("DarseDeAlta");?></td></tr>
<tr><td colspan=3 height=10></td></tr>
<tr><td class=textom colspan=3><?echo sEscribir("Texto_Alta");?></td></tr>
</table>
<?}
function sOlvidoClave (){
$strRaiz="../";
if (isset($_GET["Enviado"])){$intEnviado=$_GET["Enviado"];}else{$intEnviado=0;}?>
<table align="center" width="95%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=20 colspan=3></td></tr>
<tr><td class=textogn colspan=3><?echo sEscribir("SalaDePrensa");?> / <?echo sEscribir("OlvidoClave");?></td></tr>
<tr><td height=20 colspan=3></td></tr>
<?if ($intEnviado == "1"){?>
<tr><td class=textom><?echo sEscribir("Texto_Enviada");?></td></tr>
<tr><td height=35></td></tr>
<tr><td class=textom><?echo sEscribir("ContactoMenu");?></td></tr>
<?}else{?>
<tr><td class=textom><?echo sEscribir("Texto_Olvido");?></td></tr>
<tr><td height=10 colspan=3></td></tr>
<tr><td colspan=2>
<table align=center width=200 height=50 CELLPADDING="2" CELLSPACING="0">
<form name="frmOlvido" id="frmOlvido" method=post action="index.php?pg=6">
<tr>
<td class=textom><?echo sEscribir("Nombre");?>:</td>
<td><input type="text" name="txtNombre" id="txtNombre" class=textoinput></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("Email");?>:</td>
<td><input type="text" name="txtEmail" id="txtEmail" class=textoinput></td>
</tr>
<tr><td coslpan=2 height=10></td></tr>
<tr><td colspan=2 align=center><?Boton ($strRaiz,"javascript:fValidarOlvido();",sEscribir("Enviar"),sEscribir("Enviar"),0,3);?>
</form>
</table>
</td></tr>
<?}?>
<tr><td coslpan=2 height=20></td></tr>
<tr><td class=textom><?Boton ($strRaiz,"index.php",sEscribir("Volver"),sEscribir("Volver"),0,1);?></td></tr>
</table>
<?}
function sDarseDeAlta (){
$strRaiz="../";?>
<div name="divSala" id="divSala" style="height:315px;width:600px;overflow:auto">
<table align="center" width="95%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=20 colspan=3></td></tr>
<tr><td class=textogn colspan=3><?echo sEscribir("SalaDePrensa");?> / <?echo sEscribir("DarseDeAlta");?></td></tr>
<tr><td height=20 colspan=3></td></tr>
<tr><td>
<table cellpadding=0 cellspacing=0 width=100%>
<form name="frmAlta" id="frmAlta" method=post action="index.php?pg=7">
<tr><td colspan="2" class=textom><?echo sEscribir("Texto_DarseDeAlta");?></td></tr>
<tr><td colspan="2" height=10></td></tr>
<tr><td colspan="2" class=textomn><?echo sEscribir("DatosSolicitante");?>:</td></tr>
<tr><td colspan="2" height=1 bgcolor="#373E52"></td></tr>
<tr><td colspan="2" height=10></td></tr>
<tr>
<td class=textom width=28%><?echo sEscribir("Nombre");?>:</td>
<td width=72%><input type="text" name="txtNombre" id="txtNombre" size=40 class=textoinput></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("Apellidos");?>:</td>
<td><input type="text" name="txtApellidos" id="txtApellidos" size=40 class=textoinput></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("EmailPersonal");?>:</td>
<td><input type="text" name="txtEmail" id="txtEmail" size=40 class=textoinput></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("Telefono");?>:</td>
<td><input type="text" name="txtTelefono" id="txtTelefono" size=40 class=textoinput></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("TrabajasFreelance");?>:</td>
<td class=textom><input type="radio" name="rdbFreelance" id="rdbFreelance" value=0 checked>&nbsp;<?echo sEscribir("No");?> &nbsp; <input type="radio" name="rdbFreelance" id="rdbFreelance" value=1>&nbsp;<?echo sEscribir("Si");?></td>
</tr>
<tr><td colspan="2" height=10></td></tr>
<tr><td colspan="2" class=textomn><?echo sEscribir("DatosMedio");?>:</td></tr>
<tr><td colspan="2" height=1 bgcolor="#373E52"></td></tr>
<tr><td colspan="2" height=10></td></tr>
<tr><td colspan=2>
<table cellpadding=0 cellspacing=0 width=100%>
<tr>
<td class=textom><?echo sEscribir("NombreDelMedio");?></td>
<td class=textom><?echo sEscribir("Soporte");?></td>
<td class=textom><?echo sEscribir("Ambito");?></td>
</tr>
<tr>
<td><input type="text" name="txtMedio" id="txtMedio" size=30 class=textoinput></td>
<td>
<select name="cboSoporte" id="cboSoporte" class=textoinput>
<option value="<?echo sEscribir("Soporte01");?>"><?echo sEscribir("Soporte01");?></option>
<option value="<?echo sEscribir("Soporte02");?>"><?echo sEscribir("Soporte02");?></option>
<option value="<?echo sEscribir("Soporte03");?>"><?echo sEscribir("Soporte03");?></option>
<option value="<?echo sEscribir("Soporte04");?>"><?echo sEscribir("Soporte04");?></option>
<option value="<?echo sEscribir("Soporte05");?>"><?echo sEscribir("Soporte05");?></option>
</select>
</td>
<td>
<select name="cboAmbito" id="cboAmbito" class=textoinput>
<option value="<?echo sEscribir("Ambito01");?>"><?echo sEscribir("Ambito01");?></option>
<option value="<?echo sEscribir("Ambito02");?>"><?echo sEscribir("Ambito02");?></option>
<option value="<?echo sEscribir("Ambito03");?>"><?echo sEscribir("Ambito03");?></option>
<option value="<?echo sEscribir("Ambito04");?>"><?echo sEscribir("Ambito04");?></option>
<option value="<?echo sEscribir("Ambito05");?>"><?echo sEscribir("Ambito05");?></option>
</select>
</td>
</tr>
<tr><td colspan=3 height=10></td></tr>
<tr><td colspan=3 class=textom><?echo sEscribir("Texto_Localizacion");?></td></tr>
<tr><td colspan=3>
<textarea name="txtLocalizacion" id="txtLocalizacion" cols=100 rows=5 class=textoinput></textarea>
</td></tr>
<tr><td colspan=3 height=10></td></tr>
</table>
</td></tr>
<tr>
<td class=textom><?echo sEscribir("TlfnContacto");?>:</td>
<td><input type="text" name="txtContacto" id="txtContacto" size=40 class=textoinput></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("Fax");?>:</td>
<td><input type="text" name="txtFax" id="txtFax" size=40 class=textoinput></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("Email");?>:</td>
<td><input type="text" name="txtEmail2" id="txtEmail2" size=40 class=textoinput></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("Web");?>:</td>
<td><input type="text" name="txtWeb" id="txtWeb" size=40 class=textoinput></td>
</tr>
<tr><td colspan=2 height=10></td></tr>
<tr><td colspan=2>
<table cellpadding=0 cellspacing=0 width=100%>
<tr>
<td class=textom valign=top><?echo sEscribir("Texto_Publicacion");?></td>
<td><textarea name="txtPublicacion" id="txtPublicacion" cols=60 rows=4 class=textoinput></textarea></td>
</tr>
<tr>
<td class=textom valign=top><?echo sEscribir("Texto_Congreso");?></td>
<td><textarea name="txtCongreso" id="txtCongreso" cols=60 rows=4 class=textoinput></textarea></td>
</tr>
</table>
</td></tr>
<tr><td colspan=2 height=10></td></tr>
<tr><td colspan=2>
<table width=100%>
<tr>
<td align=center width=33%><?Boton ($strRaiz,"index.php",sEscribir("Volver"),sEscribir("Volver"),0,1);?></td>
<td align=center width=33%><?Boton ($strRaiz,"javascript:document.frmAlta.reset();",sEscribir("Borrar"),sEscribir("Borrar"),0,2);?></td>
<td align=center width=33%><?Boton ($strRaiz,"javascript:fValidarAlta();",sEscribir("Enviar"),sEscribir("Enviar"),0,3);?></td>
</tr>
</table>
</td></tr>
<tr><td colspan=2 height=10></td></tr>
</form>
</table>
</td></tr>
</table>
</div>
<?}
function sBienvenida (){
$strRaiz="../";?>
<table align="center" width="95%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=20 colspan=3></td></tr>
<tr><td class=textogn colspan=3><?echo sEscribir("SalaDePrensa");?></td></tr>
<tr><td height=20 colspan=3></td></tr>
<tr><td class=textom><?echo sEscribir("Texto_Bienvenida");?></td></tr>
</table>
<?}
function sMensajeAlta (){
$strRaiz="../";
if(isset($_GET["Enviado"])){$intEnviado = $_GET["Enviado"];}else{$intEnviado=0;}?>
<table align="center" width="95%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=20></td></tr>
<tr><td class=textogn><?echo sEscribir("SalaDePrensa");?></td></tr>
<tr><td height=20></td></tr>
<?if ($intEnviado == "1"){?>
<tr><td class=textom><?echo sEscribir("Texto_AltaEnviada");?></td></tr>
<?}else{?>
<tr><td class=textom><?echo sEscribir("Texto_AltaNoEnviada");?></td></tr>
<?}?>
<tr><td height=20></td></tr>
<tr><td class=textom><?Boton ($strRaiz,"index.php",sEscribir("Volver"),sEscribir("Volver"),0,1);?></td></tr>
<tr><td height=20></td></tr>
</table>
<?}
function sDossierDePrensa (){
if(isset($_SESSION["einstein_privado"]) && $_SESSION["einstein_privado"] != ""){?>
<table align="center" width="95%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=20></td></tr>
<tr><td class=textogn><?echo sEscribir("DossierDePrensa");?></td></tr>
<tr><td height=20></td></tr>
<tr><td class=textom><?echo sEscribir("Texto_Dossier1");?></td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom>
<ul>
<li><?echo sEscribir("PDF_Dossier1");?><br>
<li><?echo sEscribir("PDF_Dossier2");?><br>
<li><?echo sEscribir("PDF_Dossier3");?></li>
</ul>
</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom><?echo sEscribir("Texto_Dossier2");?></td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom><?echo sEscribir("Texto_Dossier3");?></td></tr>
<tr><td height=20></td></tr>
<tr><td class=textop><?echo sEscribir("Texto_Dossier4");?></td></tr>
<tr><td>
<table align=center>
<tr><?
switch ($_SESSION["einstein_idioma"])
{	case "uk":
$strLink="http://www.adobe.com/products/acrobat/readstep2.html";
break;
case "eu":
$strLink="http://www.adobe.es/products/acrobat/readstep2.html";
break;
default:
$strLink="http://www.adobe.es/products/acrobat/readstep2.html";
break;
}?>
<td align=center class=textop><a href='<?echo $strLink;?>' target='descarga'><img src='images/ico_pdf.gif' border=0></a></td>
<td class=textop> <a href='<?echo $strLink;?>' target='descarga'><?echo sEscribir("DescargarAcrobat");?></a></td>
</tr>
</table>
</td></tr>
</table>
<?}else{?>
<script>location.href='index.php';</script>
<?}
}
function sSoliciteEntrevista (){
$strRaiz="../";
if(isset($_SESSION["einstein_privado"]) && $_SESSION["einstein_privado"] != ""){
?>
<iframe src="index.php?pg=13" width="600" height="315" name="einstein_dentro" id="einstein_dentro" frameborder="0" marginwidth="0" marginheight="0"></iframe>
<?}
}
function sMensajeEntrevista (){
$strRaiz="../";
if(isset($_GET["Enviado"])){$intEnviado = $_GET["Enviado"];}else{$intEnviado=0;}
if(isset($_GET["Ponente"])){$strPonente = $_GET["Ponente"];}else{$strPonente="";}?>
<table align="center" width="95%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=20 colspan=2></td></tr>
<tr><td class=textogn colspan=2><?echo sEscribir("SoliciteEntrevista");?></td></tr>
<tr><td height=20></td></tr>
<?if ($intEnviado == "1"){?>
<tr><td class=textom colspan=2><?echo sEscribir("Texto_EntrevistaEnviada");?></td></tr>
<tr><td height=20 colspan=2></td></tr>
<tr><td class=textom colspan=2><?echo sEscribir("Texto_EntrevistaEnviada1A");?> <b><?echo $strPonente;?></b><?echo sEscribir("Texto_EntrevistaEnviada1B");?>. <?echo sEscribir("Texto_EntrevistaEnviada2");?></td></tr>
<tr><td height=20 colspan=2></td></tr>
<tr><td class=textom colspan=2><?echo sEscribir("Texto_EntrevistaEnviada3");?></td></tr>
<?}else{?>
<tr><td class=textom colspan=2><?echo sEscribir("Texto_EntrevistaNoEnviada");?></td></tr>
<?}?>
<tr><td height=20 colspan=2></td></tr>
<tr>
<td class=textom><?Boton ($strRaiz,"index.php?pg=5",sEscribir("Volver"),sEscribir("Volver"),0,1);?></td>
<td class=textom align=right><?Boton ($strRaiz,"index.php?pg=10",sEscribir("Siguiente")." >>",sEscribir("Siguiente")." >>",0,3);?></td>
</tr>
<tr><td height=20 colspan=2></td></tr>
</table>
<?}
function fDentro()
{	$strRaiz="../";
if(isset($_SESSION["entrevista_nombre"])){$strNombre = $_SESSION["entrevista_nombre"];}else{$strNombre="";}
if(isset($_SESSION["entrevista_apellidos"])){$strApellidos = $_SESSION["entrevista_apellidos"];}else{$strApellidos="";}
if(isset($_SESSION["entrevista_telefono"])){$strTelefono = $_SESSION["entrevista_telefono"];}else{$strTelefono="";}
if(isset($_SESSION["entrevista_email"])){$strEmail = $_SESSION["entrevista_email"];}else{$strEmail="";}?>
<table align="center" width="95%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=20 colspan=3></td></tr>
<tr><td class=textogn colspan=3><?echo sEscribir("SoliciteEntrevista");?></td></tr>
<tr><td height=15 colspan=3></td></tr>
<form name="frmEntrevista" id="frmEntrevista" method=post action="index.php?pg=11" target="_parent">
<tr><td class=textom colspan=3><?echo sEscribir("Texto_Entrevista");?></td></tr>
<tr><td colspan=3 height=10></td></tr>
<tr><td colspan=3 class=textomn><?echo sEscribir("DatosSolicitante");?></td></tr>
<tr>
<td class=textom><?echo sEscribir("Nombre");?>:</td>
<td colspan=2><input type="text" name="txtNombre" id="txtNombre" class=textoinput size=35 value="<?echo $strNombre;?>"></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("Apellidos");?>:</td>
<td colspan=2><input type="text" name="txtApellidos" id="txtApellidos" class=textoinput size=35 value="<?echo $strApellidos;?>"></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("TlfnContacto");?>:</td>
<td colspan=2><input type="text" name="txtTelefono" id="txtTelefono" class=textoinput size=35 value="<?echo $strTelefono;?>"></td>
</tr>
<tr>
<td class=textom><?echo sEscribir("Email");?>:</td>
<td colspan=2><input type="text" name="txtEmail" id="txtEmail" class=textoinput size=35 value="<?echo $strEmail;?>"></td>
</tr>
<tr><td colspan=3 height=10></td></tr>
<tr>
<td colspan=2 class=textom><b><?echo sEscribir("PonenteOrganizador");?></b></td>
<td>
<select name="cboPonente" id="cboPonente" class=textoinput>
<?for ($i=1;$i<=19;$i++){?>
<option value="<?echo fDevuelveNombrePonente($i);?>"><?echo fDevuelveNombrePonente($i);?></option>
<?}?>
</select>
</td>
</tr>
<tr><td colspan=3 height=10></td></tr>
<tr><td class=textom colspan=3><b><?echo sEscribir("ComoQuiereEntrevista");?></b></td></tr>
<tr>
<td colspan=2 class=textom><input type="radio" name="rdbComo" id="rdbComo" value="<?echo sEscribir("EntrevistaComo1");?>" checked>&nbsp;<?echo sEscribir("EntrevistaComo1");?></td>
<td class=textom><input type="radio" name="rdbComo" id="rdbComo" value="<?echo sEscribir("EntrevistaComo4");?>">&nbsp;<?echo sEscribir("EntrevistaComo4");?></td>
</tr>
<tr>
<td colspan=2 class=textom><input type="radio" name="rdbComo" id="rdbComo" value="<?echo sEscribir("EntrevistaComo2");?>">&nbsp;<?echo sEscribir("EntrevistaComo2");?></td>
<td class=textom rowspan=2><textarea name="txtOtra" id="txtOtra" cols=50 rows=3 class=textoinput></textarea></td>
</tr>
<tr><td colspan=2 class=textom><input type="radio" name="rdbComo" id="rdbComo" value="<?echo sEscribir("EntrevistaComo3");?>">&nbsp;<?echo sEscribir("EntrevistaComo3");?></td></tr>
<tr><td colspan=3 height=10></td></tr>
<tr><td class=textom colspan=3><b><?echo sEscribir("Cuando");?></b></td></tr>
<tr><td colspan=3 height=10></td></tr>
<tr>
<td class=textom width=30%><?echo sEscribir("Dia");?>&nbsp;<input type="text" size=4 name="txtDia" id="txtDia" class=textoinput></td>
<td class=textom width=30%><?echo sEscribir("Mes");?>&nbsp;<input type="text" size=4 name="txtMes" id="txtMes" class=textoinput></td>
<td class=textom width=40%><?echo sEscribir("HoraLocal");?>&nbsp;<input size=10 type="text" name="txtHora" id="txtHora" class=textoinput></td>
</tr>
<tr><td colspan=3 height=10></td></tr>
<tr>
<td colspan=2 class=textom><b><?echo sEscribir("IdiomaEntrevista");?></b></td>
<td>
<select name="cboIdioma" id="cboIdioma" class=textoinput>
<option value="<?echo sEscribir("Ingles");?>"><?echo sEscribir("Ingles");?></option>
<option value="<?echo sEscribir("Castellano");?>"><?echo sEscribir("Castellano");?></option>
<option value="<?echo sEscribir("Euskera");?>"><?echo sEscribir("Euskera");?></option>
</select>
</td>
</tr>
<tr><td colspan=3 height=10></td></tr>
<tr>
<td class=textom valign=top><?echo sEscribir("OtrosComentarios");?></td>
<td colspan=2><textarea name="txtComentarios" id="txtComentarios" cols=70 rows=4 class=textoinput></textarea></td>
</tr>
<tr><td colspan=3 height=10></td></tr>
<tr>
<td colspan=2 align=center><?Boton ($strRaiz,"javascript:document.frmEntrevista.reset();",sEscribir("Borrar"),sEscribir("Borrar"),0,2);?></td>
<td><?Boton ($strRaiz,"javascript:fValidarDatosEntrevista();",sEscribir("Enviar"),sEscribir("Enviar"),0,3);?></td>
</tr>
<tr><td colspan=3 height=10></td></tr>
<tr><td colspan=3 class=textop><?echo sEscribir("NotaEntrevista") . "<a href='mailto:".fDameRuta("E_Gabinete")."'><b>" . fDameRuta("E_Gabinete") . "</b></a>" ;?></td></tr>
<tr><td colspan=3 height=10></td></tr>
</form>
</table><?
}?>
