<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?function sContenidoSala (){
if(isset($_GET["pg"])){$intPg=$_GET["pg"];}else{$intPg="";}
switch ($intPg){
case "0": sSalirDelArea();break;
case "1": sBienvenida();break;
case "2": sDarseDeAlta();break;
case "3": sOlvidoClave();break;
case "4": sValidarEmailClave();break;
case "5": sBienvenida();break;
case "6": sEnviarClave();break;
case "7": sEnviarAlta();break;
case "8": sMensajeAlta();break;
case "9": sDossierDePrensa();break;
case "10": sSoliciteEntrevista();break;
case "11": sEnviarEntrevista();break;
case "12": sMensajeEntrevista();break;
case "13":fDentro();break;
default: sAcceso();break;
}
}
function sValidarEmailClave (){
if(isset($_POST["txtEmail"])){$strEmail = $_POST["txtEmail"];}else{$strEmail="";}
if(isset($_POST["txtPass"])){$strPass = $_POST["txtPass"];}else{$strPass="";}
if ($strEmail == "" || $strPass == ""){?>
<script>alert('<?echo sEscribir("UsuarioIncorrecto");?>');</script>
<?}else{
$IrA = "index.php";
if (strtoupper($strPass)==fDameRuta("C_Clave")){
$_SESSION["einstein_privado"]=1;
$_SESSION["einstein_conectado"]=$strEmail;
$IrA = "index.php?pg=5";
}else{?>
<script>alert('<?echo sEscribir("UsuarioIncorrecto");?>');</script>
<?}
}?>
<script>location.href='<?echo $IrA;?>';</script>
<?}
function sSalirDelArea (){
$_SESSION["einstein_privado"]="";?>
<script>location.href="../index.php";</script>
<?}
function sEnviarClave (){
if(isset($_POST["txtEmail"]) && isset($_POST["txtNombre"])){
$strEmail = $_POST["txtEmail"];
$strNombre = $_POST["txtNombre"];
$strBody = "";
$strBody = "<html><head>".
"<style type=text/css>".
".textomn{FONT: bold 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none }"."\r\n".
".textom{FONT: 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none} "."\r\n".
"</style>"."\r\n".
"<title>..:: EINSTEIN: Sala de Prensa ::..</title></head><body>"."\r\n".
" <table align=center width=750 CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> "."\r\n".
" <tr><td class=textom> ".sEscribir("LeRecordamosClave")."</td></tr>"."\r\n".
" </table>"."\r\n".
" </body></html>";
$strBody=sEscribir("LeRecordamosClave");
$strAsunto = sEscribir("RecordatorioClave");
$strDe = "Einstein. " . sEscribir("SalaDePrensa");
$strError = fEnviarCorreo($strEmail,$strNombre,$strAsunto,fDameRuta("E_Einstein"),$strDe,"",$strBody);
if ($strError){
$IrA = "index.php?pg=3&Enviado=1";
}else{
$IrA = "index.php?pg=3";
}
}else{?>
<script>alert('<?echo sEscribir("UsuarioIncorrecto");?>');</script>
<?$IrA = "index.php";
}?>
<script>location.href='<?echo $IrA;?>';</script>
<?}
function sEnviarAlta (){
$strNombre = $_POST["txtNombre"];
$strApellidos = $_POST["txtApellidos"];
$strEmail = $_POST["txtEmail"];
$strTelefono = $_POST["txtTelefono"];
$intFreelance = $_POST["rdbFreelance"];
if ($intFreelance == "0"){$strFreelance = sEscribir("No");}else{$strFreelance = sEscribir("Si");}
$strMedio = $_POST["txtMedio"];
$strSoporte = $_POST["cboSoporte"];
$strAmbito = $_POST["cboAmbito"];
$strLocalizacion = $_POST["txtLocalizacion"];
$strContacto = $_POST["txtContacto"];
$strEmail2 = $_POST["txtEmail2"];
$strPublicacion = $_POST["txtPublicacion"];
$strCongreso = $_POST["txtCongreso"];
if (isset($_POST["txtFax"])){$strFax = $_POST["txtFax"];}else{$strFax="";}
if (isset($_POST["txtWeb"])){$strWeb = $_POST["txtWeb"];}else{$strWeb="";}
$strError = "";
if($strError == ""){
$strBody = "";
$strBody = "<html><head>"."\r\n".
"<style type=text/css>"."\r\n".
".textomn{FONT: bold 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none }"."\r\n".
".textom{FONT: 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none} "."\r\n".
"</style>"."\r\n".
"<title>..:: EINSTEIN: Sala de Prensa ::..</title></head><body>"."\r\n".
" <table align=center width=750 CELLPADDING=2 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> "."\r\n".
" <tr><td colspan=2 class=textomn>".sEscribir("DatosSolicitante")."</td></tr>"."\r\n".
" <tr><td colspan=2 height=1 bgcolor='#373E52'></td></tr>"."\r\n".
" <tr><td colspan=2 height=10></td></tr>"."\r\n".
" <tr><td class=textom width=15%>".sEscribir("Nombre").":</td><td width=85% class=textomn>".$strNombre."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("Apellidos").":</td><td class=textomn>".$strApellidos."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("EmailPersonal").":</td><td class=textomn>".$strEmail."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("Telefono").":</td><td class=textomn>".$strTelefono."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("TrabajasFreelance").":</td><td class=textomn>".$strFreelance."</td></tr>"."\r\n".
" <tr><td colspan=2 height=10></td></tr>"."\r\n".
" <tr><td colspan=2 class=textomn>".sEscribir("DatosMedio")."</td></tr>"."\r\n".
" <tr><td colspan=2 height=1 bgcolor='#373E52'></td></tr>"."\r\n".
" <tr><td colspan=2 height=10></td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("NombreDelMedio").":</td><td class=textomn>".$strMedio."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("Soporte").":</td><td class=textomn>".$strSoporte."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("Ambito").":</td><td class=textomn>".$strAmbito."</td></tr>"."\r\n".
" <tr><td colspan=2 height=10></td></tr>"."\r\n".
" <tr><td class=textom colspan=2>".sEscribir("Texto_Localizacion")."</td></tr>"."\r\n".
" <tr><td class=textomn colspan=2>".$strLocalizacion."</td></tr>"."\r\n".
" <tr><td colspan=2 height=10></td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("TlfnContacto").":</td><td class=textomn>".$strContacto."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("Fax").":</td><td class=textomn>".$strFax."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("Email").":</td><td class=textomn>".$strEmail2."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("Web").":</td><td class=textomn>".$strWeb."</td></tr>"."\r\n".
" <tr><td colspan=2 height=10></td></tr>"."\r\n".
" <tr><td class=textom colspan=2>".sEscribir("Texto_Publicacion").":</td></tr>"."\r\n".
" <tr><td class=textomn colspan=2>".$strPublicacion."</td></tr>"."\r\n".
" <tr><td colspan=2 height=10></td></tr>"."\r\n".
" <tr><td class=textom colspan=2>".sEscribir("Texto_Congreso").":</td></tr>"."\r\n".
" <tr><td class=textomn colspan=2>".$strCongreso."</td></tr>"."\r\n".
" </table>"."\r\n".
" </body></html>";
$strBody=sEscribir("DatosSolicitante")."\r\n\r\n".
sEscribir("Nombre").": ".$strNombre."\r\n".
sEscribir("Apellidos").": ".$strApellidos."\r\n".
sEscribir("EmailPersonal").": ".$strEmail."\r\n".
sEscribir("Telefono").": ".$strTelefono."\r\n".
sEscribir("TrabajasFreelance").": ".$strFreelance."\r\n\r\n".
sEscribir("DatosMedio")."\r\n\r\n".
sEscribir("NombreDelMedio").": ".$strMedio."\r\n".
sEscribir("Soporte").": ".$strSoporte."\r\n".
sEscribir("Ambito").": ".$strAmbito."\r\n\r\n".
sEscribir("Texto_Localizacion")."\r\n\r\n".
$strLocalizacion."\r\n\r\n".
sEscribir("TlfnContacto").": ".$strContacto."\r\n".
sEscribir("Fax").": ".$strFax."\r\n".
sEscribir("Email").": ".$strEmail2."\r\n".
sEscribir("Web").": ".$strWeb."\r\n\r\n".
sEscribir("Texto_Publicacion")."\r\n\r\n".
$strPublicacion."\r\n\r\n".
sEscribir("Texto_Congreso")."\r\n\r\n".
$strCongreso."\r\n\r\n";
$strAsunto = sEscribir("AltaUsuario");
$strDe = $strNombre . " " . $strApellidos;
$strPara=fDameRuta("E_Einstein");
$strError = fEnviarCorreo ($strPara,"Einstein",$strAsunto,$strEmail,$strDe,"",$strBody);
$strBody = "";
$strBody = "<html><head>"."\r\n".
"<style type=text/css>"."\r\n".
".textomn{FONT: bold 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none }"."\r\n".
".textom{FONT: 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none} "."\r\n".
"</style>"."\r\n".
"<title>..:: EINSTEIN: Sala de Prensa ::..</title></head><body>"."\r\n".
" <table align=center width=750 CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> "."\r\n".
" <tr><td class=textom> ".sEscribir("BienvenidoSalaPrensa")."</td></tr>"."\r\n".
" </table></body></html>";
$strBody=sEscribir("BienvenidoSalaPrensa");
$strAsunto = sEscribir("AsuntoBienvenido");
$strDe = "Einstein. " . sEscribir("SalaDePrensa");
$strError = fEnviarCorreo ($strEmail,$strNombre,$strAsunto,fDameRuta("E_Einstein"),$strDe,"",$strBody);
if ($strError){
$IrA = "index.php?pg=8&Enviado=1";
}else{
$IrA = "index.php?pg=8";
}
}else{?>
<script>alert('<?echo sEscribir("DatosInvalidos");?>');</script>
<?$IrA = "index.php";
}?>
<script>location.href='<?echo $IrA;?>';</script>
<?}
function sEnviarEntrevista (){
$strNombre = $_POST["txtNombre"];
$strApellidos = $_POST["txtApellidos"];
$strTelefono = $_POST["txtTelefono"];
$strEmail = $_POST["txtEmail"];
$_SESSION["entrevista_nombre"] = $strNombre;
$_SESSION["entrevista_apellidos"] = $strApellidos;
$_SESSION["entrevista_telefono"] = $strTelefono;
$_SESSION["entrevista_email"] = $strEmail;
$strPonente = $_POST["cboPonente"];
$strComo = $_POST["rdbComo"];
$strDia = $_POST["txtDia"];
$strMes = $_POST["txtMes"];
$strHora = $_POST["txtHora"];
$strIdioma = $_POST["cboIdioma"];
if (isset($_POST["txtComentarios"])){$strComentarios = $_POST["txtComentarios"];}else{$strComentarios="";}
if (isset($_POST["txtOtra"])){$strOtra = $_POST["txtOtra"];}else{$strOtra="";}
$strError = "";
if($strError == ""){
$strBody = "";
$strBody = "<html><head>"."\r\n".
"<style type=text/css>"."\r\n".
".textomn{FONT: bold 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none }"."\r\n".
".textom{FONT: 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none} "."\r\n".
"</style>"."\r\n".
"<title>..:: EINSTEIN: Sala de Prensa ::..</title></head><body>"."\r\n".
" <table align=center width=750 CELLPADDING=2 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> "."\r\n".
" <tr><td colspan=2 class=textomn>".sEscribir("SolicitudEntrevista")."</td></tr>"."\r\n".
" <tr><td colspan=2 height=10></td></tr>"."\r\n".
" <tr><td colspan=2 class=textomn>".sEscribir("DatosSolicitante")."</td></tr>"."\r\n".
" <tr><td class=textom width=40%>".sEscribir("Nombre")."</td><td width=60% class=textomn>".$strNombre."</td></tr>"."\r\n".
" <tr><td class=textom width=40%>".sEscribir("Apellidos")."</td><td width=60% class=textomn>".$strApellidos."</td></tr>"."\r\n".
" <tr><td class=textom width=40%>".sEscribir("TlfnContacto")."</td><td width=60% class=textomn>".$strTelefono."</td></tr>"."\r\n".
" <tr><td class=textom width=40%>".sEscribir("Email")."</td><td width=60% class=textomn>".$strEmail."</td></tr>"."\r\n".
" <tr><td colspan=2 height=10></td></tr>"."\r\n".
" <tr><td class=textom width=40%>".sEscribir("PonenteOrganizador")."</td><td width=60% class=textomn>".$strPonente."</td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("ComoQuiereEntrevista")."</td><td class=textomn>".$strComo."</td></tr>"."\r\n";
if ($strOtra != ""){
$strBody = $strBody . "<tr><td colspan=2 class=textomn>".$strOtra."</td></tr>"."\r\n";
}
$strBody = $strBody . " <tr><td class=textom>".sEscribir("Cuando")."</td><td class=textom>".sEscribir("Dia")." <b>".$strDia."</b> &nbsp;&nbsp;&nbsp; " . sEscribir("Mes") . " <b>". $strMes . "</b> &nbsp;&nbsp;&nbsp; " . sEscribir("HoraLocal") . " <b>". $strHora . "</b></td></tr>"."\r\n".
" <tr><td class=textom>".sEscribir("IdiomaEntrevista").":</td><td class=textomn>".$strIdioma."</td></tr>"."\r\n";
if ($strComentarios != ""){
$strBody = $strBody . "<tr><td class=textom>".sEscribir("OtrosComentarios")."</td><td class=textomn>".$strComentarios."</td></tr>"."\r\n";
}
$strBody = $strBody . " </table></body></html>";
$strBody=sEscribir("SolicitudEntrevista")."\r\n\r\n".
sEscribir("DatosSolicitante")."\r\n\r\n".
sEscribir("Nombre").": ".$strNombre."\r\n".
sEscribir("Apellidos").": ".$strApellidos."\r\n".
sEscribir("TlfnContacto").": ".$strTelefono."\r\n\r\n".
sEscribir("PonenteOrganizador").": ".$strPonente."\r\n".
sEscribir("ComoQuiereEntrevista").": ".$strComo."\r\n";
if ($strOtra != ""){
$strBody=$strBody.$strOtra."\r\n";
}
$strBody = $strBody .sEscribir("Cuando")."    ".sEscribir("Dia")." ".$strDia."        " . sEscribir("Mes") . " ". $strMes . "        " . sEscribir("HoraLocal") . " ". $strHora ."\r\n".
sEscribir("IdiomaEntrevista").": ".$strIdioma ."\r\n";
if ($strComentarios != ""){
$strBody=$strBody.sEscribir("OtrosComentarios").": ".$strComentarios."\r\n\r\n";
}
$strAsunto = sEscribir("SolicitudEntrevista");
$strDe=sEscribir("SalaDePrensa");
$strError = fEnviarCorreo($strEmail,"Einstein",$strAsunto,fDameRuta("E_Einstein"),$strDe,"",$strBody);
if ($strError){
$IrA = "index.php?pg=12&Enviado=1&Ponente=".$strPonente;
}else{
$IrA = "index.php?pg=12";
}
}else{?>
<script>alert('<?echo sEscribir("DatosInvalidos");?>');</script>
<?$IrA = "index.php";
}?>
<script>location.href='<?echo $IrA;?>';</script>
<?}
function fDevuelveNombrePonente ($intPonente){
if($intPonente == "1"){
$strPonente = "Jean-Marie Lehn";
}elseif($intPonente == "2"){
$strPonente = "Ignacio Cirac";
}elseif($intPonente == "3"){
$strPonente = "Clifford M. Will";
}elseif($intPonente == "4"){
$strPonente = "Alberto Galindo";
}elseif($intPonente == "5"){
$strPonente = "Gerald Holton";
}elseif($intPonente == "6"){
$strPonente = "Sheldon Lee Glashow";
}elseif($intPonente == "7"){
$strPonente = "Dudley Herschbach";
}elseif($intPonente == "8"){
$strPonente = "Antony Hewish";
}elseif($intPonente == "9"){
$strPonente = "Arthur I. Miller";
}elseif($intPonente == "10"){
$strPonente = "Rafael Rebolo Lopez";
}elseif($intPonente == "11"){
$strPonente = "Heinrich Rohrer";
}elseif($intPonente == "12"){
$strPonente = "Jose M. Sanchez-Ron";
}elseif($intPonente == "13"){
$strPonente = "John Jay Stachel";
}elseif($intPonente == "14"){
$strPonente = "Claude Cohen-Tannoudji";
}elseif($intPonente == "15"){
$strPonente = "Francisco Jose Yndurain";
}elseif($intPonente == "16"){
$strPonente = "Anton Zeilinger";
}elseif($intPonente == "17"){
$strPonente = "Pedro Pascual";
}elseif($intPonente == "18"){
$strPonente = "Fernando Flores";
}elseif($intPonente == "19"){
$strPonente = "Amand Lucas";
}
return $strPonente;
}?>
</body>
</html>
