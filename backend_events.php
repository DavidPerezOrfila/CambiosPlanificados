<?php
  $fecha = $_GET['fecha'];
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
  $sql = "SELECT CM3RM1.NUMBER_STRING,
   CM3RM1.BRIEF_DESCRIPTION,
   CM3RM1.PLANNED_START,
   CM3RM1.PLANNED_END
   FROM CM3RM1
   WHERE CM3RM1.CATEGORY='Cambio planificado sobre Sistema en Produccion'
    and (CM3RM1.CURRENT_PHASE='Implementation' or CM3RM1.CURRENT_PHASE='Planning' or CM3RM1.CURRENT_PHASE='Review' or CM3RM1.CURRENT_PHASE='Closure')
    and (CM3RM1.PLANNED_START > to_date('01/06/2017 00:00:00','dd/mm/yyyy HH24:MI:ss'))
   order by CM3RM1.PLANNED_START";


  $result=odbc_exec($cid,$sql)or var_dump($sql);
  class Event {}
  $events = array();
  while ($row = odbc_fetch_array($result)) {

    $e = new Event();
    $e->id = $row['NUMBER_STRING'];
    $e->title = $row['BRIEF_DESCRIPTION'];
    $e->start = $row['PLANNED_START'];
    $e->end = $row['PLANNED_END'];
    $events[] = $e;

  }
  echo json_encode($events);
?>
