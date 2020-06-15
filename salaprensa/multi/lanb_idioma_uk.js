function fM(strMensaje) {
	strD="";
	switch (strMensaje) {
		case "EmailFormatoIncorrecto" : {strD="This is not a valid e-mail";}break;
		case "IntroduzcaApellidos" : {strD="Please enter the last name(s)";}break;
		case "IntroduzcaClave" : {strD="Please enter the password";}break;
		case "IntroduzcaCongreso" : {strD="How and when did you hear about the conference?";}break;
		case "IntroduzcaDatosLocalizacion" : {strD="Please enter the details of head office ";}break;
		case "IntroduzcaDia" : {strD="Please enter the day";}break;
		case "IntroduzcaEmail" : {strD="Please enter the e-mail";}break;
		case "IntroduzcaEmailPersonal" : {strD="Please enter the personal e-mail";}break;
		case "IntroduzcaHora" : {strD="Please enter the hour";}break;
		case "IntroduzcaMedio" : {strD="Please enter the name of the media";}break;
		case "IntroduzcaMes" : {strD="Please enter the month";}break;
		case "IntroduzcaNombre" : {strD="Please enter the firts name";}break;
		case "IntroduzcaPublicacion" : {strD="Please indicate what programme the news will appear in and on what date";}break;
		case "IntroduzcaTelefono" : {strD="Please enter the phone";}break;
		case "IntroduzcaTlfnContacto" : {strD="Please enter the contact phone";}break;
		case "IntroduzcaQueOtra" : {strD="Please specify, how do you want to do the interview? .";}break;
	}
	return strD;
}
