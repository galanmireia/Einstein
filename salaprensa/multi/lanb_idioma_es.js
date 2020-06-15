function fM(strMensaje) {
	strD="";
	switch (strMensaje) {
		
		case "EmailFormatoIncorrecto" : {strD="El formato del e-mail es incorrecto.";}break;
		case "IntroduzcaApellidos" : {strD="Introduzca sus apellidos";}break;
		case "IntroduzcaClave" : {strD="Introduzca su clave";}break;
		case "IntroduzcaCongreso" : {strD="Introduzca cómo y cuándo tuvo conocimiento de celebración del Congreso";}break;
		case "IntroduzcaDatosLocalizacion" : {strD="Introduzca los datos de la localización de la sede";}break;
		case "IntroduzcaDia" : {strD="Introduzca el día";}break;
		case "IntroduzcaEmail" : {strD="Introduzca su e-mail";}break;
		case "IntroduzcaEmailPersonal" : {strD="Introduzca su e-mail personal";}break;
		case "IntroduzcaHora" : {strD="Introduzca la hora";}break;
		case "IntroduzcaMedio" : {strD="Introduzca el nombre del medio";}break;
		case "IntroduzcaMes" : {strD="Introduzca el mes";}break;
		case "IntroduzcaNombre" : {strD="Introduzca su nombre";}break;
		case "IntroduzcaPublicacion" : {strD="Señale en qué programa y día se publicará su noticia";}break;
		case "IntroduzcaTelefono" : {strD="Introduzca el teléfono";}break;
		case "IntroduzcaTlfnContacto" : {strD="Introduzca su teléfono de contacto";}break;
		case "IntroduzcaQueOtra" : {strD="Introduzca en qué otra vía desea realizar la entrevista.";}break;
	}
	return strD;
}
