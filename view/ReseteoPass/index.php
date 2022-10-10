
<!DOCTYPE html>
<html>
<head lang="es">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>ConecTotal</title>

	<link href="../../public/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="../../public/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="../../public/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="../../public/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="../../public/img/favicon.png" rel="icon" type="image/png">
	<link href="../../public/img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
<link rel="stylesheet" href="../../public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="../../public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../../public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/main.css">

    <style>
        #grad1 {
  /* height: 200px;
  background-color: white; /* para naveg */
  /* background-image: linear-gradient(blue,white,black); */ 
  background: linear-gradient(90deg, #4b6cb7 0%, #182848 100%);
}
    </style>
</head>
<body id="grad1">
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form id="FormCambio" class="sign-box reset-password-box">
                    <!--<div class="sign-avatar">
                        <img src="img/avatar-sign.png" alt="">
                    </div>-->
                    <header class="sign-title">Cambiar Contraseña</header>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Correo" required/>
                    </div>
                    <button type="button" id="CambiarPass" class="btn btn-rounded">Cambiar</button>
                     <a href="http://localhost/TICKETSV1/">Iniciar Sesión</a>
                </form>

                <form id="FormCambioPass" class="sign-box reset-password-box">
                    <!--<div class="sign-avatar">
                        <img src="img/avatar-sign.png" alt="">
                    </div>-->
                    <header class="sign-title">Nueva Contraseña</header>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Contraseña Nueva"/>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirma la Contraseña"/>
                    </div>
                    <button type="button" class="btn btn-rounded btn-block">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div><!--.page-center-->

<script src="../../public/js/lib/jquery/jquery.min.js"></script>
<script src="../../public/js/lib/tether/tether.min.js"></script>
<script src="../../public/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="../../public/js/plugins.js"></script>
    <script type="text/javascript" src="../../public/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
<script src="../../public/js/app.js"></script>
<script type="text/javascript" src="ctrlReseteoPass.js"></script>
</body>
</html>