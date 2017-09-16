<?php
$dsn = "BBDD DAMM HPSM"; 
//debe ser de sistema no de usuario
$usuario = "SMUSER";
$clave = "SMUSER";


//realizamos la conexion mediante odbc
$cid = odbc_connect($dsn, $usuario, $clave);

if (!$cid){
	exit("<strong>Ya ocurrido un error tratando de conectarse con el origen de datos.</strong>");
}	

// consulta SQL a nuestra tabla "CM3RM1"
//$sql = "SELECT count(*) FROM CM3RM1";
$sql = "SELECT CM3RM1.NUMBER_STRING ,
 CM3RM1.ORIG_DATE_ENTERED ,
 CM3RM1.BRIEF_DESCRIPTION ,
 CM3RM1.CATEGORY ,
 CM3RM1.SUBCATEGORY ,
 CM3RM1.CHANGEMODEL ,
 CM3RM1.ASSIGN_DEPT ,
 CM3RM1.STATUS,
 CM3RM1.APPROVAL_STATUS,
 CM3RM1.CURRENT_PHASE,
 CM3RM1.AFFECTED_ITEM as Servicio,
 CAST(CM3RM1.ASSETS AS VARCHAR2(100)) as CI,
 CM3RM1.PLANNED_START as Inicio_programado,
 CM3RM1.PLANNED_END as Finalizacion_programada,
 CM3RM1.CLOSE_TIME as Fecha_cierre,
 (CASE CM3RM1.COMPLETION_CODE WHEN 1 THEN '1 - Successfull' WHEN 2 THEN '2 - Successfull (with problems)' WHEN 3 THEN '3 - Failed' WHEN 4 THEN '4 - Rejected' WHEN 6 THEN '6 - Cancelled' ELSE 'N/A' END)  as Codigo_cierre,
 CM3RM1.LOCATION,
 (CASE CM3RM1.PRIORITY_CODE WHEN '1' THEN '1 - Crítica' WHEN '2' THEN '2 - Alta' WHEN '3' THEN '3 - Media' WHEN '4' THEN '4 - Baja' ELSE 'N/A' END)  as Evaluacion_riesgo
 FROM CM3RM1
 WHERE CM3RM1.CATEGORY='Cambio planificado sobre Sistema en Produccion' 
  and (CM3RM1.CURRENT_PHASE='Implementation' or CM3RM1.CURRENT_PHASE='Planning' or CM3RM1.CURRENT_PHASE='Review' or CM3RM1.CURRENT_PHASE='Closure')
  and (CM3RM1.PLANNED_START > to_date('03/07/2017 00:00:00','dd/mm/yyyy HH24:MI:ss'))
 order by CM3RM1.PLANNED_START";

// generamos la tabla mediante odbc_result_all(); utilizando borde 1
// $result=odbc_exec($cid,$sql)or die(exit("Error en odbc_exec"));
$result=odbc_exec($cid,$sql)or var_dump($sql);
print odbc_result_all($result,"border=1");
?>
