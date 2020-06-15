<?
Function EJECUTA_SELECT($istrSQL){
$objrsRS=mysql_query($istrSQL)or die("Error en el  query: " . mysql_error());
return $objrsRS;
}
Function CierraConexion(){mysql_close();}
function AbreConexion(){
$zerbitzaria="localhost";
$erabiltzailea="einstein";
$password="einstein";
$connection = mysql_connect($zerbitzaria,$erabiltzailea,$password)or die("No se pudo conectar a la BBDD: " . mysql_error());
$db = mysql_select_db("einstein", $connection) or die(mysql_error());
}?>
