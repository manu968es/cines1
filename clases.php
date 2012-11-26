<?php

class claseArchivo {

    protected $Arxiu;  // Punter a l'arxiu
    protected $Nom;    // El nom
    protected $Mode;   // El mode en que l'obrim
    public $Contingut;

    function __construct($pNom = 'classArxiu.php') {
        $this->Nom = $pNom;
    }

    /*
      function __destruct () {
      fclose($this->Arxiu);
      echo unlink($this->Nom);
      echo "<br>--- Arxiu eliminat en tancar la sessi� ---";
      }
     */

    function Abrir($pMode = 'r+') {
        $this->Mode = $pMode;
        $this->Arxiu = fopen($this->Nom, $this->Mode);
        if (!$this->Arxiu) {
            echo "<br> No s'ha pogut obrir l'arxiu";
            return false;
        }
    }

    function Cerrar() {
        fclose($this->Arxiu); // echo "Arxiu Tancat";
    }

    function Leer() {
        rewind($this->Arxiu);
        echo "<hr>Contingut de l'arxiu: <b>" . $this->Nom . "</b><hr>";
        while (!feof($this->Arxiu)) {
            $this->Contingut = fgets($this->Arxiu);
            //$r = nl2br($this->Contingut);// esto añadia caracteres al string  NO UTILIZAR¡¡¡¡¡
            echo $this->Contingut . "<br>";
        }
    }

    
      function arrayLineas() {
      $this->Abrir("r");
      rewind($this->Arxiu);
      $a = array();
      while (!feof($this->Arxiu)) {
      $this->Contingut = fgets($this->Arxiu);
      //$r = nl2br($this->Contingut);// esto añadia caracteres al string  NO UTILIZAR¡¡¡¡¡
      $a[] = $this->Contingut;
      }
      return $a;
      }
     

    function leerLinea() {
        if (!feof($this->Arxiu)) {
            $this->Contingut = trim(fgets($this->Arxiu));
            return $this->Contingut;
        }
        else
            return false;
    }

    function Escribir($pCadena) {
        fputs($this->Arxiu, trim($pCadena) . chr(13) . chr(10));
    }

    function Borrar() {
        // Esborrem el contingut de l'arxiu
        $this->Arxiu = fopen($this->Nom, 'w+');
        // EL tanquem
        fclose($this->Arxiu);
    }

    function finArchivo() {
        if (feof($this->Arxiu))
            return true;
        else
            return false;
    }

}

//****************  clase para la gestion de salas con archivos txt ***********//

class gestCines extends claseArchivo {
   public  $butacas=array();
    function __construct($pNom = 'classArxiu.php') {
        parent::__construct($pNom);
    }

    function iniciarSalas() {
        
    }

    function iniciarSala() {
        $this->Abrir("w+");
        for ($i = 0; $i < 200; $i++) {
            $this->Escribir("0");
        }
        $this->Cerrar();
    }
    
    function compra(){
        $this->Abrir("w+");
        for ($i=0;$i<count($this->butacas);$i++){
            $this->Escribir($this->butacas[$i]);
        }
        $this->Cerrar();
    }

    function mostrarSala() {
        $cont=0;
        echo("<table>
                <tr style='color:blue'>
                    <th></th>
                    <th>b1</th>
                    <th>b2</th>
                    <th>b3</th>
                    <th>b4</th>
                    <th>b5</th>
                    <th>b6</th>
                    <th>b7</th>
                    <th>b8</th>
                    <th>b9</th>
                    <th>b10</th>
                    <th>b11</th>
                    <th>b12</th>
                    <th>b13</th>
                    <th>b14</th>
                    <th>b15</th>
                    <th>b16</th>
                    <th>b17</th>
                    <th>b18</th>
                    <th>b19</th>
                    <th>b20</th>
                </tr>");
        for ($f = 0; $f < 10; $f++) {
            echo("<tr>");
            echo("<td style='color:blue'>f".($f+1)."</td>");
            for ($col = 0; $col < 20; $col++) {
                if ($this->butacas[$cont]==0){// si la butaca esta vacia.....
                echo("<td style='color:green'>");
                echo("<form method='POST' name='but' action='' onmouseover='mostrarButaca(this)' onmouseout='ocultar()'>");
                echo(" <input type='hidden' name='datosb' value='f".($f+1)." - b".($col+1)."'/>");
                echo(" <input type='hidden' name='buta' value='".$cont."'/>");
               echo( "<input type='submit' value='' style='background-image: url(\"./libre.png\"); width: 30px; height: 31px;'/>");
               echo("</form>");
                }
                 if ($this->butacas[$cont]==1){// si la butaca esta ocupada....
                echo("<td style='color:red'>");
                echo("<form method='POST' name='but' action='' onmouseover='mostrarButaca(this)' onmouseout='ocultar()'>");
                 echo(" <input type='hidden' name='datosb' value='f".($f+1)." - b".($col+1)."'/>");
               echo( "<input type='button' name='".$cont."' style='background-image: url(\"./ocupado.png\"); width: 30px; height: 31px;'/>");
               echo("</form>");
                }
                $cont++;
                echo("</td>");
            }
            echo("</tr>");
        }
        
        echo("</table>");
    }

}

//****************  clase principal conexion a base de datos  ***********//


abstract class dbConexion {

    protected $dbbase; // = "mysql";
    protected $servidor; // = "localhost";
    protected $usuario; // = "manuel";
    protected $pass; // = "12345";
    protected $db_name; // = "prueba";
    protected $cnx;

    public function __construct($dbase, $servidor, $usuario, $pass, $dbname) {
        $this->dbbase = $dbase;
        $this->servidor = $servidor;
        $this->usuario = $usuario;
        $this->pass = $pass;
        $this->db_name = $dbname;
    }

    protected function getcnx() {
        try {
            $this->cnx = new PDO($this->dbbase . ":host=" . $this->servidor . ";dbname=" . $this->db_name, $this->usuario, $this->pass, array(PDO::ATTR_PERSISTENT => true));
            return $this->cnx;
        } catch (PDOException $ex) {
            echo ("Conexion Error" . $ex->getMessage());
        }
    }

}

//************* clase que gestiona los datos de usuario ************//
class cine extends dbConexion {

    private $resultado;

    public function __construct($dbase, $servidor, $usuario, $pass, $dbname) {
        parent::__construct($dbase, $servidor, $usuario, $pass, $dbname);
    }

    public function todosLosDatos() {
        try {
            $con = $this->getcnx(); // peticion de la conexion
            $sql = "select * from usuarios;"; //consulta
            $this->resultado = $con->query($sql) or die($sql); //el resultado de la consulta se lo metemos al atributo
            $this->resultado->setFetchMode(PDO::FETCH_ASSOC); // no meter en $row
            foreach ($this->resultado as $fila) {// recorremos el array resultante
                foreach ($fila as $key => $value) {
                    if ($key == "usuario") {
                        echo($key . "  = " . $value . "<br>"); // imprimimos
                    }
                }
            }
        } catch (PDOException $ex) {
            echo ("Conexion Error" . $ex->getMessage());
        }
    }

    public function Validar($nombre, $pass) {
        try {
            $con = $this->getcnx(); // peticion de la conexion
            $sql = "SELECT * FROM `usuarios` WHERE `usuario` ='" . $nombre . "' and pass='" . $pass . "'";
            $this->resultado = $con->query($sql) or die($sql); //el resultado de la consulta se lo metemos al atributo
            $row = $this->resultado->fetch(PDO::FETCH_ASSOC); // no meter en $row
            if (!empty($row)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo ("Conexion Error" . $ex->getMessage());
        }
    }

    public function NoDuplicado($nombre) {
        /*
         * // En dos líneas
$result = $db->prepare("SELECT * FROM $dbTabla");
$result->execute();
         */
        
        try {
            $con = $this->getcnx(); // peticion de la conexion
            $sql = "SELECT * FROM `usuarios` WHERE `usuario` ='" . $nombre . "'";
            $this->resultado = $con->prepare($sql) or die($sql); //el resultado de la consulta se lo metemos al atributo
            $this->resultado->execute();
            $row = $this->resultado->fetch(PDO::FETCH_ASSOC); // no meter en $row
            if (!empty($row)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo ("Conexion Error" . $ex->getMessage());
        }
    }

    function verDatosUsuario($nombre) {
        try {
            $con = $this->getcnx(); // peticion de la conexion
            $sql = "SELECT * FROM `usuarios` WHERE `usuario` ='" . $nombre . "'";
            $this->resultado = $con->query($sql) or die($sql); // ejecutamos la consulta
            $row = $this->resultado->fetch(PDO::FETCH_ASSOC); // metemos en row solo los resultados asociativos (nombre= manuel)
            foreach ($row as $key => $value) {// recorremos el array resultante
                echo($key . "  = " . $value . "<br>"); // imprimimos
            }
            //print_r($row);
        } catch (PDOException $ex) {
            echo ("Conexion Error" . $ex->getMessage());
        }
    }

    function getpuntos($nombre) {
        try {
            $con = $this->getcnx(); // peticion de la conexion
            $sql = "SELECT puntos FROM `usuarios` WHERE `usuario` ='" . $nombre . "'";
            $this->resultado = $con->query($sql) or die($sql); // ejecutamos la consulta
            $row = $this->resultado->fetch(PDO::FETCH_ASSOC); // metemos en row solo los resultados asociativos (nombre= manuel)
            foreach ($row as $key => $value) {// recorremos el array resultante
                return $value; // imprimimos
            }
        } catch (PDOException $ex) {
            echo ("Conexion Error" . $ex->getMessage());
        }
    }

    function verConsulta($sql) {
        try {
            $con = $this->getcnx(); // peticion de la conexion
            //$sql = "select * from usuarios;";// consulta
            $this->resultado = $con->query($sql) or die($sql); // ejecutamos la consulta
            $row = $this->resultado->fetch(PDO::FETCH_ASSOC); // metemos en row solo los resultados asociativos (nombre= manuel)
            foreach ($row as $key => $value) {// recorremos el array resultante
                echo($key . "  = " . $value . "<br>"); // imprimimos o hacemos lo que queramos...
            }
            //print_r($row);
        } catch (PDOException $ex) {
            echo ("Conexion Error" . $ex->getMessage());
        }
    }

    function hacerconsulta($sql) {
        try {
            $con = $this->getcnx(); // peticion de la conexion
            //$sql = "select * from usuarios;";// consulta
            $this->resultado = $con->query($sql) or die($sql); // ejecutamos la consulta
        } catch (PDOException $ex) {
            echo ("Conexion Error" . $ex->getMessage());
        }
    }

    function Desconexion() {
        $this->cnx = null;
    }

    function Login($nombre, $usuario) {
        try {
            $con = $this->getcnx(); // peticion de la conexion
            //$sql = "select * from usuarios;";// consulta
            $this->resultado = $con->query($sql) or die($sql); // ejecutamos la consulta
            $row = $this->resultado->fetch(PDO::FETCH_ASSOC); // metemos en row solo los resultados asociativos (nombre= manuel)
            foreach ($row as $key => $value) {// recorremos el array resultante
                echo($key . "  = " . $value . "<br>"); // imprimimos o hacemos lo que queramos...
            }
            //print_r($row);
        } catch (PDOException $ex) {
            echo ("Conexion Error" . $ex->getMessage());
        }
    }

}

?>
