<?php
require_once 'clases.php';
session_start();
// instanciamos un objeto de la clase cine para la conexion y gestion de la base de datos...
$pru = new cine("mysql", "localhost", "manuel", "12345", "gestcines2");

// si no existe la variable de sesion "nombre" lo manda al formulario de acceso
if (!isset($_SESSION['nombre'])) {
    echo ("<script>
                            window.location='index.php';
                            </script>");
}
// si se ha seleccionado una sala se crea la variable de sesion sala para crear el objeto archivo...
if (isset($_POST['sala'])) {
    switch ($_POST['sala']) {
        case '1':
            $_SESSION['sala'] = "sala1.txt";
            break;
        case '2':
            $_SESSION['sala'] = "sala2.txt";
            break;
        case '3':
            $_SESSION['sala'] = "sala3.txt";
            break;
    }
}
// si no existe la variable de sesion sala la crea y por defecto le da el valor de la sala 1
if (!isset($_SESSION['sala'])) {
    $_SESSION['sala'] = "sala1.txt";
}
//echo("<script>alert('se va a entrar en la sala ".$_SESSION['sala']."');</script>");
// instanciamos un objeto de la clase gestcines para la conexion y gestion de la base de datos...
$archivo = new gestCines($_SESSION['sala']); // creamos la clase archivo para control salas ...
// si no existe el archivo txt de la sala correspondiente se crea y se pone sus butacas a 0
if (!is_file($_SESSION['sala'])) {
    $archivo->iniciarSala();
}
$archivo->butacas = $archivo->arrayLineas();

/* * ********si se ha pulsado el boton de compra realizamos la compra...****************** */
/* if (isset($_POST['bcompra'])){
  if (isset($_POST['c0'])){
  echo("<script>alert('se selecciono la butaca f0');</script>");
  }
  if (isset($_POST['c1'])){
  echo("<script>alert('se selecciono la butaca f1');</script>");
  }
  } */

if (isset($_POST['genera'])) {
    $_SESSION['sala'] = "sala3.txt";
    $archivo = new gestCines($_SESSION['sala']);
    $archivo->iniciarSala();
    $_SESSION['sala'] = "sala2.txt";
    $archivo = new gestCines($_SESSION['sala']);
    $archivo->iniciarSala();
    $_SESSION['sala'] = "sala1.txt";
    $archivo = new gestCines($_SESSION['sala']);
    $archivo->iniciarSala();
    $archivo->butacas = $archivo->arrayLineas();
}

//*******validar la compra //

if (isset($_POST['buta'])) {
    $archivo->butacas = $archivo->arrayLineas();
    if ($archivo->butacas[$_POST['buta']] == 0) {
        $archivo->butacas[$_POST['buta']] = 1;
        $archivo->compra();
        // insertamos 10 puntos al usuario
        $sql = "UPDATE `usuarios` SET `puntos`=`puntos`+10 where `usuario`='" . $_SESSION['nombre'] . "' ";
        $pru->hacerconsulta($sql);
        // averiguamos cuantos puntos tiene despues de la compra
        $punt = $pru->getpuntos($_SESSION['nombre']);
        if ($punt == 50) {
            $sql = "UPDATE `usuarios` SET `regpalomitas`=`regpalomitas`+1 where `usuario`='" . $_SESSION['nombre'] . "' ";
            $pru->hacerconsulta($sql);
            $sql = "UPDATE `usuarios` SET `premios`=`premios`+1 where `usuario`='" . $_SESSION['nombre'] . "' ";
            $pru->hacerconsulta($sql);
        }
        if ($punt == 100) {
            $sql = "UPDATE `usuarios` SET `premios`=`premios`+2 where `usuario`='" . $_SESSION['nombre'] . "' ";
            $pru->hacerconsulta($sql);
            $sql = "UPDATE `usuarios` SET `regpalomitas`=`regpalomitas`+1 where `usuario`='" . $_SESSION['nombre'] . "' ";
            $pru->hacerconsulta($sql);
            $sql = "UPDATE `usuarios` SET `regentrada`=`regentrada`+1 where `usuario`='" . $_SESSION['nombre'] . "' ";
            $pru->hacerconsulta($sql);
            $sql = "UPDATE `usuarios` SET `puntos`=0 where `usuario`='" . $_SESSION['nombre'] . "' ";
            $pru->hacerconsulta($sql);
        }
        //echo("<script>alert('puntos de ".$_SESSION['nombre']." " . $punt . "');</script>");
    } else {
        unset($_POST['buta']);
        echo("<script>alert('Butaca no disponible');</script>");
        echo ("<script>
                            window.location='compra.php';
                            </script>");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript" src="funciones.js"></script>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
    </head>
    <body>
        <div id="contenedor" style="text-align: center">
            <h1> GESTION DE SALAS </h1>
            <?php
            if ($_SESSION['nombre'] == "manuel") {
                echo("<form id='gsalas' method='POST' action='compra.php'>
                <input type='hidden' name='genera' />
                <input type='submit' value='INICIAR SALAS' />
            </form>");
            }
            ?>
            <form id="salas" name="salas" method="POST" action="">
                <select name="sala" onchange="salas.submit()">
                    <option value="0">Seleccione una sala</option>
                    <option value="1">SALA 1</option>
                    <option value="2">SALA 2</option>
                    <option value="3">SALA 3</option>
                </select>
            </form>
            <h2> DISPONIBILIDAD DE LA SALA <?PHP
            if (isset($_SESSION['sala']) && $_SESSION['sala'] == "sala1.txt") {
                echo("1");
            }
            if (isset($_SESSION['sala']) && $_SESSION['sala'] == "sala2.txt") {
                echo("2");
            }
            if (isset($_SESSION['sala']) && $_SESSION['sala'] == "sala3.txt") {
                echo("3");
            }
            ?></h2>
            <div id="butacas" style="width: 710px; margin: 0 auto;">
                <?php
                $archivo->mostrarSala();
                ?>
            </div>
            <!--
            <form id="compra" method="POST" action="">
                NºENTRADAS<input type="text" name="cantidad"/>
                <input type="submit" value="COMPRAR"/>
            </form>-->
            <div id="dat"  style="overflow: hidden;  width: 160px; height:60px; display: none; position: absolute; z-index: 10; top: 15%;left: 65%; ">
                <input id="dat2" type="text" value="34" style="opacity: 0.8;"/>
            </div>
        </div>
    </body>
</html>
