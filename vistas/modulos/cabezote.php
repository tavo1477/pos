<header class="main-header">

	<!--=============================================
 	LOGOTIPO
	=============================================--> 

	<a href="" class="logo">
		
		<!-- logo-mini -->
		<span class="logo-mini">
			
			<img src="vistas/images/plantilla/icono-blanco.png" class="img-responsive" style="padding: 10px;">

		</span>

		<!-- logo-normal -->
		<span class="logo-mini">
			
			<img src="vistas/images/plantilla/logo-blanco-lineal.png" class="img-responsive" style="padding: 10px 0;">

		</span>

	</a>

	<!--=============================================
 	BARRA DE NAVEGACIÓN
	=============================================--> 

	<nav class="navbar navbar-static-top" role="navigation">

		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			
			<span class="sr-only">Toggle Navigation</span>		

		</a>

		<!-- Perfil de usuario -->	

		<div class="navbar-custom-menu">
			
			<ul class="nav navbar-nav">
				
				<li class="dropdown user user-menu">
					
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">

						<?php 

							if ($_SESSION["foto"] != "") {
								
								echo '<img src="'.$_SESSION["foto"].'" class="user-image" alt="User Image">';

							} else {

								echo '<img src="vistas/images/usuarios/default/anonymous.png" class="user-image" alt="User Image">';
							}

						 ?>						

						<span class="hidden-xs"><?php echo $_SESSION["nombre"] ?></span>

					</a>

					<!-- Dropdown-toggle -->

					<ul class="dropdown-menu">

						<li class="user-body">
							
							<div class="pull-right">

								 <a href="salir" class="btn btn-default btn-flat">Salir</a>
								
							</div>

						</li>			

					</ul>

				</li>

			</ul>

		</div>

	</nav>

</header>