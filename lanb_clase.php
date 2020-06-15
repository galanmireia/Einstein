<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?function PHPentities($strTexto){
if(get_magic_quotes_gpc()!=1) {
$strTexto=addslashes($strTexto);
}
$no_seguro = array('!','"',"%", "(", ")", "*", "+", ",", "-", ".", "/", ":", "<", "=", ">", "?", "{", "|", "}", "_", "'");
$seguro   = array("&#33;","&#34;", "&#37;", "&#40;", "&#41;", "&#42;", "&#43;", "&#44;", "&#45;", "&#46;", "&#47;", "&#58;", "&#60;", "&#61;", "&#62;", "&#63;", "&#123;", "&#124;", "&#125;", "&#95;", "&#180;");
$strTexto = str_replace($no_seguro, $seguro, $strTexto);
return $strTexto;
}
function VisualizarWeb($strTexto,$strSustraia){
$strTexto = ereg_replace("(\r\n|\n|\r)", "<br />", $strTexto);
/*$i=0;
$sw=0;
$strTodo = $strTexto;
$strTextoFormato="";
while($i < strlen($strTodo)) {
$strLetra = substr($strTexto,0,1);
$intLetra = ord($strLetra);
$strTexto = substr($strTexto,1,strLen($strTexto));
if(intval($intLetra)==13){$strLetra="<br>";$sw=0;}
if(intval($intLetra)==10){$strLetra=""; $sw=0;}
$strTextoFormato = $strTextoFormato . $strLetra;
$i=$i+1;
}*/
$strTexto=fFormatoDelTexto($strTexto,$strSustraia);
return $strTexto;
}
function VisualizarNoWeb($strTexto){
$no_seguro = array('!','"',"%", "(", ")", "*", "+", ",", "-", ".", "/", ":", "<", "=", ">", "?", "{", "|", "}", "_", "'");
$seguro   = array("&#33;","&#34;", "&#37;", "&#40;", "&#41;", "&#42;", "&#43;", "&#44;", "&#45;", "&#46;", "&#47;", "&#58;", "&#60;", "&#61;", "&#62;", "&#63;", "&#123;", "&#124;", "&#125;", "&#95;", "&#180;");
$strTexto = str_replace($seguro,$no_seguro, $strTexto);
return $strTexto;
}
function ChequearTexto($istrTexto,$istrTipo,$iintLongitudMax,$iintLongitudMin,$istrSuplemento,$istrCampo,$strError){
if($strError == ""){
$istrTexto=trim($istrTexto);
if($iintLongitudMax!=""){$strError=intval(strlen($istrTexto))>intval($iintLongitudMax)?$istrCampo." luzeera handiegia":"";}
if($strError == ""){
if($iintLongitudMin!="")
{
if(strlen($istrTexto)==0 && $iintLongitudMin>0){
$strError=$istrCampo. " sartu";
}else{
$strError=strlen($istrTexto)<$iintLongitudMin?$istrCampo." luzeera txikiegia":"";
}
}
}
if($strError=="" && $iintLongitudMin>0){
switch(strtolower($istrTipo))
{	case "txttexto":
$strError=preg_match('/^[a-zA-Z'.$istrSuplemento.']+$/',$istrTexto)?"":$istrCampo." hizki arraroak ditu";
break;
case "txtnumerico":
$strError=preg_match('/^[0-9'.$istrSuplemento.']+$/',$istrTexto)?"":$istrCampo." hizki arraroak ditu";
break;
case "txtalfanumerico":
$strError=preg_match('/^[a-zA-Z0-9'.$istrSuplemento.']+$/',$istrTexto)?"":$istrCampo." hizki arraroak ditu";
break;
case "fecha":
$Barra1 = substr($istrTexto,4,1);
$Barra2 = substr($istrTexto,7,1);
if($Barra1!="/" || $Barra2!="/"){
$strError=$istrCampo."  formatu oker dago(uuuu/hh/ee)";
}else{
$Dia = substr($istrTexto,8,2);
$Mes = substr($istrTexto,5,2);
$Anho = substr($istrTexto,0,4);
$strError=checkdate($Mes,$Dia,$Anho)?"":$istrCampo."  formatua oker dago(uuuu/hh/ee)";
}
break;
case "correo":
$strAux='/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/';
$strError=preg_match($strAux,$istrTexto)?"":$istrCampo." "." oker dago";
break;
}
}
}
return $strError;
}
function ChequearImagen($istrImagen,$iintTamanho,$iintTamanhoMax,$iintTamanhoMin,$istrExtension,$istrCampo,$strError){
if($strError == ""){
if($iintTamanhoMax!="" || $iintTamanhoMin!=""){
$strError =(intval($iintTamanho) > intval($iintTamanhoMax) || intval($iintTamanho) < intval($iintTamanhoMin))?$istrCampo. " tamaño incorrecto":"";
}
if($strError == ""){
$strExt=substr(strrchr($istrImagen, "."),1);
if(strpos($istrExtension, ",".$strExt.",")===false){
$strError = $istrCampo. " tipo incorrecto";
}
}
}
return $strError;
}
function Comparar($istrTexto1,$istrTexto2,$istrComparacion,$strError){
if($strError == ""){
switch($istrComparacion){
case "<":
$strAux=$istrTexto1." "."Konparaketa gaizki dago";
if($istrTexto1>=$istrTexto2){$strError=$strAux;}
break;
case ">":
$strAux=$istrTexto1." "."Konparaketa gaizki dago";
if($istrTexto1<=$istrTexto2){$strError=$strAux;}
break;
case "<=":
$strAux=$istrTexto1." "."Konparaketa gaizki dago";
if($istrTexto1>$istrTexto2){$strError=$strAux;}
break;
case ">=":
$strAux=$istrTexto1." "."Konparaketa gaizki dago";
if($istrTexto1<$istrTexto2){$strError=$strAux;}
break;
case "==":
$strAux=$istrTexto1." "."eta"." ".$istrTexto2." "." konparaketa gaizki dago";
if($istrTexto1!=$istrTexto2){$strError=$strAux;}
break;
case "===":
$strAux=$istrTexto1." "."eta"." ".$istrTexto2." konparaketa gaizki dago";
if($istrTexto1!==$istrTexto2){$strError=$strAux;}
break;
}
}
return $strError;
}
function fBorrarDocumento($strArchivo){
if($strArchivo!=""){@unlink($strArchivo);}
return;
}
/*
function fSubirArchivoServidor($strNombreInput,$strURLServidor,$intTamainoMax,$intTamainoMin,$strTipoArchivo,$strNombreNuevoArchivo,$intClase,$strBorrarImagen){
$strError="";
if(!empty($_FILES["$strNombreInput"]["name"]))
{			
$strArchivo=$_FILES["$strNombreInput"]["name"];
$intTamainoReal=intval($_FILES["$strNombreInput"]["size"]);
$strError=ChequearImagen($strArchivo,$intTamainoReal,$intTamainoMax,$intTamainoMin,$strTipoArchivo,"Artxibo",$strError);
if($strError ==""){
if(move_uploaded_file($_FILES["$strNombreInput"]['tmp_name'],  $strURLServidor . $_FILES["$strNombreInput"]["name"])){
$strArchivoViejo = $strURLServidor . $strArchivo;
$sw=0;
if($strNombreNuevoArchivo!=""){
if($intClase=="1"){$strArchivo = $strNombreNuevoArchivo . $strArchivo;}
else{$strArchivo = $strNombreNuevoArchivo;}
$strArchivoNuevo = $strURLServidor . $strArchivo;
if(file_exists($strArchivoNuevo)){
fBorrarDocumento($strArchivoNuevo);
$sw=1;
}
rename($strArchivoViejo,$strArchivoNuevo);
}
if($sw==0){if($strBorrarImagen !=""){fBorrarDocumento($strURLServidor.$strBorrarImagen);}}
}else{
$strArchivo="ERROR";?>
<script>alert("<?echo $strError;?>");</script>
<?}
}else{
$strArchivo="ERROR";?>
<script>alert("<?echo $strError;?>");</script>
<?}
}else { $strArchivo=""; }
return $strArchivo;
}
*/
function fSubirArchivoServidor($strNombreInput,$strURLServidor,$intTamainoMax,$intTamainoMin,$strTipoArchivo,$strNombreNuevoArchivo,$intClase,$strBorrarImagen)
{
$strArchivo="ERROR";
$strError="";
if(!empty($_FILES["$strNombreInput"]["name"]))
{			
$strArchivo=$_FILES["$strNombreInput"]["name"];
$intTamainoReal=intval($_FILES["$strNombreInput"]["size"]);
$strError=ChequearImagen($strArchivo,$intTamainoReal,$intTamainoMax,$intTamainoMin,$strTipoArchivo,"Artxibo",$strError);
if($strError =="")
{
if($strNombreNuevoArchivo!="")
{
if($intClase=="1")
{
$strArchivo = $strNombreNuevoArchivo . $strArchivo;
}
else
{
$strArchivo = $strNombreNuevoArchivo;
}
}
if (!move_uploaded_file($_FILES["$strNombreInput"]['tmp_name'],  $strURLServidor . $strArchivo))
{
$strArchivo="ERROR";
$strError="ERROR en move upload";
?>
<script>alert("<?echo $strError;?>");</script>
<?
}
else
{
if (!chmod( $strURLServidor . $strArchivo, 0444 ))
{
$strArchivo="ERROR";
$strError="ERROR en chmod";
?>
<script>alert("<?echo $strError;?>");</script>
<?
}
}
if($strBorrarImagen !="")
{
fBorrarDocumento($strURLServidor.$strBorrarImagen);
}
}
else
{
$strArchivo="ERROR";
?>
<script>alert("<?echo $strError;?>");</script>
<?
}
}
else
{
$strError="ERROR";
?>
<script>alert("<?echo $strError;?>");</script>
<?
}
return $strArchivo;
}
function fFormatoDelTexto($strTextoDepurado,$strSustraia)
{	$strTextoDepurado=str_replace("[sup]","<sup>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;sup]","</sup>",$strTextoDepurado);
$strTextoDepurado=str_replace("[sub]","<sub>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;sub]","</sub>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#43;&#45;]","&#177;",$strTextoDepurado);
$strTextoDepurado=str_replace("[b]","<b>",$strTextoDepurado);
$strTextoDepurado=str_replace("[/b]","</b>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;b]","</b>",$strTextoDepurado);
$strTextoDepurado=str_replace("[u]","<u>",$strTextoDepurado);
$strTextoDepurado=str_replace("[/u]","</u>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;u]","</u>",$strTextoDepurado);
$strTextoDepurado=str_replace("[k]","<i>",$strTextoDepurado);
$strTextoDepurado=str_replace("[/k]","</i>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;k]","</i>",$strTextoDepurado);
$strTextoDepurado=str_replace("[sq]","<img src='".$strSustraia."images/px_rojo.gif' border=0 width=4 height=4>&nbsp;",$strTextoDepurado);
$strTextoDepurado=str_replace("[-t]","<span class='textop'>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#45;t]","<span class='textop'>",$strTextoDepurado);
$strTextoDepurado=str_replace("[/-t]","</span>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;&#45;t]","</span>",$strTextoDepurado);
$strTextoDepurado=str_replace("[t]","<span class='textom'>",$strTextoDepurado);
$strTextoDepurado=str_replace("[/t]","</span>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;t]","</span>",$strTextoDepurado);
$strTextoDepurado=str_replace("[+t]","<span class='textog'>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#43;t]","<span class='textog'>",$strTextoDepurado);
$strTextoDepurado=str_replace("[/+t]","</span>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;&#43;t]","</span>",$strTextoDepurado);
$strTextoDepurado=str_replace("[link=","<a href='",$strTextoDepurado);
$strTextoDepurado=str_replace("=link]","' target='_blank'><u><i>",$strTextoDepurado);
$strTextoDepurado=str_replace("[link&#61;","<a href='",$strTextoDepurado);
$strTextoDepurado=str_replace("&#61;link]","' target='_blank'><u><i>",$strTextoDepurado);
$strTextoDepurado=str_replace("[/link]","</u></i></a>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;link]","</u></i></a>",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#35;","<font color='",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;&#35;]","</font>",$strTextoDepurado);
$strTextoDepurado=str_replace("&#35;]","'>",$strTextoDepurado);
$strTextoDepurado=str_replace("[#","<font color='",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;#]","</font>",$strTextoDepurado);
$strTextoDepurado=str_replace("#]","'>",$strTextoDepurado);
return $strTextoDepurado;
}
function fQuitarFormatoDelTexto($strTextoDepurado)
{	$strTextoDepurado=str_replace("[sup]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;sup]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[sub]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;sub]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#43;&#45;]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[b]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[/b]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;b]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[u]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[/u]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;u]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[k]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[/k]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;k]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[sq]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[-t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#45;t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[/-t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;&#45;t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[/t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[+t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#43;t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[/+t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;&#43;t]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[link=","",$strTextoDepurado);
$strTextoDepurado=str_replace("=link]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[link&#61;","",$strTextoDepurado);
$strTextoDepurado=str_replace("&#61;link]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[/link]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;link]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#35;","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;&#35;]","",$strTextoDepurado);
$strTextoDepurado=str_replace("&#35;]","",$strTextoDepurado);
$strTextoDepurado=str_replace("[#","",$strTextoDepurado);
$strTextoDepurado=str_replace("[&#47;#]","",$strTextoDepurado);
$strTextoDepurado=str_replace("#]","",$strTextoDepurado);
return $strTextoDepurado;
}
function fQuitarComas($istrTxt)
{	if (!isset($istrTxt) || trim($istrTxt)=="")
{	return "";
}
else
{	$istrTxt=str_replace("'","",$istrTxt);
$istrTxt=str_replace('"','',$istrTxt);
$istrTxt=str_replace("\\","/",$istrTxt);
$istrTxt=str_replace("&#34;","",$istrTxt);
$istrTxt=str_replace("&#39;","",$istrTxt);
$istrTxt=str_replace("&#92;","/",$istrTxt);
$istrTxt=VisualizarNoWeb($istrTxt);
return $istrTxt;
}
}
function FormatNumber($fValue,$sigdigits=0,$mode=0,$inverseNeg=0)
{  $sValue=''.(float)($fValue);
$lenght=strlen($sValue);
$isNeg=$fValue<0;
if(($sigdigits<=0)||($sigdigits==False))
{	if(($inverseNeg)&&($isNeg))
{	$mode=-$mode;
}
if($mode==-1)
{	return floor($fValue);
}
if($mode==1)
{	return ceil($fValue);
}
return round($fValue);
}
$posDot=strpos($sValue,'.');
$sResult=str_replace(array('.','-'),'', $sValue);
$fResult=0.0;
if(($mode==0)&&(intval($sResult{$sigdigits})>=5))
{	$fResult=1.0;
}
$sResult=substr($sResult,0,$sigdigits);
$fResult+=(float)$sResult;
if($isNeg)
{	 if($inverseNeg)
{	if($mode==1)
{	$fResult+=1;
}
}
else
{	if($mode==-1)
{	$fResult+=1;
}
}
}
else
{	if($mode==1)
{	$fResult+=1;
}
}
if($posDot==False)
{	$posDot=$lenght;
}
$numb=$sigdigits-($posDot-$isNeg);
if($numb>0)
{	for($i=0;$i<$numb;$i++)
{	$fResult/=10.0;
}
}
else
{	if($numb<0)
{	for($i=0;$i<$numb;$i++)
{	$fResult*=10.0;
}
}
}
if($isNeg)
{	return -$fResult;
}
else
{	return $fResult;
}
}
function fDimensionesImagen ($strImagen,$strRuta,$intAncho,$intAlto){
$strRutaImagen = $strRuta.$strImagen;
$aDimensiones = getimagesize($strRutaImagen);
$intAn=$aDimensiones[0];
$intAl=$aDimensiones[1];
if ($intAncho != 0 ){
if ($intAn > $intAncho ){$intDimImagen = $intAncho;}else{$intDimImagen=$intAn;}
}else{
if ($intAl > $intAlto ){$intDimImagen = $intAlto;}else{$intDimImagen=$intAl;}
}
return $intDimImagen;
}?>
</body>
</html>
