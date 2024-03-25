<?php
  // Se incluye el archivo de configuración de la conexión a la base de datos
  require_once("../../Config/conexion.php");

  // Verifica si existe una sesión iniciada para el usuario
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
<head lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Detalle Ticket</title>
    <!-- Se incluye el favicon -->
    <link rel="icon" href="ruta/de/tu/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="ruta/de/tu/favicon.ico" type="image/x-icon">
    <!-- Se incluyen las hojas de estilo y otros elementos del encabezado -->
    <?php require_once("../MainHead/head.php"); ?>
</head>
<body class="with-side-menu">
    <!-- Se incluye el encabezado de la página -->
    <?php require_once("../../view/MainHeader/header.php") ?>

    <!-- Se incluye la navegación principal -->
    <?php require_once("../../view/MainNav/nav.php")?>

    <!-- Contenedor principal del contenido de la página -->
    <div class="page-content">
        <div class="container-fluid">
            <!-- Encabezado de la sección -->
            <header class="section-header">
                <!-- Título y navegación -->
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <!-- Título del ticket y navegación -->
                            <h3 id="lblidticket"> </h3>
                            <span  id="lblestado"></span>
                            <span class="label label-pill label-primary" id="lblnomusuario"></span>
                            <span class="label label-pill label-info" id="lblfechcrea"></span>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../ConsultarTicket/index.php">Home</a></li>
                                <li class="active">Detalle Ticket</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenido del ticket -->
            <div class="box-typical box-typical-padding">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- Campo para la categoría del ticket -->
                        <fieldset class="form-group">
                            <label class="form-label semibold" for="cat_nom">Categoria</label>
                            <input type="text" class="form-control" id="cat_nom" name="cat_nom" readonly>
                        </fieldset>
                    </div>
                    <div class="col-lg-6">
                        <!-- Campo para el título del ticket -->
                        <fieldset class="form-group">
                            <label class="form-label semibold" for="tick_titulo">Titulo</label>
                            <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" readonly>
                        </fieldset>
                    </div>
                    <div class="col-lg-12">
                        <!-- Campo para la descripción del ticket -->
                        <fieldset class="form-group">
                            <label class="form-label semibold" for="tickd_descripcionDet">Descripcion</label>
                            <div class="summernote-theme-1" >
                                <textarea id="tickd_descripcionDet" class="summernote" name="tickd_descripcionDet" readonly></textarea>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <!-- Sección para la actividad relacionada con el ticket -->
            <section class="activity-line" id="lbldetalle">
                
            </section>

            <!-- Panel para ingresar comentarios -->
            <div class="box-typical box-typical-padding" id="pnldetalle">
                <div class="row">                        
                    <div class="col-lg-12">
                        <!-- Campo para ingresar comentarios -->
                        <fieldset class="form-group">
                            <label class="form-label semibold" for="tickd_descripcion">Ingresar Comentario</label>
                            <div class="summernote-theme-1" >
                                <textarea id="tickd_descripcion" class="summernote" name="tickd_descripcion"></textarea>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-12">
                        <!-- Botones para guardar y cerrar el ticket -->
                        <button type="button" id="btnenviar" class="btn btn-rounded btn-inline btn-primary"><font style="vertical-align: inherit;">Guardar</font></button>
                        <button type="button" id="btncerrar" class="btn btn-rounded btn-inline btn-danger"><font style="vertical-align: inherit;">Cerrar Ticket</font></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Se incluyen los archivos JavaScript -->
    <?php require_once("../../view/MainJS/JS.php") ?>
    
    <!-- Se incluye el script específico para esta página -->
    <script type="text/javascript" src="detalleticket.js"></script>

</body>
</html>
<?php
  } else {
    // Si no hay una sesión iniciada, redirige al usuario a la página de inicio de sesión
    header("Location:".Conectar::ruta()."index.php");
  }
?>