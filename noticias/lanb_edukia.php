<?function sEdukia(){
if ($_SESSION["einstein_nivel"]=="2"){
if(isset($_GET["pg"])){$intPg=$_GET["pg"];}else{$intPg=0;}
switch ($intPg){
case "1": sBerriZerrenda();break;
case "2": sBerriBerriaAldatu();break;
case "3": sBerriaGorde();break;
case "4": sBerriakEzabatu();break;
case "7": fBerriBatEzabatu();break;
case "8": sIrudiaEzabatu();break;
}
}
}
function sEdukiWeb(){
if(isset($_GET["pg"])){$intPg=$_GET["pg"];}else{$intPg=0;}
if(isset($_SESSION["einstein_privado"]) && $_SESSION["einstein_privado"] != ""){
switch ($intPg){
case "1": fBerriaIkusi();break;
case "2": sBerriaBidali();break;
case "3": sEmailBidali();break;
case "4": sBerriHistorikoak();break;
default: sBerriZerrendaWeb();break;
}
}
}
function sBerriaGorde() {
if(isset($_POST["BerriKodea"])){$intBerriKodea=$_POST["BerriKodea"];}else{$intBerriKodea="";}
$strTitulua=$_POST["txtTitulua"];
$strLead=$_POST["txtLead"];
$strTextua=$_POST["txtTextua"];
$intEguna = $_POST["cboDia"];
if (strlen($intEguna)<2){
$intEguna = "0" . $intEguna;
}
$intHilabetea=$_POST["cboMes"];
if (strlen($intHilabetea)<2){
$intHilabetea = "0" . $intHilabetea;
}
$strBukaera=$_POST["cboAnho"].$intHilabetea.$intEguna;
if(isset($_POST["txtSinadura"])){$strSinadura=$_POST["txtSinadura"];}else{$strSinadura="";}
if(isset($_POST["txtOina"])){$strOina=$_POST["txtOina"];}else{$strOina="";}
$strPasahitzak=$_POST["txtPasahitzak"];
$strError = "";
$strError = ChequearTexto($strTitulua,"",150,1,"","Título",$strError);
$strError = ChequearTexto($strLead,"",500,1,"","Lead",$strError);
$strError = ChequearTexto($strSinadura,"",100,0,"","Firma",$strError);
$strError = ChequearTexto($strPasahitzak,"",200,0,"","Palabras clave",$strError);
$strError = ChequearTexto($strOina,"",200,0,"","Pie de foto",$strError);
if ($strError == ""){
$strTitulua = PHPentities ($strTitulua);
$strLead = PHPentities ($strLead);
$strSinadura = PHPentities ($strSinadura);
$strOina = PHPentities ($strOina);
$strTextua = PHPentities ($strTextua);
$strPasahitzak = PHPentities ($strPasahitzak);
$intBerria=0;
AbreConexion();
if ($intBerriKodea==""){
$intBerria=1;
$strSelect=fSQLBerriHandiena();
$objrow=EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$intHandiena=$row["HANDIENA"];
if (!isset($intHandiena) || $intHandiena==""){
$intBerriKodea=1;
}else{
$intBerriKodea=intval($intHandiena) + 1;
}
$strIrudiaEzabatu="";
}else{
$strSelect=fSQLIrudiIzena($intBerriKodea);
$objrow=EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strIrudiaEzabatu=$row["t759_foto"];
$strIrudiaEzabatu2="t_".$row["t759_foto"];
}
$strData = fObtenerFechaHoy();
$strRutaUpload=fDameRuta("S_Noticias");
$strIzenBerria = $intBerriKodea."_";
$strIrudia = fSubirArchivoServidor ("txtIrudia",$strRutaUpload,"2408000","0",",jpg,gif,jpeg,bmp,png,",$strIzenBerria,"1",$strIrudiaEzabatu);
if ($strIrudia == "ERROR"){
$strIrudia = "";?>
<script>alert('Ha habido un problema al intertar subir el fichero.');</script>
<?}
$strIzenBerria2 = "t_".$intBerriKodea."_";
$strIrudia2 = fSubirArchivoServidor ("txtIrudia2",$strRutaUpload,"51200","0",",jpg,gif,jpeg,bmp,png,",$strIzenBerria2,"1",$strIrudiaEzabatu2);
if ($strIrudia2 == "ERROR"){
$strIrudia2 = "";?>
<script>alert('Ha habido un problema al intertar subir el fichero.');</script>
<?}
if ($intBerria==0){
$strUpdate=fSQLBerriaAldatu($intBerriKodea,$strTitulua,$strLead,$strTextua,$strBukaera,$strData,$strSinadura,$strIrudia,$strOina,$strPasahitzak);
$objrow=EJECUTA_SELECT($strUpdate);
}else{
$strInsert=fSQLBerriaSartu($intBerriKodea,$strTitulua,$strLead,$strTextua,$strBukaera,$strData,$strSinadura,$strIrudia,$strOina,$strPasahitzak);
$objrow=EJECUTA_SELECT($strInsert);
}
$Joan="index.php?pg=2&BerriKodea=".$intBerriKodea;
CierraConexion();
}else{?>
<script>alert('<?echo $strError;?>');</script>
<?$Joan="index.php?pg=1";
}?>
<script>location.href ='<?echo $Joan;?>';</script>
<?}
function sBerriakEzabatu() {
$strBerriak = $_POST["hdnBerriak"];
AbreConexion();
$aB = split(",",$strBerriak);
for ($i=0;$i<intval(count($aB));$i++){
$strSelect=fSQLIrudiIzena($aB[$i]);
$objrow=EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strRutaUpload=fDameRuta("S_Noticias").$row["t759_foto"];
fBorrarDocumento($strRutaUpload);
$strDelete = fSQLBerriaEzabatu ($aB[$i]);
$objrow=EJECUTA_SELECT($strDelete);
}
$Joan="index.php?pg=1";
CierraConexion();?>
<script>location.href='<?echo $Joan;?>';</script>
<?}
function sIrudiaEzabatu(){
AbreConexion();
$intBerriKodea=$_GET["BerriKodea"];
$strSelect=fSQLIrudiIzena($intBerriKodea);
$objrow=EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strRutaUpload=fDameRuta("S_Noticias") . $row["t759_foto"];
fBorrarDocumento($strRutaUpload);
$strUpdate=fSQLBerriIrudiaEzabatu ($intBerriKodea);
$objrow=EJECUTA_SELECT($strUpdate);
CierraConexion();?>
<script>location.href ='index.php?pg=2&BerriKodea=<?echo $intBerriKodea;?>';</script>
<?}
function fBerriBatEzabatu(){
AbreConexion();
$intBerriKodea=$_GET["BerriKodea"];
$strSelect=fSQLIrudiIzena($intBerriKodea);
$objrow=EJECUTA_SELECT($strSelect);
$row=mysql_fetch_assoc($objrow);
$strRutaUpload=fDameRuta("S_Noticias").$row["t759_foto"];
fBorrarDocumento($strRutaUpload);
$strDelete=fSQLBerriaEzabatu($intBerriKodea);
$objrow=EJECUTA_SELECT($strDelete);
CierraConexion();?>
<script>location.href ='index.php?pg=1';</script>
<?}?>
