<?php include 'seguridad.php';
if ($_SESSION['rol'] != 'A') {
	header("Location: index.php");
}
?>
<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Web Bitacora</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
				<link rel="stylesheet" href="css/datatable.min.css">
        <script src="js/jquery-3.2.1.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/buscarPrestamos.js"></script>
				<script src="js/datatable.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">SISTEMA PRÉSTAMOS</a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="logout.php"><?php echo $_SESSION["NombreCompleto"]. " "; ?><i class="fa fa-sign-out"></i> Salir</a></li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
             <div class="row">
                <div class="col-sm-3 col-md-2 sidebar" id="sidebar">
                    <ul class="nav nav-sidebar">
                        <li>
                            <a href="index.php" class="w3-bar-item w3-button"><i class="fa fa-home"></i> Principal</a>
                        </li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li>
                            <a href="webClientes.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i> Clientes</a>
                        </li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li>
                            <a href="webPrestamos.php" class="w3-bar-item w3-button"><i class="fa fa-list-alt"></i> Prestamos</a>
                        </li>
                    </ul>
                    <?php
                    if ($_SESSION['rol'] == 'A') {
                      echo '<ul class="nav nav-sidebar">
                        <li>
                          <a href="webParametros.php" class="w3 bar-item w3-button"><i class="fa fa-cog"></i> Configuracion </a>
                        </li>
                      </ul>
                      <ul class="nav nav-sidebar">
                        <li>
                        <a href="webUsers.php" class="w3 bar-item w3-button"><i class="fa fa-users"></i> Usuarios </a>
                        </li>
                      </ul>
                      <ul class="nav nav-sidebar">
                        <li>
                          <a href="reporteEstadosFinancieros.php" target="_blank" class="w3 bar-item w3-button"><i class="fa fa-university"></i> Estados Financieros </a>
                        </li>
                      </ul>
											<ul class="nav nav-sidebar">
					              <li>
					                <a href="modificarPlantillaContrato.php" class="w3 bar-item w3-button"><i class="fa fa-file-text"></i> Editar Contrato </a>
					              </li>
					            </ul>
											<ul class="nav nav-sidebar">
					              <li>
					                <a href="webBitacora.php" class="w3 bar-item w3-button"><i class="fa fa-address-book"></i> Bitacora</a>
					              </li>
					            </ul> ';
                    }
                      ?>
                </div>
                 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                 <br>
                 <table class="table table-condensed" id="tablaBitacora">
                     <thead>
                         <tr>
                         <th>ID Bitacora</th>
                         <th>Usuario</th>
                         <th>Fecha</th>
                         <th>Accion</th>
                         </tr>
                     </thead>
                     <tbody>
                        <?php
                            require_once 'Bitacora.php';
                            $b = new Bitacora();
                            $Bitacora = $b->obtenerTodos();
                            $numBitacora = count($Bitacora);
                            for ($i = 0; $i < $numBitacora; $i++) {
                                echo "<tr>";
                                echo "<td>" . $Bitacora[$i]->getId_bitacora() . "</td>";
                                echo "<td>" . $Bitacora[$i]->getId_usuario() . "</td>";
                                echo "<td>" . $Bitacora[$i]->getFecha() . "</td>";
                                echo "<td>" . $Bitacora[$i]->getAccion() . "</td>";
                                echo "</tr>";
                            }
                        ?>
                     </tbody>
                 </table>
            </div>
    </body>
    </html>
