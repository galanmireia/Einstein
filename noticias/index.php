<?session_start();?>
<?
include("../lanb_ado.php");
include("../salaprensa/multi/lanb_idiomas.php");
include("../lanb_estructura.php");
include("../lanb_edukia.php");
include("../lanb_sql.php");
include("../lanb_clase.php");
include("../lanb_rutas.php");
include("lanb_estruktura.php");
include("lanb_edukia.php");
include("lanb_sql.php");
include("../salaprensa/lanb_estructura.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>..:: Einstein ::.. Berriak / Noticias / News</title>
<script language="javascript" src="js/balidatu.js"></script>
<script language="javascript" src="../js/validar.js"></script>
<script language="javascript" src="../multi/lanb_eu.js"></script>
<LINK rel="stylesheet" type="text/css" href="../estilos.css">
</HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" BORDER=0 NORESIZE  frameborder="NO" <?if(isset($_GET["inprimatu"])){?>onLoad="javascript:fImprimirYCerrar();"<?}else{?> scroll=no<?}?>>
<?if(isset($_GET["inprimatu"])){$intInprimatu=1;}else{$intInprimatu=0;}?>
<table align="center" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0" border="0">
<?if ($intInprimatu == "1"){?>
<tr><td height="320" width="600" valign="top" bgcolor="#D9E4EA"><?sEdukiWeb();?></td></tr>
<?}else{?>
<tr><td bgcolor="#FFFFFF" width="100%" height="100%" valign="middle">
<table valign="middle" bgcolor="#737886" align="center" width="796" height="448" CELLPADDING="0" CELLSPACING="1" topmargin="0" leftmargin="0" border="0">
<tr><td bgcolor="#FFFFFF" width="100%" height="100%" valign="top">
<table border=0 border="0" width="100%" height="100%" CELLPADDING="0" CELLSPACING="0" topmargin="0" leftmargin="0">
<tr><td height="80" colspan="3"><?sCabeceraSala();?></td></tr>
<tr>
<td height="350" width="150" bgcolor="000000" valign=top><?sMenuSala();?></td>
<td width=16 bgcolor="#D9E4EA">&nbsp;</td>
<td height="320" width="630" valign="top" bgcolor="#D9E4EA"><?sEdukiWeb();?></td>
</tr>
</table>
</td></tr>
</table>
</td></tr>
<?}?>
</table>
</BODY>
</HTML>
