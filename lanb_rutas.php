<?function fDameRuta($strRuta){
$intDonde = 1;
switch ($intDonde){
case "1": //**** Pulgon
switch ($strRuta){
case "S_Noticias": $strR = "../fotos/";break;
case "S_BancoImages": $strR = "../fotos/";break;
case "A_Raiz": $strR = "http://pulgon/einstein/";break;
case "a_bancoimages": $strR = "\\einstein\\bancoimages\\fotos\\";break;
case "C_Clave": $strR = "AEAM05";break;
case "E_Einstein": $strR= "alicia@lanbyte.com";break;
case "E_Gabinete": $strR= "alicia@lanbyte.com";break;
case "E_Confirmacion": $strR= "umartin@lanbyte.com";break;
}
break;
case "2": //**** Internet
switch ($strRuta){
case "S_Noticias": $strR = "../fotos/";break;
case "A_Raiz": $strR = "http://www.elansys.net/einstein/";break;
case "a_bancoimages": $strR = "\\bancoimages\\fotos\\";break;
case "C_Clave": $strR = "AEAM05";break;
case "E_Einstein": $strR= "press@dipc-einstein05.com";break;
case "E_Gabinete": $strR= "press@dipc-einstein05.com";break;
case "E_Confirmacion": $strR= "umartin@lanbyte.com";break;
}
break;
}
return $strR;
}?>
