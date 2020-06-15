<?session_start();?>
<?header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?include("lanb_estructura.php");
include("lanb_edukia.php");
include("lanb_planas.php");
include("lanb_rutas.php");
include("lanb_ado.php");
include("lanb_clase.php");
include("lanb_sql.php");
include("multi/lanb_idiomas.php");?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>..::.. Einstein ..::..</title>
<LINK rel="stylesheet" type="text/css" href="estilos.css">
<script language="JavaScript" src="js/menu.js"></script>
<script language="JavaScript" src="js/validar.js"></script>
<script language="JavaScript" src="js/capas.js"></script>
</head>
<?if(isset($_GET["ini"])){$intIni=$_GET["ini"];}else{$intIni=0;}
if ($intIni=="2" || $intIni=="3"){sCerrarSesion();}
if(isset($_GET["idioma"])){$_SESSION["einstein_idioma"]=$_GET["idioma"];
}else{
if(!isset($_SESSION["einstein_idioma"])){$_SESSION["einstein_idioma"]="uk";}
}
if(isset($_GET["pg"])){$intPg=$_GET["pg"];}else{$intPg="";}
if(isset($_GET["opcion"])){$intOpcion=$_GET["opcion"];}else{$intOpcion="";}
$strScroll = "";
$strEstilo = "";
$strBgColor ="bgcolor='#FFFFFF'";
if($intPg=="2"){
$strScroll = "scroll=no scrolling=no";
}elseif ($intPg!="4" && $intPg!="9" && $intPg!="14" && $intPg!="15" && $intPg!="16"){
$strScroll = "scroll=no scrolling=no";
}elseif($intPg==4 && ($intOpcion==1 ||$intOpcion==18 || $intOpcion==19 || $intOpcion==26)){
$strScroll = "scroll=no scrolling=no";
}else{
if($intPg!="9"){$strBgColor="bgcolor='#d9e4ea'";}
}
if($intPg=="8"){$strBgColor="bgcolor='#d9e4ea'";}
if($intPg=="9" || $intPg=="14" || $intPg=="15" || $intPg=="16"){
$strEstilo="class='scroll1'";
if ($intPg=="14"){
$strBgColor="bgcolor='#FFFAE9'";
}else{
$strBgColor="bgcolor='#FFFFFF'";
}
}?>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" BORDER=0 NORESIZE  frameborder="NO" <?echo $strBgColor . " ". $strScroll . " " . $strEstilo;?>>
<table align="center" width="100%" height="100%"  CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0
<tr><td valign="middle"><?sContenido();?></td></tr>
</table>
</BODY>
</HTML>
