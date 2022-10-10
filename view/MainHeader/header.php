
<style>
		#HeaderDegradado{
			background: linear-gradient(90deg,#182848 100% ,#4b6cb7 0%);
           
		}
	</style>
<header id="HeaderDegradado" class="site-header">
    <div class="container-fluid">

       
        <a href="../Home/" class="site-logo">
	            <!-- <img class="hidden--down" src="../../public/img/Logo.PNG" alt=""> -->
	            <!-- <img class="hidden-lg-up" src="../../public/img/logo-2-mob-caribbean.png" alt=""> -->
                <span class="hidden-md-down"  style="color: white;">CONEXIÓN</span> <span class="hidden-md-down" style="color:dodgerblue">TOTAL</span>
                <span class="hidden-lg-up"  style="color: white;">C</span> <span class="hidden-lg-up" style="color:dodgerblue">T</span>
	        </a>
        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>

        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                    <div class="dropdown user-menu">
                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../../public/img/avatar-1-128.png" alt="">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <!-- <a class="dropdown-item" href="../Perfil/"><span class="font-icon glyphicon glyphicon-user"></span>Perfil</a> -->
                            <!-- <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span>Ayuda</a> -->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../Logout/logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Cerrar Sesion</a>
                        </div>
                    </div>
                </div>

                <div class="mobile-menu-right-overlay"></div>

                <input type="hidden" id="UsuarioId" value="<?php echo $_SESSION["UsuarioId"] ?>"><!-- ID del Usuario-->
                <input type="hidden" id="RolId" value="<?php echo $_SESSION["RolId"] ?>"><!-- Rol del Usuario-->
<!-- 
                <div class="dropdown dropdown-typical">
                    <a href="#" class="dropdown-toggle no-arr">
                        <span class="font-icon font-icon-user"></span>
                        <span style="color: white;"class="lblcontactonomx"><?php echo $_SESSION["Nombre"]?></span>
                    </a>
                </div> -->

            </div>
        </div>
    </div>
</header>