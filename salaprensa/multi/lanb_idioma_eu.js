function fM(strMensaje) {
	strD="";
	switch (strMensaje) {
		case "EmailFormatoIncorrecto" : {strD="E-mail formatu oker dago.";}break;
		case "IntroduzcaApellidos" : {strD="Sartu abizenak";}break;
		case "IntroduzcaClave" : {strD="Sartu gakoa";}break;
		case "IntroduzcaCongreso" : {strD="Noiz eta nola izan zenuen Kongresuaren berri?";}break;
		case "IntroduzcaDatosLocalizacion" : {strD="Sartu egoitzaren datuak";}break;
		case "IntroduzcaDia" : {strD="Sartu eguna";}break;
		case "IntroduzcaEmail" : {strD="Sartu posta-elektronikoa";}break;
		case "IntroduzcaEmailPersonal" : {strD="Sartu posta-elektroniko helbide pertsonala";}break;
		case "IntroduzcaHora" : {strD="Sartu ordua";}break;
		case "IntroduzcaMedio" : {strD="Sartu komunikabidearen izena";}break;
		case "IntroduzcaMes" : {strD="Sartu hilabetea";}break;
		case "IntroduzcaNombre" : {strD="Sartu izena";}break;
		case "IntroduzcaPublicacion" : {strD="Mesedez, adierazi zein programa eta egunetan argitaratuko den albistea.";}break;
		case "IntroduzcaTelefono" : {strD="Sartu telefonoa";}break;
		case "IntroduzcaTlfnContacto" : {strD="Sartu harremanetan jartzeko telefonoa";}break;
		case "IntroduzcaQueOtra" : {strD="Adierazi, nola egin nahi duzu elkarrizketa?";}break;
	}
	return strD;
}
