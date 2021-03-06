<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv=refresh content=1800>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cambios Semanales Planificados </title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/sm31.css">
	<link rel="stylesheet" type="text/css" href="css/calendar_green.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="js/sm31.js"></script>
	<script src="js/moment-with-locales.js"></script>
	<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
	<script src='fullcalendar/fullcalendar.js'></script>
	<script src='fullcalendar/locale-all.js'></script>
</head>
<body>
<div class="container-fluid">
	<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
		<div class="panel panel-success">
    <div class="panel-heading titulo"><center><img src="css/images/logo_grupodamm.gif" class="img-responsive" width="150" height="100" ></center><h1 class="text-center">Cambios Planificados desde el <?php $fecha = $_GET['fecha']; echo $fecha ?></h1></div>
    <div class="panel-body">
		<div class="table-responsive">
			<table class="table table-bordered">
					<tr class="bg-primary">
						<th>ID</th>
						<th>Titulo</th>
						<th class="categoria">Categoria</th>
						<th class="subcategoria">Sub-Categoria</th>
						<th class="cambioModelo">Cambio Modelo</th>
						<th>Departamento asignado</th>
						<th>Estatus</th>
						<th>Estado aprobacion</th>
						<th>Fase Actual</th>
						<th>Servicio</th>
						<th class="ci">CI</th>
						<th>Inicio programado</th>
						<th>Finalizacion programada</th>
						<th>Fecha cierre</th>
						<th>Codigo cierre</th>
						<th>Sede</th>
						<th class="riesgo">Evaluacion riesgo</th>
					</tr>
				<?php
					$dsn = "BBDD DAMM HPSM";
					//debe ser de sistema no de usuario
					$usuario = "SMUSER";
					$clave = "SMUSER";


					//realizamos la conexion mediante odbc
					$cid = odbc_connect($dsn, $usuario, $clave);

					if (!$cid){
						exit("<strong>Ha ocurrido un error tratando de conectarse con el origen de datos.</strong>");
					}

					// consulta SQL a nuestra tabla "CM3RM1"
					//$sql = "SELECT count(*) FROM CM3RM1";
					$sql = "SELECT CM3RM1.NUMBER_STRING,
					 CM3RM1.ORIG_DATE_ENTERED,
					 CM3RM1.BRIEF_DESCRIPTION,
					 CM3RM1.CATEGORY,
					 CM3RM1.SUBCATEGORY,
					 CM3RM1.CHANGEMODEL,
					 CM3RM1.ASSIGN_DEPT,
					 CM3RM1.STATUS,
					 CM3RM1.APPROVAL_STATUS,
					 CM3RM1.CURRENT_PHASE,
					 CM3RM1.AFFECTED_ITEM,
					 CAST(CM3RM1.ASSETS AS VARCHAR2(100)) as CI,
					 CM3RM1.PLANNED_START,
					 CM3RM1.PLANNED_END,
					 CM3RM1.CLOSE_TIME,
					 CM3RM1.COMPLETION_CODE,
					 CM3RM1.LOCATION,
					 CM3RM1.RISK_ASSESSMENT
					 FROM CM3RM1
					 WHERE CM3RM1.CATEGORY='Cambio planificado sobre Sistema en Produccion'
					  and (CM3RM1.CURRENT_PHASE='Implementation' or CM3RM1.CURRENT_PHASE='Planning' or CM3RM1.CURRENT_PHASE='Review' or CM3RM1.CURRENT_PHASE='Closure')
					  and (CM3RM1.PLANNED_START > to_date('$fecha 00:00:00','dd/mm/yyyy HH24:MI:ss'))
					 order by CM3RM1.PLANNED_START";

					// generamos la tabla mediante odbc_result_all(); utilizando borde 1
					// $result=odbc_exec($cid,$sql)or die(exit("Error en odbc_exec"));
					$result=odbc_exec($cid,$sql)or var_dump($sql);


					//print odbc_result_all($result, class="table table-bordered");

					class Event {}
					$events = array();
					while ($row = odbc_fetch_array($result)) {
						$cm = $row['NUMBER_STRING'];
						$FechaInicio = $row['ORIG_DATE_ENTERED'];
						$titulo = $row['BRIEF_DESCRIPTION'];
						$categoria = $row['CATEGORY'];
						$subcategoria = $row['SUBCATEGORY'];
						$CambioModelo = $row['CHANGEMODEL'];
						$DepartamentoAsignado = $row['ASSIGN_DEPT'];
						$Status = $row['STATUS'];
						$EstadoAprobacion = $row['APPROVAL_STATUS'];
						$FaseActual = $row['CURRENT_PHASE'];
						$ServicioAfectado = $row['AFFECTED_ITEM'];
						$CI = $row['CI'];
						$InicioProgramado = $row['PLANNED_START'];
						$FechaCierre = $row['PLANNED_END'];
						$CloseTime = $row['CLOSE_TIME'];
						$CodigoCierre = $row['COMPLETION_CODE'];
						$Sede = $row['LOCATION'];
						$EvaluacionRiesgo = $row['RISK_ASSESSMENT'];
						$e = new Event();
					  $e->id = $row['NUMBER_STRING'];
					  $e->text = $row['BRIEF_DESCRIPTION'];
					  $e->start = $row['PLANNED_START'];
					  $e->end = $row['PLANNED_END'];
					  $events[] = $e;
						json_encode($events);
						?>
						<tr align="center">
							<td><?php echo $cm; ?></td>
							<td><?php echo $titulo; ?></td>
							<td class="categoria"><?php echo $categoria; ?></td>
							<td class="subcategoria"><?php echo $subcategoria; ?></td>
							<td class="cambioModelo"><?php echo $CambioModelo; ?></td>
							<td><?php echo $DepartamentoAsignado; ?></td>
							<td class="estado"><?php echo $Status; ?></td>
							<td><?php echo $EstadoAprobacion; ?></td>
							<td><?php echo $FaseActual; ?></td>
							<td><?php echo $ServicioAfectado; ?></td>
							<td class="ci"><?php echo $CI; ?></td>
							<td><?php echo $InicioProgramado; ?></td>
							<td><?php echo $FechaCierre; ?></td>
							<td><?php echo $CloseTime; ?></td>
							<td class="cierre"><?php echo $CodigoCierre; ?></td>
							<td><?php echo $Sede; ?></td>
							<td class="riesgo"><?php echo $EvaluacionRiesgo; ?></td>
						</tr>
				<?php
					}
				?>

				</table>
			</div>
			<button type="button" id ="planning" class="btn btn-info btn-xs bg-primary" data-toggle="collapse" data-target="#calendar">Planning</button>

		<div id='calendar' class="collapse panel-footer"></div>
		<div class="panel-footer"><p class="text-center"><b>Centro de Control 2017</b></p></div>
    </div>
		
</div>
</div>
</div>
</div>
</div>
</body>
</html>
