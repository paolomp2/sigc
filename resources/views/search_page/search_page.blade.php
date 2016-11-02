

<!DOCTYPE HTML>
<!--
	Big Picture by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Delimitador ontológico</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="css/main.css" />
		<link rel="stylesheet" href="css/my.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		
	</head>
	<body>

		<!-- Header -->
			<header id="header">

				<!-- Logo -->
					<h1 id="logo">Delimitador ontológico</h1>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="#intro">Búsqueda</a></li>
							<li><a href="#one">Necesidad</a></li>
							<li><a href="#two">Resultados</a></li>
							<li><a href="#work">Módulos</a></li>
							<li><a href="/login">Acceder</a></li>
						</ul>
					</nav>

			</header>

		<!-- Intro -->
			<section id="intro" class="main style1 dark fullscreen">
				<div class="content container 100%">
					<header>
						<h1>Es hora de comenzar a consultar</h1>
					</header>

					{!!Form::open(['route'=>'search.post','method'=>'POST'])!!}

						<div>
							<textarea name="sparql_text" class="seacrh_text" type="text" placeholder="Ingrese su código SPARQL aquí."></textarea>
						</div>

						<div>
							<div id="div_inline" class="label_search_select">
								Dominio de búsqueda:
							</div>
							<div id="div_inline" class="select_box">
								<select id="select_domain" name="select_domain">
								  <option value="volvo">Volvo</option>
								  <option value="saab">Saab</option>
								  <option value="mercedes">Mercedes</option>
								  <option value="audi">Audi</option>
								</select>
							</div>
						</div>
						<button type="submit" class="btn">Buscar</button>
					</form>

					<footer>
						<a href="#one" class="button style2 down">More</a>
					</footer>
				</div>
			</section>

		<!-- One -->
			<section id="one" class="main style2 right dark fullscreen">
				<div class="content box style2">
					<header>
						<h2>Necesidad</h2>
					</header>
					<p>La web semántica organiza la información de manera estructurada en ontologías que contienen información
						de uno o más dominios. Pero ¿si deseamos buscar en un dominio determinado? ¿Cómo delimitamos la información
						en dominios personalizados?
						Aquí les contamos.
					</p>
				</div>
				<a href="#two" class="button style2 down anchored">Next</a>
			</section>

		<!-- Two -->
			<section id="two" class="main style2 left dark fullscreen">
				<div class="content box style2">
					<header>
						<h2>Resultados</h2>
					</header>
					<p>La presente aplicación permite buscar a través de SPARQL en una o más ontologías alojadas en los repositorios semánticos
						dispersos por toda la web. Estas búsquedas se hacen consultando en uno o más grupos de información denomiadas clases
						que pertenecen a una o varias ontologías y devuelve los resultados indicando de dónde provienen.</p>
				</div>
				<a href="#work" class="button style2 down anchored">Next</a>
			</section>

		<!-- Work -->
			<section id="work" class="main style3 primary">
				<div class="content container">
					<header>
						<h2>Módulos</h2>
						<p>La presente aplicación tiene como resultado 5 módulos que permiten procesar la información de los repositorios
							semánticos.</p>
					</header>

					<!-- Lightbox Gallery  -->
						<div class="container 75% gallery">
							<div class="row 0% images">
								<div class="6u 12u(mobile)"><a href="images/fulls/Diapositiva1.jpg" class="image fit from-left"><img src="images/fulls/Diapositiva1.jpg" title="Módulo de repositorios - Permite anexar repositorios semánticos." alt="" /></a></div>
								<div class="6u 12u(mobile)"><a href="images/fulls/Diapositiva3.jpg" class="image fit from-right"><img src="images/fulls/Diapositiva3.jpg" title="Módulo de mapeo de clases - Permite extraer la jerarquía de clases de los repositorios." alt="" /></a></div>
							</div>
							<div class="row 0% images">
								<div class="6u 12u(mobile)"><a href="images/fulls/Diapositiva4.jpg" class="image fit from-left"><img src="images/fulls/Diapositiva4.jpg" title="Módulo de definición de dominios - Permite definir los dominios de búsqueda personalizados." alt="" /></a></div>
								<div class="6u 12u(mobile)"><a href="images/fulls/Diapositiva5.jpg" class="image fit from-right"><img src="images/fulls/Diapositiva5.jpg" title="Módulo de clasificación de dominios - Permite clasificaar las clases en los dominios definidos." alt="" /></a></div>
							</div>
							<div class="row 0% images">
								<div class="6u 12u(mobile)"><a href="images/fulls/Diapositiva6.jpg" class="image fit from-left"><img src="images/fulls/Diapositiva6.jpg" title="Módulo de inferencias - Permite transformar las consultas SPARQL para buscar específicamente en un dominio" alt="" /></a></div>
								<div class="6u 12u(mobile)"><a href="images/fulls/Diapositiva7.jpg" class="image fit from-right"><img src="images/fulls/Diapositiva7.jpg" title="Proceso de transformación de las consultas SPARQL" alt="" /></a></div>
							</div>
						</div>

				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">

				<!-- Icons -->
					<ul class="actions">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
						<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
						<li><a href="#" class="icon fa-pinterest"><span class="label">Pinterest</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
					</ul>

				<!-- Menu -->
					<ul class="menu">
						<li>&copy; Untitled</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>

			</footer>

		<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.poptrox.min.js"></script>
			<script src="js/jquery.scrolly.min.js"></script>
			<script src="js/jquery.scrollex.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/util.js"></script>
			<!--[if lte IE 8]><script src="js/ie/respond.min.js"></script><![endif]-->
			<script src="js/main.js"></script>
			<script src="js/my.js"></script>
			
			{!!Html::script('cms/js/select/select2.full.js')!!}
			<script>
			$(document).ready(function() {
		      $(".select2_single").select2();  
		    });
			</script>

	</body>
</html>
