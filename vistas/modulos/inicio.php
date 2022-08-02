<div class="content-wrapper"> 

    <section class="content-header">

      <h1>

        Página de inicio
        <small>Panel de control</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>      
        <li class="active">Tablero</li>

      </ol>

    </section>

    <section class="content">

      <div class="row">
        
        <?php 

          if ($_SESSION["perfil"] == "Administrador") {
            
             include "inicio/caja-superiores.php";

          }         

         ?>

      </div> 

      <div class="row">
          
        <div class="col-lg-12">
          
          <?php 

          if ($_SESSION["perfil"] == "Administrador") {

            include "reportes/grafico-ventas.php";

          }   

           ?>

        </div>

         <div class="col-lg-6">

          <?php 

            if ($_SESSION["perfil"] == "Administrador") {

              include "reportes/productos-mas-vendidos.php";

            }

           ?>           

         </div>

         <div class="col-lg-6">

          <?php 

            if ($_SESSION["perfil"] == "Administrador") {

             include "inicio/productos-mas-recientes.php";

            }

           ?>           

         </div>

         <div class="col-lg-12">
           
          <?php 

            if ($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor") {

              echo '<div class="box box-success text-center">

                      <div class="box-header">

                        <h1>Bienvenid@ ' .$_SESSION["nombre"].'</h1> <br> 

                        <img class="img-fluid" src="'.$_SESSION["foto"].'">

                      </div>

                 </div>';


            }

           ?>

         </div>

      </div>          

    </section>
 
</div>