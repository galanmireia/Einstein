<?function sBerriZerrenda(){
$strSustraia = "../../";
if(isset($_GET["historiko"])){$intHistoriko=$_GET["historiko"];}else{$intHistoriko=0;}
if(isset($_GET["pag"])){$strPos=$_GET["pag"];}else{$strPos=1;}
if(isset($_GET["txtTitulua"])){$strTitulua =$_GET["txtTitulua"];}
else{if(isset($_POST["txtTitulua"])){$strTitulua =$_POST["txtTitulua"];}
else{$strTitulua="";}}
if(isset($_GET["txtLead"])){$strLead =$_GET["txtLead"];}
else{if(isset($_POST["txtLead"])){$strLead =$_POST["txtLead"];}
else{$strLead="";}}
if(isset($_GET["txtSinadura"])){$strSinadura =$_GET["txtSinadura"];}
else{if(isset($_POST["txtSinadura"])){$strSinadura =$_POST["txtSinadura"];}
else{$strSinadura="";}}
if(isset($_GET["txtData"])){$strData =$_GET["txtData"];}
else{if(isset($_POST["txtData"])){$strData =$_POST["txtData"];}
else{$strData="";}}
AbreConexion();
if ($strTitulua=="" && $strLead=="" && $strSinadura=="" && $strData==""){
$intBilakera = 0;
$strSelect=fSQLBerriakZerrendatu($intHistoriko);
}else{
$intBilakera = 1;
$strDataB = $strData;
$strSelect=fSQLBerriakBilatu($strTitulua,$strLead,$strSinadura,$strDataB,$intHistoriko);
}
$objrow=EJECUTA_SELECT($strSelect);
$intLerroTotala=mysql_num_rows($objrow);
if (intval($intLerroTotala)<intval($strPos)){
$strPos=1;
}
$intLerroak=7;
$strLink="index.php?pg=1&txtTitulua=".$strTitulua."&txtLead=".$strLead."&txtSinadura=".$strSinadura."&txtData=".$strData."&historiko=".$intHistoriko;?>
<br>
<form name="frmBuscar" id="frmBuscar" action="index.php?pg=1&historiko=<?echo $intHistoriko;?>" method="post">
<table border="0" class="tabla" width="80%" bgcolor="#eff0f2" align="center" cellspacing="0">
<tr><td colspan="6"><img src="<?echo $strSustraia;?>images/px_t.gif" height="5"></td></tr>
<tr>
<td colspan="4" class="textogn">Buscador de noticias</td>
</tr>
<tr>
<td class="textom">título</td>
<td><input class="textoinput" type="text" name="txtTitulua" id="txtTitulua" size="40" value="<?echo $strTitulua;?>"></td></tr>
<tr>
<td class="textom">lead</td>
<td><input class="textoinput" type="text" name="txtLead" id="txtLead" size="40" value="<?echo $strLead;?>"></td></tr>
<tr>
<td class="textom">firma</td>
<td><input class="textoinput" type="text" name="txtSinadura" id="txtSinadura" size="40" value="<?echo $strSinadura;?>"></td></tr>
<tr>
<td class="textom" >fecha</td>
<td class="textom"><input class="textoinput" type="text" name="txtData" id="txtData" size="10" maxlength="10" value="<?echo $strData;?>"> <span class="textop">(formato dd/mm/aaaa)</span></td></tr>
<tr>
<td><?Boton ($strSustraia,"javascript:fValidarBuscar();","buscar","buscar",0,1);?></td><td><?Boton ($strSustraia,"javascript:fBilatzaileaGarbitu(1);","Limpiar","Limpiar",0,1);?></td>
</tr>
<tr><td colspan="8"><img src="<?echo $strSustraia;?>/images/px_t.gif" height="5"></td></tr>
</table>
</form>
<table border="0" width="95%" align="center" cellpadding="0" cellspacing="0">
<form name="frmLista" id="frmLista" action="index.php?pg=4" method="post">
<?if ($intHistoriko!="1"){?>
<tr><td colspan="5" class="textogn" align="center">Gestor de noticias:&nbsp;Listado de noticias</td></tr>
<?}else{?>
<tr><td colspan="5" class="textogn" align="center">Gestor de noticias:&nbsp;Histórico de noticias</td></tr>
<?}
$cont=0;
if (mysql_num_rows($objrow)!=0){
$row=mysql_fetch_assoc($objrow);?>
<tr><td colspan="5" height="5%" align="right"><?sGeziakPintatu($strSustraia,$strPos,$intLerroTotala,$intLerroak,$strLink,0);?></tr></td>
<tr><td colspan="5" height="1" width="100%" bgcolor="#737886"></td></tr>
<tr>
<td width="1%"></td>
<td width="10%" class="textomn"><i>fecha</i></td>
<td width="60%" class="textomn"><i>título</i></td>
<td width="15%" class="textomn" align=center><i>caducidad</i></td>
</tr>
<tr><td colspan="5" height="1" width="100%" bgcolor="#737886"></td></tr>
<?$row=mysql_data_seek($objrow,$strPos-1);
$j=0;
$intKolumnak = 4;
$strColorOut = "#FFFFFF";
$strColorOver = "#FFFAE7";
while ($row=mysql_fetch_assoc($objrow)){
if ($cont<=$intLerroak){
$j=$j+1;
$intBerriKodea=$row["t759_codigo"];
$strTitulua=$row["t759_titulo"];
$strTitulua = fQuitarFormatoDelTexto($strTitulua);
if (strlen($strTitulua)>75){
$strTituluaP = substr($strTitulua,0,75) . "...";
}else{
$strTituluaP = $strTitulua;
}
$strLead=$row["t759_lead"];
$strTextua=$row["t759_texto"];
$strBukaera=$row["t759_caducidad"];
$strBukaera=sObtenerFechaVer($strBukaera);
$strData=$row["t759_fecha"];
$strData=sObtenerFechaVer($strData);
$strSinadura=$row["t759_firma"];
$strLink = "javascript:location.href='index.php?pg=2&BerriKodea=".$intBerriKodea."'";?>
<tr>
<td name="fila1_<?echo $j;?>" id="fila1_<?echo $j;?>" onMouseOver="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOver;?>');this.style.cursor='hand'" onMouseOut="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOut;?>');"><input type="checkbox" name="chkBerria" id="chkBerria" value="<?echo $intBerriKodea;?>"></td>
<td class="textom" name="fila2_<?echo $j;?>" id="fila2_<?echo $j;?>" onMouseOver="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOver;?>');this.style.cursor='hand'" onMouseOut="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOut;?>');" onClick="<?echo $strLink;?>"><?echo $strData;?></td>
<td class="textom" name="fila3_<?echo $j;?>" id="fila3_<?echo $j;?>" onMouseOver="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOver;?>');this.style.cursor='hand'" onMouseOut="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOut;?>');" onClick="<?echo $strLink;?>"><?echo $strTituluaP;?></td>
<td align=center class="textom" name="fila4_<?echo $j;?>" id="fila4_<?echo $j;?>" onMouseOver="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOver;?>');this.style.cursor='hand'" onMouseOut="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOut;?>');" onClick="<?echo $strLink;?>"><?echo $strBukaera;?></td>
</tr>
<?$cont=$cont + 1;
}
}?>
<input type="hidden" name="Zenbat" id="Zenbat" value="<?echo $cont;?>">
<input type="hidden" name="hdnBerriak" id="hdnBerriak" value>
<?}else{?>
<tr><td class="textomn" align="center">&nbsp;</td></tr>
<?if ($intBilakera=="1"){?>
<tr><td class="textomn" align="center">No se han encontrado noticias para esta búsqueda</td></tr>
<?}else{?>
<tr><td class="textomn" align="center">No se han encontrado noticias</td></tr>
<?}
}?>
</form>
</table>
<?CierraConexion();?>
<table width="100%" cellpadding="0" cellspacing="0" align="center">
<tr><td colspan="4" class="textom">&nbsp;</td></tr>
<tr>
<td align="center" width="25%"><?Boton ($strSustraia,"index.php?pg=2","Nueva","Nueva",0,3);?></td>
<?if ($intBilakera=="1"){?>
<td align="center" width="25%"><?Boton ($strSustraia,"index.php?pg=1","Volver","Volver",0,1);?></td>
<?}?>
<?if ($cont!="0"){?>
<td align="center" width="25%"><?Boton ($strSustraia,"javascript:fZiurBerriaEzabatu();","Borrar","Borrar",0,2);?></td>
<?}?>
<?if ($intHistoriko=="1"){?>
<td align="center" width="25%"><?Boton ($strSustraia,"index.php?pg=1","Noticias actuales","Noticias actuales",10,1);?></td>
<?}else{?>
<td align="center" width="25%"><?Boton ($strSustraia,"index.php?pg=1&historiko=1","Histórico de noticias","Histórico de noticias",0,1);?></td>
<?}?>
</tr>
</table>
<?}
function sBerriBerriaAldatu(){
$strSustraia = "../../";
if(isset($_GET["BerriKodea"])){$intBerriKodea=$_GET["BerriKodea"];}else{$intBerriKodea="";}
AbreConexion();
if ($intBerriKodea!=""){
$strSelect=fSQLBerriDatuak($intBerriKodea);
$objrow=EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strTitulua=$row["t759_titulo"];
$strLead=$row["t759_lead"];
$strTextua=$row["t759_texto"];
$strBukaera=$row["t759_caducidad"];
$strSinadura=$row["t759_firma"];
$strIrudia=$row["t759_foto"];
$strOina=$row["t759_pie"];
$strPasahitzak=$row["t759_palabrasclave"];
$intUrtea=substr($strBukaera,0,4);
$intHilabetea=substr($strBukaera,4,2);
$intEguna=substr($strBukaera,6,2);
}else{
$strTitulua="";
$strLead="";
$strTextua="";
$strSinadura="";
$strIrudia="";
$strOina="";
$strPasahitzak="";
$intEguna=Date("d");
$intHilabetea=Date("m");
$intUrtea=Date("Y");
}?>
<table border="0" width="50%" cellpadding="0" cellspacing="0" topmargin="0" leftmargin="0" align="center">
<form name="frmBerria" id="frmBerria" method="post" enctype="multipart/form-data" action="index.php?pg=3">
<input type="hidden" name="BerriKodea" id="BerriKodea" value="<?echo $intBerriKodea;?>">
<tr><td colspan="2" class="textom">&nbsp;</td></tr>
<tr><td colspan="2" class="textogn" align="center">Gestor de noticias:&nbsp;
<?if ($intBerriKodea!=""){
echo "Modificar noticia";
}else{
echo "Nueva noticia";
}?>
</td></tr>
<tr><td colspan="2" height=10></td></tr>
<tr><td colspan="2"><?sPintarBotonesFormato("",$strSustraia);?></td></tr>
<tr><td colspan="2" height=10></td></tr>
<tr><td width="10%"><font class="textom">* título</font></td>
<td><textarea onclick="strFoco=this" class="textoinput" type="text" name="txtTitulua" id="txtTitulua" rows="4" cols="107"><?echo $strTitulua;?></textarea></td>
</tr>
<tr><td><font class="textom">* lead</font></td>
<td><textarea onclick="strFoco=this" class="textoinput" type="text" name="txtLead" id="txtLead" rows="4" cols="107"><?echo $strLead;?></textarea></td>
</tr>
<tr><td><font class="textom">* texto</font></td>
<td><textarea onclick="strFoco=this" class="textoinput" name="txtTextua" id="txtTextua" rows="14" cols="107"><?echo $strTextua;?></textarea></td>
</tr>
<tr>
<td><font class="textom">* caducidad</font></td>
<td><?sDataPintatu($intEguna,$intHilabetea,$intUrtea,2);?></td>
</tr>
<tr><td><font class="textom">firma</font></td>
<td><input onclick="strFoco=this" class="textoinput" type="text" name="txtSinadura" id="txtSinadura" size="50" value="<?echo $strSinadura;?>" maxlength="100"></td>
</tr>
<tr><td width=13%><font class="textom">* palabras clave</font></td>
<td><input class="textoinput" type="text" name="txtPasahitzak" id="txtPasahitzak" style="width:417px" value="<?echo $strPasahitzak;?>" maxlength="100"></td>
</tr>
<tr>
<td></td>
<td class=textop>para meter más de una palabra, separadas por comas.</td>
</tr>
<tr>
<td><font class="textom">foto indice</font></td>
<td><input class="textoinput" type="file" name="txtIrudia2" id="txtIrudia2" size="35"></td>
</tr>
<tr>
<td></td>
<td class=textop><i><b>Alto y ancho recomendado:</b> 80px; <b>Tamaño máximo</b>: 50Kb</i></td>
</tr>
<?if ($strIrudia!=""){?>
<tr><td colspan="2"><img src="<?echo $strSustraia;?>images/px_t.gif" height="3"></td></tr>
<tr>
<td class="textom">foto actual</td>
<td>
<table border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
<td width="30%"><img src="<?echo $strSustraia;?>noticias/fotos/t_<?echo $strIrudia;?>" height="80" width=80></td>
<td valign="bottom" width="70%"><?Boton ($strSustraia,"javascript:fZiurIrudiaEzabatu(".$intBerriKodea.");","Borrar imagen","Borrar imagen",0,2);?></td>
</tr>
</table>
</td>
</tr>
<tr><td colspan="2"><img src="<?echo $strSustraia;?>images/px_t.gif" height="3"></td></tr>
<?}?>
<tr>
<td><font class="textom">foto</font></td>
<td><input class="textoinput" type="file" name="txtIrudia" id="txtIrudia" size="35"></td>
</tr>
<tr>
<td></td>
<td class=textop><i><?echo strtoupper(sEscribir("Gomendatutako"));?> <b>Ancho máximo recomendado</b>: 230px. <b>Tamaño máximo</b>: 2Mb</i></td>
</tr>
<?if ($strIrudia!=""){?>
<tr><td colspan="2"><img src="<?echo $strSustraia;?>images/px_t.gif" height="3"></td></tr>
<tr>
<td class="textom">foto actual</td>
<td>
<table border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
<td width="30%"><img src="<?echo $strSustraia;?>noticias/fotos/<?echo $strIrudia;?>" height="150"></td>
<td valign="bottom" width="70%"><?Boton ($strSustraia,"javascript:fZiurIrudiaEzabatu(".$intBerriKodea.");","Borrar imagen","Borrar imagen",0,2);?></td>
</tr>
</table>
</td>
</tr>
<tr><td colspan="2"><img src="<?echo $strSustraia;?>images/px_t.gif" height="3"></td></tr>
<?}?>
<tr>
<td><font class="textom">pie de foto</font></td>
<td><textarea class="textoinput" name="txtOina" id="txtOina" rows="2" cols="107" onKeyUp="textCounter(200,this);"><?echo $strOina;?></textarea></td>
</tr>
</form>
</table>
<table align="center" width="100%">
<tr><td colspan="4" height=10></td></tr>
<tr>
<td width="25%" align="center"><?Boton ($strSustraia,"javascript:fBerriDatuakBalidatu();","Guardar","Guardar",0,1);?></td>
<td width="25%" align="center"><?Boton ($strSustraia,"index.php?pg=1","Volver","Volver",0,1);?></td>
<?if ($intBerriKodea != ""){?>
<td width="25%" align="center"><?Boton ($strSustraia,"javascript:fZiurBerriBatEzabatu(".$intBerriKodea.");","Borrar","Borrar",0,2);?></td>
<td width="25%" align="center"><?Boton ($strSustraia,"index.php?pg=2","Nueva","Nueva",0,3);?></td>
<?}?>
</tr>
</table>
<?CierraConexion();
}
function sBerriZerrendaWeb(){
$strSustraia = "../";
if(isset($_GET["historiko"])){$intHistoriko=$_GET["historiko"];}else{$intHistoriko=0;}
if(isset($_GET["pag"])){$strPos=$_GET["pag"];}else{$strPos=1;}
if(isset($_GET["txtTitulua"])){$strTitulua=PHPentities($_GET["txtTitulua"]);}
else{$strTitulua="";}
if(isset($_GET["txtData"])){$strData =$_GET["txtData"];}
else{if(isset($_POST["txtData"])){$strData =$_POST["txtData"];}
else{$strData="";}}
AbreConexion();
if ($strTitulua=="" && $strData==""){
$intBilakera = 0;
$strSelect=fSQLBerriakZerrendatu($intHistoriko);
}else{
$intBilakera = 1;
$strDataB = $strData;
$strSelect=fSQLBerriakBilatuWeb($strTitulua,$strDataB,$intHistoriko);
}
$objrow=EJECUTA_SELECT($strSelect);
$intLerroTotala=mysql_num_rows($objrow);
if (intval($intLerroTotala)<intval($strPos)){
$strPos=1;
}
$intLerroak=25;
$strLink="index.php?txtTitulua=".$strTitulua."&txtData=".$strData."&historiko=".$intHistoriko;
if ($intHistoriko=="1"){?>
<table cellpadding="0" cellspacing="0" width="100%">
<tr><td align=center><form name="frmBuscar" id="frmBuscar" action="index.php" method="get">
<?sPintarBuscadorInicio($strSustraia,sEscribir("BerriBilatzailea"));?>
<table border="0" width="95%" align="center" cellspacing="0" cellspacing="0">
<tr>
<td class="textom" width="5%"><?echo strtolower(sEscribir("Textua"));?>&nbsp;</td>
<td class="textom"><input class="textoinput" type="text" name="txtTitulua" id="txtTitulua" size="58" value="<?echo $strTitulua;?>"></td>
<td><?Boton ($strSustraia,"javascript:fBilatzaileaGarbitu(0);",sEscribir("Garbitu"),sEscribir("Garbitu"),0,1);?></td>
<td><?Boton ($strSustraia,"javascript:fValidarBuscar();",sEscribir("Bilatu"),sEscribir("Bilatu"),0,1);?></td>
</tr>
<tr>
<td class="textom"><?echo strtolower(sEscribir("Taldea"));?>&nbsp;</td>
<td colspan=3>
<table width=100% cellpadding=0 cellspacing=0><tr>
<td>
<select name="cboTaldea" id="cboTaldea" class="textoinput" style="width:170px">
<option value="G">-- <?echo sEscribir("Guztiak");?> --</option>
<option value="0" <?if ($intTaldeKodea=="0"){?>selected<?}?>> <?echo strtoupper(sEscribir("Orokorrak"));?> </option><?
$strSelect=fSQLTaldeZerrenda();
$objrowII=EJECUTA_SELECT($strSelect);
while($rowII=mysql_fetch_assoc($objrowII)){
$intTalde = $rowII["t660_kodea"];
$strTaldea = $rowII["t660_izena"];?>
<option value="<?echo $intTalde;?>" <?if($intTalde==$intTaldeKodea){?>selected<?}?>><?echo $strTaldea;?></option><?
}?>
</select>
</td>
<td class="textom"><?echo strtolower(sEscribir("Data"));?>&nbsp;<input class="textoinput" type="text" name="txtData" id="txtData" size="6" maxlength="10" value="<?echo $strData;?>">&nbsp;<span class="textop"><i><?echo sEscribir("UUUUHHEEFormatuan");?></i></span></td>
</tr></table>
</td>
</tr>
</table>
<?sPintarBuscadorFin($strSustraia);?>
</center>
</form>
</td></tr></table>
<?}?>
<div name="divSala" id="divSala" style="height:350px;width:590px;overflow:auto">
<table border="0" width="95%" align="center" cellpadding="0" cellspacing="0">
<tr><td colspan=4 height=20></td></tr>
<tr><td colspan=4 class=textogn>
<table cellpadding=0 width=100% cellspacing=0 border=0>
<tr>
<td width="150" class="textogn"><?echo sEscribir("UltimasNoticias");?></font></td>
<td width="500">
<table>
<tr><?sGeziakPintatu("../",$strPos,$intLerroTotala,$intLerroak,$strLink,0);?></tr>
</table>
</td>
</tr>
</table>
</td></tr>
<tr><td colspan=4 height=5></td></tr>
<tr><td colspan=4 class=textom><?echo sEscribir("Texto_ListadoNoticias");?></td></tr>
<tr><td colspan=4 height=5></td></tr>
<?if (mysql_num_rows($objrow)!=0){?>
<tr><td height=5></td></tr>
<?$row=mysql_data_seek($objrow,$strPos-1);
$i=0;
$cont=0;
while ($row=mysql_fetch_assoc($objrow)){
if ($cont<$intLerroak){
$strIrudia=$row["t759_foto"];
$strTituluBerri=$row["t759_titulo"];
$strLead=$row["t759_lead"];
$strData=$row["t759_fecha"];
$intKodea=$row["t759_codigo"];?>
<tr><td class=textogn2><font color=#FFCC00><a href="index.php?pg=1&idb=<?echo $intKodea;?>"><?echo fMarkatu($strTituluBerri,$strTitulua,"#ff5133");?></a>&nbsp; <font class="textom">(<?echo sObtenerFechaVer($strData);?>)&nbsp;</font></td></tr>
<tr><td>
<table width="100%" cellpadding="0" cellspacing="0">
<tr><?
if ($strIrudia!="" && 1==0){?>
<td width="100" align="center"><a href="index.php?pg=1&idb=<?echo $intKodea;?>"><img border=0 width="80" height="80" src="<?echo $strSustraia;?>noticias/fotos/t_<?echo $strIrudia;?>"></a></td>
<td width="10"><img width="10" src="<?echo $strSustraia;?>images/px_t.gif"></td>
<td width="1" bgcolor="#ffcc00"><img src="<?echo $strSustraia;?>images/px_t.gif"></td>
<td width="15"><img width="15" src="<?echo $strSustraia;?>images/px_t.gif"></td>
<td width="100%" class="textom" valign="top"><a href="index.php?pg=1&idb=<?echo $intKodea;?>"><?echo fMarkatu(fstrMaximoLargo($strLead,500),$strTitulua,"ff5133");?></a>&nbsp;&nbsp;<a href="index.php?pg=1&idb=<?echo $intKodea;?>"><img border=0 src="<?echo $strSustraia;?>images/ico_mas.gif"></a></td>
<?}else{?>
<td width="100%" class="textom"><a href="index.php?pg=1&idb=<?echo $intKodea;?>"><?echo fMarkatu(fstrMaximoLargo($strLead,500),$strTitulua,"ff5133");?></a>&nbsp;&nbsp;<a href="index.php?pg=1&idb=<?echo $intKodea;?>"><img border=0 src="<?echo $strSustraia;?>images/ico_mas.gif"></a></td><?
}?>
</tr>
</table>
</td></tr>
<tr><td class=textomn>&nbsp;</td></tr>
<tr><td class=textomn bgcolor="FFFFFF" height=1></td></tr>
<tr><td class=textomn>&nbsp;</td></tr>
<?
$i++;
}
$cont = $cont +1;
}
}else{?>
<tr><td align=center height=50 valign=middle class=textomn><?echo sEscribir("NoHayNoticias");?></td></tr>
<?}?>
</table>
</div>
<?CierraConexion();
}
function fBerriaIkusi()
{	$strSustraia="../";
AbreConexion();
if(isset($_GET["inprimatu"])){$intInprimatu=1;}else{$intInprimatu=0;}
if(isset($_GET["historikoa"])){$intHistorikoa=1;}else{$intHistorikoa=0;}
if (isset($_GET["idb"]))
{	$intErregistroa=$_GET["idb"];
}
else
{	$intErregistroa=0;
}
$strSelect = fSQLBerriarenDatuak($intErregistroa);
$objrow=EJECUTA_SELECT($strSelect);
if(mysql_num_rows($objrow)!=0){
$row=mysql_fetch_assoc($objrow);
$intKodea = $row["t759_codigo"];
$strTitulua = $row["t759_titulo"];
$strTitulua = VisualizarWeb ($strTitulua,$strSustraia);
$strLead = $row["t759_lead"];
$strLead = VisualizarWeb ($strLead,$strSustraia);
$strTextua = $row["t759_texto"];
$strTextua = VisualizarWeb ($strTextua,$strSustraia);
$strSinadura = $row["t759_firma"];
$strIrudia = $row["t759_foto"];
$strOina = $row["t759_pie"];
$strData = $row["t759_fecha"];
$strData = sObtenerFechaVer ($strData);
if ($intInprimatu != "1"){?>
<div name="divSala" id="divSala" style="position: relative;height: 350px;width: 600px;overflow: auto;text-align: center;">
<?}?>
<table border=0 width=95% cellpadding=0 cellspacing=0 <?if ($intInprimatu == "1"){?>align=center<?}?>>
<?if($intInprimatu!=1){?>
<tr><td colspan=5 height=10></td></tr>
<tr><td class=textop colspan=5 align=right>
<table cellpadding=0 cellspacing=0 border=0>
<tr>
<td><a href="javascript:ventana('index.php?pg=1&idb=<?echo $intKodea;?>&inprimatu=1',450,600,'yes','Noticia');"><img border=0 src="<?echo $strSustraia;?>images/ico_imprimir.gif"></a></td>
<td class=textom>&nbsp;<a href="javascript:ventana('index.php?pg=1&idb=<?echo $intKodea;?>&inprimatu=1',450,600,'yes','Noticia');"><?echo sEscribir("ImprimirNoticia");?></a> &nbsp;|&nbsp;</td>
</tr>
</table>
</td></tr>
<?}?>
<tr><td height=10></td></tr>
<tr><td class=textogn><?echo $strTitulua;?></td></tr>
<tr><td height=10></td></tr>
<tr><td class=textomn><?echo $strLead;?></td></tr>
<tr><td height=10></td></tr>
<tr><td class=textomj valign=top>
<?if ($strIrudia != ""){?>
<table width=10% border=0 align=left cellpadding=0 cellspacing="0">
<tr>
<?$intWidth=fDimensionesImagen($strIrudia,$strSustraia."noticias/fotos/",230,0);?>
<td align=right><img border="0" src="<?echo $strSustraia;?>noticias/fotos/<?echo $strIrudia;?>" width="<?echo $intWidth;?>"></td>
<td width=10 rowspan=2><img src="<?echo $strSustraia;?>images/px_t.gif" width=10></td>
<td width=1 rowspan=2 bgcolor=ffcc00><img src="<?echo $strSustraia;?>images/px_t.gif" width=1></td></td>
<td width=15 rowspan=2><img src="<?echo $strSustraia;?>images/px_t.gif" width=15></td>
</tr>
<tr><td class="textop" align=center><i><?echo $strOina;?></i></td></tr>
</table>
<?}
echo $strTextua;?>
</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom align=right><i><?echo $strData;?></i></td></tr>
<tr><td class=textomn align=right><i><?echo $strSinadura;?></i></td></tr>
<?if($intInprimatu!=1){?>
<tr><td align="left"><?Boton ($strSustraia,"javascript:history.back();",sEscribir("Volver"),sEscribir("Volver"),0,1);?></td></tr>
<tr><td align="right">&nbsp;</td></tr>
<?}?>
</table>
<?if ($intInprimatu != "1"){?>
</div>
<?}
}else{?>
<script>
alert("<?echo sEscribir("EzDaBerriaAurkitu");?>");
history.back();
</script>
<?}
CierraConexion();
}
function sBerriaBidali (){
$strSustraia = "../";
if (isset($_GET["BerriKodea"])){
$intBerriKodea = $_GET["BerriKodea"];
AbreConexion();
$strSelect = fSQLBerriarenDatuak ($intBerriKodea);
$objrow = EJECUTA_SELECT($strSelect);
if(mysql_num_rows($objrow)!=0){
$row=mysql_fetch_assoc($objrow);
$strBerria = $row["t759_titulo"];?>
<table width=100% height=100% align=center>
<tr><td valign=top>
<?$strModulua = "Berri";
$strAction ="index.php?pg=3&BerriKodea=".$intBerriKodea;
fFormularioPintatu($strSustraia,$strBerria,$strModulua,$strAction);?>
</td></tr>
</table>
<?}else{?>
<script>window.close ();</script>
<?}
CierraConexion();
}else{?>
<script>window.close ();</script>
<?}
}
function sEmailBidali (){
$strSustraia = "../";
$strIgorle = $_POST["txtEmail"];
$strIzena = $_POST["txtIzena"];
$strHartzaile = $_POST["txtEmail2"];
$strIzena2 = $_POST["txtIzena2"];
$strMezua = $_POST["txtMezua"];
if(isset($_POST["chkKopia"])){$strKopia = $strIgorle;}else{$strKopia="";}
if (isset($_GET["BerriKodea"])){
$intBerriKodea = $_GET["BerriKodea"];
AbreConexion();
$strSelect = fSQLBerriarenDatuak ($intBerriKodea);
$objrow=EJECUTA_SELECT($strSelect);
if(mysql_num_rows($objrow)!=0){
$strBody = "";
$strBody = "<html><head><LINK rel=stylesheet type=text/css href=".fDameRuta("A_Sustraia")."agenda/agenda.css><LINK rel=stylesheet type=text/css href=".fDameRuta("A_Sustraia")."estilos.css><title>..:: EPS Boletina ::..</title></head><body>".
"<table border=0 width=670 align=center cellpadding=0 cellspacing=0>".
"<tr><td class=textom>&nbsp;</td></tr>".
"<tr><td class=textom>". $strMezua . "</td></tr>".
"<tr><td class=textom>&nbsp;</td></tr>".
"</table>".
"<table border=0 class=tabla2 width=670 align=center cellpadding=0 cellspacing=0>".
"<tr><td><img src=".fDameRuta("A_Sustraia")."images/cabecera_boletina2.jpg></td></tr>".
"<tr><td class=textom>";
$row=mysql_fetch_assoc($objrow);
$intKodea = $row["t759_codigo"];
$strTitulua = $row["t759_titulo"];
$strTitulua = VisualizarWeb ($strTitulua,$strSustraia);
$strLead = $row["t759_lead"];
$strLead = VisualizarWeb ($strLead,$strSustraia);
$strTextua = $row["t759_texto"];
$strTextua = VisualizarWeb ($strTextua,$strSustraia);
$strSinadura = $row["t759_firma"];
$strIrudia = $row["t759_foto"];
$strOina = $row["t759_pie"];
$strData = $row["t759_fecha"];
$strData = sObtenerFechaVer ($strData);
$strTaldea = $row["t660_izena"];
$strBody = $strBody . "<table border=0 width=95% align=center cellpadding=0 cellspacing=0>".
"<tr><td class=textogn>".$strTitulua."</td></tr>".
"<tr><td height=10></td></tr>".
"<tr><td class=textomn>".$strLead."</td></tr>".
"<tr><td height=10></td></tr>".
"<tr><td class=textomj valign=top>";
if ($strIrudia != ""){
$strBody = $strBody . "<table width=10% border=0 align=left cellpadding=0 cellspacing=0>".
"<tr>".
"<td align=right><img border=0 src=".fDameRuta("A_Sustraia")."noticias/fotos/".$strIrudia."></td>".
"<td width=10 rowspan=2><img src=".fDameRuta("A_Sustraia")."images/px_t.gif width=10></td>".
"<td width=1 rowspan=2 bgcolor=ffcc00><img src=".fDameRuta("A_Sustraia")."images/px_t.gif width=1></td></td>".
"<td width=15 rowspan=2><img src=".fDameRuta("A_Sustraia")."images/px_t.gif width=15></td>".
"</tr>".
"<tr><td class=textop align=center><i>".$strOina."</i></td></tr>".
"</table>";
}
$strBody = $strBody . $strTextua . "</td></tr>".
"<tr><td height=10></td></tr>".
"<tr><td class=textom align=right><i>".$strData."</i></td></tr>".
"<tr><td class=textomn align=right><i>".$strSinadura."</i></td></tr>".
"<tr><td class=textomn align=right>".$strTaldea."</td></tr></table>".
"</td></tr></table>".
"<br><table width=670 align=center><tr><td class=textom>".sEscribir("GehiagoIkustekoBerriak")."</td></tr></table>".
"</body></html>";
$strError = fEnviarCorreo ($strHartzaile,$strIzena2,sEscribir("ZureLagunBatekBerria"),$strIgorle,$strIzena,$strKopia,$strBody);
}
CierraConexion();
}?>
<script>window.close ();</script>
<?}
function sBerriHistorikoak (){
$strSustraia = "../";
if(isset($_GET["pag"])){$strPos=$_GET["pag"];}else{$strPos=1;}
if(isset($_GET["hdnBilatu"])){$intBilatu = 1;}else{$intBilatu=0;}
if(isset($_GET["txtHasieraData"])){$strHasieraData = $_GET["txtHasieraData"];}else{$strHasieraData="";}
if(isset($_GET["txtBukaeraData"])){$strBukaeraData = $_GET["txtBukaeraData"];}else{$strBukaeraData="";}
if(isset($_GET["txtTextua"])){$strTextua = $_GET["txtTextua"];}else{$strTextua="";}
if(isset($_GET["cboTaldea"])){$intTaldeKodea = $_GET["cboTaldea"];}else{$intTaldeKodea="G";}
AbreConexion();
$strHistorikoa = "<a href='index.php'>".sEscribir("Berriak")."</a>";?>
<table width=100% cellpadding=0 cellspacing=0><tr><td align=center>
<form name="frmBuscar" id="frmBuscar" method="get" action="index.php">
<input type="hidden" name="pg" id="pg" value="4">
<input type="hidden" name="hdnBilatu" id="hdnBilatu" value="1">
<?sPintarBuscadorInicio($strSustraia,sEscribir("BerriHistorikoBilatzailea"));?>
<table border="0" align="center" cellspacing="0">
<tr>
<td class="textom"><?echo strtolower(sEscribir("Taldea"));?>&nbsp;</td>
<td>
<select name="cboTaldea" id="cboTaldea" class="textoinput" style="width:170px">
<option value="G">-- <?echo sEscribir("Guztiak");?> --</option>
<option value="0" <?if ($intTaldeKodea=="0"){?>selected<?}?>> <?echo strtoupper(sEscribir("Orokorrak"));?> </option>
<?$strSelect = fSQLTaldeZerrenda ();
$objrowII=EJECUTA_SELECT($strSelect);
while($rowII=mysql_fetch_assoc($objrowII)){
$intTalde = $rowII["t660_kodea"];
$strTaldea = $rowII["t660_izena"];?>
<option value="<?echo $intTalde;?>" <?if($intTalde==$intTaldeKodea){?>selected<?}?>><?echo $strTaldea;?></option>
<?}?>
</select>
</td>
<td class="textom" width="5%"><?echo strtolower(sEscribir("Textua"));?>&nbsp;</td>
<td><input class="textoinput" type="text" name="txtTextua" id="txtTextua" size="30" value="<?echo $strTextua;?>"></td>
<td><?Boton ($strSustraia,"javascript:fHistorikoBilatzaileaGarbitu();",sEscribir("Garbitu"),sEscribir("Garbitu"),0,1);?></td>
</tr>
<tr>
<td class="textom" colspan=2><?echo strtolower(sEscribir("HasieraData"));?>&nbsp;<input class="textoinput" type="text" name="txtHasieraData" id="txtHasieraData" size="6" maxlength="10" value="<?echo $strHasieraData;?>">&nbsp;&nbsp;&nbsp;<?echo strtolower(sEscribir("BukaeraData"));?>&nbsp;</td>
<td class="textom" colspan=2><input class="textoinput" type="text" name="txtBukaeraData" id="txtBukaeraData" size="6" maxlength="10" value="<?echo $strBukaeraData;?>">&nbsp;<font class="textop"><?echo sEscribir("UUUUHHEEFormatuan");?></font></td>
<td><?Boton ($strSustraia,"javascript:fHistorikoBilatzaileaBalidatu();",sEscribir("Bilatu"),sEscribir("Bilatu"),0,1);?></td>
</tr>
</table>
<?sPintarBuscadorFin($strSustraia,1);?>
</form>
</td></tr></table>
<?if ($intBilatu == 1){?>
<table width=95% cellpadding=0 cellspacing=0 align=center>
<?if ($strTextua=="" && $intTaldeKodea=="G" && $strHasieraData=="" && $strBukaeraData==""){$intBilakera = 0;}else{$intBilakera = 1;}
$strHasieraDataB = $strHasieraData;
$strBukaeraDataB = $strBukaeraData;
$strSelect=fSQLBerriHistorikoakBilatu($strTextua,$intTaldeKodea,$strHasieraDataB,$strBukaeraDataB);
$objrow=EJECUTA_SELECT($strSelect);
$intLerroTotala=mysql_num_rows($objrow);
if (intval($intLerroTotala)<intval($strPos)){
$strPos=1;
}
$intLerroak=fDameRuta("L_BerriHist");
$strLink="index.php?pg=5&txtTextua=".$strTextua."&txtHasieraData=".$strHasieraData."&txtBukaeraData=".$strBukaeraData."&cboTaldea=".$intTaldeKodea;
if (mysql_num_rows($objrow)!=0){?>
<tr>
<td width=1%></td>
<td width=65% class=textomn><i><?echo strtolower(sEscribir("Titulua"));?></i></td>
<td width=20% class=textomn><i><?echo strtolower(sEscribir("Taldea"));?></i></td>
<td width=15% class=textomn align=right><i><?echo strtolower(sEscribir("Data"));?></i></td>
<td width=1%></td>
</tr>
<tr><td colspan=4 height=1 bgcolor=716f6e></td></tr>
<?$row=mysql_data_seek($objrow,$strPos-1);
$j=0;
$intKolumnak = 5;
$strColorOut = "#FFFFFF";
$strColorOver = "#F2F2F2";
$cont=0;
while ($row=mysql_fetch_assoc($objrow)){
if ($cont<=$intLerroak){
$j=$j+1;
$intBerriKodea = $row["t759_codigo"];
$strTitulua = $row["t759_titulo"];
$strData = $row["t759_fecha"];
$strTaldea = $row["t660_izena"];
$strData = sObtenerFechaVer ($strData);
$strLink = "javascript:location.href='index.php?pg=1&historikoa=1&idb=".$intBerriKodea."'";?>
<tr>
<td height=20 class="textom" name="fila1_<?echo $j;?>" id="fila1_<?echo $j;?>" onMouseOver="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOver;?>');this.style.cursor='hand'" onMouseOut="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOut;?>');" onClick="<?echo $strLink;?>">&nbsp;</td>
<td class="textom" name="fila2_<?echo $j;?>" id="fila2_<?echo $j;?>" onMouseOver="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOver;?>');this.style.cursor='hand'" onMouseOut="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOut;?>');" onClick="<?echo $strLink;?>"><i><img src="<?echo $strSustraia;?>images/px_rojo.gif" width=5 height=5>&nbsp;&nbsp;<?echo fMarkatu($strTitulua,$strTextua,"ff5133");?></i></td>
<td class="textom" name="fila3_<?echo $j;?>" id="fila3_<?echo $j;?>" onMouseOver="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOver;?>');this.style.cursor='hand'" onMouseOut="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOut;?>');" onClick="<?echo $strLink;?>" valign=top><i><?echo $strTaldea;?></i></td>
<td class="textom" name="fila4_<?echo $j;?>" id="fila4_<?echo $j;?>" onMouseOver="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOver;?>');this.style.cursor='hand'" onMouseOut="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOut;?>');" onClick="<?echo $strLink;?>" align=right valign=top><i><?echo $strData;?></i></td>
<td class="textom" name="fila5_<?echo $j;?>" id="fila5_<?echo $j;?>" onMouseOver="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOver;?>');this.style.cursor='hand'" onMouseOut="fCambiarFilaColor('<?echo $j;?>','<?echo $intKolumnak;?>','<?echo $strColorOut;?>');" onClick="<?echo $strLink;?>">&nbsp;</td>
</tr>
<?}
$cont = $cont + 1;
}
}else{?>
<tr><td align=center height=50 valign=middle class=textomn><?echo sEscribir("NoHayNoticias");?></td></tr>
<?}?>
</table>
<?}
}
function sDataPintatu($intcboDia,$intcboMes,$intcboAnho,$intTipo) {
if ($intTipo == "1"){?>
<span id="contenidoIE2">
<script language="javascript">cambia_dias('cboDia','contenidoIE2','<?echo intval($intcboMes);?>','cboMes','cboAnho','<?echo intval($intcboDia);?>')</script>
</span>
<script language="javascript">
muestrameses(<?echo intval($intcboMes);?>,'cboMes','cboDia','contenidoIE2','cboAnho');
muestraanhos('cboAnho','<?echo $intcboAnho;?>','cboMes','cboDia','contenidoIE2');
</script>
<?
}elseif ($intTipo == "2"){?>
<span id="contenidoIE2">
<script language="javascript">cambia_dias('cboDia','contenidoIE2','<?echo intval($intcboMes);?>','cboMes','cboAnho','<?echo intval($intcboDia);?>')</script>
</span>
<script language="javascript">
muestrameses(<?echo intval($intcboMes);?>,'cboMes','cboDia','contenidoIE2','cboAnho');
muestraanhos2('cboAnho','<?echo $intcboAnho;?>','cboMes','cboDia','contenidoIE2',2004);
</script>
<?}elseif ($intTipo == "3"){?>
<span id="contenidoIE">
<script language="javascript">cambia_dias('cboDia2','contenidoIE','<?echo intval($intcboMes);?>','cboMes2','cboAnho2','<?echo intval($intcboDia);?>')</script>
</span>
<script language="javascript">
muestrameses(<?echo intval($intcboMes);?>,'cboMes2','cboDia2','contenidoIE','cboAnho2');		
muestraanhos2('cboAnho2','<?echo $intcboAnho;?>','cboMes2','cboDia2','contenidoIE',2004);
</script>
<?}
}?>
