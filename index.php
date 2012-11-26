<?php
require_once 'clases.php';
session_start();
$pru = new cine("mysql", "localhost", "manuel", "12345", "gestcines2");
if (isset($_SESSION['nombre'])) {
    echo ("<script>
                            window.location='compra.php';
                            </script>");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Formulario de acceso</title>
        <?php
        if (isset($_POST['1'])) {// opcion para formulario de entrada
            $nombre = trim($_POST['usuario']);
            $pass = md5(trim($_POST['pass']));
            if ($nombre != "" && $pass != "") {
                $resultado = $pru->Validar($nombre, $pass);
                if (!$resultado) {
                    echo("<script>alert('Usuario inexistente');</script>");
                } else {
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['pass'] = $pass;
                    // echo("<script>alert('la variable de sesion nombre es ".$_SESSION['nombre']."');</script>");
                    echo ("<script>
                            window.location='compra.php';
                            </script>");
                }
            } else {
                echo("<script> alert('Tiene que completar todos los campos');</script>");
            }
        }
        if (isset($_POST['2'])) {
            $nombre = trim($_POST['usuario']);
            $pass = md5(trim($_POST['pass']));
            if ($nombre != "" && $pass != "") {
                $resultado = $pru->NoDuplicado($nombre);
                if (!$resultado) {
                    $fecha = $_POST['ano'] . "-" . $_POST['mes'] . "-" . $_POST['dia'];
                    echo("<script> alert('" . $fecha . "');</script>");
                    $dni = $_POST['dni'];
                    $sql = "INSERT INTO `usuarios`(`usuario`, `pass`,`dni`,`fecha`) VALUES ('" . $nombre . "','" . $pass . "','" . $dni . "','" . $fecha . "')";
                    echo("<script>alert('Vamos a registrar');</script>");
                    $pru->hacerconsulta($sql);
                } else {
                    echo("<script>alert('Usuario existente,ingrese otro nombre de usuario');</script>");
                }
            } else {
                echo("<script> alert('Tiene que completar todos los campos');</script>");
            }
        }
        ?>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
    </head>
    <body>
       

    <?php
    setlocale(LC_ALL,"es_ES@euro","es_ES","esp");// establecemos la zona horaria
    echo strftime("%A %d de %B del %Y");// mostramos el nombre del dia, el dia, "de", el nombre del mes ,"del", el año.
    ?>
        <div id="contenedor">
            <h1 style="margin: 0 auto;width: 50%;text-align: center;">FORMULARIO DE ACCESO</h1>
            <div id="formulario">
                <form method="POST" action="" id="formu">
                    <table id="login">
                        <tr>
                            <td>USUARIO:</td><td><input type="text" name="usuario"/></td>
                        </tr>
                        <tr>
                            <td>PASSWORD:</td><td><input type="password" name="pass"/></td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="ENTRAR" name="1"/></td> 
                        </tr>
                    </table>
                </form>
            </div>
            <div id="formulario2">
                <form method="POST" action="" id="formu2">
                    <table id="login2">
                        <tr>
                            <td>USUARIO:</td><td><input type="text" name="usuario"/></td>
                        </tr>
                        <tr>
                            <td>DNI:</td><td><input type="text" name="dni"/></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Fecha Nacimiento:
                                <select name="dia">
                                    <?php
                                    date_default_timezone_set('Europe/Madrid');
                                    $diasmes = date("t");
                                    $diam = date("d");
                                    $mm = date("m");
                                    $yy = date("Y");
                                    for ($d = 1; $d <= $diasmes; $d++) {
                                        if ($d == $diam) {
                                            echo("<option value='" . $d . "' selected>" . $d . "</option>");
                                        } else {
                                            echo("<option value='" . $d . "'>" . $d . "</option>");
                                        }
                                    }
                                    ?>
                                </select>
                                <select name="mes">
                                    <?php
                                    for ($m = 1; $m <= 12; $m++) {
                                        if ($m == $mm) {
                                            echo("<option value='" . $m . "' selected>" . $m . "</option>");
                                        } else {
                                            echo("<option value='" . $m . "'>" . $m . "</option>");
                                        }
                                    }
                                    ?>
                                </select>
                                <select name="ano">
                                    <?php
                                    for ($a = 1950; $a <= 2050; $a++) {
                                        if ($a == $yy) {
                                            echo("<option value='" . $a . "' selected>" . $a . "</option>");
                                        } else {
                                            echo("<option value='" . $a . "'>" . $a . "</option>");
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>PASSWORD:</td><td><input type="password" name="pass"/></td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="REGISTRAR" name="2"/></td>

                        </tr>
                    </table>
                </form>
                <script type="text/javascript">selectFecha(); </script>
            </div>
        </div><!-- fin  id contenedor -->
    </body>
</html>