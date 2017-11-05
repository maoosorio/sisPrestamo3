<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Sistema Préstamos</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
  </head>
<?php
require_once 'Bitacora.php';
  
  session_start();

  if ($_SESSION["estado"] == "activo") {

      $controladorBitacora = new Bitacora();
      $id_usuario = $_SESSION["id_usuario"];
      $fecha = date('Y-m-d');
      $hora = date('h:i:s');
      $usuario = $_SESSION["userName"];
      $accion = "El usuario ".$usuario." cerro sesion ";
      $id_bitacora = $controladorBitacora->maxID($id_usuario);
        $b = new Bitacora();
        $b->setId_bitacora($id_bitacora);
        $b->setId_usuario($id_usuario);
        $b->setFecha($fecha . " " . $hora);
        $b->setAccion($accion);
        $controladorBitacora->agregar($b);
        session_destroy();
  }


 ?>
  <body>
      <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container-fluid">
              <div class="navbar-header">
                  <a class="navbar-brand" href="#">SISTEMA PRÉSTAMOS</a>
              </div>
          </div>
      </nav>

    <div class="container">

      <form class="form-signin" method="POST" action="autorizar.php">
        <h2 class="form-signin-heading">Inicio de sesión</h2>
        <label for="Usuario" class="sr-only">Nombre de usuario</label>
        <input type="text" id="user" name="user" class="form-control" placeholder="Nombre de usuario" required autofocus>
        <label for="password" class="sr-only">Contraseña</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>
