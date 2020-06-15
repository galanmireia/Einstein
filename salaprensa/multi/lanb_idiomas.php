<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<?function sEscribir($istrTexto)
{
$strTexto="";
switch($_SESSION["einstein_idioma"]){
case "es":
switch($istrTexto){
case "Castellano": $strTexto="Castellano";break;
case "Euskera": $strTexto="Euskera";break;
case "Ingles": $strTexto="Inglés";break;
case "Acceso": $strTexto="Acceso";break;
case "AlbertEinstein": $strTexto="Albert Einstein";break;
case "Ambito": $strTexto="Ámbito";break;
case "Ambito01": $strTexto="Local";break;
case "Ambito02": $strTexto="Regional";break;
case "Ambito03": $strTexto="Nacional";break;
case "Ambito04": $strTexto="Europeo";break;
case "Ambito05": $strTexto="Internacional";break;
case "AltaUsuario": $strTexto="Congreso Einstein - Prensa: Alta usuario";break;
case "Apellidos": $strTexto="Apellidos";break;
case "AsuntoBienvenido": $strTexto="Albert Einstein Annus Mirabilis 2005 - Sala de Prensa";break;
case "BancoImagenes": $strTexto="Banco de imágenes";break;
case "BienvenidoSalaPrensa": $strTexto="Bienvenido/a a la Sala de Prensa,\r\n\r\nSu clave de acceso a la Sala de Prensa del Congreso Albert Einstein Annus Mirabilis 2005 es: ".fDameRuta("C_Clave").".\r\n\r\nSi desea obtener más información no dude en contactar con el Gabinete de Prensa del Congreso.\r\n\r\nUn saludo.";break;
case "Borrar": $strTexto="Borrar";break;
case "Clave": $strTexto="Clave";break;
case "ClaveAcceso": $strTexto="Clave de acceso";break;
case "ClaveNoEnviada": $strTexto="Ha habido un error al enviar la clave. Por favor, intentelo de nuevo.";break;
case "ComiteOrganizativo": $strTexto="Comité Organizador";break;
case "ComoQuiereEntrevista": $strTexto="¿Cómo quiere realizar la entrevista?";break;
case "Contacto": $strTexto="Contacto";break;
case "ContactoMenu": $strTexto="<b>Gabinete de Prensa<br>Congreso Albert Einstein</b><br>Tel.: 943 31 08 31<br>Móvil: 617 300 217<br>Pers. Contacto: Cristina Ortega<br>E-mail: <a href='mailto:press@dipc-einstein05.com'>press@dipc-einstein05.com</a>";break;
case "Cuando": $strTexto="¿Cuándo?";break;
case "DarseDeAlta": $strTexto="Darse de alta";break;
case "DatosInvalidos": $strTexto="Datos del alta rellenada son inválidos";break;
case "DatosMedio": $strTexto="Datos del medio/s para el que trabaja:";break;
case "DatosSolicitante": $strTexto="Datos del solicitante";break;
case "DescargarAcrobat": $strTexto="Descargar Acrobat Reader";break;
case "Dia": $strTexto="Día: ";break;
case "DIPC": $strTexto="DIPC";break;
case "DossierDePrensa": $strTexto="Dossier de prensa";break;
case "Email": $strTexto="E-mail";break;
case "EmailPersonal": $strTexto="E-mail personal";break;
case "Entrar": $strTexto="Entrar";break;
case "EntrevistaComo1": $strTexto="Entrevista en persona";break;
case "EntrevistaComo2": $strTexto="Entrevista por teléfono";break;
case "EntrevistaComo3": $strTexto="Vía cuestionario";break;
case "EntrevistaComo4": $strTexto="Otra vía (indíquenoslo):";break;
case "EnTotal": $strTexto="en total";break;
case "Enviar": $strTexto="Enviar";break;
case "Fax": $strTexto="Fax";break;
case "Home": $strTexto="Home";break;
case "HoraLocal": $strTexto="Hora local aproximada: ";break;
case "IdiomaEntrevista": $strTexto="¿En qué idioma desea realizar la entrevista?";break;
case "ImagenNoEncontrada": $strTexto="Imagen no encontrada";break;
case "ImprimirNoticia": $strTexto="Imprimir noticia";break;
case "InformacionGeneral": $strTexto="Información general";break;
case "Inscripciones": $strTexto="Inscripciones";break;
case "IntroduzcaDatosAcceso": $strTexto="Introduzca sus datos de acceso";break;
case "LeRecordamosClave": $strTexto="Estimado Sr./Sra.,".
"\r\n\r\nSu clave de acceso a la Sala de Prensa del Congreso Albert Einstein Annus Mirabilis 2005 es: ".fDameRuta("C_Clave").".".
"\r\n\r\nSi desea obtener más información no dude en contactar con el Gabinete de Prensa del Congreso.".
"\r\n\r\nUn saludo.";break;
case "Links": $strTexto="Links";break;
case "Mes": $strTexto="Mes: ";break;
case "No": $strTexto="No";break;
case "NoHayImagenes": $strTexto="No se han encontrado imágenes";break;
case "NoHayNoticias": $strTexto="No se han encontrado noticias";break;
case "Nombre": $strTexto="Nombre";break;
case "NombreDelMedio": $strTexto="Nombre del medio";break;
case "NotaEntrevista": $strTexto="Nota: en el caso de publicar alguna noticia en prensa o soporte impreso, el Gabinete de Prensa del Congreso le agradecería enviara un original a la siguiente dirección: ";break;
case "OlvidoClave": $strTexto="¿Olvidó su clave?";break;
case "OtrosComentarios": $strTexto="Otros comentarios:";break;
case "Patrocinadores": $strTexto="Patrocinadores";break;
case "PDF_Dossier1": $strTexto="La figura de Albert Einstein (PDF - 23 Kb.)";break;
case "PDF_Dossier2": $strTexto="<a href='program_es.pdf'><b>El programa del Congreso</b></a> (PDF - 442 Kb.)";break;
case "PDF_Dossier3": $strTexto="Los ponentes (PDF - 23 Kb.)";break;
case "PonenteOrganizador": $strTexto="Ponente y/u organizador que desea entrevistar:";break;
case "Programa": $strTexto="Programa";break;
case "RecordatorioClave": $strTexto="Albert Einstein Annus Mirabilis 2005  Sala de Prensa  Recordatorio clave";break;
case "SalaDePrensa": $strTexto="Sala de prensa";break;
case "SalirAreaPrivada": $strTexto="Salir del área privada";break;
case "Si": $strTexto="Sí";break;
case "Siguiente": $strTexto="Siguiente";break;
case "SoliciteEntrevista": $strTexto="Solicite entrevista";break;
case "SolicitudEntrevista": $strTexto="Congreso Einstein - Prensa: Solicitud de entrevista";break;
case "Soporte": $strTexto="Soporte";break;
case "Soporte01": $strTexto="Impreso";break;
case "Soporte02": $strTexto="Electrónico";break;
case "Soporte03": $strTexto="Audivisual";break;
case "Soporte04": $strTexto="Radiofónico";break;
case "Soporte05": $strTexto="Otros soportes";break;
case "Subir": $strTexto="Top";break;
case "Telefono": $strTexto="Telefono";break;
case "TlfnContacto": $strTexto="Tfno. de contacto";break;
case "Texto_Acceso": $strTexto="<b>Sala de Prensa</b> es un área privada donde los profesionales de los medios de comunicación encontrarán toda la información de interés relacionada con el Congreso. ".
"<br><br>Podrá consultar desde el <b>dossier de prensa</b> y conocer las <b>últimas noticias</b> relacionadas con el Congreso, hasta la posibilidad de <b>descargar material fotográfico</b> y <b>solicitar entrevistas</b> tanto con los ponentes como con los organizadores de esta edición.";break;
case "Texto_Alta": $strTexto="Para poder acceder a la <b>Sala de Prensa</b>, rellene el <a href='index.php?pg=2'><b><u>formulario</u></b></a> que le facilitamos y recibirá su clave en la dirección de correo electrónico que nos especifique.";break;
case "Texto_AltaEnviada": $strTexto="Su petición de alta se ha cursado correctamente. En breve recibirá en su e-mail la clave con la que podrá acceder y visualizar todos los servicios disponibles en la <b>Sala de Prensa</b>.";break;
case "Texto_AltaNoEnviada": $strTexto="No se ha podido realizar correctamente su solicitud de alta a la Sala de Prensa. Rogamos vuelva a intentarlo de nuevo.";break;
case "Texto_Bienvenida": $strTexto="Bienvenid&#64; a la <b>Sala de Prensa</b> del Congreso. En este apartado podrá consultar y hacer uso de los siguientes servicios:".
"<br><br><ul><li><b>Dossier de Prensa</b>. Disponible el Dossier de Prensa genérico en el que encontrará información sobre la figura de <b>Albert Einstein</b>, el programa, los ponentes...".
"<br><br><li>Completo <b>banco de imágenes</b> donde están albergadas las fotografías de los ponentes, personalidades, actos...".
"<br><br><li>Ojear las <b>últimas noticias</b> que vayan surgiendo antes, durante y tras el Congreso.".
"<br><br><li>Y si quiere solicitar alguna entrevista con los ponentes y/u organizadores del Congreso, podrá hacerlo desde la opción <b>Solicite entrevista</b>. Tan sólo tendrá que indicarnos a quién o quienes desea realizar la entrevista, junto al día y la hora.</li></ul>";break;
case "Texto_Congreso": $strTexto="¿Cómo y cuándo tuvo conocimiento de la celebración del Congreso?";break;
case "Texto_DarseDeAlta": $strTexto="Para acceder a la <b>Sala de Prensa</b> ha de cumplimentar el siguiente formulario:";break;
case "Texto_Dossier1": $strTexto="Hemos desglosado el <b>Dossier de Prensa</b> con la finalidad de facilitar la consulta de la información que necesite.";break;
case "Texto_Dossier2": $strTexto="Y si desea descargar el <b>Dossier de Prensa</b> al completo, puede hacerlo desde aquí.";break;
case "Texto_Dossier3": $strTexto="<b>Albert Einstein Annus Mirabilis 2005<br>Dossier de Prensa</b><br>(PDF - 215 Kb.)";break;
case "Texto_Dossier4": $strTexto="Nota: para la visualización de archivos PDF requiere tener instalado Acrobat Reader. Si no lo tiene instalado, puede bajar el plug-in desde su página haciendo clic sobre el icono.";break;
case "Texto_Entrevista": $strTexto="Desde esta opción puede solicitar tantas entrevistas como lo desee. Para ello tan sólo ha de insertar los datos requeridos y desde el <b>Gabinete de Prensa del Congreso Albert Einstein</b> nos pondremos en contacto con usted.";break;
case "Texto_EntrevistaEnviada": $strTexto="Su solicitud se ha enviado correctamente. En breve recibirá respuesta del <b>Gabinete de Prensa del Congreso Albert Einstein.</b>";break;
case "Texto_EntrevistaEnviada1B": $strTexto="";break;
case "Texto_EntrevistaEnviada1A": $strTexto="Hemos recogido los datos para realizar una entrevista con";break;
case "Texto_EntrevistaEnviada2": $strTexto="Rogaríamos que si se publicase la entrevista en algún medio, ya sea en un soporte impreso o en internet, no los comunicase o en su defecto, nos remitiese un original o la dirección de la página en la que esté albergada.";break;
case "Texto_EntrevistaEnviada3": $strTexto="Si desea solicitar otra entrevista con otro ponente u organizador, haga clic en el botón Siguiente.";break;
case "Texto_EntrevistaNoEnviada": $strTexto="No se ha podido realizar correctamente su solicitud de entrevista a un ponente. Rogamos vuelva a intentarlo de nuevo.";break;
case "Texto_Enviada": $strTexto="Hemos enviado su clave a la dirección de correo electrónico insertada. ".
"<br><br>Si tiene algún problema y no puede acceder a la <b>Sala de Prensa</b>, no dude en contactar con el <b>Gabinete de Prensa del Congreso de Albert Einstein.</b> ";break;
case "Texto_ListadoNoticias": $strTexto="Listado de las últimas noticias acaecidas entorno al Congreso:";break;
case "Texto_Localizacion": $strTexto="Datos de la localización de la sede (dirección, C.P. localidad, país):";break;
case "Texto_Olvido": $strTexto="Si no recuerda su clave de acceso a la <b>Sala de Prensa</b>, indíquenos su dirección de correo electrónico junto a su nombre.";break;
case "Texto_Publicacion": $strTexto="Por favor, señálenos en qué programa y día se publicará su noticia:";break;
case "TrabajasFreelance": $strTexto="¿Trabaja como freelance?";break;
case "UltimasNoticias": $strTexto="Últimas noticias";break;
case "UsuarioIncorrecto": $strTexto="El usuario es incorrecto";break;
case "VerDiferido": $strTexto="Congreso online";break;
case "VerDiferidoURL": $strTexto="http://www.digitalak.com/einstein/einsteinesp.html";break;
case "Visualizando": $strTexto="Visualizando";break;
case "Volver": $strTexto="Volver";break;
case "Web": $strTexto="Web";break;
}
break;
case "eu":
$strTexto= "";
switch($istrTexto){
case "Castellano": $strTexto="Gaztelania";break;
case "Euskera": $strTexto="Euskara";break;
case "Ingles": $strTexto="Ingeles";break;
case "Acceso": $strTexto="Sarrera";break;
case "AlbertEinstein": $strTexto="Albert Einstein";break;
case "Ambito": $strTexto="Esparrua";break;
case "Ambito01": $strTexto="Tokikoa";break;
case "Ambito02": $strTexto="Eskualdekoa";break;
case "Ambito03": $strTexto="Nazionala";break;
case "Ambito04": $strTexto="Europakoa";break;
case "Ambito05": $strTexto="Nazioartekoa";break;
case "AltaUsuario": $strTexto="Einstein Kongresua - Prentsa: Erabiltzailearen alta";break;
case "Apellidos": $strTexto="Abizenak";break;
case "AsuntoBienvenido": $strTexto="Albert Einstein Annus Mirabilis 2005 - Prentsa Aretoa";break;
case "BancoImagenes": $strTexto="Irudiak";break;
case "BienvenidoSalaPrensa": $strTexto="Ongietorria Prentsa Bulegora,\r\n\r\nAlbert Einstein Annus Mirabilis 2005 kongresuko Prentsa Bulegoan sartzeko gakoa ondorengoa da: ".fDameRuta("C_Clave").".\r\n\r\nInformazio gehiago behar izanez gero Kongresuko Prentsa Aretoarekin kontaktuan jarri.\r\n\r\nAgur bero bat.";break;
case "Borrar": $strTexto="Ezabatu";break;
case "Clave": $strTexto="Gakoa";break;
case "ClaveAcceso": $strTexto="Sarrera gakoa";break;
case "ComiteOrganizativo": $strTexto="Antolakuntza Batzordea";break;
case "ComoQuiereEntrevista": $strTexto="Nola egin nahi duzu elkarrizketa?";break;
case "Contacto": $strTexto="Kontaktua";break;
case "ContactoMenu": $strTexto="<b>Albert Einstein<br>Kongresuko Prentsa Bulegoa</b><br>Tel.: 943 31 08 31<br>Mugikorra: 617 300 217<br>Harremanetarako pertsona: Cristina Ortega<br>Posta-elektronikoa: <a href='mailto:press@dipc-einstein05.com'>press@dipc-einstein05.com</a>";break;
case "Cuando": $strTexto="¿Noiz?";break;
case "DarseDeAlta": $strTexto="Alta ematea";break;
case "DatosInvalidos": $strTexto="Altan sartu dituzun datuak okerrak dira.";break;
case "DatosMedio": $strTexto="Lan egiten duzun komunikabide(ar)en datuak:";break;
case "DatosSolicitante": $strTexto="Eskatzailearen datuak";break;
case "DescargarAcrobat": $strTexto="Acrobat Reader jeitsi";break;
case "Dia": $strTexto="Eguna: ";break;
case "DIPC": $strTexto="DIPC";break;
case "DossierDePrensa": $strTexto="Prentsa-txostena";break;
case "Email": $strTexto="Email-a";break;
case "EmailPersonal": $strTexto="Posta elektroniko pertsonala";break;
case "Entrar": $strTexto="Sartu";break;
case "EntrevistaComo1": $strTexto="Aurrez aurre";break;
case "EntrevistaComo2": $strTexto="Telefono bidezko elkarrizketa";break;
case "EntrevistaComo3": $strTexto="Galdetegi bidez";break;
case "EntrevistaComo4": $strTexto="Beste nolabait (adierazi):";break;
case "EnTotal": $strTexto="guztira";break;
case "Enviar": $strTexto="Bidali";break;
case "Fax": $strTexto="Faxa";break;
case "Home": $strTexto="Home";break;
case "HoraLocal": $strTexto="Tokiko ordua (gutxi-gorabehera): ";break;
case "IdiomaEntrevista": $strTexto="Zein hizkuntzatan egin nahi duzu elkarrizketa?";break;
case "ImagenNoEncontrada": $strTexto="Irudia ezin izan da aurkitu";break;
case "ImprimirNoticia": $strTexto="Albistea inprimatu";break;
case "InformacionGeneral": $strTexto="Informazio orokorra";break;
case "Inscripciones": $strTexto="Izena emateak";break;
case "IntroduzcaDatosAcceso": $strTexto="Sartu zure sarrera-datuak";break;
case "LeRecordamosClave": $strTexto="Jaun/Andere agurgarria,".
"\r\n\r\nAlbert Einstein Annus Mirabilis 2005 kongresuko Prentsa Bulegoan sartzeko gakoa ondorengoa da: ".fDameRuta("C_Clave").".".
"\r\n\r\nInformazio gehiago behar izanez gero Kongresuko Prentsa Aretoarekin kontaktuan jarri.".
"\r\n\r\nAgur bero bat.";break;
case "Links": $strTexto="Linkak";break;
case "Mes": $strTexto="Hilabetea: ";break;
case "No": $strTexto="Ez";break;
case "NoHayImagenes": $strTexto="Ez da irudirik aurkitu";break;
case "NoHayNoticias": $strTexto="Ez da albisterik aurkitu";break;
case "Nombre": $strTexto="Izena";break;
case "NombreDelMedio": $strTexto="Komunikabidearen izena";break;
case "NotaEntrevista": $strTexto="Oharra:Prentsan edo idatziz albisteren bat erabiltzearen kasuan, Kongresuko Prentsa Bulegoak eskertuko lizuke jatorrizko bat ondoko helbidera bidaltzea: ";break;
case "OlvidoClave": $strTexto="Zure gakoa ahaztu duzu?";break;
case "OtrosComentarios": $strTexto="Beste komentario batzuk:";break;
case "Patrocinadores": $strTexto="Babesleak";break;
case "PDF_Dossier1": $strTexto="Albert Einsteinen irudia (PDF - 23 Kb.";break;
case "PDF_Dossier2": $strTexto="<a href='program_eu.pdf'><b>Kongresuko programa</b></a> (PDF - 442 Kb.)";break;
case "PDF_Dossier3": $strTexto="Hizlariak (PDF - 23 Kb.)";break;
case "PonenteOrganizador": $strTexto="Elkarrizketatu nahi duzun hizlari eta/edo antolatzailea:";break;
case "Programa": $strTexto="Programa";break;
case "RecordatorioClave": $strTexto="Albert Einstein Annus Mirabilis 2005  Prentsa Aretoa: Zure gakoa";break;
case "SalaDePrensa": $strTexto="Prentsa aretoa";break;
case "SalirAreaPrivada": $strTexto="Gune Pribatutik atera";break;
case "Si": $strTexto="Bai";break;
case "Siguiente": $strTexto="Hurrengoa";break;
case "SoliciteEntrevista": $strTexto="Eskatu elkarrizketa";break;
case "SolicitudEntrevista": $strTexto="Einstein Kongresua - Prentsa: Elkarrizketa eskaera";break;
case "Soporte": $strTexto="Euskarria";break;
case "Soporte01": $strTexto="Idatzia";break;
case "Soporte02": $strTexto="Elektronikoa";break;
case "Soporte03": $strTexto="Ikus-entzunezkoa";break;
case "Soporte04": $strTexto="Irratia";break;
case "Soporte05": $strTexto="Bestelako euskarriak";break;
case "Subir": $strTexto="Gora";break;
case "Telefono": $strTexto="Telefonoa";break;
case "TlfnContacto": $strTexto="Harremanetarako tel.";break;
case "Texto_Acceso": $strTexto="<b>Prentsa Aretoa</b> gune pribatua da eta bertan komunikabideetako profesionalek Kongrsuarekin erlazionaturiko informazio interesgarri guztia aurkituko dute. ".
"<br><br><b>Prentsa-txostena</b> kontsultatu edo Kongresuarekin erlazionaturiko <b>azken albisteak</b> ezagutu ahal izango dituzu, bai eta argazkiak deskargatu eta elkarrizketak eskatu ere, hala edizio honetako hizlariei nola antolatzaileei.";break;
case "Texto_Alta": $strTexto="<b>Prentsa Aretoan</b> sartu ahal izateko, bete ezazu ondoko <a href='index.php?pg=2'><b><u>formularioa</u></b></a> eta zure gakoa adierazten duzun posta elektronikoko helbidean jasoko duzu.";break;
case "Texto_AltaEnviada": $strTexto="Zure alta-eskaera behar bezala bideratu da. Laster zure posta elektronikoan jasoko duzu <b>Prentsa Aretoan</b> sartu eta eskuragarri dauden zerbitzu guztiak ikusi ahal izateko gakoa.";break;
case "Texto_AltaNoEnviada": $strTexto="Zure Prentsa Aretoko alta-eskaera ez da behar bezala bideratu. Mesedez, saia zaitez berriro.";break;
case "Texto_Bienvenida": $strTexto="Ongi etorri Kongresuko Prentsa Aretora. Atal honetan ondoko zerbitzuak kontsultatu eta erabili ahal izango dituzu:".
"<br><br><ul><li><b>Prentsa-txostena</b>. Prentsa Txosten orokorra eskuragarri dago eta bertan <b>Albert Einsteinen</b> irudiari , programari, hizlariei eta beste hainbat gaiei buruzko informazioa aurkituko duzu.".
"<br><br><li><b>Irudiak</b>, bertan daude hizlarien, pertsonaia ospetsuen, ekitaldien eta beste hainbat gauzen argazkiak.".
"<br><br><li><b>Azken albisteak</b>, Kongresua baino lehen, garatzen den bitartean eta ondoren gertatutakoak.".
"<br><br><li>Eta Kongresuko hizlari eta/edo antolatzaileekin elkarrizketa bat eskatu nahi baduzu, <b>Eskatu elkarrizketa</b> aukeratik egin ahal izango duzu. Ez duzu elkarrizketa nori, noiz eta non egin nahi diozun besterik adierazi beharko.</li></ul>";break;
case "Texto_Congreso": $strTexto="Noiz eta nola izan zenuen Kongresuaren berri?";break;
case "Texto_DarseDeAlta": $strTexto="<b>Prentsa Aretoan</b> sartzeko ondoko formularioa bete behar duzu:";break;
case "Texto_Dossier1": $strTexto="<b>Prentsa Txostena</b> bereizi dugu behar duzun informazioaren kontsulta errazteko helburuarekin.";break;
case "Texto_Dossier2": $strTexto="Eta Prentsa Txosten osoa deskargatu nahi baduzu, hemendik egin dezakezu.";break;
case "Texto_Dossier3": $strTexto="<b>Albert Einstein Annus Mirabilis 2005<br>Prentsa Txostena</b><br>(PDF - 215 Kb.)";break;
case "Texto_Dossier4": $strTexto="Oharra: PDF artxiboak ikusteko Acrobat Reader instalatuta eduki behar duzu. Ez badaukazu instalatuta, plug-ina bere orrialdetik jaitsi dezakezu ikonoaren gainean klik eginez.";break;
case "Texto_Entrevista": $strTexto="Aukera honetatik nahi hainbat elkarrizketa eska ditzakezu. Horretarako eskatutako datuak sartu beharko dituzu eta <b>Albert Einstein Kongresuko Prentsa Bulegotik</b> zurekin harremanetan jarriko gara.";break;
case "Texto_EntrevistaEnviada": $strTexto="Zure eskaera behar bezala bidali da. Laster jasoko duzu <b>Albert Einstein Kongresuko Prentsa Bulegoaren</b> erantzuna.";break;
case "Texto_EntrevistaEnviada1A": $strTexto="";break;
case "Texto_EntrevistaEnviada1B": $strTexto="(r)ekin elkarrizketa bat egiteko datuak bildu ditugu";break;
case "Texto_EntrevistaEnviada2": $strTexto="Eskertuko genizuke elkarrizketa komunikabideren batean argitaratuko bazenu, prentsa idatzian edo interneten izan, guri jakinaraztea edo orijinal bat edo zintzilikatuta dagoen orriaren helbidea bidaltzea.";break;
case "Texto_EntrevistaEnviada3": $strTexto="Beste hizlari edo antolatzaile batekin beste elkarrizketa bat eskatu nahi baduzu, sakatu Hurrengoa botoia.";break;
case "Texto_Enviada": $strTexto="Zure gakoa altako erregistroko posta elektronikoko helbidera bidali dugu. ".
"<br><br>Arazoren bat izan eta ezin baduzu Prentsa Aretoan sartu, ez zalantzarik izan <b>Albert Einstein Kongresuko Prentsa Bulegoarekin</b> harremanetan jartzeko. ";break;
case "Texto_ListadoNoticias": $strTexto="Kongresuaren inguruan gertatutako azken albisteen zerrenda.";break;
case "Texto_Localizacion": $strTexto="Egoitzaren datuak (helbidea, PK, herria, herrialdea,):";break;
case "Texto_Olvido": $strTexto="Ez baduzu <b>Prentsa Aretora</b> sartzeko zure gakoa gogoratzen, adierazi zure posta elektronikoko helbidea zure izenaren ondoan.";break;
case "Texto_Publicacion": $strTexto="Mesedez, adierazi zein programa eta egunetan argitaratuko den albistea:";break;
case "TrabajasFreelance": $strTexto="Freelance bezala lan egiten duzu?";break;
case "UltimasNoticias": $strTexto="Azken albisteak";break;
case "UsuarioIncorrecto": $strTexto="Erabiltzaile okerra";break;
case "VerDiferido": $strTexto="Kongresua online";break;
case "VerDiferidoURL": $strTexto="http://www.digitalak.com/einstein/einsteineus.html";break;
case "Visualizando": $strTexto="Ikusten";break;
case "Volver": $strTexto="Itzuli";break;
case "Web": $strTexto="Web-orria";break;
}
break;
case "uk":
$strTexto= "--TRAD--Inglés";
switch($istrTexto){
case "Castellano": $strTexto="Spanish";break;
case "Euskera": $strTexto="Vasque";break;
case "Ingles": $strTexto="English";break;
case "Acceso": $strTexto="Access";break;
case "AlbertEinstein": $strTexto="Albert Einstein";break;
case "Ambito": $strTexto="Area";break;
case "Ambito01": $strTexto="Local";break;
case "Ambito02": $strTexto="Regional";break;
case "Ambito03": $strTexto="National";break;
case "Ambito04": $strTexto="European";break;
case "Ambito05": $strTexto="International";break;
case "AltaUsuario": $strTexto="Albert Einstein Annus Mirabilis 2005 - Press: Register";break;
case "Apellidos": $strTexto="Last name(s)";break;
case "AsuntoBienvenido": $strTexto="Albert Einstein Annus Mirabilis 2005 - Press room";break;
case "BancoImagenes": $strTexto="Image bank";break;
case "BienvenidoSalaPrensa": $strTexto="Wellcome to Press Room,\r\n\r\nYour password to access to Press Room is:  ".fDameRuta("C_Clave");break;
case "Borrar": $strTexto="Clear";break;
case "Clave": $strTexto="Password";break;
case "ClaveAcceso": $strTexto="Access password";break;
case "ComiteOrganizativo": $strTexto="Organising Committee";break;
case "ComoQuiereEntrevista": $strTexto="How do you want to do the interview?";break;
case "Contacto": $strTexto="Contact";break;
case "ContactoMenu": $strTexto="<b>Albert Einstein<br>Conference - Press Office</b><br>Tel.: 943 31 08 31<br>Mobile: 617 300 217<br>Contact: Cristina Ortega<br>E-mail: <a href='mailto:press@dipc-einstein05.com'>press@dipc-einstein05.com</a>";break;
case "Cuando": $strTexto="When?";break;
case "DarseDeAlta": $strTexto="Register";break;
case "DatosMedio": $strTexto="Details of the media you work for";break;
case "DatosSolicitante": $strTexto="Applicant's details";break;
case "DescargarAcrobat": $strTexto="Download Acrobat Reader";break;
case "Dia": $strTexto="Day: ";break;
case "DIPC": $strTexto="DIPC";break;
case "DossierDePrensa": $strTexto="Press Pack";break;
case "Email": $strTexto="E-mail";break;
case "EmailPersonal": $strTexto="Private e-mail";break;
case "Entrar": $strTexto="Enter";break;
case "EntrevistaComo1": $strTexto="In person";break;
case "EntrevistaComo2": $strTexto="By phone";break;
case "EntrevistaComo3": $strTexto="By questionnaire";break;
case "EntrevistaComo4": $strTexto="Other (please specify):";break;
case "EnTotal": $strTexto="at all";break;
case "Enviar": $strTexto="Send";break;
case "Fax": $strTexto="Fax";break;
case "Home": $strTexto="Home";break;
case "HoraLocal": $strTexto="Approximate local time: ";break;
case "IdiomaEntrevista": $strTexto="What language do you want the interview to be in?";break;
case "ImagenNoEncontrada": $strTexto="Image not found";break;
case "ImprimirNoticia": $strTexto="Print";break;
case "InformacionGeneral": $strTexto="General information";break;
case "Inscripciones": $strTexto="Registration";break;
case "IntroduzcaDatosAcceso": $strTexto="Introduce your access details";break;
case "LeRecordamosClave": $strTexto="Your password to access to Press Room is: ".fDameRuta("C_Clave").".";break;
case "Links": $strTexto="Links";break;
case "Mes": $strTexto="Month: ";break;
case "No": $strTexto="No";break;
case "NoHayImagenes": $strTexto="No images has been found";break;
case "NoHayNoticias": $strTexto="No news has been found";break;
case "Nombre": $strTexto="First Name";break;
case "NombreDelMedio": $strTexto="Name of the media";break;
case "NotaEntrevista": $strTexto="Note: if you publish any news in the press or other print media, the conference press office would be grateful if you could send an original copy to the following address: ";break;
case "OlvidoClave": $strTexto="Forgotten your password?";break;
case "OtrosComentarios": $strTexto="Other remarks:";break;
case "Patrocinadores": $strTexto="Sponsors";break;
case "PDF_Dossier1": $strTexto="The figure of Albert Einstein (PDF - 23 Kb.)";break;
case "PDF_Dossier2": $strTexto="<a href='program_es.pdf'><b>The conference programme</b></a> (PDF - 422 Kb.)";break;
case "PDF_Dossier3": $strTexto="The speakers (PDF - 23 Kb.)";break;
case "PonenteOrganizador": $strTexto="Speaker and/or organiser you would like to interview:";break;
case "Programa": $strTexto="Programme";break;
case "RecordatorioClave": $strTexto="Albert Einstein Annus Mirabilis 2005 - Press Room: Your password.";break;
case "SalaDePrensa": $strTexto="Press room";break;
case "SalirAreaPrivada": $strTexto="Log out of Private Area";break;
case "Si": $strTexto="Yes";break;
case "Siguiente": $strTexto="Next";break;
case "SoliciteEntrevista": $strTexto="Request an interview";break;
case "SolicitudEntrevista": $strTexto="Albert Einstein Annus Mirabilis 2005 - Press: Request an interview";break;
case "Soporte": $strTexto="Type";break;
case "Soporte01": $strTexto="Print";break;
case "Soporte02": $strTexto="Electronic";break;
case "Soporte03": $strTexto="Audio-visual";break;
case "Soporte04": $strTexto="Radio/TV";break;
case "Soporte05": $strTexto="Other";break;
case "Subir": $strTexto="Top";break;
case "Telefono": $strTexto="Tel.";break;
case "TlfnContacto": $strTexto="Contact number";break;
case "Texto_Acceso": $strTexto="<b>The Press Room</b> is a private area where media professionals can find information of interest related on the conference. ".
"<br><br>You can browse our <b>press pack</b>, check for any <b>latest news</b> on the conference, <b>download photographic material</b> and <b>request interviews</b> with speakers or organisers.";break;
case "Texto_Alta": $strTexto="In order to access the Press Room, please fill out the <a href='index.php?pg=2'><b><u>form</u></b></a> provided. Your password will be sent to the e-mail address you specify.";break;
case "Texto_AltaEnviada": $strTexto="Your registration application has been correctly processed. A password will shortly be sent to your e-mail address which will enable you to access and view all available services in the <b>Press Room</b>.";break;
case "Texto_AltaNoEnviada": $strTexto="It has not been possible to complete your application for registration in the <b>Press Room</b>. Please try again.";break;
case "Texto_Bienvenida": $strTexto="Welcome to the Conference <b>Press room</b>. In this section you can check and use the following services:".
"<br><br><ul><li><b>Press Pack</b>. A general press pack is available with information on the figure of <b>Albert Einstein</b>, the programme, the speakers, etc. ".
"<br><br><li>Comprehensive <b>image bank</b> which will host photos of speakers, celebrities, events, etc.".
"<br><br><li>Check on the <b>latest news</b> as it comes in, before, during and after the conference.".
"<br><br><li>If you would like to interview conference speakers and/or organisers, you can use the <b>Request interview</b> option. Just enter the name of the person or people you would like to interview and the date and time.</li></ul>";break;
case "Texto_Congreso": $strTexto="How and when did you hear about the conference?";break;
case "Texto_DarseDeAlta": $strTexto="To access the <b>Press room</b> please complete the following form:";break;
case "Texto_Dossier1": $strTexto="We have broken the <b>Press Pack</b> down into sections to make it easier to find the information you need.";break;
case "Texto_Dossier2": $strTexto="And if you would like to download the entire <b>Press Pack</b>, you can do so here.";break;
case "Texto_Dossier3": $strTexto="<b>Albert Einstein Annus Mirabilis 2005<br>Press Pack</b><br>(PDF - 215 Kb.)";break;
case "Texto_Dossier4": $strTexto="Note : to view PDF files you will need to have Acrobat Reader installed on your computer. If you do not have Acrobat Reader installed, you can download the plug-in by clicking on the icon.";break;
case "Texto_Entrevista": $strTexto="Use this option to request as many interviews as you require. Just enter the necessary details and you will be contacted by the <b>Albert Einstein Conference Press Office</b>.";break;
case "Texto_EntrevistaEnviada": $strTexto="You request has been sent correctly. You will shortly receive an answer from the <b>press office of the Albert Einstein Conference.</b>";break;
case "Texto_EntrevistaEnviada1B": $strTexto="";break;
case "Texto_EntrevistaEnviada1A": $strTexto="We have collected the details for an interview with";break;
case "Texto_EntrevistaEnviada2": $strTexto="If the interview appears in print or on the Internet, we would be grateful if you could notify us or send us an original or the URL of the website hosting the interview.";break;
case "Texto_EntrevistaEnviada3": $strTexto="If you would like to request another interview with another speaker or organiser, please click the Next button.";break;
case "Texto_Enviada": $strTexto="We have sent your password to the e-mail address you specified in your registration. ".
"<br><br>If you have any problems and cannot access the <b>Press room</b>, please contact the <b>Press Office of the Albert Einstein Conference</b>.";break;
case "Texto_ListadoNoticias": $strTexto="List of latest news on and at the conference:";break;
case "Texto_Localizacion": $strTexto="Details of head office (address, post code. town/city, country):";break;
case "Texto_Olvido": $strTexto="If you can't remember your password for the <b>Press Room</b>, please enter your name and e-mail address.";break;
case "Texto_Publicacion": $strTexto="Please indicate what programme the news will appear in and on what date:";break;
case "TrabajasFreelance": $strTexto="Do you work freelance?";break;
case "UltimasNoticias": $strTexto="Lastest news";break;
case "UsuarioIncorrecto": $strTexto="Wrong user";break;
case "VerDiferido": $strTexto="Congress<br>online";break;
case "VerDiferidoURL": $strTexto="http://www.digitalak.com/einstein/einsteineng.html";break;
case "Visualizando": $strTexto="Viewing";break;
case "Volver": $strTexto="Back";break;
case "Web": $strTexto="URL";break;
}
break;
}
return $strTexto;
}?>
</body>
</html>
