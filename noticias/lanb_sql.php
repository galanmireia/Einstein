<?function fSQLBerriakZerrendatu($intHistoriko){
$strGaurkoData=fObtenerFechaHoy();
$strSelect = " select t759_codigo, t759_titulo, t759_fecha, t759_texto, t759_foto,t759_lead, t759_caducidad, t759_firma,t759_palabrasclave from t759_noticia b ";
if ($intHistoriko=="1"){
$strSelect = $strSelect . " where t759_caducidad<'".$strGaurkoData."' ";
}else{
$strSelect = $strSelect . " where t759_caducidad>='".$strGaurkoData."' ";
}
$strSelect = $strSelect . " order by t759_fecha desc ";
return $strSelect;
}
function fSQLBerriakBilatu($strTitulua,$strLead,$strSinadura,$strData,$intHistoriko){
$strGaurkoData=fObtenerFechaHoy();
$strSelect= " select t759_codigo, t759_titulo, t759_fecha, t759_texto, t759_foto,t759_lead, t759_caducidad, t759_firma,t759_palabrasclave from t759_noticia b where 1=1 ";
if ($intHistoriko=="1"){
$strSelect = $strSelect . " and t759_caducidad<'".$strGaurkoData."' ";
}else{
$strSelect = $strSelect . " and t759_caducidad>='".$strGaurkoData."' ";
}
if ($strTitulua!=""){
$strSelect= $strSelect . "and UPPER(t759_titulo) like UPPER('%".$strTitulua."%') ";
}
if ($strLead!=""){
$strSelect= $strSelect . "and UPPER(t759_lead) like UPPER('%".$strLead."%') ";
}
if ($strSinadura!=""){
$strSelect= $strSelect . "and UPPER(t759_firma) like UPPER('%".$strSinadura."%') ";
}
if ($strData!=""){
$strData = sObtenerFechaTabla ($strData);
$strSelect= $strSelect . "and UPPER(t759_fecha)=UPPER('".$strData."') ";
}
$strSelect = $strSelect . " order by t759_fecha desc ";
return $strSelect;
}
function fSQLBerriHandiena(){
$strSelect="select max(t759_codigo)as HANDIENA from t759_noticia";
return $strSelect;
}
function fSQLBerriaSartu($intBerriKodea,$strTitulua,$strLead,$strTextua,$strBukaera,$strData,$strSinadura,$strIrudia,$strOina,$strPasahitzak){
$strInsert="Insert into t759_noticia (t759_codigo,t759_titulo,t759_lead,t759_texto,t759_caducidad,t759_fecha,t759_firma,t759_foto,t759_pie,t759_palabrasclave) values(".$intBerriKodea.",'".$strTitulua."','".$strLead."','".$strTextua."','".$strBukaera."','".$strData."','".$strSinadura."','".$strIrudia."','".$strOina."','".$strPasahitzak."')";
return $strInsert;
}
function fSQLBerriaAldatu($intBerriKodea,$strTitulua,$strLead,$strTextua,$strBukaera,$strData,$strSinadura,$strIrudia,$strOina,$strPasahitzak){
$strUpdate= " update t759_noticia set t759_titulo='".$strTitulua."',t759_lead='".$strLead."',t759_texto='".$strTextua."',t759_caducidad='".$strBukaera."',t759_fecha='".$strData."',t759_firma='".$strSinadura."', ".
" t759_pie='".$strOina."',t759_palabrasclave='".$strPasahitzak."' ";
if ($strIrudia != ""){
$strUpdate = $strUpdate . ",t759_foto='".$strIrudia."'";
}
$strUpdate = $strUpdate . "where t759_codigo=".$intBerriKodea;
return $strUpdate;
}
function fSQLBerriDatuak($intBerriKodea){
$strSelect = "select t759_codigo,t759_titulo,t759_lead,t759_texto,t759_caducidad,t759_fecha,t759_firma,t759_foto,t759_pie,t759_palabrasclave from t759_noticia where t759_codigo=".$intBerriKodea;
return $strSelect;
}
function fSQLBerriIrudiaEzabatu ($intBerriaKodea){
$strUpdate = " update t759_noticia set t759_foto='',t759_pie='' where t759_codigo=".$intBerriaKodea;
return $strUpdate;
}
function fSQLIrudiIzena ($intBerriaKodea){
$strSelect = " select t759_foto from t759_noticia where t759_codigo=".$intBerriaKodea;
return $strSelect;
}
function fSQLBerriaEzabatu ($intBerriaKodea){
$strDelete = " Delete from t759_noticia where t759_codigo=".$intBerriaKodea;
return $strDelete;
}
function fSQLBerriarenDatuak($iintKodea)
{	$strSelect="select t759_codigo,t759_fecha,t759_caducidad,t759_titulo,t759_lead,t759_texto,t759_foto,t759_pie,t759_firma,t759_palabrasclave ".
" from t759_noticia b where t759_codigo=".$iintKodea;
return $strSelect;
}
function fSQLBerriakBilatuWeb($strTextua,$strData,$intTaldeKodea)
{	$strGaurkoData=fObtenerFechaHoy();
$strSelect= " select t759_codigo, t759_titulo, t759_fecha, t759_texto, t759_foto,t759_lead, t759_caducidad, t759_firma, t759_palabrasclave from t759_noticia b where t759_caducidad>='".$strGaurkoData."' ";
if ($strTextua!=""){
$strSelect= $strSelect . "and (UPPER(t759_titulo) like UPPER('%".$strTextua."%') or UPPER(t759_lead) like UPPER('%".$strTextua."%') or UPPER(t759_palabrasclave) like UPPER(',%".$strTextua."%,') or UPPER(t759_firma) like UPPER(',%".$strTextua."%,'))";
}
if ($strData!=""){
$strData = sObtenerFechaTabla ($strData);
$strSelect= $strSelect . "and UPPER(t759_fecha)=UPPER('".$strData."') ";
}
$strSelect = $strSelect . " order by t759_fecha desc ";
return $strSelect;
}
function fSQLBerriHistorikoakBilatu($strTextua,$intTaldeKodea,$strHasieraData,$strBukaeraData){
$strGaurkoData=fObtenerFechaHoy();
$strSelect= " select t759_codigo, t759_titulo, t759_fecha, t759_texto, t759_foto,t759_lead, t759_caducidad, t759_firma,t759_palabrasclave from t759_noticia b where and t759_caducidad<'".$strGaurkoData."' ";
if ($strTextua!=""){
$strSelect= $strSelect . "and (UPPER(t759_titulo) like UPPER('%".$strTextua."%') or UPPER(t759_lead) like UPPER('%".$strTextua."%') or UPPER(t759_palabrasclave) like UPPER(',%".$strTextua."%,') or UPPER(t759_firma) like UPPER(',%".$strTextua."%,'))";
}
if ($strHasieraData!="" && $strBukaeraData == ""){
$strHasieraData = sObtenerFechaTabla ($strHasieraData);
$strSelect= $strSelect . "and UPPER(t759_fecha)=UPPER('".$strHasieraData."') ";
}elseif ($strHasieraData!="" && $strBukaeraData != ""){
$strHasieraData = sObtenerFechaTabla ($strHasieraData);
$strBukaeraData = sObtenerFechaTabla ($strBukaeraData);
$strSelect= $strSelect . "and UPPER(t759_fecha)>=UPPER('".$strHasieraData."') and UPPER(t759_fecha)<=UPPER('".$strBukaeraData."')";
}
return $strSelect;
}?>
