<?function sContenido (){
if(isset($_GET["pg"])){$intPg=$_GET["pg"];}else{$intPg="";}
switch ($intPg){
case "1":sEstructuraPrincipal();break;
case "2":sMenu();break;
case "3":sPie();break;
case "4":sPlanas();break;
case "5":sSubCabecera();break;
case "6":sCabecera();break;
case "7":sPonente();break;
case "8":break;
case "9":sDatosPonente();break;
case "10":fCambiarIdioma();break;
case "11":fFlashFelicitacion();break;
case "12":fFlashMapa();break;
case "13":fFlashHome();break;
case "14":fFormularioSoloAlojamiento();break;
case "15":fGuardarAlojamiento();break;
case "21":fConfirmarInscripcion();break;
case "22":fHtmlSkipIntro();break;
default:sEstructuraInicio ();break;
}
}
function fMarkatu($x,$var,$istrKolore) {
if ($var != "") {
$xtemp = "";
$i=0;
while($i<strlen($x)){
if((($i + strlen($var)) <= strlen($x)) && (strcasecmp($var, substr($x, $i, strlen($var))) == 0)) {
$xtemp .= "<font color=".$istrKolore.">" . substr($x, $i , strlen($var)) . "</font>";
$i += strlen($var);
}
else {
$xtemp .= $x{$i};
$i++;
}
}
$x = $xtemp;
}
return $x;
}
function fstrMaximoLargo($strTexto,$strLargo)
{	if (strlen($strTexto)>$strLargo)
{	$strBlanco=" ";
$sw=0;
for ($y=1;$y<$strLargo;$y++)
{	$strCaracter=substr($strTexto,$y-1,1);
if ("a".$strCaracter."a"=="a".$strBlanco."a")
{	$sw=1;
}
}
if ($sw==1)
{	$strCaracter=substr($strTexto,0,$strLargo-3);
if ("a".$strCaracter."a"=="a".$strBlanco."a")
{	return substr($strTexto,0,$strLargo-4)."...";
}
else
{	$x=$strLargo-3;
$strCaracter=substr($strTexto,$x-1,1);
while ("a".$strCaracter."a"!="a".$strBlanco."a" && $x>1)
{	$x=$x-1;
$strCaracter=substr($strTexto,$x-1,1);
}
$x=$x-1;
return substr($strTexto,0,$x)."...";
}
}
else
{	return substr($strTexto,0,$strLargo-3)."...";
}
}
else
{	return $strTexto;
}
}
function fCambiarIdioma (){
if(isset($_GET["idioma"])){$strIdioma = $_GET["idioma"];}else{$strIdioma = "uk";}
if($strIdioma != "es" && $strIdioma != "eu" && $strIdioma != "uk"){
$_SESSION["einstein_idioma"]="uk";
}else{
$_SESSION["einstein_idioma"]=$strIdioma;
}?>
<script>window.open('index.php?pg=1&opcion=2','_parent');</script>
<?}
function sCerrarSesion(){
sVaciarSesiones();
if (isset($_GET["ini"]) && $_GET["ini"]!="3")
{	?>
<script>
location.href="index.php";
einstein_escritorio=window.open("","einstein_administracion","left=8000,screenX=8000,width=10,height=10");
einstein_escritorio.close();
</script><?
}
}
function sVaciarSesiones()
{	$_SESSION["einstein_user"]="";
$_SESSION["einstein_nivel"]="";
$_SESSION["einstein_privado"]="";
}
Function fObtenerFechaHoy () {
$intEguna=Date("d");
$intHilabetea=Date("m");
$intUrtea=Date("Y");
$strData=$intUrtea.$intHilabetea.$intEguna;
return ($strData);
}
Function sObtenerFechaVer ($data){
$intEguna = substr($data,6,2);
$intHilabete = substr($data,4,2);
$intUrtea = substr($data,0,4);
$dataaldatuta = $intEguna . "/" . $intHilabete . "/". $intUrtea;
return ($dataaldatuta);
}
Function sObtenerFechaTabla ($data){
if(isset($data) && $data!=""){
$intEguna = substr($data,0,2);
$intHilabete = substr($data,3,2);
$intUrtea = substr($data,6,4);
$dataformateatuta = $intUrtea . $intHilabete . $intEguna;
}
else{$dataformateatuta="";}
return ($dataformateatuta);
}
function fEnviarCorreo ($strEmailAQuien,$strNombreAQuien,$strAsunto,$strEmailDeQuien,$strNombreDeQuien,$strCopias,$strBody){
$strCabeceras  = "MIME-Version: 1.0\r\n";
$strCabeceras .= "Content-type: text/plain; charset=iso-8859-1\r\n";
if ($strNombreAQuien != "" && $strEmailAQuien != ""){
$strCabeceras .= "To: " . $strNombreAQuien. " <" . $strEmailAQuien . ">\r\n";
}elseif ($strNombreAQuien == "" && $strEmailAQuien != ""){
$strCabeceras .= "To: " . $strEmailAQuien. "\r\n";
}elseif ($strNombreAQuien != "" && $strEmailAQuien == ""){
$strCabeceras .= "To: " . $strNombreAQuien. "\r\n";
}
if ($strNombreDeQuien != "" && $strEmailDeQuien != ""){
$strCabeceras .= "From: " . $strNombreDeQuien . " <" . $strEmailDeQuien . ">\r\n";
}elseif ($strNombreDeQuien == "" && $strEmailDeQuien != ""){
$strCabeceras .= "From: ".$strEmailDeQuien."\r\n";
}elseif ($strNombreDeQuien != "" && $strEmailDeQuien == ""){
$strCabeceras .= "From: ".$strNombreDeQuien."\r\n";
}
if ($strCopias != ""){
$strCabeceras .= "Bcc: " . $strCopias ." \r\n";
}
$strError = mail($strEmailAQuien,$strAsunto,$strBody,$strCabeceras);
if(!$strError){?><script>alert('Ha habido un problema al mandar el e-mail.');</script><?}
return $strError;
}
function fGuardarFormulario1 (){
$strNombre = $_POST["txtNombre"];
$strApellido1 = $_POST["txtApellido1"];
$strApellido2 = $_POST["txtApellido2"];
$strDNI = $_POST["txtDNI"];
$strCalle = $_POST["txtCalle"];
$strNum = $_POST["txtNum"];
$strProvincia = $_POST["txtProvincia"];
$strCiudad = $_POST["txtCiudad"];
$strCP = $_POST["txtCP"];
$strPais = $_POST["txtPais"];
if(isset($_POST["txtTelefono"])){$strTelefono = $_POST["txtTelefono"];}else{$strTelefono="";}
if(isset($_POST["txtFax"])){$strFax = $_POST["txtFax"];}else{$strFax="";}
$strEmpresa = $_POST["txtEmpresa"];
$strSeccion = $_POST["txtSeccion"];
$strCalleE = $_POST["txtCalleE"];
$strNumE = $_POST["txtNumE"];
$strProvinciaE = $_POST["txtProvinciaE"];
$strCiudadE = $_POST["txtCiudadE"];
$strCPE = $_POST["txtCPE"];
$strPaisE = $_POST["txtPaisE"];
if(isset($_POST["txtTelefonoE"])){$strTelefonoE = $_POST["txtTelefonoE"];}else{$strTelefonoE="";}
if(isset($_POST["txtFaxE"])){$strFaxE = $_POST["txtFaxE"];}else{$strFaxE="";}
$strEmail = $_POST["txtEmail"];
$strDias = $_POST["hdnDias"];
$intBeca = $_POST["rdbBeca"];
$intAlojamiento = $_POST["rdbAlojamiento"];
$strNombre = PHPentities($strNombre);
$strApellido1 = PHPentities($strApellido1);
$strApellido2 = PHPentities($strApellido2);
$strCalle = PHPentities($strCalle);
$strDNI = PHPentities($strDNI);
$strNum = PHPentities($strNum);
$strProvincia = PHPentities($strProvincia);
$strCiudad = PHPentities($strCiudad);
$strPais = PHPentities($strPais);
$strCP = PHPentities($strCP);
$strEmpresa = PHPentities($strEmpresa);
$strSeccion = PHPentities($strSeccion);
$strCalleE = PHPentities($strCalleE);
$strNumE = PHPentities($strNumE);
$strProvinciaE = PHPentities($strProvinciaE);
$strCiudadE = PHPentities($strCiudadE);
$strPaisE = PHPentities($strPaisE);
$strCPE = PHPentities($strCPE);
AbreConexion ();
$strSelect = fSQLMaximoDatos ();
$objrow = EJECUTA_SELECT ($strSelect);
$row=mysql_fetch_assoc($objrow);
$intMaximo=$row["MAXIMO"];
if (!isset($intMaximo) || $intMaximo==""){
$intCodDatos=1;
}else{
$intCodDatos=intval($intMaximo) + 1;
}
$strInsert = fSQLMeterDatorForm1 ($intCodDatos,$strNombre,$strApellido1,$strApellido2,$strDNI,$strCalle,$strNum,$strCiudad,$strCP,$strProvincia,$strPais,$strTelefono,$strFax,$strEmpresa,$strSeccion,$strCalleE,$strNumE,$strCiudadE,$strCPE,$strProvinciaE,$strPaisE,$strTelefonoE,$strFaxE,$strEmail,$strDias,$intBeca,$intAlojamiento);
$objrow = EJECUTA_SELECT ($strInsert);
CierraConexion();
$strIrA="";
if ($intBeca == "1"){
$strIrA="index.php?pg=15&CodDatos=".$intCodDatos;
}else{
if ($intAlojamiento == "1"){
$strIrA="index.php?pg=16&CodDatos=".$intCodDatos;
}else{
fEnviarEmailInscripcion($intCodDatos,0);
}
}
if ($strIrA != ""){?>
<script>location.href='<?echo $strIrA;?>'</script>
<?}
}
function fGuardarFormulario2_NO_BORRAR_BECAS (){
$intCodDatos = $_POST["CodDatos"];
$strRazones=$_POST["txtRazones"];
$strMeritos=$_POST["txtMeritos"];
if(isset($_POST["rdbBeca"])){$intBeca = $_POST["rdbBeca"];}else{$intBeca=0;}
$intBecaPernoctacion = 0;
$intBecaDesplazamiento = 0;
if ($intBeca == "1"){$intBecaDesplazamiento = 1;}
elseif ($intBeca == "2"){$intBecaPernoctacion = 1;}
AbreConexion();
$strUpdate = fSQLModificarDatosForm2 ($intCodDatos,$strRazones,$strMeritos,$intBecaDesplazamiento,$intBecaPernoctacion);
$objrow = EJECUTA_SELECT ($strUpdate);
CierraConexion();
$strIrA="";
if ($intBeca == "2"){
$strIrA="index.php?pg=16&CodDatos=".$intCodDatos;
}else{
fEnviarEmailInscripcion($intCodDatos,0);
}
if ($strIrA != ""){?>
<script>location.href='<?echo $strIrA;?>'</script>
<?}
}
function fGuardarFormulario3 (){
$intCodDatos = $_POST["CodDatos"];
if(isset($_POST["txtDatosFiscales"])){$strFiscales = $_POST["txtDatosFiscales"];}else{$strFiscales="";}
if(isset($_POST["rdbBecaPernoctacion"])){$intBeca = $_POST["rdbBecaPernoctacion"];}else{$intBeca=0;}
if(isset($_POST["rdbAlojamiento"])){$intAlojamiento = $_POST["rdbAlojamiento"];}else{$intAlojamiento=0;}
$strHotel = $_POST["txtHotel"];
$intHabitaciones = $_POST["txtHabitaciones"];
$intDobles = $_POST["txtDobles"];
$intIndividuales = $_POST["txtIndividuales"];
$intLlegada = $_POST["cboLlegada"];
$intSalida = $_POST["cboSalida"];
$intNoches = $_POST["txtNoches"];
$intImporte = $_POST["txtImporte"];
$intTotal = $_POST["txtTotal"];
if(isset($_POST["txtDto"])){$intDto = $_POST["txtDto"];}else{$intDto=0;}
$strFiscales = PHPentities($strFiscales);
AbreConexion ();
$strUpdate = fSQLModificarForm3 ($intCodDatos,$strFiscales,$strHotel,$intHabitaciones,$intDobles,$intIndividuales,$intLlegada,$intSalida,$intNoches,$intImporte,$intTotal,$intDto,$intBeca,$intAlojamiento);
$objrow = EJECUTA_SELECT ($strUpdate);
CierraConexion ();
fEnviarEmailInscripcion($intCodDatos,0);
}
function fObtenerPasswordConfirmacion() {
$Letra ="ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
$i=1;
$strKodea="";
while ($i<=8) {
srand((double)microtime()*1000000);
$strRandom=rand(0,33);
$strLetraKodea = substr($Letra,$strRandom,1);
$strKodea = $strKodea . $strLetraKodea;
$i=$i+1;
}
return ($strKodea);
}
function fEnviarEmailInscripcion ($intCodDatos,$intConfirmacion){
$strPass = fObtenerPasswordConfirmacion();
AbreConexion();
$strSelect = fSQLObtenerDatos($intCodDatos);
$objrow = EJECUTA_SELECT ($strSelect);
$row=mysql_fetch_assoc($objrow);
$strNombre = $row["t758_1_nombre"];
$strApellido1 = $row["t758_1_apellido1"];
$strApellido2 = $row["t758_1_apellido2"];
$strDNI = $row["t758_1_dni"];
$strCalle = $row["t758_1_calle"];
$strNum = $row["t758_1_numero"];
$strCiudad = $row["t758_1_ciudad"];
$strCP = $row["t758_1_cp"];
$strProvincia = $row["t758_1_provincia"];
$strPais = $row["t758_1_pais"];
$strTelefono = $row["t758_1_telefono"];
$strFax = $row["t758_1_fax"];
$strEmpresa = $row["t758_1_empresa"];
$strSeccion = $row["t758_1_seccion"];
$strCalleE = $row["t758_1_callee"];
$strNumE = $row["t758_1_numeroe"];
$strCiudadE = $row["t758_1_ciudade"];
$strCPE = $row["t758_1_cpe"];
$strProvinciaE = $row["t758_1_provinciae"];
$strPaisE = $row["t758_1_paise"];
$strTelefonoE = $row["t758_1_telefonoe"];
$strFaxE = $row["t758_1_faxe"];
$intBeca = $row["t758_1_beca"];
$intAlojamiento = $row["t758_1_alojamiento"];
$strDias = $row["t758_1_dias"];
$strEmail = $row["t758_1_email"];
$strRazones = $row["t758_2_razones"];
$strMeritos = $row["t758_2_meritos"];
$intBeca1 = $row["t758_2_becadesplazamiento"];
$intBeca2 = $row["t758_2_becapernoctacion"];
$intAlojamiento2 = $row["t758_3_alojamiento"];
$strBody = "";
$strBody = "<html><head>".
"<style type=text/css>".
".textomnb{FONT: bold 10px Verdana; COLOR: #FFFFFF; TEXT-DECORATION: none }".
".textomn{FONT: bold 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none }".
".textom{FONT: 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none} ".
".textop{FONT: 9px Verdana; COLOR: #373e52; TEXT-DECORATION: none} ".
".textopb{FONT: 9px Verdana; COLOR: #ffffff; TEXT-DECORATION: none} ".
".textosp{FONT: 9px Arial; COLOR: #373e52; TEXT-DECORATION: none} ".
".textoxln{FONT: bold 15px Verdana; COLOR: #373e52; TEXT-DECORATION: none} ".
"</style>".
"<title>..:: EINSTEIN: Inscripciones ::..</title></head><body>".chr(13);
$strBody = $strBody . " <table align=center width=750 CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> " .chr(13);
if ($intConfirmacion == "1"){
$strBody = $strBody . "<tr><td class=textomn>ESTE E-MAIL ES PARA INFORMARLE QUE SU PRE-INSCRIPCI\D3N HA SIDO CONFIRMADA.</td></tr>" .chr(13);
}else{
$strBody = $strBody ."<tr><td class=textomn>Compruebe la validez de los datos  y confirme su solicitud, pulsando el bot\F3n enviar al final del formulario.</td></tr>".chr(13);
}
$strBody = $strBody . "<tr><td height=20></td></tr>".chr(13)."</table>".chr(13).
"<table align=center width=750 height=100% CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> ".chr(13).
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td class=textoxln align=center>Albert Einstein Annus Mirabilis</td></tr>".chr(13).
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td class=textom align=center>Donostia - San Sebasti\E1n</td></tr>".chr(13).
"	<tr><td class=textom align=center>5-8 Iraila-Septiembre-September</td></tr>".chr(13).
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td class=textom align=center>IZENA EMATEKO ORRIA / BOLET\CDN DE PRE-INSCRIPCION/ PRE-REGISTRATION FORM</td></tr>".chr(13);
$strSelect = fSQLFechaLimiteFormulario (1);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];
$strBody = $strBody . "<tr><td class=textop>Gehieneko data: ".$strFecha1." / Fecha L\EDmite: ".$strFecha2." / Deadline: ".$strFecha3."</td></tr>". chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;DATU PERTSONALAK / DATOS PERSONALES / PERSONAL DETAILS</td></tr>".chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td><table width=100% cellpadding=0 cellspacing=0>".chr(13).
"	<tr><td class=textop>ABIZENA 1-APELLIDO 1-SURNAME 1:</td><td><font class=textomn>".$strApellido1."</font></td></tr>".chr(13).
"	<tr><td class=textop>ABIZENA 2-APELLIDO 2-SURNAME 2:</td><td> <font class=textomn>".$strApellido2."</font></td></tr>".chr(13).
"	<tr><td class=textop>IZENA/ NOMBRE/ NAME:</td><td> <font class=textomn>".$strNombre."</font></td></tr>".chr(13).
"   <tr><td class=textop>NAN edo Pasaportea / DNI o Pasaporte / N.I.D. or Passport:</td><td> <font class=textomn>".$strDNI."</font></td></tr>".chr(13).
"	<tr><td class=textop>KALEA-CALLE-STREET:</td><td> <font class=textomn>".$strCalle."</font> </td></tr>".chr(13).
"   <tr><td class=textop>ZK / N\BA / N\BA:</td><td> <font class=textomn>".$strNum."</font></td></tr>".chr(13).
"	<tr><td class=textop>HIRIA / CIUDAD / CITY:</td><td> <font class=textomn>".$strCiudad."</font></td></tr>".chr(13).
"	<tr><td class=textop>KP / CP / PC:</td><td> <font class=textomn>".$strCP."</font></td></tr>".chr(13).
"	<tr><td class=textop>PROBINTZIA / PROVINCIA /PROVINCE:</td><td> <font class=textomn>".$strProvincia."</font></td></tr>".chr(13).
"	<tr><td class=textop>HERRIALDEA / PAIS / COUNTRY:</td><td> <font class=textomn>".$strPais."</font></td></tr>".chr(13).
"	<tr><td class=textop>TEL / TF / TEL (*):</td><td> <font class=textomn>".$strTelefono."</font></td></tr>".chr(13).
"	<tr><td class=textop>FAXA / FAX / FAX (*):</td><td> <font class=textomn>".$strFax."</font></td></tr> ".chr(13).
"	</td></tr></table>".
"	<tr><td height=15></td></tr>".chr(13).
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;DATU PROFESIONALAK / DATOS PROFESIONALES / PROFESSIONAL DETAILS</td></tr>".chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td><table width=100% cellpadding=0 cellspacing=0>".chr(13).
"	<tr><td class=textop>ERAKUNDEA EDO ENPRESA / INSTITUCION O EMPRESA / INSTITUTION OR COMPANY:</td><td> <font class=textomn>".$strEmpresa."</font></td></tr>".chr(13).
"	<tr><td class=textop>DEPARTAMENTUA EDO ATALA / DPTO. O SECCION / DEPT OR SECTION:</td><td> <font class=textomn>".$strSeccion."</font></td></tr>".chr(13).
"	<tr><td class=textop>KALEA-CALLE-STREET:</td><td> <font class=textomn>".$strCalleE."</font></td></tr>".chr(13).
"	<tr><td class=textop>ZK / N\BA / N\BA:</td><td> <font class=textomn>".$strNumE."</font></td></tr>".chr(13).
"	<tr><td class=textop>HIRIA / CIUDAD / CITY:</td><td> <font class=textomn>".$strCiudadE."</font></td></tr>".chr(13).
"	<tr><td class=textop>KP / CP / PC:</td><td> <font class=textomn>".$strCPE."</font></td></tr>".chr(13).
"	<tr><td class=textop>PROBINTZIA / PROVINCIA /PROVINCE:</td><td> <font class=textomn>".$strProvinciaE."</font></td></tr>".chr(13).
"	<tr><td class=textop>HERRIALDEA / PAIS / COUNTRY:</td><td> <font class=textomn>".$strPaisE."</font></td></tr>".chr(13).
"	<tr><td class=textop>TEL / TF / TEL (*):</td><td> <font class=textomn>".$strTelefonoE."</font></td></tr>".chr(13).
"	<tr><td class=textop>FAXA / FAX / FAX (*):</td><td> <font class=textomn>".$strFaxE."</font></td></tr>".chr(13).
"	</td></tr></table>".
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td>".chr(13).
"		<table align=center cellpadding=4 bgcolor=#E4E5E5>".chr(13).
"			<tr>".chr(13).
"				<td class=textop>HARREMANETARAKO E-MAILA JARRI<br>".
"				INDIQUENOS SU E-MAIL DE CONTACTO<br>".
"				WRITE IN YOUR CONTACT E-MAIL</td>".
"				<td>".chr(13).
"				<td><font class=textomn>".$strEmail."</font></td>".chr(13).
"			</tr>".chr(13).
"		</table>".chr(13).
"	</td></tr>".chr(13).
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td class=textop align=center>IRAILAK / SEPTIEMBRE / SEPTEMBER</td></tr>".chr(13).
"	<tr><td class=textop align=center><font class=textomn>".$strDias."</font></td></tr>".chr(13).
"	<tr><td height=15></td></tr>".chr(13).
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;BEKA ESKATU NAHI DUZU? / \BF DESEA SOLICITAR BECA? / DO YOU WANT TO APPLY FOR A GRANT?</td></tr>".chr(13);
if ($intBeca == "1"){
$strBody = $strBody . "<tr><td class=textop bgcolor=EFEFF0>BAI / SI / YES</td></tr>".chr(13);
}else{
$strBody = $strBody . "<tr><td class=textop bgcolor=EFEFF0>EZ / NO / NO</td></tr>".chr(13);
}
$strBody = $strBody . "	<tr><td height=10 bgcolor=EFEFF0></td></tr>".chr(13);
if ($intBeca == "0"){
$strBody = $strBody . "	<tr><td bgcolor=EFEFF0>".
"		<table width=100%>".chr(13).
"			<tr>".chr(13).
"				<td height=18 class=textomnb bgcolor=000000>".chr(13).
"					&nbsp;&nbsp;ALOJAMENDU ERRESERBA ORAIN FORMALIZATU NAHI DUZU?".
"					<br>&nbsp;&nbsp;\BF DESEA FORMALIZAR AHORA LA RESERVA DE SU ALOJAMIENTO ?".
"					<br>&nbsp;&nbsp;DO YOU WANT TO FORMALISE YOUR ACCOMMODATION BOOKING NOW?".
"				</td>".chr(13).
"				<td width=35% class=textop align=center>".chr(13);
if($intAlojamiento == "1"){
$strBody = $strBody . "BAI / SI / YES";
}else{
$strBody = $strBody . "EZ / NO / NO";
}
$strBody = $strBody . " </td>".
"			</tr>".chr(13).
"		</table>".
"	</td></tr>".chr(13);
}
$strBody = $strBody . " <tr><td height=20 bgcolor=EFEFF0></td></tr>".chr(13).
"</table>";
if($intBeca == "1"){
$strBody = $strBody . "<table align=center width=750 CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0>".
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td bgcolor=#E4E5E5 valign=top>".
"		<table align=center width=95% cellpadding=0 cellspacing=0>".
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td class=textop>Arrazoiak / Razones / Reasons</td></tr>".chr(13).
"			<tr><td><font class=textomn>".$strRazones."</font></td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td class=textop>Merituak / M\E9ritos / Merits</td></tr>".chr(13).
"			<tr><td class=textomn>".$strMeritos."</td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td bgcolor=#ffffff class=textop height=18>&nbsp;&nbsp;BEKA MOTAK / TIPOS DE BECA / TYPES OF GRANT</td></tr>".chr(13).
"			<tr><td height=5></td></tr>".chr(13).
"			<tr><td>".
"				<table>".
"					<tr><td bgcolor=000000 class=textopb>".
"						JOAN-ETORRIKO BEKA<br>".
"						BECA DE DESPLAZAMIENTO<br>".
"						TRAVEL GRANT".
"					</td>";
if($intBeca1 == "1"){
$strBody = $strBody . "<td class=textop>&nbsp;&nbsp;BAI / SI / YES &nbsp;</td>";
}else{
$strBody = $strBody . "<td class=textop>&nbsp;&nbsp;EZ / NO / NO &nbsp;</td>";
}
$strBody = $strBody . "</tr>".chr(13).
"				</table>".
"			</td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td>".
"				<table>".
"					<tr><td bgcolor=000000 class=textopb>".
"						GAUA IGAROTZEAGATIKOA<br>".
"						BECA DE PERNOCTACION<br>".
"						OVERNIGHT GRANT".
"					</td>";
if($intBeca2 == "1"){
$strBody = $strBody . "<td class=textop>&nbsp;&nbsp;BAI / SI / YES &nbsp;</td>";
}else{
$strBody = $strBody . "<td class=textop>&nbsp;&nbsp;EZ / NO / NO &nbsp;</td>";
}
$strBody = $strBody . "</tr>". chr(13).
"				</table>".
"			</td></tr>".chr(13);
$strBody = $strBody . " <tr><td height=10></td></tr>".chr(13);
$strSelect = fSQLFechaLimiteFormulario (2);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];
$strBody = $strBody . "		</table>".chr(13).
"	</td></tr>".chr(13).
"	<tr><td height=20></td></tr>".chr(13).
"</table>";
}
if ($intConfirmacion == "0"){
$strBody = $strBody . chr(13). "<table width=750 align=center><tr><td class=textom>".
"Si desea confirmar la pre-inscripci\F3n pulse <a href=".fDameRuta("A_Raiz")."index.php?pg=21&CodDatos=".$intCodDatos."&tipo=1&CodPass=".$strPass." target='inscripciones'><b>AQUI</b></a>".
"<br><br><br>Si por alg\FAn motivo no le funciona el link, copie y pegue en su navegador la siguiente direcci\F3n: ".
"<br><b>".fDameRuta("A_Raiz")."index.php?pg=21&CodDatos=".$intCodDatos."&tipo=1&CodPass=".$strPass."</b> ".
"</td></tr>".chr(13);
}
$strBody = $strBody . "</table></body></html>";
$strEmailAQuien = $strEmail;
$strNombreAQuien = $strNombre. " " .$strApellido1;
$strAsunto = "Confirmaci\F3nn de Solicitud";
$strEmailDeQuien = fDameRuta("E_Einstein");
$strNombreDeQuien = "Einstein inscripciones";
$strCopias = "";
if ($intConfirmacion == "1"){
$strCopias = fDameRuta("E_Confirmacion");
}
$strError = fEnviarCorreo ($strEmailAQuien,$strNombreAQuien,$strAsunto,$strEmailDeQuien,$strNombreDeQuien,$strCopias,$strBody);
if ($strError){
$strUpdate = fSQLMeterPassConfimacion ($intCodDatos,$strPass);
$objrow=EJECUTA_SELECT($strUpdate);
if (($intAlojamiento =="1" || $intAlojamiento2=="1") && $intConfirmacion == "0"){
fEnviarEmailAlojamiento ($intCodDatos,0);
}else{
if ($intConfirmacion == "0"){?>
<script>
alert ('Su petici\F3n ha sido enviada con \E9xito');
location.href='index.php?pg=1&opcion=2';
</script>
<?}
}
}
CierraConexion();
}
function fEnviarEmailAlojamiento ($intCodDatos,$intConfirmacion){
AbreConexion();
$strSelect = fSQLObtenerDatos($intCodDatos);
$objrow = EJECUTA_SELECT ($strSelect);
$row=mysql_fetch_assoc($objrow);
$strPass= $row["t758_pass"];
$strNombre = $row["t758_1_nombre"];
$strApellido1 = $row["t758_1_apellido1"];
$strApellido2 = $row["t758_1_apellido2"];
$strDNI = $row["t758_1_dni"];
$strCalle = $row["t758_1_calle"];
$strNum = $row["t758_1_numero"];
$strCiudad = $row["t758_1_ciudad"];
$strCP = $row["t758_1_cp"];
$strProvincia = $row["t758_1_provincia"];
$strPais = $row["t758_1_pais"];
$strTelefono = $row["t758_1_telefono"];
$strFax = $row["t758_1_fax"];
$strEmpresa = $row["t758_1_empresa"];
$strSeccion = $row["t758_1_seccion"];
$strCalleE = $row["t758_1_callee"];
$strNumE = $row["t758_1_numeroe"];
$strCiudadE = $row["t758_1_ciudade"];
$strCPE = $row["t758_1_cpe"];
$strProvinciaE = $row["t758_1_provinciae"];
$strPaisE = $row["t758_1_paise"];
$strTelefonoE = $row["t758_1_telefonoe"];
$strFaxE = $row["t758_1_faxe"];
$strEmail = $row["t758_1_email"];
$strFiscales = $row["t758_3_datosfiscales"];
$strHotel = $row["t758_3_hotel"];
$strHabitaciones = $row["t758_3_habitaciones"];
$intDobles = $row["t758_3_dobles"];
$intIndividuales = $row["t758_3_individuales"];
$intLlegada = $row["t758_3_llegada"];
$intSalida = $row["t758_3_salida"];
$intNoches = $row["t758_3_noches"];
$intImporte = $row["t758_3_importe"];
$intDto = $row["t758_3_dto"];
$intTotal = $row["t758_3_total"];
$intAlojamiento2 = $row["t758_3_alojamiento"];
$intBeca = $row["t758_1_beca"];
$strBody = "";
$strBody = "<html><head>".
"<style type=text/css>".
".textomnb{FONT: bold 10px Verdana; COLOR: #FFFFFF; TEXT-DECORATION: none }".
".textomn{FONT: bold 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none }".
".textom{FONT: 10px Verdana; COLOR: #373e52; TEXT-DECORATION: none} ".
".textop{FONT: 9px Verdana; COLOR: #373e52; TEXT-DECORATION: none} ".
".textopb{FONT: 9px Verdana; COLOR: #ffffff; TEXT-DECORATION: none} ".
".textosp{FONT: 9px Arial; COLOR: #373e52; TEXT-DECORATION: none} ".
".textoxln{FONT: bold 15px Verdana; COLOR: #373e52; TEXT-DECORATION: none} ".
"</style>".
"<title>..:: EINSTEIN: Inscripciones ::..</title></head><body>";
$strBody = $strBody . chr(13). " <table align=center width=750 CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> ";
if ($intConfirmacion == "1"){
$strBody = $strBody . "<tr><td class=textomn>ESTE E-MAIL ES PARA INFORMARLE QUE SU PRE-INSCRIPCI\D3N HA SIDO CONFIRMADA.</td></tr>";
}else{
$strBody = $strBody . "<tr><td class=textomn>Compruebe la validez de los datos  y confirme su solicitud, pulsando el bot\F3n enviar al final del formulario.</td></tr>";
}
$strBody = $strBody . chr(13). "<tr><td height=20></td></tr> </table>".
" <table align=center width=750 height=100% CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> ".
"	<tr><td height=10></td></tr>".
"	<tr><td class=textoxln align=center>Albert Einstein Annus Mirabilis</td></tr>".
"	<tr><td height=10></td></tr>".
"	<tr><td class=textom align=center>Donostia - San Sebasti\E1n</td></tr>".
"	<tr><td class=textom align=center>5-8 Iraila-Septiembre-September</td></tr>".
"	<tr><td height=10></td></tr>".
"	<tr><td class=textom align=center>IZENA EMATEKO ORRIA / BOLET\CDN DE PRE-INSCRIPCI\D3N/ PRE-REGISTRATION FORM</td></tr>";
$strSelect = fSQLFechaLimiteFormulario (3);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];
$strBody = $strBody . chr(13). "	<tr><td class=textop>Gehieneko data: ".$strFecha1." / Fecha L\EDmite: ".$strFecha2." / Deadline: ".$strFecha3."</td></tr>".
"	<tr><td height=20></td></tr>".
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;DATU PERTSONALAK / DATOS PERSONALES / PERSONAL DETAILS</td></tr>".
"	<tr><td height=5></td></tr>".
"	<tr><td><table width=100% cellpadding=0 cellspacing=0>".chr(13).
"	<tr><td class=textop>ABIZENA 1-APELLIDO 1-SURNAME 1:</td><td><font class=textomn>".$strApellido1."</font></td></tr>".chr(13).
"	<tr><td class=textop>ABIZENA 2-APELLIDO 2-SURNAME 2:</td><td> <font class=textomn>".$strApellido2."</font></td></tr>".chr(13).
"	<tr><td class=textop>IZENA/ NOMBRE/ NAME:</td><td> <font class=textomn>".$strNombre."</font></td></tr>".chr(13).
"   <tr><td class=textop>NAN edo Pasaportea / DNI o Pasaporte / N.I.D. or Passport:</td><td> <font class=textomn>".$strDNI."</font></td></tr>".chr(13).
"	<tr><td class=textop>KALEA-CALLE-STREET:</td><td> <font class=textomn>".$strCalle."</font> </td></tr>".chr(13).
"   <tr><td class=textop>ZK / N\BA / N\BA:</td><td> <font class=textomn>".$strNum."</font></td></tr>".chr(13).
"	<tr><td class=textop>HIRIA / CIUDAD / CITY:</td><td> <font class=textomn>".$strCiudad."</font></td></tr>".chr(13).
"	<tr><td class=textop>KP / CP / PC:</td><td> <font class=textomn>".$strCP."</font></td></tr>".chr(13).
"	<tr><td class=textop>PROBINTZIA / PROVINCIA /PROVINCE:</td><td> <font class=textomn>".$strProvincia."</font></td></tr>".chr(13).
"	<tr><td class=textop>HERRIALDEA / PAIS / COUNTRY:</td><td> <font class=textomn>".$strPais."</font></td></tr>".chr(13).
"	<tr><td class=textop>TEL / TF / TEL (*):</td><td> <font class=textomn>".$strTelefono."</font></td></tr>".chr(13).
"	<tr><td class=textop>FAXA / FAX / FAX (*):</td><td> <font class=textomn>".$strFax."</font></td></tr> ".chr(13).
"	</td></tr></table>".
"	<tr><td height=15></td></tr>".chr(13).
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;DATU PROFESIONALAK / DATOS PROFESIONALES / PROFESSIONAL DETAILS</td></tr>".chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td><table width=100% cellpadding=0 cellspacing=0>".chr(13).
"	<tr><td class=textop>ERAKUNDEA EDO ENPRESA / INSTITUCION O EMPRESA / INSTITUTION OR COMPANY:</td><td> <font class=textomn>".$strEmpresa."</font></td></tr>".chr(13).
"	<tr><td class=textop>DEPARTAMENTUA EDO ATALA / DPTO. O SECCION / DEPT OR SECTION:</td><td> <font class=textomn>".$strSeccion."</font></td></tr>".chr(13).
"	<tr><td class=textop>KALEA-CALLE-STREET:</td><td> <font class=textomn>".$strCalleE."</font></td></tr>".chr(13).
"	<tr><td class=textop>ZK / N\BA / N\BA:</td><td> <font class=textomn>".$strNumE."</font></td></tr>".chr(13).
"	<tr><td class=textop>HIRIA / CIUDAD / CITY:</td><td> <font class=textomn>".$strCiudadE."</font></td></tr>".chr(13).
"	<tr><td class=textop>KP / CP / PC:</td><td> <font class=textomn>".$strCPE."</font></td></tr>".chr(13).
"	<tr><td class=textop>PROBINTZIA / PROVINCIA /PROVINCE:</td><td> <font class=textomn>".$strProvinciaE."</font></td></tr>".chr(13).
"	<tr><td class=textop>HERRIALDEA / PAIS / COUNTRY:</td><td> <font class=textomn>".$strPaisE."</font></td></tr>".chr(13).
"	<tr><td class=textop>TEL / TF / TEL (*):</td><td> <font class=textomn>".$strTelefonoE."</font></td></tr>".chr(13).
"	<tr><td class=textop>FAXA / FAX / FAX (*):</td><td> <font class=textomn>".$strFaxE."</font></td></tr>".chr(13).
"	</td></tr></table>".
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td>".
"		<table align=center cellpadding=4 bgcolor=#E4E5E5>".
"			<tr>".
"				<td class=textop>HARREMANETARAKO E-MAILA JARRI<br>".
"				INDIQUENOS SU E-MAIL DE CONTACTO<br>".
"				WRITE IN YOUR CONTACT E-MAIL</td>".
"				<td>".
"				<td><font class=textomn>".$strEmail."</font></td>".
"			</tr>".
"		</table>".
"	</td></tr>".
"	<tr><td height=5></td></tr>";
if ($intBeca = "1"){
$strBody = $strBody . "	<tr><td>".
"				<table width=100%>".
"					<tr>".
"						<td height=18 class=textomnb bgcolor=000000>".
"							&nbsp;&nbsp;ZURE OSTATU HARTZEKO ERRESERBA ORAIN FORMALIZATU NAHI DUZU?".
"							<br>&nbsp;&nbsp;\BF DESEA FORMALIZAR AHORA LA RESERVA DE SU ALOJAMIENTO ?".
"							<br>&nbsp;&nbsp;DO YOU WANT TO FORMALISE YOUR ACCOMMODATION BOOKING NOW?".
"						</td>".
"						<td width=35% class=textop align=center>";
if($intAlojamiento2 == "1"){
$strBody = $strBody . "&nbsp;&nbsp; BAI / SI / YES";
}else{
$strBody = $strBody . "&nbsp;&nbsp; EZ / NO / NO";
}
$strBody = $strBody ."</td>".
"					</tr>".
"				</table>".
"			</td></tr>";
}
$strBody = $strBody . "	<tr><td><font class=textomn>".$strFiscales."</font></td></tr>".
"	<tr><td height=10></td></tr>".
"	<tr><td>".
"		<table width=100%>".
"			<tr><td height=10></td></tr>".
"			<tr><td>".
"				<table width=100% CELLPADDING=0 CELLSPACING=0>".
"					<tr><td class=textop colspan=2><b>ERRESERBA / RESERVA / RESERVATION</b></td></tr>".
"					<tr><td class=textosp>Aukeratutako hotela / Hotel Elegido / Hotel chosen</td><td> <font class=textomn>".$strHotel."</font></td></tr>".
"					<tr><td class=textosp>Logela(k) / Habitacion(es) / Room(s)</td><td> <font class=textomn>".$strHabitaciones."</font></td></tr>".
"					<tr><td class=textosp>Bikoitza(k) / Doble(s)  /Double</td><td> <font class=textomn>".$intDobles."</font></td></tr>".
"					<tr><td class=textosp>Banakoak(k) / Individual(es) / Single</td><td> <font class=textomn>".$intIndividuales."</font></td></tr>".
"					<tr><td class=textosp>Iritsiera eguna / Fecha de Llegada / Arrival date </td><td><font class=textomn>".$intLlegada."</font></td></tr>".
"					<tr><td class=textosp>Irteera eguna / Fecha de Salida / Departure date</td><td> <font class=textomn>".$intSalida."</font></td></tr>".
"					<tr><td class=textosp>Gauak orotara / Total Noches / Total Nights</td><td> <font class=textomn>".$intNoches."</font></td></tr>".
"					<tr><td class=textosp>Zenbateko Osoa / Importe Total / Total Amount</td><td> <font class=textomn>".$intImporte."\80</font></td></tr>";
if ($intBeca == "1"){
$strBody = $strBody  . "<tr><td class=textosp>Beka deskontua / Descuento por beca / Grant discount</td><td> <font class=textomn>".$intDto." \80</font> </td></tr>".
" <tr><td class=textosp> Orotara ordaintzeko / Total a pagar / Total a pagar</td><td> <font class=textomn>".$intTotal."\80</font> </td></tr>";
}else{
$strBody = $strBody  . "<tr><td colspan=2 class=textosp>Orotara ordaintzeko / Total a pagar / Total to pay</td><td> <font class=textomn>".$intTotal."\80</font> </td></tr>";
}
$strBody = $strBody  ."	</table>".
"			</td></tr>".
"		</table>".
"	</td></tr>".
"	<tr><td height=10></td></tr>".
"	<tr><td bgcolor=000000 class=textomnb height=18>&nbsp;&nbsp;ORDAINKETA MODUA / FORMA DE PAGO / METHOD OF PAYMENT</td></tr>".
"	<tr><td height=10></td></tr>".
"	<tr><td class=textop>".
"		<font color=#E67B1D>Ostatu hartzeko erreserba egin ondoren, Kongresuko Bidaia-Agentzia Ofiziala den Carlson Wagonlit Travelek erreserba idatziz (posta elektronikoz) ".
"		konfirmatuko dizu eta ordaintzeko moduak adieraziko dizkizu.</font><br><br>".
"		Una vez realizada la reserva de alojamiento, la Agencia de Viajes Oficial del Congreso, Carlson Wagonlit Travel le confirmar\E1 su reserva por escrito (v\EDa e-mail) y le indicar\E1 las".
"		formas de pago posible.<br><br>".
"		<font color=#009900>Once you have booked your accommodation, the Congress Official Travel Agency, Carlson Wagonlit Travel, will confirm your booking in writing (by e-mail) and will let you know".
"		the possible methods of payment.</font>".
"	</td></tr>".
"	<tr><td height=30></td></tr>".
"	<tr><td class=textosp>".
"		OSTATUARI BURUZKO INFORMAZIO GEHIAGORAKO:".
"		<br>PARA MAS INFORMACION SOBRE EL ALOJAMIENTO:".
"		<br>FOR FURTHER INFORMATION ABOUT ACCOMMODATION:".
"		<br><br>KONGRESUAREN AGENTZI OFIZIALA".
"		<br>AGENCIA OFICIAL DEL CONGRESO".
"		<br>Congress Official Agency".
"		<br>Carlons Wagonlit Travel".
"		<br>Sra. Ma\F1en Echarri".
"		<br>Fax: (34) 943 430532".
"		<br>E-mail: mecharri@carlsonwagonlit.es".
"	</td></tr>".
"	<tr><td height=20></td></tr>".
"</table>";
if ($intConfirmacion == "0"){
$strBody = $strBody . "<table width=750 align=center><tr><td class=textom>Si desea confirmar el alojamiento pulse <a href=".fDameRuta("A_Raiz")."index.php?pg=21&CodDatos=".$intCodDatos."&tipo=2&CodPass=".$strPass." target='inscripciones'><b>AQUI</b></a></td></tr></table></body></html>";
}
$strEmailAQuien = $strEmail;
$strNombreAQuien = $strNombre. " " .$strApellido1;
$strAsunto = "Confirmaci\F3n de Solicitud";
$strEmailDeQuien = fDameRuta("E_Einstein");
$strNombreDeQuien = "Einstein alojamiento";
$strCopias = "";
if ($intConfirmacion == "1"){
$strCopias = fDameRuta("E_Confirmacion");
}
$strError = fEnviarCorreo ($strEmailAQuien,$strNombreAQuien,$strAsunto,$strEmailDeQuien,$strNombreDeQuien,$strCopias,$strBody);
if ($strError){
if ($intConfirmacion == "0"){?>
<script>
alert ('Su petici\F3n ha sido enviada con \E9xito');
location.href='index.php?pg=1&opcion=2';
</script>
<?}
}
}
function fConfirmarInscripcion (){
$intCodDatos=$_GET["CodDatos"];
$strPass=$_GET["CodPass"];
$intTipo=$_GET["tipo"];
AbreConexion();
if ($intTipo == "1"){
$strUpdate = fSQLConfirmarInscripcionDatos($intCodDatos,$strPass);
$objrow=EJECUTA_SELECT ($strUpdate);
fEnviarEmailInscripcion ($intCodDatos,1);
}elseif ($intTipo == "2"){
$strUpdate = fSQLConfirmarInscripcionAlojamiento($intCodDatos,$strPass);
$objrow=EJECUTA_SELECT ($strUpdate);
fEnviarEmailAlojamiento ($intCodDatos,1);
}?>
<table align=center valign=middle>
<tr><td class=textom>
Zure inskripzioa egiaztatu eginda.
<br>Su inscripcion ha sido enviada con \E9xito.
</td></tr>
<tr><td height=10></td></tr>
<tr><td align=center class=textogn><a href="javascript:window.close();">x cerrar ventana</a></td></tr>
</table>
<?}
function fGuardarAlojamiento (){
$strNombre = $_POST["txtNombre"];
$strApellido1 = $_POST["txtApellido1"];
$strApellido2 = $_POST["txtApellido2"];
$strDNI = $_POST["txtDNI"];
$strCalle = $_POST["txtCalle"];
$strNum = $_POST["txtNum"];
$strProvincia = $_POST["txtProvincia"];
$strCiudad = $_POST["txtCiudad"];
$strCP = $_POST["txtCP"];
$strPais = $_POST["txtPais"];
if(isset($_POST["txtTelefono"])){$strTelefono = $_POST["txtTelefono"];}else{$strTelefono="";}
if(isset($_POST["txtFax"])){$strFax = $_POST["txtFax"];}else{$strFax="";}
$strEmpresa = $_POST["txtEmpresa"];
$strSeccion = $_POST["txtSeccion"];
$strCalleE = $_POST["txtCalleE"];
$strNumE = $_POST["txtNumE"];
$strProvinciaE = $_POST["txtProvinciaE"];
$strCiudadE = $_POST["txtCiudadE"];
$strCPE = $_POST["txtCPE"];
$strPaisE = $_POST["txtPaisE"];
if(isset($_POST["txtTelefonoE"])){$strTelefonoE = $_POST["txtTelefonoE"];}else{$strTelefonoE="";}
if(isset($_POST["txtFaxE"])){$strFaxE = $_POST["txtFaxE"];}else{$strFaxE="";}
$strEmail = $_POST["txtEmail"];
$intAlojamiento = 1;
$strDias = 0;
$intBeca = 0;
$strNombre = PHPentities($strNombre);
$strApellido1 = PHPentities($strApellido1);
$strApellido2 = PHPentities($strApellido2);
$strCalle = PHPentities($strCalle);
$strDNI = PHPentities($strDNI);
$strNum = PHPentities($strNum);
$strProvincia = PHPentities($strProvincia);
$strCiudad = PHPentities($strCiudad);
$strPais = PHPentities($strPais);
$strCP = PHPentities($strCP);
$strEmpresa = PHPentities($strEmpresa);
$strSeccion = PHPentities($strSeccion);
$strCalleE = PHPentities($strCalleE);
$strNumE = PHPentities($strNumE);
$strProvinciaE = PHPentities($strProvinciaE);
$strCiudadE = PHPentities($strCiudadE);
$strPaisE = PHPentities($strPaisE);
$strCPE = PHPentities($strCPE);
AbreConexion ();
$strSelect = fSQLMaximoDatos ();
$objrow = EJECUTA_SELECT ($strSelect);
$row=mysql_fetch_assoc($objrow);
$intMaximo=$row["MAXIMO"];
if (!isset($intMaximo) || $intMaximo==""){
$intCodDatos=1;
}else{
$intCodDatos=intval($intMaximo) + 1;
}
$strInsert = fSQLMeterDatorForm1 ($intCodDatos,$strNombre,$strApellido1,$strApellido2,$strDNI,$strCalle,$strNum,$strCiudad,$strCP,$strProvincia,$strPais,$strTelefono,$strFax,$strEmpresa,$strSeccion,$strCalleE,$strNumE,$strCiudadE,$strCPE,$strProvinciaE,$strPaisE,$strTelefonoE,$strFaxE,$strEmail,$strDias,$intBeca,$intAlojamiento);
$objrow = EJECUTA_SELECT ($strInsert);
if(isset($_POST["txtDatosFiscales"])){$strFiscales = $_POST["txtDatosFiscales"];}else{$strFiscales="";}
$intBeca=0;
$intAlojamiento="1";
$strHotel = $_POST["txtHotel"];
$intHabitaciones = $_POST["txtHabitaciones"];
$intDobles = $_POST["txtDobles"];
$intIndividuales = $_POST["txtIndividuales"];
$intLlegada = $_POST["cboLlegada"];
$intSalida = $_POST["cboSalida"];
$intNoches = $_POST["txtNoches"];
$intImporte = $_POST["txtImporte"];
$intTotal = $_POST["txtTotal"];
if(isset($_POST["txtDto"])){$intDto = $_POST["txtDto"];}else{$intDto=0;}
$strFiscales = PHPentities($strFiscales);
$strUpdate = fSQLModificarForm3 ($intCodDatos,$strFiscales,$strHotel,$intHabitaciones,$intDobles,$intIndividuales,$intLlegada,$intSalida,$intNoches,$intImporte,$intTotal,$intDto,$intBeca,$intAlojamiento);
$objrow = EJECUTA_SELECT ($strUpdate);
fEnviarEmailAlojamiento($intCodDatos,0);
CierraConexion();
}?>
