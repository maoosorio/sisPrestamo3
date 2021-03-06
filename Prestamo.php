<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'Cliente.php';
require_once 'Cuota.php';
require_once 'Conexion.php';
require_once 'Parametro.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;

class Prestamo {
    var $id_prestamo;
    var $cliente;
    var $monto;
    var $valor_cuota;
    var $tasa_interes;
    var $tasa_mora;
    var $cantidad_cuotas;
    var $fecha_inicio;
    var $fecha_fin;
    var $fecha_ultimo_pago;
    var $saldo;
    var $estado;
    var $observaciones;
    var $capitalizacion;
    var $cuotas;


    function crearNuevaCuota(){
        try {
            $cuota = new Cuota();
            return $cuota;
        } catch (ErrorPrestamo $e) {
            echo $e->nuevo($titulo, $ubicacion, $mensaje);
        }
    }

    function agregarCuota(Cuota $c) {
        try {
            $id_prestamo = $c->getId_prestamo();
            $num_cuota = $c->getNum_cuota();
            $valor = $c->getValor();
            $interes = $c->getInteres();
            $fecha = $c->getFecha();
            $capital = $c->getCapital();
            $saldo_anterior = $c->getSaldo_anterior();
            $saldo_actualizado = $c->getSaldo_actualizado();
            $mora = $c->getMora();
            $cuotas = array();
            array_push($cuotas, $c);
            $conn = new Conexion();
            $stmn = "INSERT INTO cuota(ID_prestamo, num_cuota, valor, interes, fecha, capital, saldo_anterior, saldo_actualizado, mora) VALUES ('".$id_prestamo."','".$num_cuota."', '".$valor."','".$interes."','".$fecha."','".$capital."','".$saldo_anterior."','".$saldo_actualizado."','".$mora."')";
            $conn->execQuery($stmn);
            if ($saldo_actualizado != 0) {
                $stmn2 = "UPDATE prestamo SET fecha_ultimo_pago= '".$fecha."', saldo='".$saldo_actualizado."', fecha_fin = '" . $fecha . "' WHERE id_prestamo='".$id_prestamo."'";
                $conn->execQuery($stmn2);
            } else {
                $stmn2 = "UPDATE prestamo SET fecha_ultimo_pago= '".$fecha."', saldo='".$saldo_actualizado."',estado = 'I', fecha_fin = '" . $fecha . "' WHERE id_prestamo='".$id_prestamo."'";
                $conn->execQuery($stmn2);
            }

        } catch (ErrorPrestamo $e) {
            echo $e->nuevo($titulo, $ubicacion, $mensaje);
        }
    }

    function imprimir(Cuota $c, $usuario){
      //Variables
      $id_prestamo = $c->getId_prestamo();
      $num_cuota = $c->getNum_cuota();
      $valor = $c->getValor();
      $interes = $c->getInteres();
      $fecha = $c->getFecha();
      $capital = $c->getCapital();
      $saldo_anterior = $c->getSaldo_anterior();
      $saldo_actualizado = $c->getSaldo_actualizado();
      $mora = $c->getMora();
      //Nombre con el que configure la impreso en CUPS
      $connector = new CupsPrintConnector("impresora_DSI2");
      $printer = new Printer($connector);
      $fechaPago = date('d-m-Y');
      $horaPago = date('h:i:s');
      $par = new Parametro();
      $Parametro = $par->obtener();
        $nombre_empresa =  $Parametro[0]->valor;
        $direccion = $Parametro[6]->valor;
        $telefono = $Parametro[2]->valor;

      //Impresion
      $printer->setEmphasis(true);
      $printer->text($nombre_empresa . "\n");
      $printer->text($direccion . "\n");
      $printer->text("Telefono: " . $telefono . "\n");
      $printer->text("Cajero: " . $usuario . "\n");
      $printer->setEmphasis(false);
      $printer->feed();
      $printer->text("Pago efectuado el: ".$fechaPago . "\n");
      $printer->text("a las: " .$horaPago ."\n");
      $printer->text("----------------------------\n");
      $printer->setEmphasis(true);
      $printer->text("Pago:          $". $valor . "\n");
      $printer->text("Mora:          $" .$mora . "\n");
      $printer->text("----------------------------\n");
      $printer->text("Total a pagar: $" .$valor + $mora . "\n");
      $printer->text("----------------------------\n");
      $printer->text("Nuevo Saldo:   $". $saldo_actualizado . "\n");
      $printer->feed(4);
      $printer->cut();
      $printer->close();
    }

    //GET
    function getId_prestamo() {
        return $this->id_prestamo;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getMonto() {
        return $this->monto;
    }

    function getValor_cuota() {
        return $this->valor_cuota;
    }

    function getTasa_interes() {
        return $this->tasa_interes;
    }

    function getTasa_mora () {
        return $this->tasa_mora;
    }
    function getCantidad_cuotas() {
        return $this->cantidad_cuotas;
    }

    function getFecha_inicio() {
        return $this->fecha_inicio;
    }

    function getFecha_fin() {
        return $this->fecha_fin;
    }

    function getFecha_ultimo_pago() {
        return $this->fecha_ultimo_pago;
    }

    function getSaldo() {
        return $this->saldo;
    }

    function getEstado() {
        return $this->estado;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getCapitalizacion() {
        return $this->capitalizacion;
    }

    function getCuotas() {
        return $this->cuotas;
    }

    //SET
    function setId_prestamo($id_prestamo) {
        $this->id_prestamo = $id_prestamo;
    }

    function setCliente(Cliente $c) {
        $this->cliente = $c;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

    function setValor_cuota($valor_cuota) {
        $this->valor_cuota = $valor_cuota;
    }

    function setTasa_interes($tasa_interes) {
        $this->tasa_interes = $tasa_interes;
    }

    function setTasa_mora($tasa_mora) {
        $this->tasa_mora = $tasa_mora;
    }

    function setCantidad_cuotas($cantidad_cuotas) {
        $this->cantidad_cuotas = $cantidad_cuotas;
    }

    function setFecha_inicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    function setFecha_fin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }

    function setFecha_ultimo_pago($fecha_ultimo_pago) {
        $this->fecha_ultimo_pago = $fecha_ultimo_pago;
    }

    function setSaldo($saldo) {
        $this->saldo = $saldo;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setCapitalizacion($capitalizacion) {
        $this->capitalizacion = $capitalizacion;
    }

    function setCuotas($cuotas) {
        $this->cuotas = $cuotas;
    }
}
