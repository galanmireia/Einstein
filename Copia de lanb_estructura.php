<?functionsEstructuraInicio (){?>
<table valign=top align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td align=center>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="616" height="448" id="ShockwaveFlash1" VIEWASTEXT>
<param name="movie" value="swf/index.swf">
<param name="quality" value="high">
<param name="menu" value="false">
<embed src="swf/index.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%"></embed ></object>
</td></tr>
<tr><td height=5></td></tr>
<tr><td height=5 class=textom3 align=right><a onmouseOver="this.style.cursor='hand';" onClick="location.href='index.php?pg=22';">Skip Intro</a></td></tr>
</table>
<?}
function sGeziakPintatu($strSustraia,$intRegAct,$intCuantos,$intRegxPag,$istrLink,$intAncho){
$intAnchoCentral=0;
if ($intAncho==0){
$intAncho=30;
$intAnchoCentral=0;
}
$intTotalAncho=$intAncho*4+$intAnchoCentral;
if ($intCuantos<$intRegAct+$intRegxPag-1){
$intUltimo=$intCuantos;
}else{
$intUltimo=$intRegAct+$intRegxPag-1;
}?>
<table border="0" cellpadding="0" cellspacing="0" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<tr>
<?if (intval($intRegAct)>intval($intRegxPag)){?>
<td class="textomi" width="<?echo $intAncho;?>" align="center"><a href="<?echo $istrLink;?>&amp;pag=1"><img src="<?echo $strSustraia;?>images/ico_inicio.gif" border="0"></a></td>
<?}else{?>
<td class="textomi" width="<?echo $intAncho;?>" align="center">&nbsp;</td>
<?}
if (intval($intRegAct)>intval($intRegxPag)){?>
<td class="textomi" width="<?echo $intAncho;?>" align="center"><a href="<?echo $istrLink;?>&amp;pag=<?echo intval($intRegAct)-intval($intRegxPag);?>"><img src="<?echo $strSustraia;?>images/ico_atras.gif" border="0"></a></td>
<?}else{?>
<td class="textomi" width="<?echo $intAncho;?>" align="center">&nbsp;</td>
<?}
if (intval($intRegAct)<>intval($intUltimo)){
$strCentro=$intRegAct . "-" . $intUltimo;
}else{
$strCentro=$intRegAct;
}?>
<td class="textom" width="<?echo $intAnchoCentral;?>" align="center"> <font class=textoprojo><b>[</b></font> <i>Visualizando</i>: <font class=textog><?echo  $strCentro . "</font> (<b><i>" . $intCuantos. " en total</b>)";?></i> <font class=textoprojo><b>]</b></font> </td>
<?if ((intval(intval($intCuantos)/intval($intRegxPag))>intval(intval($intRegAct)/intval($intRegxPag))) && $intCuantos >= ($intRegxPag + $intRegAct)){?>
<td class="textomi" width="<?echo $intAncho;?>" align="center"><a href="<?echo $istrLink;?>&pag=<?echo $intRegAct+$intRegxPag;?>"><img src="<?echo $strSustraia;?>images/ico_alante.gif" border="0"></a></td>
<?}
if (intval($intCuantos/$intRegxPag)>intval($intRegAct/$intRegxPag) && $intCuantos >= ($intRegxPag + $intRegAct)){?>
<td class="textomi" width="<?echo $intAncho;?>" align="center"><a href="<?echo $istrLink;?>&pag=<?echo (intval($intCuantos/$intRegxPag)*$intRegxPag)+1;?>"><img src="<?echo $strSustraia;?>images/ico_final.gif" border="0"></a></td>
<?}?>
</tr>
</table>
<?}
function Boton($strRaiz,$strUrl,$strTextoBotoi,$strAltBotoi,$intAncho,$intTipo){
$strLehenengoak = substr($strUrl,0,21);
switch ($intTipo){
case "1":
case "2":
case "3":
case "4":
$intAncho1=7;
$intAncho2=8;
$intAlto=19;
break;
default:
$intAncho1=7;
$intAncho2=8;
$intAlto=19;
break;
}?>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td><img src="<?echo $strRaiz;?>images/btn_izd<?echo $intTipo;?>.gif" height="<?echo $intAlto;?>" width="<?echo $intAncho1;?>"></td>
<td background="<?echo $strRaiz;?>images/btn_cen<?echo $intTipo;?>.gif" class="boton<?echo $intTipo;?>" width="<?echo $intAncho;?>">&nbsp;</td>
<td background="<?echo $strRaiz;?>images/btn_cen<?echo $intTipo;?>.gif" class="boton<?echo $intTipo;?>" valign="middle" height="<?echo $intAlto;?>">
<?if ($strLehenengoak == "javascript:window.open"){?>
<a href="#" onClick="<?echo $strUrl;?>" title="<?echo $strAltBotoi;?>">&nbsp;<?echo strtolower($strTextoBotoi);?>&nbsp;</a>
<?}else{?>
<a href="<?echo $strUrl;?>" title="<?echo $strAltBotoi;?>">&nbsp;<?echo strtolower($strTextoBotoi);?>&nbsp;</a>
<?}?>
</td>
<td background="<?echo $strRaiz;?>images/btn_cen<?echo $intTipo;?>.gif" class="boton<?echo $intTipo;?>" width="<?echo $intAncho;?>">&nbsp;</td>
<td><img src="<?echo $strRaiz;?>images/btn_dch<?echo $intTipo;?>.gif" height="<?echo $intAlto;?>" width="<?echo $intAncho2;?>"></td>
</tr>
</table>
<?}
function sEstructuraPrincipal (){
if(isset($_GET["opcion"])){$intOpcion=$_GET["opcion"];}else{$intOpcion="";}?>
<table align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td bgcolor="#FFFFFF" width="100%" height="100%" valign="middle">
<table valign="middle" bgcolor="#737886" align="center" width="796" height="448" CELLPADDING="0" CELLSPACING="1" topmargin="0" leftmargin="0" border="0">
<tr><td bgcolor="#FFFFFF" width="100%" height="100%" valign="top">
<table border=0 border="0" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0">
<tr><td height="65" colspan="2">
<iframe src="index.php?pg=6" width="796" height="65" name="einstein_cabecera" id="einstein_cabecera" frameborder="0" marginwidth="0" marginheight="0"></iframe>
</td></tr>
<!--<tr><td width="794" height="23" colspan="2"><iframe src="index.php?pg=5" width="794" height="23" name="einstein_subcabecera" id="einstein_subcabecera" frameborder="0" marginwidth="0" marginheight="0"></iframe></td></tr>-->
<tr><td width="794" height="23" colspan="2"><?sSubCabecera();?></td></tr>
<!--<tr>
<td bgcolor="000000">&nbsp;</td>
<td bgcolor="D9E4EA">&nbsp;</td>
</tr>-->
<tr>
<td height="350" width="120" rowspan=2><iframe src="index.php?pg=2&opcion=<?echo $intOpcion;?>" width="120" height="360" name="einstein_menu" id="einstein_menu" frameborder="0" marginwidth="0" marginheight="0" scrolling=no></iframe></td>
<td height="320" width="676" valign="top">
<iframe src="index.php?pg=4&opcion=<?echo $intOpcion;?>" width="676" height="320" name="einstein_contenido" id="einstein_contenido" frameborder="0" marginwidth="0" marginheight="0"></iframe>
</td>
</tr>
<tr><td width="676" height="40"><?sPie();?></td></tr>
</table>
</td></tr>
</table>
</td></tr>
</table>
<?}
function sMenu (){
$intOpcion = $_GET["opcion"];?>
<table bgcolor="000000" valign="top" width="100%" height="100%" CELLPADDING="1" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td colspan=3>&nbsp;</td></tr>
<tr>
<td rowspan="25" width=8"></td>
<td class="textomn<?if ($intOpcion == "2" || $intOpcion == "8" || $intOpcion == "9" || $intOpcion == "10" || $intOpcion == "11" || $intOpcion == "21"){?>a<?}else{?>b<?}?>"><a href="index.php?pg=2&opcion=2" onclick="window.open('index.php?pg=4&opcion=2','einstein_contenido');"><?echo strtoupper(sEscribir("InformacionGeneral"));?></a></td>
</tr>
<?if ($intOpcion == "2" || $intOpcion == "8" || $intOpcion == "9" || $intOpcion == "10" || $intOpcion == "11" || $intOpcion == "21"){?>
<tr><td class="textom<?if ($intOpcion == "2"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=2" onclick="window.open('index.php?pg=4&opcion=2','einstein_contenido');"><?echo sEscribir("Presentacion");?></a></td></tr>
<!--<tr><td class="textom<?if ($intOpcion == "8"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=8" onclick="window.open('index.php?pg=4&opcion=8','einstein_contenido');"><?echo sEscribir("EventosParalelos");?></a></td></tr>-->
<tr><td class="textom<?if ($intOpcion == "9"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=9" onclick="window.open('index.php?pg=4&opcion=9','einstein_contenido');"><?echo sEscribir("Kutxaespacio");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "10"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=10" onclick="window.open('index.php?pg=4&opcion=10','einstein_contenido');"><?echo sEscribir("ComoLlegarASanSebastian");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "21"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=21" onclick="window.open('index.php?pg=4&opcion=21','einstein_contenido');"><?echo sEscribir("LaCiudad");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "11"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=11" onclick="window.open('index.php?pg=4&opcion=11','einstein_contenido');"><?echo sEscribir("ElPaisVasco");?></a></td></tr>
<?}?>
<tr><td class="textomn<?if ($intOpcion == "1" || $intOpcion == "6" || $intOpcion == "7" || $intOpcion == "18" || $intOpcion == "19" || $intOpcion == "20" || $intOpcion == "26"){?>a<?}else{?>b<?}?>"><a href="index.php?pg=2&opcion=20" onclick="window.open('index.php?pg=4&opcion=20','einstein_contenido');"><?echo strtoupper(sEscribir("Programa"));?></a></td></tr>
<?if ($intOpcion == "1" || $intOpcion == "6" || $intOpcion == "7" || $intOpcion == "18" || $intOpcion == "19"|| $intOpcion == "20" || $intOpcion == "26"){?>
<tr><td class="textom<?if ($intOpcion == "20"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=20" onclick="window.open('index.php?pg=4&opcion=20','einstein_contenido');"><?echo sEscribir("Introduccion");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "26"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=26" onclick="window.open('index.php?pg=4&opcion=26','einstein_contenido');"><?echo sEscribir("5Septiembre");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "1"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=1" onclick="window.open('index.php?pg=4&opcion=1','einstein_contenido');"><?echo sEscribir("6Septiembre");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "18"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=18" onclick="window.open('index.php?pg=4&opcion=18','einstein_contenido');"><?echo sEscribir("7Septiembre");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "19"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=19" onclick="window.open('index.php?pg=4&opcion=19','einstein_contenido');"><?echo sEscribir("8Septiembre");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "6"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=6" onclick="window.open('index.php?pg=4&opcion=6','einstein_contenido');"><?echo sEscribir("Ponentes");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "7"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=7" onclick="window.open('index.php?pg=4&opcion=7','einstein_contenido');"><?echo sEscribir("LaSede");?></a></td></tr>
<?}?>
<!--<tr><td class="textomnb"><a href="javascript:ventana('index.php?pg=14',580,750,'','inscripciones')"><?echo strtoupper(sEscribir("Inscripciones"));?></a></td></tr>-->
<!--<tr><td class="textom2"><b><?echo strtoupper(sEscribir("Inscripciones"));?></b></td></tr>-->
<tr><td class="textomn<?if ($intOpcion == "3" || $intOpcion == "12" || $intOpcion == "13"){?>a<?}else{?>b<?}?>"><a href="index.php?pg=2&opcion=3" onclick="window.open('index.php?pg=4&opcion=3','einstein_contenido');"><?echo strtoupper(sEscribir("Inscripciones"));?></a></td></tr>
<?if ($intOpcion == "3" || $intOpcion == "12" || $intOpcion == "13"){?>
<tr><td class="textom<?if ($intOpcion == "3"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=3" onclick="window.open('index.php?pg=4&opcion=3','einstein_contenido');"><?echo sEscribir("ComoInscribirse");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "12"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=12" onclick="window.open('index.php?pg=4&opcion=12','einstein_contenido');"><?echo sEscribir("Becas");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "13"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=13" onclick="window.open('index.php?pg=4&opcion=13','einstein_contenido');"><?echo sEscribir("Alojamientos");?></a></td></tr>
<?}?>
<tr><td class="textom2"><b><?echo strtoupper(sEscribir("SalaDePrensa"));?></b></td></tr>
<!--<tr><td class="textomn<?if ($intOpcion == "5" || $intOpcion == "22" || $intOpcion == "23" || $intOpcion == "24" || $intOpcion == "25"){?>a<?}else{?>b<?}?>"><a href="index.php?pg=2&opcion=22" onclick="window.open('index.php?pg=4&opcion=22','einstein_contenido');"><?echo strtoupper(sEscribir("SalaDePrensa"));?></a></td></tr>-->
<?if ($intOpcion == "22" || $intOpcion == "23" || $intOpcion == "24" || $intOpcion == "25"){?>
<tr><td class="textom<?if ($intOpcion == "22"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=22" onclick="window.open('index.php?pg=4&opcion=22','einstein_contenido');"><?echo sEscribir("DossierDePrensa");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "23"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=23" onclick="window.open('index.php?pg=4&opcion=23','einstein_contenido');"><?echo sEscribir("UltimasNoticias");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "24"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=24" onclick="window.open('index.php?pg=4&opcion=24','einstein_contenido');"><?echo sEscribir("GaleriaDeImagenes");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "25"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=25" onclick="window.open('index.php?pg=4&opcion=25','einstein_contenido');"><?echo sEscribir("FormularioDeAcreditacion");?></a></td></tr>
<?}?>
<tr><td class="textomn<?if ($intOpcion == "4" || $intOpcion == "14" || $intOpcion == "15" || $intOpcion == "16" || $intOpcion == "17"){?>a<?}else{?>b<?}?>"><a href="index.php?pg=2&opcion=4" onclick="window.open('index.php?pg=4&opcion=4','einstein_contenido');"><?echo strtoupper(sEscribir("AlbertEinstein"));?></a></td></tr>
<?if ($intOpcion == "4" || $intOpcion == "14" || $intOpcion == "15" || $intOpcion == "16" || $intOpcion == "17"){?>
<tr><td class="textom<?if ($intOpcion == "4"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=4" onclick="window.open('index.php?pg=4&opcion=4','einstein_contenido');"><?echo sEscribir("VidayObra");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "14"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=14" onclick="window.open('index.php?pg=4&opcion=14','einstein_contenido');"><?echo sEscribir("LosCincoTrabajosDeEinstein");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "15"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=15" onclick="window.open('index.php?pg=4&opcion=15','einstein_contenido');"><?echo sEscribir("Culminacion");?></a></td></tr>
<tr><td class="textom<?if ($intOpcion == "16"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=16" onclick="window.open('index.php?pg=4&opcion=16','einstein_contenido');"><?echo sEscribir("ImpactoDeLaObra");?></a></td></tr>
<?if($_SESSION["einstein_idioma"]!="uk"){?>
<tr><td class="textom<?if ($intOpcion == "17"){?>n2<?}?>b"><a href="index.php?pg=2&opcion=17" onclick="window.open('index.php?pg=4&opcion=17','einstein_contenido');"><?echo sEscribir("Significado");?></a></td></tr>
<?}?>
<?}?>
<tr><td class="textomnb" height="300"></td></tr>
</table>
<?}
function sPie (){?>
<table valign="top" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td height=17 colspan="10" bgcolor="d9e4ea"></td></tr>
<tr>
<td bgcolor="d9e4ea" class="textomenu" width="150">&nbsp;</td>
<td bgcolor="787165" class="textomenu" onMouseOver="this.style.cursor='hand';" onClick="window.open('index.php?pg=4&opcion=27','einstein_contenido');window.open('index.php?pg=2&opcion=0','einstein_menu');">&nbsp;<?echo sEscribir("ComiteOrganizativo");?>&nbsp;</td>
<td bgcolor="787165" class="textomenu" width="1">|</td>
<td bgcolor="787165" class="textomenu" align="center" onMouseOver="this.style.cursor='hand';" onClick="window.open('index.php?pg=4&opcion=28','einstein_contenido');window.open('index.php?pg=2&opcion=0','einstein_menu');">&nbsp;<?echo sEscribir("Contacto");?>&nbsp;</td>
<td bgcolor="787165" class="textomenu" width="1">|</td>
<td bgcolor="787165" class="textomenu" width="40%" onMouseOver="this.style.cursor='hand';" onClick="fSubirArriba();"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?echo strtoupper(sEscribir("Subir"));?>&nbsp;</b></td>
</tr>
</table>
<?}
function sSubCabecera (){
sPintarJsCapas2();?>
<table valign="top" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr>
<td bgcolor="FFFFFF" width=213><img src="images/titulo.gif"></td>
<td bgcolor="787165" class="textomenu" onclick="window.open('index.php?pg=13','_parent');" onMouseOver="this.style.cursor='hand';">&nbsp;<?echo sEscribir("Home");?>&nbsp;</td>
<td bgcolor="787165" class="textomenu" width="1">|</td>
<!--<td bgcolor="787165" class="textomenu" onMouseOver="javascript:fMenuCabeceraOver('0');this.style.cursor='hand';">&nbsp;<?echo sEscribir("Patrocinadores");?>&nbsp;</td>-->
<td bgcolor="787165" class="textomenu" onMouseOver="javascript:this.style.cursor='hand';" onClick="javascript:window.open('index.php?pg=4&opcion=29','einstein_contenido');">&nbsp;<?echo sEscribir("Patrocinadores");?>&nbsp;</td>
<td bgcolor="787165" class="textomenu" width="1">|</td>
<td bgcolor="787165" class="textomenu" onMouseOver="javascript:this.style.cursor='hand';" onClick="window.open('http://dipc.ehu.es/','_blank');">&nbsp;<?echo sEscribir("DIPC");?>&nbsp;</td>
<td bgcolor="787165" class="textomenu" width="1">|</td>
<td bgcolor="787165" class="textom3">&nbsp;<?echo sEscribir("Links");?>&nbsp;</td>
<td bgcolor="787165" class="textomenu" width="1">|</td>
<td bgcolor="787165" class="textomenu" width="45%" align="right">
<table border=0 CELLPADDING="0" CELLSPACING="0">
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<!--<td class="<?if($_SESSION["einstein_idioma"]=="eu"){?>textomna<?}else{?>textomnb<?}?>"><a href="index.php?pg=10&idioma=eu"><?echo sEscribir("EUSK");?></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
<td class="textom3"><b><?echo sEscribir("EUSK");?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td></td>
<!--<td class="<?if($_SESSION["einstein_idioma"]=="es"){?>textomna<?}else{?>textomnb<?}?>"><a href="index.php?pg=10&idioma=es"><?echo sEscribir("CAST");?></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
<td class="textom3"><b><?echo sEscribir("CAST");?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td></td>
<td class="<?if($_SESSION["einstein_idioma"]=="uk"){?>textomna<?}else{?>textomnb<?}?>"><a href="index.php?pg=10&idioma=uk"><?echo sEscribir("ENGL");?></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
<?}
function sPlanas (){
$intOpcion = $_GET["opcion"];?>
<table border="0" bgcolor="D9E4EA" valign=top align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0">
<tr><td>
<table border="0" valign=top align="center" width="98%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0">
<tr>
<td height=10 colspan=2></td>
<?if ($intOpcion == "1" || $intOpcion == "18" || $intOpcion == "19" || $intOpcion == "26"){ //PROGRAMA
if(isset($_GET["ponente"])){$intPonente = $_GET["ponente"];}else{$intPonente ="";}
if ($intPonente!=""){?>
<td rowspan=2 width="360" valign=top bgcolor="D9E4EA"><iframe src="index.php?pg=7&ponente=<?echo $intPonente;?>" width="360" height="320" name="einstein_ponente" id="einstein_ponente" scrolling=no frameborder="0" marginwidth="0" marginheight="0"></iframe></td>
<?}else{?>
<td rowspan=2 width="360" valign=top bgcolor="D9E4EA"><iframe src="index.php?pg=8" width="360" height="320" name="einstein_ponente" id="einstein_ponente" frameborder="0" marginwidth="0"  scrolling=no marginheight="0"></iframe></td>
<?}?>
<?}?>
</tr>
<tr>
<td width=8>&nbsp;</td>
<a name="#arriba"></a>
<?if ($intOpcion == "1" || $intOpcion == "18" || $intOpcion == "19" || $intOpcion == "26"){ //PROGRAMA?>
<td class="textom" valign=top width="316" height=100%>
<?}else{?>
<td class="textom" valign=top width="94%" height=100%>
<?}
if ($intOpcion == "26"){ fDibujarDia5(); }
elseif ($intOpcion == "1"){ fDibujarDia6(); }
elseif ($intOpcion == "18"){ fDibujarDia7(); }
elseif ($intOpcion == "19"){ fDibujarDia8(); }
elseif ($intOpcion == "6"){ fDibujarPonentes (); }
elseif ($intOpcion == "7"){ fDibujarLaSede(); }
elseif ($intOpcion == "20"){ fDibujarIntroPrograma(); }
elseif ($intOpcion == "2"){ fDibujarIntroduccion(); }
elseif ($intOpcion == "9"){ fDibujarMiramonKutxaEspacio(); }
elseif ($intOpcion == "10"){fDibujarComoLlegarSS(); }
elseif ($intOpcion == "11"){fDibujarPaisVasco(); }
elseif ($intOpcion == "21"){fDibujarLaCiudad(); }
elseif ($intOpcion == "3"){ fDibujarComoInscribirse(); }
elseif ($intOpcion == "12"){ fDibujarBecas(); }
elseif ($intOpcion == "13"){fDibujarAlojamientos(); }
elseif ($intOpcion == "4"){ fDibujarVidaYObra (); }
elseif ($intOpcion == "14"){ fDibujar5Trabajos(); }
elseif ($intOpcion == "15"){ fDibujarCulminacion(); }
elseif ($intOpcion == "16"){ fDibujarImpactoDeLaObra(); }
elseif ($intOpcion == "17"){ fDibujarSignificadoSociedadVasca(); }
elseif ($intOpcion == "27"){ fDibujarComiteOrganizador(); }
elseif ($intOpcion == "28"){ fDibujarContacto(); }
elseif ($intOpcion == "29"){ fDibujarPatrocinadores(); }?>
</td>
</tr>
<?if ($intOpcion != "1" && $intOpcion != "18" && $intOpcion != "19" && $intOpcion != "26"){?>
<tr><td class="textom">&nbsp;</td></tr>
<?}?>
</table>
</td></tr>
</table>
<?}
function sCabecera (){?>
<table valign=top align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="748" height="65" id="ShockwaveFlash1" VIEWASTEXT>
<param name="movie" value="swf/cabecera.swf">
<param name="quality" value="high">
<param name="menu" value="false">
<embed src="swf/cabecera.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="748" height="65"></embed ></object>
</td></tr>
</table>
<?}
function sPonente (){
$intPonente = $_GET["ponente"];
if(isset($_GET["abstract"])){$intAbstract = $_GET["abstract"];}else{$intAbstract=0;}
if($intPonente == "1"){
$strImagen = "lehn.jpg";
$strPonente = "Jean-Marie Lehn";
}elseif($intPonente == "2"){
$strImagen = "cirac.jpg";
$strPonente = "Ignacio Cirac";
}elseif($intPonente == "3"){
$strImagen = "clifford.jpg";
$strPonente = "Clifford M. Will";
}elseif($intPonente == "4"){
$strImagen = "galindo.jpg";
$strPonente = "Alberto Galindo";
}elseif($intPonente == "5"){
$strImagen = "gerald.jpg";
$strPonente = "Gerald Holton";
}elseif($intPonente == "6"){
$strImagen = "glashow.jpg";
$strPonente = "Sheldon Lee Glashow";
}elseif($intPonente == "7"){
$strImagen = "dudley.jpg";
$strPonente = "Dudley Herschbach";
}elseif($intPonente == "8"){
$strImagen = "hewish.jpg";
$strPonente = "Antony Hewish";
}elseif($intPonente == "9"){
$strImagen = "miller.jpg";
$strPonente = "Arthur I. Miller";
}elseif($intPonente == "10"){
$strImagen = "rebolo.jpg";
$strPonente = "Rafael Rebolo Lopez";
}elseif($intPonente == "11"){
$strImagen = "rohrer.jpg";
$strPonente = "Heinrich Rohrer";
}elseif($intPonente == "12"){
$strImagen = "sanchez.jpg";
$strPonente = "Jose M. Sanchez-Ron";
}elseif($intPonente == "13"){
$strImagen = "stachel.jpg";
$strPonente = "John Jay Stachel";
}elseif($intPonente == "14"){
$strImagen = "cohen.jpg";
$strPonente = "Claude Cohen-Tannoudji";
}elseif($intPonente == "15"){
$strImagen = "yndurain.jpg";
$strPonente = "Francisco Jose Yndurain";
}elseif($intPonente == "16"){
$strImagen = "anton.jpg";
$strPonente = "Anton Zeilinger";
}elseif($intPonente == "17"){
$strImagen = "pascual.jpg";
$strPonente = "PEDRO Pascual";
}elseif($intPonente == "18"){
$strImagen = "flores.jpg";
$strPonente = "FERNANDO Flores";
}?>
<table bgcolor="FFFFFF" border=0 class=tablaa2 valign=top align="center" width="360" height="316" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr>
<?if($intAbstract == 1){?>
<td class=textom2 height=25 width=262>
&nbsp;&nbsp;<a href="index.php?pg=7&ponente=<?echo $intPonente;?>&abstract=0"><b>CURRICULUM</b></a> | <font class=textomna>ABSTRACT</font>
</td>
<?}else{?>
<td class=textom2 height=25 width=262>
&nbsp;&nbsp;<font class=textomna>CURRICULUM</font> | <a href="index.php?pg=7&ponente=<?echo $intPonente;?>&abstract=1"><b>ABSTRACT</b></a>
</td>
<?}?>
<!--<td width=157 class=textomnb><img src="images/px_t.gif" width=157 height=25></td>-->
<td align=right rowspan=2 width=80><img src="images/<?echo $strImagen;?>" width="80" height=110></td>
<td width=18 rowspan=2><img src="images/px_t.gif" width=18 height=25></td>
</tr>
<tr><td height="85" class="textogn" valign=bottom>&nbsp;&nbsp;&nbsp;<b><?echo strtoupper($strPonente);?></b></td></tr>
<tr><td colspan=3 height=10></td></tr>
<tr><td colspan=3 bgcolor="FFFFFF" valign=top><iframe src="index.php?pg=9&ponente=<?echo $intPonente;?>&abstract=<?echo $intAbstract;?>" width="355" height="185" name="einstein_ponente2" id="einstein_ponente2" frameborder="0" marginwidth="0" marginheight="0"></iframe></td></tr>
</table>
<?}
function sDatosPonente (){
$intPonente = $_GET["ponente"];
if(isset($_GET["abstract"])){$intAbstract = $_GET["abstract"];}else{$intAbstract=0;}?>
<table border="0" bgcolor="FFFFFF" valign=top align="center" width="95%" height="100%" CELLPADDING="4" CELLSPACING="0" topmargin="0" leftmargin="0">
<tr><td class=textomj valign=top>
<?if($intPonente == "1"){//****************** LEHN
if($intAbstract == 1){fDibujarAbstractLehn ();}
else{fDibujarCurriculumLehn ();}
}elseif($intPonente == "2"){//*************** CIRAC
if($intAbstract == 1){fDibujarAbstractCirac ();}
else{fDibujarCurriculumCirac ();}
}elseif($intPonente == "3"){//*************** CLIFFORD
if($intAbstract == 1){fDibujarAbstractClifford ();}
else{fDibujarCurriculumClifford ();}
}elseif($intPonente == "4"){//*************** GALINDO
if($intAbstract == 1){fDibujarAbstractGalido ();}
else{fDibujarCurriculumGalindo ();}
}elseif($intPonente == "5"){//*************** GERALD
if($intAbstract == 1){fDibujarAbstractGerald ();}
else{fDibujarCurriculumGerald ();}
}elseif($intPonente == "6"){//*************** SHELDON LEE GLASHOW
if($intAbstract == 1){fDibujarAbstractSheldon ();}
else{fDibujarCurriculumSheldon ();}
}elseif($intPonente == "7"){//*************** DUDLEY HERSCHBACH
if($intAbstract == 1){fDibujarAbstractDudley ();}
else{fDibujarCurriculumDudley ();}
}elseif($intPonente == "8"){//*************** ANTONY HEWISH
if($intAbstract == 1){fDibujarAbstractHewish ();}
else{echo fDibujarCurriculumHewish ();}
}elseif($intPonente == "9"){//*************** ARTHUR I. MILLER
if($intAbstract == 1){fDibujarAbstractMiller ();}
else{fDibujarCurriculumMiller ();}
}elseif($intPonente == "10"){//*************** RAFAEL REBOLO LOPEZ
if($intAbstract == 1){fDibujarAbstractRebolo ();}
else{fDibujarCurriculumRebolo ();}
}elseif($intPonente == "11"){//*************** HEINRICH ROHRER
if($intAbstract == 1){fDibujarAbstractRohrer ();}
else{fDibujarCurriculumRohrer ();}
}elseif($intPonente == "12"){//*************** JOSÉ M. SÁNCHEZ-RON
if($intAbstract == 1){fDibujarAbstractRon ();}
else{fDibujarCurriculumRon ();}
}elseif($intPonente == "13"){//*************** JOHN JAY STACHEL
if($intAbstract == 1){fDibujarAbstractStachel ();}
else{fDibujarCurriculumStachel ();}
}elseif($intPonente == "14"){//*************** CLAUDE COHEN-TANNOUDJI
if($intAbstract == 1){fDibujarAbstractCohen ();}
else{fDibujarCurriculumCohen ();}
}elseif($intPonente == "15"){//*************** FRANCISCO JOSÉ YNDURAIN MUÑOZ
if($intAbstract == 1){fDibujarAbstractYndurain ();}
else{fDibujarCurriculumYndurain();}
}elseif($intPonente == "16"){//*************** ANTON ZEILINGER
if($intAbstract == 1){fDibujarAbstractZeilinger ();}
else{fDibujarCurriculumZeilinger();}
}elseif($intPonente == "17"){//*************** P. PASCUAL ECHENIQUE
if($intAbstract == 1){fDibujarAbstractPascual ();}
else{fDibujarCurriculumPascual();}
}elseif($intPonente == "18"){//*************** F. FLORES
if($intAbstract == 1){fDibujarAbstractFlores ();}
else{fDibujarCurriculumFlores();}
}?>
</td></tr>
</table>
<?}
function sPintarJsCapas2(){?>
<script language="JavaScript">
var offsetx = 10;var offsety = 8;var x = 0;var y = 0;var snow = 0;var sw = 0;var cnt = 0;var dir = 1;var tr = 1; var sw2=1;
var menus=new Array();
var ns4, ie4, ie5, ns6, over, aux_x, aux_y;
<?for ($i=0;$i<=3;$i++){?>
menus[<?echo $i;?>]="<?sPintarHTMLMenu($i);?>";
<?}?>
function initTooltip(){
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
ns6 = (!document.all && document.getElementById)? true:false
if (ie4) {
if (navigator.userAgent.indexOf('MSIE 5')>0 || navigator.userAgent.indexOf('MSIE 6')>0) {ie5 = true;}
else {ie5 = false; }
}else {ie5 = false;}
if (ns4) over = document.overDiv
if (ie4) over = overDiv.style
if (ns6) over = document.getElementById('overDiv').style
}
function nd() {
if ( cnt >= 1 ) { sw = 0 };
if ( sw == 0 && sw2==0) {
sw2=1;
snow=0;
hideObject(over);
}else{cnt++;}
}
function div2(i){
strPintar='<div id=textDiv style=\'position:absolute; top: 17px; left: 5px; clipping: 0px 101px 63px 0px;; width: 120px; height: 53px\'>';
strPintar=strPintar+ menus[i];
strPintar=strPintar+ '</div>';
layerWrite(strPintar);
disp2();
}
function disp2() {
pos=aux_x;
posy=aux_y;
moveTo(over,pos,posy);
if (snow == 0) 	{
if (dir == 2) { moveTo(over,pos,posy);}
if (dir == 1) {	moveTo(over,pos,posy); }
if (dir == 0) { moveTo(over,pos,posy);	}
showObject(over);
snow = 1;
}
}
function layerWrite(txt) {
if (ns4) {
var lyr = document.overDiv.document
lyr.write(txt)
lyr.close()
}
else if (ie4) {document.all["overDiv"].innerHTML = txt}
else if (ns6) {document.getElementById("overDiv").innerHTML = txt}
}
function showObject(obj) {
if (ns4) obj.visibility = "show"
else if (ie4) obj.visibility = "visible"
else if (ns6) obj.visibility = "visible";
}
function hideObject(obj) {
if (ns4) obj.visibility = "hide"
else if (ie4) obj.visibility = "hidden"
else if (ns6) obj.visibility = "hidden";
}
function moveTo(obj,xL,yL) {
obj.left = xL
obj.top = yL
}
</script>
<div id="overDiv" onMouseOver="sw2=1;" onMouseOut="sw2=0;setTimeout('nd();',0);" style="z-index=1; LEFT: 32px; VISIBILITY: hidden; WIDTH: 250px; POSITION: absolute; TOP: 10px; clipping: 0px 50px 50px 0px"></div>
<script language="javascript" type="text/javascript" xml:space="preserve">initTooltip()</script>
<?}
function sPintarHTMLMenu($istrCual){
$strCodigo="";
switch ($istrCual){
case "0":
$strCodigo="<html>".
"<body scroll=no rightmargin=0 bottommargin=0 leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 border=0 align=center valign=top>".
"<table border=0 width=140 height=34 bgcolor=#FFFFFF class=tablaa cellpaddind=0 cellspacing=1>".
"<tr><td bgcolor=#ffffff height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('http://www.ej-gv.net','_blank');>&nbsp;".sEscribir("GobiernoVasco")."</td></tr>".
"<tr><td bgcolor=#ffffff height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('http://www.kutxa.net','_blank');>&nbsp;".sEscribir("Kutxa")."</td></tr>".
"<tr><td bgcolor=#ffffff height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('http://www.ehu.es','_blank');>&nbsp;".sEscribir("UPV")."</td></tr>".
"<tr><td bgcolor=#ffffff height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('http://www.gipuzkoa.net','_blank');>&nbsp;".sEscribir("Diputacion")."</td></tr>".
"<tr><td bgcolor=#ffffff height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('http://www.donostia.org','_blank');>&nbsp;".sEscribir("Ayuntamiento")."</td></tr>".
"</table>".
"</body>".
"</html>";
break;
case "1":
$strCodigo="<html>".
"<body scroll=no rightmargin=0 bottommargin=0 leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 border=0 align=center valign=top>".
"<table onMouseOut=javascript:fMenuCabeceraOut('0'); border=0 width=140 height=34 bgcolor=#FFFFFF class=tablaa cellpaddind=0 cellspacing=1>".
"<tr><td height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('#','einstein_contenido');>&nbsp;DIPC 1</td></tr>".
"<tr><td height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('#','einstein_contenido');>&nbsp;DIPC 2</td></tr>".
"<tr><td height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('#','einstein_contenido');>&nbsp;DIPC 3</td></tr>".
"</table>".
"</body>".
"</html>";
break;
case "2":
$strCodigo="<html>".
"<body scroll=no rightmargin=0 bottommargin=0 leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 border=0 align=center valign=top>".
"<table border=0 width=140 height=34 bgcolor=#FFFFFF class=tablaa cellpaddind=0 cellspacing=1>".
"<tr><td height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('#','einstein_contenido');>&nbsp;Patrocinador 1</td></tr>".
"<tr><td height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('#','einstein_contenido');>&nbsp;Patrocinador 2</td></tr>".
"</table>".
"</body>".
"</html>";
break;
case "3":
$strCodigo="<html>".
"<body scroll=no rightmargin=0 bottommargin=0 leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 border=0 align=center valign=top>".
"<table border=0 bgcolor=FFFFFF width=140 height=34 class=tablaa cellpaddind=0 cellspacing=1>".
"<tr><td height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('#','einstein_contenido');>&nbsp;Comité organizativo 1</td></tr>".
"<tr><td height=17 width=140 align=left class=textom onMouseOut=bgColor='#ffffff'; onMouseOver=bgColor='#FFF5CD';this.style.cursor='hand'; onClick=javascript:window.open('#','einstein_contenido');>&nbsp;Comité organizativo 2</td></tr>".
"</table>".
"</body>".
"</html>";
break;
}
echo $strCodigo;
}
function fFlashFelicitacion (){
if(isset($_GET["idioma"])){$strIdioma=$_GET["idioma"];}else{$strIdioma="es";}?>
<table valign=top align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td align=center>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="600" height="300" id="ShockwaveFlash1" VIEWASTEXT>
<param name="movie" value="swf/f_<?echo $strIdioma;?>.swf">
<param name="quality" value="high">
<param name="menu" value="false">
<embed src="swf/f_<?echo $strIdioma;?>.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="600" height="300"></embed ></object>
</td></tr>
<tr><td height=5></td></tr>
<tr><td height=5 class=textom3 align=right><a onmouseOver="this.style.cursor='hand';" onClick="location.href='index.php';">
<?if ($strIdioma=="es"){?>Volver<?}else{?>Itzuli<?}?>
</a></td></tr>
</table>
<?}
function fFlashHome (){
if(isset($_GET["idioma"])){$_SESSION["einstein_idioma"]=$_GET["idioma"];}
else{
if(!isset($_SESSION["einstein_idioma"])){$_SESSION["einstein_idioma"]="uk";}
}?>
<table valign=top align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td align=center>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="616" height="448" id="ShockwaveFlash1" VIEWASTEXT>
<param name="movie" value="swf/home_<?echo $_SESSION["einstein_idioma"];?>.swf">
<param name="quality" value="high">
<param name="menu" value="false">
<embed src="swf/home_<?echo $_SESSION["einstein_idioma"];?>.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" ></embed ></object>
</td></tr>
<tr><td height=5></td></tr>
<tr><td height=5 class=textom3 align=right><a onmouseOver="this.style.cursor='hand';" onClick="location.href='index.php';">
<< <?echo sEscribir("Volver");?>
</a></td></tr>
</table>
<?}
function fFlashMapa(){?>
<table valign=top align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td align=center>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="593" height="509" id="ShockwaveFlash1" VIEWASTEXT>
<param name="movie" value="swf/mapa.swf">
<param name="quality" value="high">
<param name="menu" value="false">
<embed src="swf/mapa.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="593" height="509"></embed ></object>
</td></tr>
</table>
<?}
function fFormularioInscripciones1 (){?>
<table align="center" width="95%" height=100% CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<form name="frmInscripciones1" id="frmInscripciones1" method=post action="index.php?pg=17">
<tr><td height=10></td></tr>
<tr><td class=textoxln align=center>Albert Einstein Annus Mirabilis</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom align=center>Donostia - San Sebastián</td></tr>
<tr><td class=textom align=center>5-8 Iraila-Septiembre-September</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom align=center>IZENA EMATEKO ORRIA / BOLETÍN DE PRE-INSCRIPCION/ PRE-REGISTRATION FORM</td></tr>
<?AbreConexion ();
$strSelect = fSQLFechaLimiteFormulario (1);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];
CierraConexion();?>
<tr><td class=textom align=center>Gehieneko data: <?echo $strFecha1;?> / Fecha Límite: <?echo $strFecha2;?> / Deadline: <?echo $strFecha3;?></td></tr>
<tr><td height=5></td></tr>
<tr><td height=18 class=textomnb bgcolor="000000">&nbsp;&nbsp;DATU PERTSONALAK / DATOS PERSONALES / PERSONAL DETAILS</td></tr>
<tr><td height=5></td></tr>
<tr><td class=textop>ABIZENA 1-APELLIDO 1-SURNAME 1: <input type="text" class=textoinput style="width:140px" name="txtApellido1" id="txtApellido1" maxlength="100"> &nbsp; ABIZENA 2-APELLIDO 2-SURNAME 2: <input maxlength="100" type="text" class=textoinput style="width:132px" name="txtApellido2" id="txtApellido2"></td></tr>
<tr><td class=textop>IZENA/ NOMBRE/ NAME: <input type="text" class=textoinput size=20 name="txtNombre" id="txtNombre" maxlength="100"> &nbsp; NAN edo Pasaportea / DNI o Pasaporte / N.I.D. or Passport: <input maxlength="10" type="text" class=textoinput style="width:130px" name="txtDNI" id="txtDNI"></td></tr>
<tr><td class=textop>KALEA-CALLE-STREET: <input type="text" class=textoinput style="width:200px" name="txtCalle" id="txtCalle"> &nbsp; ZK / Nº / Nº: <input maxlength="5" type="text" class=textoinput style="width:35px" name="txtNum" id="txtNum"> &nbsp; HIRIA / CIUDAD / CITY: <input maxlength="100" type="text" class=textoinput style="width:113px" name="txtCiudad" id="txtCiudad"></td></tr>
<tr><td class=textop>KP / CP / PC: <input maxlength="7" type="text" class=textoinput style="width:40px" name="txtCP" id="txtCP"> &nbsp; PROBINTZIA / PROVINCIA /PROVINCE: <input maxlength="100" type="text" class=textoinput style="width:85px" name="txtProvincia" id="txtProvincia"> &nbsp; HERRIALDEA / PAIS / COUNTRY: <input maxlength="100" type="text" class=textoinput style="width:84px" name="txtPais" id="txtPais"></td></tr>
<tr><td class=textop>TEL / TF / TEL (*): <input type="text" maxlength="15" class=textoinput style="width:90px" name="txtTelefono" id="txtTelefono"> &nbsp; FAXA / FAX / FAX (*): <input type="text" maxlength="15" class=textoinput style="width:90px" name="txtFax" id="txtFax"></td></tr>
<tr><td height=5></td></tr>
<tr><td height=15></td></tr>
<tr><td height=18 class=textomnb bgcolor="000000">&nbsp;&nbsp;DATU PROFESIONALAK / DATOS PROFESIONALES / PROFESSIONAL DETAILS</td></tr>
<tr><td height=5></td></tr>
<tr><td class=textop>
<font color="#E67B1D">Ez da derrigorrezkoa erakunde bati atxikita egotea. Erakunde bateko partaide bazara bete ezazu atal hori. Zenbait erakundek Kongresuaren Antolakuntzarekin akordio puntualak dituzte jaso daitezkeen beka eta laguntzei dagokionez.</font>
<br><br>
No es obligatorio estar adscrito a una organización. Si pertenece a una organización rellene ese apartado. Algunas organizaciones tienen acuerdos puntuales con la Organización del Congreso,
en lo referente a becas y ayudas.<br><br>
<font color="#009900">It is not compulsory to be attached to an organisation. If you belong to an organisation, fill in this section. Some organisations have specific agreements with the Congress Organisers, concerning
grants and support that can be provided.</font><br><br>
</td></tr>
<tr><td height=5></td></tr>
<tr><td class=textop>ERAKUNDEA EDO ENPRESA / INSTITUCION O EMPRESA / INSTITUTION OR COMPANY: <input type="text" class=textoinput style="width:219px" name="txtEmpresa" id="txtEmpresa" maxlength="100"></td></tr>
<tr><td class=textop>DEPARTAMENTUA EDO ATALA / DPTO. O SECCION / DEPT OR SECTION: <input type="text" class=textoinput style="width:230px" name="txtSeccion" id="txtSeccion" maxlength="100"></td></tr>
<tr><td class=textop>KALEA-CALLE-STREET: <input type="text" class=textoinput style="width:200px" name="txtCalleE" id="txtCalleE" maxlength="100"> &nbsp; ZK / Nº / Nº: <input maxlength="5" type="text" class=textoinput style="width:35px" name="txtNumE" id="txtNumE"> &nbsp; HIRIA / CIUDAD / CITY: <input maxlength="100" type="text" class=textoinput style="width:113px" name="txtCiudadE" id="txtCiudadE"></td></tr>
<tr><td class=textop>KP / CP / PC: <input maxlength="7" type="text" class=textoinput style="width:40px" name="txtCPE" id="txtCPE"> &nbsp; PROBINTZIA / PROVINCIA /PROVINCE: <input maxlength="100" type="text" class=textoinput style="width:84px" name="txtProvinciaE" id="txtProvinciaE"> &nbsp; HERRIALDEA / PAIS / COUNTRY: <input maxlength="100" type="text" class=textoinput style="width:85px" name="txtPaisE" id="txtPaisE"></td></tr>
<tr><td class=textop>TEL / TF / TEL (*): <input type="text" class=textoinput style="width:90px" name="txtTelefonoE" id="txtTelefonoE" maxlength="15"> &nbsp; FAXA / FAX / FAX (*): <input maxlength="15" type="text" class=textoinput style="width:90px" name="txtFaxE" id="txtFaxE"></td></tr>
<tr><td height=5></td></tr>
<tr><td height=5></td></tr>
<tr><td><br>
<table align=center cellpadding=4 bgcolor="#E4E5E5">
<tr>
<td class=textop>HARREMANETARAKO E-MAILA JARRI<br>
INDIQUENOS SU E-MAIL DE CONTACTO<br>
WRITE IN YOUR CONTACT E-MAIL</td>
<td>
<td><input type="text" class=textoinput style="width:200px" name="txtEmail" id="txtEmail"></td>
</tr>
</table><br>
</td></tr>
<tr><td height=5></td></tr>
<tr><td class=textop align=center>ADIERAZI ZEIN EGUNETAN JOANGO ZAREN KONGRESURA/ INDIQUE LOS DIAS QUE QUIERE ASISTIR AL CONGRESO<br>
INDICATE THE DAYS THAT YOU WILL BE ATTENDING THE CONGRESS</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textop align=center>IRAILAK / SEPTIEMBRE / SEPTEMBER</td></tr>
<input type="hidden" name="hdnDias" id="hdnDias">
<tr><td class=textop align=center>5 <input type="checkbox" name="chkDia" id="chkDia" value="5">&nbsp;&nbsp;6 <input type="checkbox" name="chkDia" id="chkDia" value="6">&nbsp;&nbsp;7 <input type="checkbox" name="chkDia" id="chkDia" value="7">&nbsp;&nbsp;8 <input type="checkbox" name="chkDia" id="chkDia" value="8">&nbsp;&nbsp; </td></tr>
<tr><td height=15></td></tr>
<tr><td height=18 class=textomnb bgcolor="000000">&nbsp;&nbsp;BEKA ESKATU NAHI DUZU? / ¿ DESEA SOLICITAR BECA? / DO YOU WANT TO APPLY FOR A GRANT?</td></tr>
<tr><td class=textop bgcolor="EFEFF0">BAI / SI / YES<input type="radio" name="rdbBeca" id="rdbBeca" value="1" onClick="javascript:fVerAlojamiento(0);"> &nbsp;&nbsp; EZ / NO / NO <input type="radio" name="rdbBeca" id="rdbBeca" value="0" checked onClick="javascript:fVerAlojamiento(1);"></td></tr>
<tr><td height=10 bgcolor="EFEFF0"></td></tr>
<tr><td bgcolor="EFEFF0">
<div name="dAlojamiento" id="dAlojamiento">
<table width=100%>
<tr>
<td height=18 class=textomnb bgcolor="000000">
&nbsp;&nbsp;ZURE OSTATU HARTZEKO ERRESERBA ORAIN FORMALIZATU NAHI DUZU?
<br>&nbsp;&nbsp;¿ DESEA FORMALIZAR AHORA LA RESERVA DE SU ALOJAMIENTO ?
<br>&nbsp;&nbsp;DO YOU WANT TO FORMALISE YOUR ACCOMMODATION BOOKING NOW?
</td>
<td width=35% class=textop align=center>
BAI / SI / YES &nbsp;&nbsp; EZ / NO / NO
<br><input type="radio" name="rdbAlojamiento" id="rdbAlojamiento" value="1">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="rdbAlojamiento" id="rdbAlojamiento" value="0" checked>
</td>
</tr>
</table><br><br>
</div>
</td></tr>
<tr><td height=15 bgcolor="EFEFF0"></td></tr>
<tr><td height=18 class=textomnb bgcolor="000000">&nbsp;&nbsp;INFORMAZIOA/ INFORMACION / INFORMATION</td></tr>
<tr><td height=5 bgcolor="EFEFF0"></td></tr>
<tr><td class=textop bgcolor="EFEFF0">
<font color="#E67B1D">Datu Pertsonalak babesteko Lege Organikoaren, abenduaren 13koaren ondorioetarako, interesatuari jakinarazten zaio boluntarioki DIPCari (Donostia International Physics Center) ematen dizkion datuak aipaturiko erakundeak sortu eta mantendutako datu pertsonalen fitxategi batean sartuko direla. Datu-base horretan sartutako datuak bildu diren helbururako bakarrik erabiliko dira. Datu pertsonalen beste edozein erabilerak interesatuaren aurreko eta berariazko baimena beharko du. Azken horrek bere datu pertsonalak zuzendu, bertan behera utzi edo horien aurka azaltzeko eskubideaz baliatu ahal izango du, DIPCaen (Donostia, International Physics Center) zuzendaritzan.</font><br><br>
A efectos de lo dispuesto en la Ley Orgánica de protección de Datos de Carácter Personal 15/1999, de 13 de diciembre, se
informa al interesado que cuantos datos facilite de forma voluntaria al DIPC (Donostia International Physics Center), serán
incluidos en un fichero automatizado de datos de carácter personal creados y mantenido por la referida entidad. Los datos
registrados en esta base de datos solo serán usados para la finalidad para la que han sido recogidos. Cualquier otro uso de
los datos personales requerirá del previo y expreso consentimiento del interesado. Este podrá ejercer en cualquier momento
sus derechos de rectificación, cancelación, modificación u oposición de sus datos personales, en la dirección del DIPC (Donostia
International Physics Center).<br><br>
<font color="#009900">For the purposes of the provisions in the Organic Law regarding Personal Data Protection 15/1999, of the 13th of December,
all interested parties are informed that any data that they voluntarily provide the DIPC with (Donostia International Physics
Center), will be included in an automated personal data file created and maintained by the aforementioned body. The details
recorded in this database will only be used for the purpose for which they have been gathered. Any other use of these personal
details will require the prior express consent of the interested party. The latter may exercise their rights to correct, cancel, modify
or object to their personal details at any time, at the DIPC (Donostia International Physics Center).</font>
</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textogn align=right> <a href="javascript:fValidarForm1();">siquiente >></a></td></tr>
<tr><td height=20></td></tr>
</form>
</table>
<?}
function fFormularioInscripciones2(){
if(isset($_GET["CodDatos"])){$intCodDatos = $_GET["CodDatos"];}else{$intCodDatos=0;}?>
<table align="center" width="95%" height=100% CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<form name="frmInscripciones2" id="frmInscripciones2" method=post action="index.php?pg=18">
<input type="hidden" name="CodDatos" id="CodDatos" value="<?echo $intCodDatos;?>">
<tr><td height=10></td></tr>
<tr><td class=textoxln align=center>Albert Einstein Annus Mirabilis</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom align=center>Donostia - San Sebastián</td></tr>
<tr><td class=textom align=center>5-8 Iraila-Septiembre-September</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom align=center>BEKA ESKATZEKO ORRIA / BOLETIN DE SOLICITUD DE BECA / GRANT APPLICATION FORM</td></tr>
<?AbreConexion ();
$strSelect = fSQLFechaLimiteFormulario (2);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];
CierraConexion();?>
<tr><td class=textop align=center>Gehieneko data: <?echo $strFecha1;?> / Fecha Límite: <?echo $strFecha2;?> / Deadline: <?echo $strFecha3;?></td></tr>
<tr><td height=5></td></tr>
<tr><td bgcolor="#E4E5E5">
<table align=center width=95% cellpadding="0" cellspacing="0">
<tr><td height=10></td></tr>
<tr><td class=textosp align=center><u>Beka-eskaerari buruzko informazioa / Informacion sobre solicitud de becas / Information about Grant applications</u></td></tr>
<tr><td height=10></td></tr>
<tr><td bgcolor="#ffffff" class=textop height=18>&nbsp;&nbsp;<b>DERRIGORREZ BETETZEKO / A RELLENAR OBLIGATORIAMENTE / THIS MUST BE FILLED IN<b></td></tr>
<tr><td height=10></td></tr>
<tr><td class=textop>
Atal bakoitzean gehienez 200 hitz.<br>
No más de 200 palabras por cada apartado.<br>
No more than 200 words per section
</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textop>Arrazoiak / Razones / Reasons</td></tr>
<tr><td><textarea onKeyPress="javascript:fHitzak(200,this);" class=textoinput cols=127 rows=5 name="txtRazones" id="txtRazones"></textarea></td></tr>
<tr><td height=10></td></tr>
<tr><td class=textop>Merituak / Méritos / Merits</td></tr>
<tr><td><textarea onKeyPress="javascript:fHitzak(200,this);" class=textoinput cols=127 rows=5 name="txtMeritos" id="txtMeritos"></textarea></td></tr>
<tr><td height=10></td></tr>
<tr><td bgcolor="#ffffff" class=textop height=18>&nbsp;&nbsp;<b>BEKA MOTAK / TIPOS DE BECA / TYPES OF GRANT</b></td></tr>
<tr><td height=5></td></tr>
<tr><td>
<table>
<tr><td bgcolor=000000 class=textopb>
JOAN-ETORRIKO BEKA<br>
BECA DE DESPLAZAMIENTO<br>
TRAVEL GRANT
</td>
<td class=textop>&nbsp;&nbsp;BAI / SI / YES &nbsp; <input type="radio" name="rdbBeca" id="rdbBeca" value="1"></td>
</tr>
</table>
</td></tr>
<tr><td height=5></td></tr>
<tr><td class=textop>
Joan-etorriko beka lortzeko aukera du: (Donostiatik eta inguruetatik kanpo bizi direnentzat bakarrik)<br>
Opta a beca de desplazamiento: (sólo para aquellos que residan fuera de San Sebastián y alrededores)<br>
Application for a travel grant: (only for people who live outside San Sebastián and its surrounding area)<br><br>
Zenbatekoa: 25 € / egun - Importe : 25 € / día - Amount : 25 € / day
</td></tr>
<tr><td height=10></td></tr>
<tr><td>
<table>
<tr><td bgcolor=000000 class=textopb>
GAUA IGAROTZEAGATIKOA<br>
BECA DE PERNOCTACION<br>
OVERNIGHT GRANT
</td>
<td class=textop>&nbsp;&nbsp;BAI / SI / YES &nbsp; <input type="radio" name="rdbBeca" id="rdbBeca" value="2"></td>
</tr>
</table>
</td></tr>
<tr><td class=textop>
<br>Gaua igarotzeagatiko beka lortzeko aukera du: (EAEtik eta Nafarrotik kanpo bizi diren eta gaua Donostian igarotzen dutenentzat bakarrik)<br>
Opta a beca de pernoctación: (sólo para aquellos que residan fuera de la C.A.V. y Navarra y pernocten en San Sebastián)<br>
Application for overnight grant: (only for people who live outside the Basque Autonomous Community and Navarra and stay overnight in San Sebastián)<br><br>
Gehieneko zenbatekoa: 100 € /gaua - Importe Máximo: 100 € / noche - Maximum amount: 100 € / night
Ezinbestekoa da ostatu hartzeko orria betetzea / Imprescindible rellenar boletín de alojamiento / You must fill in the accommodation form /
</td></tr>
<tr><td height=10></td></tr>
<?AbreConexion ();
$strSelect = fSQLFechaLimiteFormulario (2);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];
CierraConexion();?>
<tr><td class=textop>Gehieneko data: <?echo $strFecha1;?> / Fecha Límite: <?echo $strFecha2;?> / Deadline: <?echo $strFecha3;?></td></tr>
<tr><td height=10></td></tr>
</table>
</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textogn align=right> <a href="javascript:fValidarForm2();">siquiente >></a></td></tr>
<tr><td height=20></td></tr>
</from>
</table>
<?}
function fFormularioInscripciones3 (){
if(isset($_GET["CodDatos"])){$intCodDatos = $_GET["CodDatos"];}else{$intCodDatos=0;}?>
<table align="center" width="95%" height=100% CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<form name="frmInscripciones3" id="frmInscripciones3" method=post action="index.php?pg=19">
<input type="hidden" name="CodDatos" id=CodDatos" value="<?echo $intCodDatos;?>">
<tr><td height=10></td></tr>
<tr><td class=textoxln align=center>Albert Einstein Annus Mirabilis</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom align=center>Donostia - San Sebastián</td></tr>
<tr><td class=textom align=center>5-8 Iraila-Septiembre-September</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textom align=center>IZENA EMATEKO ORRIA / BOLETÍN DE PRE-INSCRIPCION/ PRE-REGISTRATION FORM</td></tr>
<?AbreConexion ();
$strSelect = fSQLFechaLimiteFormulario (3);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];?>
<tr><td class=textop align=center>Gehieneko data: <?echo $strFecha1;?> / Fecha Límite: <?echo $strFecha2;?> / Deadline: <?echo $strFecha3;?></td></tr>
<tr><td height=5></td></tr>
<tr><td height=20></td></tr>
<?$strSelect = fSQLObtenerDatos($intCodDatos);
$objrow = EJECUTA_SELECT ($strSelect);
$row=mysql_fetch_assoc($objrow);
$intBeca = $row["t758_1_beca"];
if ($intBeca == "1"){?>
<tr><td>
<table width=100%>
<tr>
<td height=18 class=textomnb bgcolor="000000">
<font color="#E67B1D">&nbsp;&nbsp;ZURE OSTATU HARTZEKO ERRESERBA ORAIN FORMALIZATU NAHI DUZU?</font>
<br>&nbsp;&nbsp;¿ DESEA FORMALIZAR AHORA LA RESERVA DE SU ALOJAMIENTO ?
<br>&nbsp;&nbsp;DO YOU WANT TO FORMALISE YOUR ACCOMMODATION BOOKING NOW?
</td>
<td width=35% class=textop align=center>
BAI / SI / YES &nbsp;&nbsp; EZ / NO / NO
<br><input type="radio" name="rdbAlojamiento" id="rdbAlojamiento" value="1">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="rdbAlojamiento" id="rdbAlojamiento" value="0" checked>
</td>
</tr>
</table>
</td></tr>
<?}?>
<tr><td height=10></td></tr>
<tr><td class=textop>
FAKTURA BEHAR BADUZU, ADIERAZI ZURE DATU FISKALAK MESEDEZ.<br>
EN CASO DE NECESITAR FACTURA, ROGAMOS INDIQUE LOS DATOS FISCALES PARA SU REALIZACION.<br>
IF YOU NEED A BILL, PLEASE PROVIDE YOUR TAX DETAILS SO THAT IT CAN BE WRITTEN OUT.
</td></tr>
<tr><td><textarea name="txtDatosFiscales" id="txtDatosFiscales" class=textoinput cols=132 rows=4></textarea></td></tr>
<tr><td height=10></td></tr>
<tr><td bgcolor="000000" class=textomnb height=18>&nbsp;&nbsp;HOTELEKO ERRESERBA / RESERVA DE HOTEL / HOTEL RESERVATION</td></tr>
<tr><td height=10></td></tr>
<?$strSelect = fSQLTieneBeca ($intCodDatos);
$objrow = EJECUTA_SELECT ($strSelect);
$row=mysql_fetch_assoc($objrow);
$intTieneBeca = $row["t758_1_beca"];
CierraConexion();?>
<tr><td>
<table align=center width=75%>
<tr>
<td class=textop></td>
<td class=textosp>Bikoitza / Doble / Double</td>
<td class=textosp>&nbsp;&nbsp;&nbsp;&nbsp;Banakoak / Individual / Single&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
<td class=textop>RESIDENCIA OLARAIN</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="12118" onClick="javascript:fCambiarDatos(1,2,118,<?echo $intTieneBeca;?>);"> 118 €</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="1174" onClick="javascript:fCambiarDatos(1,1,74,<?echo $intTieneBeca;?>);"> 74 €</td>
</tr>
<tr>
<td class=textop>HOTEL LONDRES Y DE INGLATERRA ****</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="22188" onClick="javascript:fCambiarDatos(2,2,188,<?echo $intTieneBeca;?>);"> 188 €</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="21144" onClick="javascript:fCambiarDatos(2,1,144,<?echo $intTieneBeca;?>);"> 144 €</td>
</tr>
<tr>
<td class=textop>HOTEL NH ARANZAZU ****</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="32143" onClick="javascript:fCambiarDatos(3,2,143,<?echo $intTieneBeca;?>);"> 143 €</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="31131" onClick="javascript:fCambiarDatos(3,1,131,<?echo $intTieneBeca;?>);"> 131 €</td>
</tr>
<tr>
<td class=textop>HOTEL AMARA PLAZA ****</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="42122" onClick="javascript:fCambiarDatos(4,2,122,<?echo $intTieneBeca;?>);"> 122 €</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="41103" onClick="javascript:fCambiarDatos(4,1,103,<?echo $intTieneBeca;?>);"> 103 €</td>
</tr>
<tr>
<td class=textop>HOTEL TRYP ORLY ****</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="5297" onClick="javascript:fCambiarDatos(5,2,97,<?echo $intTieneBeca;?>);"> 97 €</td>
<td class=textop>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="rdbHotel" id="rdbHotel" value="5197" onClick="javascript:fCambiarDatos(5,1,97,<?echo $intTieneBeca;?>);"> 97 €</td>
</tr>
<tr><td height=10 colspan=3></td></tr>
<tr><td class=textop colspan=3><a href=javascript:ventana('index.php?pg=12',510,593,'no','einstein_mapa')><u>Ikus mapa / Ver mapa / See map</u></a></td></tr>
<tr><td class=textosp colspan=3>Prezio guztiak egun eta gelako dira, gosaria eta BEZ barne / Todos los precios son por habitación y día, desayuno e IVA incluidos/ All prices are per room and per day and include breakfast and VAT</td></tr>
</table>
</td></tr>
<tr><td height=10></td></tr>
<tr><td>
<table width=100%>
<tr><td height=10></td></tr>
<tr><td align=center>
<table width=100% CELLPADDING="0" CELLSPACING="0">
<tr><td class=textop colspan=3><b>ERRESERBA / RESERVA / RESERVATION</b></td></tr>
<tr>
<td class=textosp>Aukeratutako hotela / Hotel Elegido / Hotel chosen <input type="text" class=textoinputp style="width:172px" name="txtHotel" id="txtHotel" ReadOnly></td>
<td class=textosp>Logela(k) / Habitacion(es) / Room(s) <input type="text" class=textoinputp style="width:30px" name="txtHabitaciones" id="txtHabitaciones" ReadOnly></td>
<tr>
<td class=textosp>Bikoitza(k) / Doble(s)  / Double <input type="text" class=textoinputp style="width:30px" name="txtDobles" id="txtDobles" onKeyUp="javascript:fCambioNumHabitaciones(<?echo $intTieneBeca;?>);">
<td class=textosp>Banakoa(k) / Individual(es) / Single <input type="text" class=textoinputp style="width:30px" name="txtIndividuales" id="txtIndividuales" onKeyUp="javascript:fCambioNumHabitaciones(<?echo $intTieneBeca;?>);"></td>
</tr>
<tr>
<td class=textosp>Iritsiera eguna / Fecha de Llegada / Arrival date <select name="cboLlegada" id="cboLlegada" class=textoinputp onChange="javascript:fCambiarNoches(<?echo $intTieneBeca;?>);"><?for($i=5;$i<=8;$i++){?><option value="<?echo $i;?>"><?echo $i;?></option><?}?></select></td>
<td class=textosp>Irteera eguna / Fecha de Salida / Departure date <select name="cboSalida" id="cboSalida" class=textoinputp onChange="javascript:fCambiarNoches(<?echo $intTieneBeca;?>);"><?for($i=6;$i<=9;$i++){?><option value="<?echo $i;?>"><?echo $i;?></option><?}?></select></td>
</tr>
<tr>
<td class=textosp>Gauak orotara / Total Noches / Total Nights <input type="text" class=textoinputp style="width:10px" name="txtNoches" id="txtNoches" ReadOnly></td>
<td class=textosp>Zenbateko Osoa / Importe Total / Total amount <input type="text" class=textoinputp style="width:40px" name="txtImporte" id="txtImporte" ReadOnly> €</td>
</tr>
<?if ($intTieneBeca == "1"){?>
<tr>
<td class=textosp>Beka deskontua / Descuento por beca / Grant discount <input type="text" class=textoinputp style="width:30px" name="txtDto" id="txtDto" ReadOnly> €</td>
<td class=textosp>Orotara ordaintzeko / Total a pagar / Total to pay <input type="text" class=textoinputp style="width:40px" name="txtTotal" id="txtTotal" ReadOnly> €</td>
</tr>
<?}else{?>
<tr><td colspan=2 class=textosp>Orotara ordaintzeko / Total a pagar / Total to pay <input type="text" class=textoinputp style="width:40px" name="txtTotal" id="txtTotal" ReadOnly> €</td></tr>
<?}?>
</table>
</td></tr>
</table>
</td></tr>
<tr><td height=10></td></tr>
<tr><td bgcolor="000000" class=textomnb height=18>&nbsp;&nbsp;ORDAINKETA MODUA / FORMA DE PAGO / METHOD OF PAYMENT</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textop>
<font color="#E67B1D">Ostatu hartzeko erreserba egin ondoren, Kongresuko Bidaia-Agentzia Ofiziala den Carlson Wagonlit Travelek erreserba idatziz (posta elektronikoz)
konfirmatuko dizu eta ordaintzeko moduak adieraziko dizkizu.</font><br><br>
Una vez realizada la reserva de alojamiento, la Agencia de Viajes Oficial del Congreso, Carlson Wagonlit Travel le confirmará su reserva por escrito (vía e-mail) y le indicará las
formas de pago posible.<br><br>
<font color="#009900">Once you have booked your accommodation, the Congress Official Travel Agency, Carlson Wagonlit Travel, will confirm your booking in writing (by e-mail) and will let you know
the possible methods of payment.</font>"
</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textosp>
<font color="#E67B1D">OSTATU ESKAERA HANDIAREN AURREAN ETA NAHI DUZUN HOTELA BERMATU AHAL IZATEKO, ERRESERBA AHALIK ETA AZKARREN ETA AHAL BADA EKAINAK 30A BAINO LEHEN EGITEA GOMENDATZEN DUGU. GOGORA EZAZU ZURE HOTELEKO EGONALDIA LUZA DEZAKEZULA , KONGRESUKO EGUNETATIK KANPO, KONGRESUKO AGENTZIA OFIZIALAK ESKAINTZEN DITUEN PREZIO BEREZIAK APROBETXATUZ</font><br><br>
ANTE LA GRAN DEMANDA DE ALOJAMIENTO Y CON EL FIN DE PODER GARANTIZARLE EL HOTEL DESEADO, RECOMENDAMOS REALIZAR LA RESERVA A LA MAYOR BREVEDAD POSIBLE Y A PODER SER ANTES DEL 30 DE JUNIO. LE RECORDAMOS QUE
PUEDE PROLONGAR LA ESTANCIA EN EL HOTEL, FUERA DE LOS DÍAS DEL CONGRESO, BENEFICIANDOSE DE LOS PRECIOS ESPECIALES OFERTADOS POR LA AGENCIA DE VIAJES OFICIAL DEL CONGRESO.<br><br>
<font color="#009900">IN VIEW OF THE GREAT DEMAND FOR ACCOMMODATION, AND IN ORDER TO BE ABLE TO GUARANTEE THAT YOU CAN STAY AT THE HOTEL YOU WANT, WE RECOMMEND THAT YOU BOOK AS SOON AS YOU CAN, IF POSSIBLE BEFORE THE 30TH OF JUNE. WE RECOMMEND THAT YOU EXTEND YOUR STAY AT YOUR HOTEL BEYOND THE
DAYS THAT THE CONGRESS IS BEING HELD, BY TAKING ADVANTAGE OF THE SPECIAL PRICES OFFERED BY THE CONGRESS OFFICIAL AGENCY.</FONT>
</td></tr>
<tr><td height=5></td></tr>
<tr><td class=textosp><b>
OSTATUARI BURUZKO INFORMAZIO GEHIAGORAKO:
<br>PARA MAS INFORMACION SOBRE EL ALOJAMIENTO:
<br>FOR FURTHER INFORMATION ABOUT ACCOMMODATION:
<br><br>KONGRESUAREN AGENTZI OFIZIALA
<br>AGENCIA OFICIAL DEL CONGRESO
<br>CONGRESS OFFICIAL AGENCY
<br>Carlons Wagonlit Travel
<br>Sra. Mañen Echarri
<br>Fax: (34) 943 430532
<br>E-mail: mecharri@carlsonwagonlit.es</b>
</td></tr>
<tr><td height=10></td></tr>
<tr><td class=textogn align=right> <a href="javascript:fValidarForm3();">terminar >></a></td></tr>
<tr><td height=20></td></tr>
</form>
</table>
<?}
function sPintarBotonesFormato($istrFrame,$strRaiz)
{	?>
<table cellpadding="2" cellspacing="0">
<tr>
<td><?Boton($strRaiz,"javascript:fInsertarSimbolo('c','".$istrFrame."');","&#8226;",sEscribir("Cuadrado"),0,1);?></td>
<td><?Boton($strRaiz,"javascript:fFormatoTexto('u','".$istrFrame."');","<u>subr</u>",sEscribir("Subrayado"),0,1);?></td>
<td><?Boton($strRaiz,"javascript:fFormatoTexto('k','".$istrFrame."');","<i>cur</i>",sEscribir("Cursiva"),0,1);?></td>
<td><?Boton($strRaiz,"javascript:fFormatoTexto('b','".$istrFrame."');","<b>neg</b>",sEscribir("Negrita"),0,1);?></td>
<td><?Boton($strRaiz,"javascript:fFormatoTexto('-t','".$istrFrame."');","<font class=textop>-ABC</font>",sEscribir("DisminuirLetra"),0,1);?></td>
<td><?Boton($strRaiz,"javascript:fFormatoTexto('+t','".$istrFrame."');","<font class=textog>+ABC</font>",sEscribir("AumentarLetra"),0,1);?></td>
<td><?Boton($strRaiz,"javascript:fInsertarSimbolo('mm','".$istrFrame."');","&#177;",sEscribir("MasMenos"),0,1);?></td>
<td><?Boton($strRaiz,"javascript:fFormatoTexto('sup','".$istrFrame."');","<font class=textop>sup<sup>x</sup></font>",sEscribir("Superindice"),0,1);?></td>
<td><?Boton($strRaiz,"javascript:fFormatoTexto('sub','".$istrFrame."');","<font class=textop>sub<sub>x</sub></font>",sEscribir("Subindice"),0,1);?></td>
<td><?Boton($strRaiz,"javascript:fInsertarEnlace('http');","http://",sEscribir("Enlace"),0,1);?></td>
</tr>
</table>
<?
}
function fHtmlSkipIntro (){?>
<table align=center valign=middle>
<tr><td><img src="images/img_skipintro.jpg"></td></tr>
<tr><td height=10></td></tr>
<tr><td>
<table width=100 align=center cellpadding=0 cellspacing=0>
<tr><td bgcolor="000000" align=center height=15 class=textomnb><a href="index.php?pg=1&opcion=2&idioma=eu">EUSKARA</a></td></tr>
<tr><td height=3></td></tr>
<tr><td bgcolor="000000" align=center height=15 class=textomnb><a href="index.php?pg=1&opcion=2&idioma=es">CASTELLANO</a></td></tr>
<tr><td height=3></td></tr>
<tr><td bgcolor="000000" align=center height=15 class=textomnb><a href="index.php?pg=1&opcion=2&idioma=uk">ENGLISH</a></td></tr>
</table>
</td></tr>
</table>
<?}?>
