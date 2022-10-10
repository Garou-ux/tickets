<?php
require_once("config/conexion.php");
if(isset($_POST["enviar"]) && $_POST["enviar"]=="si"){
    require_once("models/Modelusuario.php");
    $usuario = new Usuario();
    $usuario->login();
}
?>

<!DOCTYPE html>
<html>
<head lang="es">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>ConecTotal</title>

	<link href="public/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="public/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="public/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="public/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="public/img/favicon.png" rel="icon" type="image/png">
	<link href="public/img/favicon.ico" rel="shortcut icon">


<link rel="stylesheet" href="public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/indexmain.css">
</head>
<body id="grad1">

    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">

            <div class="register-photo">
    <div class="form-container">
        <div class="image-holder"></div>
        <form method="post" action=""  id="Datos">
        <?php
                    if(isset($_GET["m"])){
                        switch($_GET["m"]){
                            case '1':
                                ?>
                                <div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<i class="font-icon font-icon-warning"></i>
							Usuario o Contraseña Invalidos
						</div>
                                <?php
                                break;
                                case '2':
                                ?>
                                       <div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<i class="font-icon font-icon-warning"></i>
							Los Campos no pueden estar vacios
						</div>
                                <?php
                        }
                        
                    }
                    ?>
            <h2 class="text-center"><strong>Iniciar</strong> Sesión</h2>
            <div class="form-group"><input class="form-control" type="email" id="Datos_Correo" name="Datos_Correo" placeholder="Usuario"></div>
            <div class="form-group"><input class="form-control" type="password" id="Datos_Pass" name="Datos_Pass" placeholder="Contraseña"></div>
          
            <input type="hidden" name="enviar" class="form-control" value="si">
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Iniciar Sesión</button></div>
            <!-- <a class="already" href="http://localhost/TICKETSV1/view/ReseteoPass/">¿Olvidaste tu contraseña?</a> -->
           
        </form>
    </div>
</div>
            </div>
        </div>
    </div><!--.page-center-->


<script src="public/js/lib/jquery/jquery.min.js"></script>
<script src="public/js/lib/tether/tether.min.js"></script>
<script src="public/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="public/js/plugins.js"></script>
<script type="text/javascript" src="public/js/lib/match-height/jquery.matchHeight.min.js"></script>
<script src="public/js/app.js"></script>
</body>
</html>