<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<?session_start();?>
<?header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include("../lanb_rutas.php");
include("../lanb_clase.php");
include("../lanb_estructura.php");
include("../lanb_edukia.php");
include("multi/lanb_idiomas.php");
include("lanb_estructura.php");
include("lanb_edukia.php");?>

<title>..::.. Einstein ..::..</title>
<LINK rel="stylesheet" type="text/css" href="../estilos.css">
<?if(isset($_GET["idioma"])){$_SESSION["einstein_idioma"]=$_GET["idioma"];
}else{
if(!isset($_SESSION["einstein_idioma"])){$_SESSION["einstein_idioma"]="uk";}
}?>
<script language="JavaScript" src="js/validar.js"></script>
<script language="JavaScript" src="../js/validar.js"></script>
<script language="JavaScript" src="../js/menu.js"></script>
<script language="JavaScript" src="multi/lanb_idioma_<?echo $_SESSION["einstein_idioma"];?>.js"></script>
</HEAD>
<?if(isset($_GET["ini"])){$intIni=$_GET["ini"];}else{$intIni=0;}
if ($intIni=="2"){sCerrarSesion();}
if(isset($_GET["pg"])){$intPg=$_GET["pg"];}else{$intPg="";}
if(isset($_GET["opcion"])){$intOpcion=$_GET["opcion"];}else{$intOpcion="";}
$strScroll = "";
$strEstilo = "";
$strBgColor ="bgcolor='#FFFFFF'";
$swDentro=0;
if (isset($_GET["pg"]))
{	if ($_GET["pg"]=="13")
{	$swDentro=1;
}
}
if ($swDentro==1)
{	?>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" BORDER=0 NORESIZE  frameborder="NO" scroll=auto bgcolor="#D9E4EA"><?
sContenidoSala();
}
else
{	?>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" BORDER=0 NORESIZE  frameborder="NO" scroll=no>
<table align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<tr><td bgcolor="#FFFFFF" width="100%" height="100%" valign="middle">
<table valign="middle" bgcolor="#737886" align="center" width="796" height="448" CELLPADDING="0" CELLSPACING="1" topmargin="0" leftmargin="0" border="0">
<tr><td bgcolor="#FFFFFF" width="100%" height="100%" valign="top">
<table border=0 width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0">
<tr><td height="80" colspan="3"><?sCabeceraSala();?></td></tr>
<tr>
<td height="350" width="120" bgcolor="000000" valign=top rowspan="2"><?sMenuSala();?></td>
<td width=16 bgcolor="#D9E4EA">&nbsp;</td>
<td height="284" width="660" valign="top" bgcolor="#D9E4EA"><?sContenidoSala();?></td>
</tr>
<tr><td height="36" colspan="2" align="right" bgcolor="#D9E4EA"><?
if (!(isset($_SESSION["einstein_privado"]) && $_SESSION["einstein_privado"] == 1))
{	if (isset($_GET["pg"]))
{	if ($_GET["pg"]=="2")
{	sPie("../",2);
}
else
{	sPie("../",0);
}
}
else
{	sPie("../",0);
}
}
else
{	?>&nbsp;<?
}?></td></tr>
</table>
</td></tr>
</table>
</td></tr>
</table><?
}?>
</BODY>
</HTML>
