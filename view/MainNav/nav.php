<?php
//rolid =2 clientes
    if ($_SESSION["RolId"]==2){
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Home\">
                            <span class="glyphicon glyphicon-home"></span>
                            <span class="lbl">Inicio</span>
                        </a>
                    </li>
                    <li class="blue-dirty">
                        <a href="..\NuevoTicket\">
                            
                            <span class="glyphicon glyphicon-edit"></span>
                            <span class="lbl">Nuevo Ticket</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\ConsultarTicket\">
                        <span class="glyphicon glyphicon-list-alt"></span>
                            <span class="lbl">Consultar Ticket</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php
    }
    
    //rolid =1 admins
    if ($_SESSION["RolId"]==1){
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Home\">
                            <span class="glyphicon glyphicon-home"></span>
                            <span class="lbl">Inicio</span>
                        </a>
                    </li>
                        <!-- <li class="blue-dirty">
                            <a href="..\MntUsuario\">
                                <span class="glyphicon glyphicon-user"></span>
                                <span class="lbl">Usuarios</span>
                            </a>
                        </li> -->
                    <li class="blue with-sub">
	            <span>
	                <i class="font-icon font-icon-burger"></i>
	                <span class="lbl">Catalogos</span>
	            </span>
	            <ul >
	               <li class="blue-dirty">
                            <a href="..\MntUsuario\">                           
                                <span class="lbl">Usuarios</span>
                            </a>
                        </li>
	                <li><a href="..\Productos\"><span class="lbl">Productos</span></a></li>
	                <li><a href="..\Categorias\"><span class="lbl">Categorias</span></a></li>
                    <li><a href="..\Clientes\"><span class="lbl">Clientes</span></a></li>
	                
	            </ul>
	        </li>
                    <li class="blue-dirty">
                        <a href="..\ConsultarTicket\">
                        <span class="glyphicon glyphicon-list-alt"></span>
                            <span class="lbl">Consultar Ticket</span>
                        </a>
                    </li>
                    <li class="blue-dirty">
                        <a href="..\Cotizacion\">
                        <span class="glyphicon glyphicon-file"></span>
                            <span class="lbl">Cotizacion</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\Facturacion\">
                        <span class="glyphicon glyphicon-file"></span>
                            <span class="lbl">Facturacion</span>
                        </a>
                    </li>
                    
                    <li class="blue-dirty">
                        <a href="..\Pagos\">
                        <span class="glyphicon glyphicon-file"></span>
                            <span class="lbl">Pagos</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php
    }
   // rolid=3 facturacion
    if ($_SESSION["RolId"]==3){
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                   
                <li class="blue with-sub">
	            <span>
	                <i class="font-icon font-icon-burger"></i>
	                <span class="lbl">Catalogos</span>
	            </span>
	            <ul >
	            
	           
                    <li><a href="..\Clientes\"><span class="lbl">Clientes</span></a></li>
	                
	            </ul>
	        </li>
                    <li class="blue-dirty">
                        <a href="..\Facturacion\">
                        <span class="glyphicon glyphicon-file"></span>
                            <span class="lbl">Facturacion</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\Cotizacion\">
                        <span class="glyphicon glyphicon-file"></span>
                            <span class="lbl">Cotizacion</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php
    }
?>
