<html>
	<head>
	
	<!-- Load js files -->
	<script src="/object/jquery/jquery-3.2.1.min.js"></script>
	<script src="/object/js/bootstrap.bundle.js"></script>

	<!-- Load CSS & Icons library -->
	<link rel="stylesheet" href="/object/css/bootstrap.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!-- Responsive design for mobile navigation -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style>
		body {
		    font-family: Arial;
		}
	</style>

	<!-- Assign UTF-8 -->
	<meta charset="utf-8" />

	<title>
		Alta
	</title>
	</head>
	<body>

		<!-- Navbar -->

		<nav class="navbar navbar-expand-lg navbar-dark bg-dark" 
		style="position: sticky; z-index: 1071; top: 0;">

		    <a class="navbar-brand" href="#">
			    <img src="/object/images/cn.png" width="80" height="30" class="d-inline-block align-top" alt="">
			    Club de Natación
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav mr-auto">
		    		<li class="nav-item active">
		    			<a class="nav-link" href="index.html">Inicio <span class="sr-only">(current)</span></a>
		    		</li>
		    		<li class="nav-item">
		    			<a class="nav-link" href="FichasEmpleados.php">Personal</a>
		    		</li>
		    		<li class="nav-item">
		    			<a class="nav-link" href="crud.php">Socios</a>
		    		</li>
		    	</ul>
		    	<span class="navbar-text">
		    	</span>
			</div>
		</nav>

		<!-- End of Navbar -->

		<!-- Content -->

		<div class="container-fluid" style="margin-top: 3rem;">
			<div class="row flex-xl-nowrap">

				<!-- Left Sidebar -->

				<div class="col-12 col-md-3 col-xl-2 bd-sidebar">
					helloworld!
					helloworld!
					helloworld!
					helloworld!
				</div>

				<!-- End of Sidebar -->

				<!-- Main body -->

				<main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content">

					<?php	
						require('Conectar.php');
					?>
					<?php

						//Tomando por Post las variables del formulario:
						$nombre = $_POST['nombre'];
						$apellido = $_POST['apellido'];
						$DNI = $_POST['DNI'];
						$telefono = $_POST['telefono'];
						$direccion = $_POST['direccion'];
						$actividad = $_POST['actividad'];

						//Conecto a la BD
						$pdo = conectar();

						//Preparo la sentencia INSERT, con parámetros llamados :a, :b, :c, :d, :e, :f
						$insercion = $pdo -> prepare("INSERT INTO socios (nombre, apellido, telefono, DNI, direccion) VALUES (:a, :b, :c, :d, :e);");

						$insercion1 = $pdo -> prepare ("INSERT INTO socio_actividad (actividad_id) VALUES (:f);");

						//Le asigno valor a los parámetros :a , :b, :c, :d, :e, :f
						$insercion -> bindValue(':a',$nombre);
						$insercion -> bindValue(':b',$apellido);
						$insercion -> bindValue(':c',$telefono);
						$insercion -> bindValue(':d',$DNI);
						$insercion -> bindValue(':e',$direccion);


						$insercion1 -> bindValue(':f',$actividad);

						$insercion -> execute();
						$insercion -> execute();
						
						// Preparo la sentencia INSERT para tabla pivot:
						//$activityselect = $pdo -> prepare("INSERT INTO socio.actividad (socio_id, actividad_id) 
							//VALUES (:f);");

						// Verifico DNI mediante que no exista el socio mediante un Select:
						$idsocionuevo = $pdo -> prepare("SELECT id from socios WHERE DNI = $DNI");
						$idsocionuevo -> execute ();
						
						$row1 = $idsocionuevo->fetchAll(PDO::FETCH_ASSOC);

						print_r($idsocionuevo);

						// Asigno valor a los parámetros :f
						//$activityselect -> bindValue(':f',$actividad);
						//$activityselect -> execute ();

						//Ejecutamos la sentencia preparada antes:
						if ($insercion -> execute() ) {
						 //Si la inserción fue exitosa:
							echo "El socio fue agregado."."<br><br>";
							if ($activityselect -> execute() ){
							   	echo "Funciono el segundo select";
							    }
							else{
							  	echo "No funciono el segundo select";
							}
						}
						else {
						    echo "Error al agregar al socio";
						}
							//else {
							//	echo "El socio ingresado ya existe. ";
							//}	
					
					?>	
					<a href="crud.php" class="btn btn btn-primary"> Volver a la página de socios </a>
					<a href="index.html" class="btn btn btn-primary"> Volver al Inicio </a>

				</main>

				<!-- End of Main Body-->

				<!-- Right Sidebar -->

				<div class="d-none d-xl-block col-xl-2 bd-toc">
					<ul class="section-nav" style="list-style: none; margin-top: 4rem;">
						<li class="toc-entry toc-h2">
							<a href="formAlta.php" style="color:#99979c"> 
								<i class="fa fa-plus" aria-hidden="true"></i> Dar de alta a un nuevo socio 
							</a> 
						</li>
						<li class="toc-entry toc-h2">
							<a href="index.html" style="color:#99979c">
								<i class="fa fa-home" aria-hidden="true"></i> Volver al inicio
							</a>
						</li>
					</ul>
				</div>

				<!-- End of  Sidebar -->

			</div>

		</div>

		<!-- End of Content -->

	</body> 
</html>
