<?
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
$strBody = $strBody . "<tr><td class=textomn>ESTE E-MAIL ES PARA INFORMARLE QUE SU INSCRIPCIÓN HA SIDO CONFIRMADA.</td></tr>" .chr(13);
}else{
$strBody = $strBody ."<tr><td class=textomn>Compruebe la validez de los datos  y confirme su solicitud, pulsando el botón enviar al final del formulario.</td></tr>".chr(13);
}
$strBody = $strBody . "<tr><td height=20></td></tr>".chr(13)."</table>".chr(13).
"<table align=center width=750 height=100% CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> ".chr(13).
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td class=textoxln align=center>Albert Einstein Annus Mirabilis</td></tr>".chr(13).
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td class=textom align=center>Donostia - San Sebastián</td></tr>".chr(13).
"	<tr><td class=textom align=center>5-8 Iraila-Septiembre-September</td></tr>".chr(13).
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td class=textom align=center>IZENA EMATEKO ORRIA / BOLETÍN DE PRE-INSCRIPCION/ PRE-REGISTRATION FORM</td></tr>".chr(13);
$strSelect = fSQLFechaLimiteFormulario (1);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];
$strBody = $strBody . "<tr><td class=textop>Gehieneko data: ".$strFecha1." / Fecha Límite: ".$strFecha2." / Deadline: ".$strFecha3."</td></tr>". chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;DATU PERTSONALAK / DATOS PERSONALES / PERSONAL DETAILS</td></tr>".chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td class=textop>ABIZENA 1-APELLIDO 1-SURNAME 1: <font class=textomn>".$strApellido1."</font> &nbsp; ABIZENA 2-APELLIDO 2-SURNAME 2: <font class=textomn>".$strApellido2."</font></td></tr>".chr(13).
"	<tr><td class=textop>IZENA/ NOMBRE/ NAME: <font class=textomn>".$strNombre."</font> &nbsp; NAN edo Pasaportea / DNI o Pasaporte / N.I.D. or Passport: <font class=textomn>".$strDNI."</font></td></tr>".chr(13).
"	<tr><td class=textop>KALEA-CALLE-STREET: <font class=textomn>".$strCalle."</font> &nbsp; ZK / Nº / Nº: <font class=textomn>".$strNum."</font> &nbsp; HIRIA / CIUDAD / CITY: <font class=textomn>".$strCiudad."</font></td></tr>".chr(13).
"	<tr><td class=textop>KP / CP / PC: <font class=textomn>".$strCP."</font> &nbsp; PROBINTZIA / PROVINCIA /PROVINCE: <font class=textomn>".$strProvincia."</font> &nbsp; HERRIALDEA / PAIS / COUNTRY: <font class=textomn>".$strPais."</font></td></tr>".chr(13).
"	<tr><td class=textop>TEL / TF / TEL (*): <font class=textomn>".$strTelefono."</font> &nbsp; FAXA / FAX / FAX (*): <font class=textomn>".$strFax."</font></td></tr> ".chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td height=15></td></tr>".chr(13).
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;DATU PROFESIONALAK / DATOS PROFESIONALES / PROFESSIONAL DETAILS</td></tr>".chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td class=textop>ERAKUNDEA EDO ENPRESA / INSTITUCION O EMPRESA / INSTITUTION OR COMPANY: <font class=textomn>".$strEmpresa."</font></td></tr>".chr(13).
"	<tr><td class=textop>DEPARTAMENTUA EDO ATALA / DPTO. O SECCION / DEPT OR SECTION: <font class=textomn>".$strSeccion."</font></td></tr>".chr(13).
"	<tr><td class=textop>KALEA-CALLE-STREET: <font class=textomn>".$strCalleE."</font> &nbsp; ZK / Nº / Nº: <font class=textomn>".$strNumE."</font> &nbsp; HIRIA / CIUDAD / CITY: <font class=textomn>".$strCiudadE."</font></td></tr>".chr(13).
"	<tr><td class=textop>KP / CP / PC: <font class=textomn>".$strCPE."</font> &nbsp; PROBINTZIA / PROVINCIA /PROVINCE: <font class=textomn>".$strProvinciaE."</font> &nbsp; HERRIALDEA / PAIS / COUNTRY: <font class=textomn>".$strPaisE."</font></td></tr>".chr(13).
"	<tr><td class=textop>TEL / TF / TEL (*): <font class=textomn>".$strTelefonoE."</font> &nbsp; FAXA / FAX / FAX (*): <font class=textomn>".$strFaxE."</font></td></tr>".chr(13).
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
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td class=textop align=center>ADIERAZI ZEIN EGUNETAN JOANGO ZAREN KONGRESURA/ INDIQUE LOS DIAS QUE QUIERE ASISTIR AL CONGRESO<br>".chr(13).
"	INDICATE THE DAYS THAT YOU WILL BE ATTENDING THE CONGRESS</td></tr>".chr(13).
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td class=textop align=center>IRAILAK / SEPTIEMBRE / SEPTEMBER</td></tr>".chr(13).
"	<tr><td class=textop align=center><font class=textomn>".$strDias."</font></td></tr>".chr(13).
"	<tr><td height=15></td></tr>".chr(13).
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;BEKA ESKATU NAHI DUZU? / ¿ DESEA SOLICITAR BECA? / DO YOU WANT TO APPLY FOR A GRANT?</td></tr>".chr(13);
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
"					<br>&nbsp;&nbsp;¿ DESEA FORMALIZAR AHORA LA RESERVA DE SU ALOJAMIENTO ?".
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
$strBody = $strBody . " <tr><td height=15 bgcolor=EFEFF0></td></tr>".chr(13).
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;INFORMAZIOA/ INFORMACION / INFORMATION</td></tr>".chr(13).
"	<tr><td height=5 bgcolor=EFEFF0></td></tr>".chr(13).
"	<tr><td class=textop bgcolor=EFEFF0>".
"		<font color=#E67B1D>Datu Pertsonalak babesteko Lege Organikoaren, abenduaren 13koaren ".
"		informa al interesado que cuantos datos facilite de forma voluntaria al DIPC (Donostia International Physics Center), serán".
"		incluidos en un fichero automatizado de datos de carácter personal creados y mantenido por la referida entidad. Los datos".
"		registrados en esta base de datos solo serán usados para la finalidad para la que han sido recogidos. Cualquier otro uso de".
"		los datos personales requerirá del previo y expreso consentimiento del interesado. Este podrá ejercer en cualquier momento".
"		sus derechos de rectificación, cancelación, modificación u oposición de sus datos personales, en la dirección del DIPC (Donostia".
"		International Physics Center).</font><br><br>".chr(13).
"		A efectos de lo dispuesto en la Ley Orgánica de protección de Datos de Carácter Personal 15/1999, de 13 de diciembre, se".
"		informa al interesado que cuantos datos facilite de forma voluntaria al DIPC (Donostia International Physics Center), serán".
"		incluidos en un fichero automatizado de datos de carácter personal creados y mantenido por la referida entidad. Los datos".
"		registrados en esta base de datos solo serán usados para la finalidad para la que han sido recogidos. Cualquier otro uso de".
"		los datos personales requerirá del previo y expreso consentimiento del interesado. Este podrá ejercer en cualquier momento".
"		sus derechos de rectificación, cancelación, modificación u oposición de sus datos personales, en la dirección del DIPC (Donostia".
"		International Physics Center).<br><br>".chr(13).
"		For the purposes of the provisions in the Organic Law regarding Personal Data Protection 15/1999, of the 13th of December,".
"		all interested parties are informed that any data that they voluntarily provide the DIPC with (Donostia International Physics".
"		Center), will be included in an automated personal data file created and maintained by the aforementioned body. The details".
"		recorded in this database will only be used for the purpose for which they have been gathered. Any other use of these personal".
"		details will require the prior express consent of the interested party. The latter may exercise their rights to correct, cancel, modify".
"		or object to their personal details at any time, at the DIPC (Donostia International Physics Center).".
"	</td></tr>".chr(13).
"	<tr><td height=20></td></tr>".chr(13).
"</table>";
if($intBeca == "1"){
$strBody = $strBody . "<table align=center width=750 height=100% CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0>".
"	<tr><td height=10></td></tr>".chr(13).
"	<tr><td class=textom align=center>BEKA ESKATZEKO ORRIA / BOLETIN DE SOLICITUD DE BECA / GRANT APPLICATION FORM</td></tr>".chr(13).
"	<tr><td class=textom align=center>Gehieneko data: 2005eko maiatzak 31 / Fecha Límite: 31 de Mayo de 2005 / Deadline: 31<sup>st</sup> of May 2005</td></tr>".chr(13).
"	<tr><td height=5></td></tr>".chr(13).
"	<tr><td bgcolor=#E4E5E5>".
"		<table align=center width=95% cellpadding=0 cellspacing=0>".
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td class=textosp align=center><u>Beka-eskaerari buruzko informazioa / Informacion sobre solicitud de becas / Information about Grant applications</u></td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td bgcolor=#ffffff class=textop height=18>&nbsp;&nbsp;DERRIGORREZ BETETZEKO / A RELLENAR OBLIGATORIAMENTE / THIS MUST BE FILLED IN</td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td class=textop>".
"				Atal bakoitzean gehienez 200 hitz.<br>".
"				No más de 200 palabras por cada apartado.<br>".
"				No more than 200 words per section".
"			</td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td class=textop>Arrazoiak / Razones / Reasons</td></tr>".chr(13).
"			<tr><td><font class=textomn>".$strRazones."</font></td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13).
"			<tr><td class=textop>Merituak / Méritos / Merits</td></tr>".chr(13).
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
"			<tr><td height=5></td></tr>".chr(13).
"			<tr><td class=textop>".
"				Joan-etorriko beka lortzeko aukera du: (Donostiatik eta inguruetatik kanpo bizi direnentzat bakarrik)<br>".
"				Opta a beca de desplazamiento: (sólo para aquellos que residan fuera de San Sebastián y alrededores)<br>".
"				Application for a travel grant: (only for people who live outside San Sebastián and its surrounding area)<br><br>".
"				Zenbatekoa: 25 € / egun - Importe : 25 € / día - Amount : 25 € / day".
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
"			</td></tr>".chr(13).
"			<tr><td class=textop>".
"				Gaua igarotzeagatiko beka lortzeko aukera du: (EAEtik eta Nafarrotik kanpo bizi diren eta gaua Donostian igarotzen dutenentzat bakarrik)<br>".
"				Opta a beca de pernoctación: (sólo para aquellos que residan fuera de la C.A.V. y Navarra y pernocten en San Sebastián)<br>".
"				Application for overnight grant: (only for people who live outside the Basque Autonomous Community and Navarra and stay overnight in San Sebastián)<br><br>".
"				Gehieneko zenbatekoa: 100 € /gaua - Importe Máximo: 100 € / noche - Maximum amount: 100 € / night".
"				Ezinbestekoa da ostatu hartzeko orria betetzea / Imprescindible rellenar boletín de alojamiento / You must fill in the accommodation form / ".
"			</td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13);
$strBody = $strBody . " <tr><td height=10></td></tr>".chr(13);
$strSelect = fSQLFechaLimiteFormulario (2);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];
$strBody = $strBody . "	<tr><td class=textop>Gehieneko data: ".$strFecha1." / Fecha Límite: ".$strFecha2." / Deadline: ".$strFecha3."</td></tr>".chr(13).
"			<tr><td height=10></td></tr>".chr(13).
"		</table>".chr(13).
"	</td></tr>".chr(13).
"	<tr><td height=20></td></tr>".chr(13).
"</table>";
}
if ($intConfirmacion == "0"){
$strBody = $strBody . chr(13). "<table width=750 align=center><tr><td class=textom>Si desea confirmar la inscripción pulse <a href=".fDameRuta("A_Raiz")."index.php?pg=21&CodDatos=".$intCodDatos."&tipo=1&CodPass=".$strPass." target='inscripciones'><b>AQUI</b></a></td></tr>".chr(13);
}
$strBody = $strBody . "</table></body></html>";
$strEmailAQuien = $strEmail;
$strNombreAQuien = $strNombre. " " .$strApellido1;
$strAsunto = "Confirmación de Solicitud";
$strEmailDeQuien = fDameRuta("E_Einstein");
$strNombreDeQuien = "Einstein ::.. Inscripciones";
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
alert ('Su petición ha sido enviada con éxito');
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
$strBody = $strBody . "<tr><td class=textomn>ESTE E-MAIL ES PARA INFORMARLE QUE SU INSCRIPCIÓN HA SIDO CONFIRMADA.</td></tr>";
}else{
$strBody = $strBody . "<tr><td class=textomn>Compruebe la validez de los datos  y confirme su solicitud, pulsando el botón enviar al final del formulario.</td></tr>";
}
$strBody = $strBody . chr(13). "<tr><td height=20></td></tr> </table>".
" <table align=center width=750 height=100% CELLPADDING=0 CELLSPACING=0 topmargin=0 leftmargin=0 border=0> ".
"	<tr><td height=10></td></tr>".
"	<tr><td class=textoxln align=center>Albert Einstein Annus Mirabilis</td></tr>".
"	<tr><td height=10></td></tr>".
"	<tr><td class=textom align=center>Donostia - San Sebastián</td></tr>".
"	<tr><td class=textom align=center>5-8 Iraila-Septiembre-September</td></tr>".
"	<tr><td height=10></td></tr>".
"	<tr><td class=textom align=center>IZENA EMATEKO ORRIA / BOLETÍN DE PRE-INSCRIPCION/ PRE-REGISTRATION FORM</td></tr>";
$strSelect = fSQLFechaLimiteFormulario (3);
$objrow = EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strFecha1 = $row["t761_fecha1"];
$strFecha2 = $row["t761_fecha2"];
$strFecha3 = $row["t761_fecha3"];
$strBody = $strBody . chr(13). "	<tr><td class=textop>Gehieneko data: ".$strFecha1." / Fecha Límite: ".$strFecha2." / Deadline: ".$strFecha3."</td></tr>".
"	<tr><td height=20></td></tr>".
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;DATU PERTSONALAK / DATOS PERSONALES / PERSONAL DETAILS</td></tr>".
"	<tr><td height=5></td></tr>".
"	<tr><td class=textop>ABIZENA 1-APELLIDO 1-SURNAME 1: <font class=textomn>".$strApellido1."</font> &nbsp; ABIZENA 2-APELLIDO 2-SURNAME 2: <font class=textomn>".$strApellido2."</font></td></tr>".
"	<tr><td class=textop>IZENA/ NOMBRE/ NAME: <font class=textomn>".$strNombre."</font> &nbsp; NAN edo Pasaportea / DNI o Pasaporte / N.I.D. or Passport: <font class=textomn>".$strDNI."</font></td></tr>".
"	<tr><td class=textop>KALEA-CALLE-STREET: <font class=textomn>".$strCalle."</font> &nbsp; ZK / Nº / Nº: <font class=textomn>".$strNum."</font> &nbsp; HIRIA / CIUDAD / CITY: <font class=textomn>".$strCiudad."</font></td></tr>".
"	<tr><td class=textop>KP / CP / PC: <font class=textomn>".$strCP."</font> &nbsp; PROBINTZIA / PROVINCIA /PROVINCE: <font class=textomn>".$strProvincia."</font> &nbsp; HERRIALDEA / PAIS / COUNTRY: <font class=textomn>".$strPais."</font></td></tr>".
"	<tr><td class=textop>TEL / TF / TEL (*): <font class=textomn>".$strTelefono."</font> &nbsp; FAXA / FAX / FAX (*): <font class=textomn>".$strFax."</font></td></tr> ".
"	<tr><td height=5></td></tr>".
"	<tr><td class=textosp>(*) Ez da derrigorrezkoa datu hau betetzea / No es necesario rellenarlo obligatoriamente / It is not compulsory to fill this in</td></tr>".
"	<tr><td height=15></td></tr>".
"	<tr><td height=18 class=textomnb bgcolor=000000>&nbsp;&nbsp;DATU PROFESIONALAK / DATOS PROFESIONALES / PROFESSIONAL DETAILS</td></tr>".
"	<tr><td height=5></td></tr>".
"	<tr><td class=textop>".
"		Ez da derrigorrezkoa erakunde bati atxikita egotea. Erakunde bateko partaide bazara bete ezazu atal hori. Zenbait erakundek Kongresuaren Antolakuntzarekin akordio puntualak dituzte bekei eta".
"		laguntzei dagokienez <font color=#E67B1D>que puedan ser otorgadas.</font><br>".
"		No es obligatorio estar adscrito a una organización. Si pertenece a una organización rellene ese apartado. Algunas organizaciones tienen acuerdos puntuales con la Organización del Congreso,".
"		en lo referente a becas y ayudas <font color=#E67B1D>que puedan ser otorgadas.</font><br>".
"		It is not compulsory to be attached to an organisation. If you belong to an organisation, fill in this section. Some organisations have specific agreements with the Congress Organisers, concerning".
"		grants and support that can be provided.".
"	</td></tr>".
"	<tr><td height=5></td></tr>";
$strBody  = $strBody . chr(13) . " <tr><td class=textop>ERAKUNDEA EDO ENPRESA / INSTITUCION O EMPRESA / INSTITUTION OR COMPANY: <font class=textomn>".$strEmpresa."</font></td></tr>".
"	<tr><td class=textop>DEPARTAMENTUA EDO ATALA / DPTO. O SECCION / DEPT OR SECTION: <font class=textomn>".$strSeccion."</font></td></tr>".
"	<tr><td class=textop>KALEA-CALLE-STREET: <font class=textomn>".$strCalleE."</font> &nbsp; ZK / Nº / Nº: <font class=textomn>".$strNumE."</font> &nbsp; HIRIA / CIUDAD / CITY: <font class=textomn>".$strCiudadE."</font></td></tr>".
"	<tr><td class=textop>KP / CP / PC: <font class=textomn>".$strCPE."</font> &nbsp; PROBINTZIA / PROVINCIA /PROVINCE: <font class=textomn>".$strProvinciaE."</font> &nbsp; HERRIALDEA / PAIS / COUNTRY: <font class=textomn>".$strPaisE."</font></td></tr>".
"	<tr><td class=textop>TEL / TF / TEL (*): <font class=textomn>".$strTelefonoE."</font> &nbsp; FAXA / FAX / FAX (*): <font class=textomn>".$strFaxE."</font></td></tr>".
"	<tr><td height=5></td></tr>".
"	<tr><td class=textosp>(*) Ez da derrigorrezkoa datu hau betetzea / No es necesario rellenarlo obligatoriamente / It is not compulsory to fill this in</td></tr>".
"	<tr><td height=5></td></tr>".
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
"							<font color=#E67B1D>&nbsp;&nbsp;ZURE OSTATU HARTZEKO ERRESERBA ORAIN FORMALIZATU NAHI DUZU?</font>".
"							<br>&nbsp;&nbsp;¿ DESEA FORMALIZAR AHORA LA RESERVA DE SU ALOJAMIENTO ?".
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
"					<tr><td class=textosp>Aukeratutako hotela / Hotel Elegido / Hotel chosen <font class=textomn>".$strHotel."</font></td>".
"					<td class=textosp>Logela(k) / Habitacion(es) / Room(s) <font class=textomn>".$strHabitaciones."</font></td></tr>".
"					<tr><td class=textosp>Bikoitza(k) / Doble(s)  /Double <font class=textomn>".$intDobles."</font></td>".
"					<td class=textosp>Banakoak(k) / Individual(es) / Single <font class=textomn>".$intIndividuales."</font></td></tr>".
"					<tr><td class=textosp>Iritsiera eguna / Fecha de Llegada / Arrival date <font class=textomn>".$intLlegada."</font></td>".
"					<td class=textosp>Irteera eguna / Fecha de Salida / Departure date <font class=textomn>".$intSalida."</font></td></tr>".
"					<tr><td class=textosp>Gauak orotara / Total Noches / Total Nights <font class=textomn>".$intNoches."</font></td>".
"					<td class=textosp>Zenbateko Osoa / Importe Total / Total Amount <font class=textomn>".$intImporte."</font> €</td></tr>";
if ($intBeca == "1"){
$strBody = $strBody  . " <tr><td class=textosp>Beka deskontua / Descuento por beca / Grant discount <font class=textomn>".$intDto."</font> €</td>".
" <td class=textosp>Orotara ordaintzeko / Total a pagar / Total a pagar <font class=textomn>".$intTotal."</font> €</td></tr>";
}else{
$strBody = $strBody  . " <tr><td colspan=2 class=textosp>Orotara ordaintzeko / Total a pagar / Total Amount <font class=textomn>".$intTotal."</font> €</td></tr>";
}
$strBody = $strBody  ."	</table>".
"			</td></tr>".
"		</table>".
"	</td></tr>".
"	<tr><td height=10></td></tr>".
"	<tr><td bgcolor=000000 class=textomnb height=18>&nbsp;&nbsp;ORDAINKETA MODUA / FORMA DE PAGO / <font color=#E67B1D>METHOD OF PAYMENT</font></td></tr>".
"	<tr><td height=10></td></tr>".
"	<tr><td class=textop>".
"		<font color=#E67B1D>Ostatu hartzeko erreserba egin ondoren, Kongresuko Bidaia-Agentzia Ofiziala den Carlson Wagonlit Travelek erreserba idatziz (posta elektronikoz) ".
"		konfirmatuko dizu eta ordaintzeko moduak adieraziko dizkizu.</font><br><br>".
"		Una vez realizada la reserva de alojamiento, la Agencia de Viajes Oficial del Congreso, Carlson Wagonlit Travel le confirmará su reserva por escrito (vía e-mail) y le indicará las".
"		formas de pago posible.<br><br>".
"		Once you have booked your accommodation, the Congress Official Travel Agency, Carlson Wagonlit Travel, will confirm your booking in writing (by e-mail) and will let you know".
"		the possible methods of payment.".
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
"		<br>Sra. Mañen Echarri".
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
$strAsunto = "Confirmación de Solicitud";
$strEmailDeQuien = fDameRuta("E_Einstein");
$strNombreDeQuien = "Einstein ::.. Alojamiento";
$strCopias = "";
if ($intConfirmacion == "1"){
$strCopias = fDameRuta("E_Confirmacion");
}
$strError = fEnviarCorreo ($strEmailAQuien,$strNombreAQuien,$strAsunto,$strEmailDeQuien,$strNombreDeQuien,$strCopias,$strBody);
if ($strError){
if ($intConfirmacion == "0"){?>
<script>
alert ('Su petición ha sido enviada con éxito');
location.href='index.php?pg=1&opcion=2';
</script>
<?}
}
}
?>
