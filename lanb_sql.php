<?function fSQLMaximoDatos (){
$strSelect = " select max(t758_codigo) as MAXIMO from t758_datos ";
return $strSelect;
}
function fSQLMeterDatorForm1 ($intCodDatos,$strNombre,$strApellido1,$strApellido2,$strDNI,$strCalle,$strNum,$strCiudad,$strCP,$strProvincia,$strPais,$strTelefono,$strFax,$strEmpresa,$strSeccion,$strCalleE,$strNumE,$strCiudadE,$strCPE,$strProvinciaE,$strPaisE,$strTelefonoE,$strFaxE,$strEmail,$strDias,$intBeca,$intAlojamiento){
$strFecha = fObtenerFechaHoy();
$strInsert = " insert into t758_datos (t758_codigo,t758_1_nombre,t758_1_apellido1,t758_1_apellido2,t758_1_dni,t758_1_calle,t758_1_numero,t758_1_ciudad,t758_1_cp,t758_1_provincia,t758_1_pais,t758_1_telefono,t758_1_fax ".
" ,t758_1_empresa,t758_1_seccion,t758_1_callee,t758_1_numeroe,t758_1_ciudade,t758_1_cpe,t758_1_provinciae,t758_1_paise,t758_1_telefonoe,t758_1_faxe ".
" ,t758_1_email, t758_1_beca, t758_1_alojamiento,t758_1_dias,t758_fecha) values( ".
" ".$intCodDatos.",'".$strNombre."','".$strApellido1."','".$strApellido2."','".$strDNI."','".$strCalle."','".$strNum."','".$strCiudad."','".$strCP."','".$strProvincia."','".$strPais."','".$strTelefono."','".$strFax."'".
" ,'".$strEmpresa."','".$strSeccion."','".$strCalleE."','".$strNumE."','".$strCiudadE."','".$strCPE."','".$strProvinciaE."','".$strPaisE."','".$strTelefonoE."','".$strFaxE."'".
" ,'".$strEmail."',".$intBeca.",".$intAlojamiento.",'".$strDias."','".$strFecha."') " ;
return $strInsert;
}
function fSQLModificarDatosForm2 ($intCodDatos,$strRazones,$strMeritos,$intBecaDesplazamiento,$intBecaPernoctacion){
$strUpdate = " update t758_datos set t758_2_razones = '".$strRazones."', t758_2_meritos = '".$strMeritos."' ".
" ,t758_2_becadesplazamiento = ".$intBecaDesplazamiento." , t758_2_becapernoctacion = ".$intBecaPernoctacion." where t758_codigo = ". $intCodDatos;
return $strUpdate;
}
function fSQLModificarForm3 ($intCodDatos,$strFiscales,$strHotel,$intHabitaciones,$intDobles,$intIndividuales,$intLlegada,$intSalida,$intNoches,$intImporte,$intTotal,$intDto,$intBeca,$intAlojamiento){
$strUpdate = " update t758_datos set t758_3_datosfiscales='".$strFiscales."',t758_3_becapernoctacion=".$intBeca.",t758_3_hotel ='".$strHotel."',t758_3_habitaciones=".$intHabitaciones.", ".
" t758_3_dobles=".$intDobles.",t758_3_individuales=".$intIndividuales.",t758_3_noches=".$intNoches.",t758_3_llegada=".$intLlegada.",t758_3_salida=".$intSalida.",t758_3_importe=".$intImporte.",t758_3_dto=".$intDto.",t758_3_total=".$intTotal.",t758_3_alojamiento=".$intAlojamiento." ".
" where t758_codigo = ". $intCodDatos;
return $strUpdate;
}
function fSQLObtenerDatos ($intCodDatos){
$strSelect = " select t758_codigo,t758_pass,t758_1_nombre,t758_1_apellido1,t758_1_apellido2,t758_1_dni,t758_1_calle,t758_1_numero,t758_1_ciudad,t758_1_cp,t758_1_provincia,t758_1_pais,t758_1_telefono,t758_1_fax ".
" ,t758_1_empresa,t758_1_seccion,t758_1_callee,t758_1_numeroe,t758_1_ciudade,t758_1_cpe,t758_1_provinciae,t758_1_paise,t758_1_telefonoe,t758_1_faxe ".
" ,t758_1_email, t758_1_beca, t758_1_alojamiento,t758_1_dias,t758_fecha,t758_2_razones,t758_2_meritos,t758_3_alojamiento,t758_2_becadesplazamiento,t758_2_becapernoctacion ".
" ,t758_3_datosfiscales,t758_3_hotel,t758_3_llegada,t758_3_salida,t758_3_noches,t758_3_dobles,t758_3_individuales,t758_3_habitaciones,t758_3_importe,t758_3_dto,t758_3_total ".
" from t758_datos where t758_codigo = ".$intCodDatos;
return $strSelect;
}
function fSQLTieneBeca ($intCodDatos){
$strSelect = " select t758_1_beca from t758_datos where t758_codigo = ".$intCodDatos;
return $strSelect;
}
function fSQLMeterPassConfimacion ($intCodDatos,$strPass){
$strUpdate = " update t758_datos set t758_pass ='".$strPass."' where t758_codigo = ". $intCodDatos;
return $strUpdate;
}
function fSQLConfirmarInscripcionDatos($intCodDatos,$strPass){
$strFecha = fObtenerFechaHoy();
$strUpdate = " update t758_datos set t758_confirmardatos = 1,t758_fechaconfirmaciond='".$strFecha."' where t758_codigo = ". $intCodDatos;
return $strUpdate;
}
function fSQLConfirmarInscripcionAlojamiento($intCodDatos,$strPass){
$strFecha = fObtenerFechaHoy();
$strUpdate = " update t758_datos set t758_confirmaralojamiento = 1,t758_fechaconfirmaciona='".$strFecha."' where t758_codigo = ". $intCodDatos;
return $strUpdate;
}
function fSQLFechaLimiteFormulario ($intTipo){
$strSelect = " select t761_fecha1, t761_fecha2, t761_fecha3 from t761_limite where t761_tipo = ". $intTipo;
return $strSelect;
}?>
