<?php

function obtenerProductos(){

    include 'bd_conexion.php'; //abrir la conexion

    try{
        return $conn->query("SELECT Id_Producto, Nombre_Producto, Id_Tipo_Producto, Precio_Venta, Nombre_Usuario FROM producto");
        
    }catch(Exception $e){
        echo "error!!". $e->getMessage() ."<br>";
        return false;
    }
}

function obtenerInventario(){

    include 'bd_conexion.php'; //abrir la conexion

    try {
               $sql = "SELECT Id_Producto, Id_Tipo_Producto, Nombre_Producto, Precio_Venta,Nombre_Usuarioo, SUM(Cantidad_Producto) as existencia ";
               $sql .= "FROM producto, entradas_de_producto ";
               $sql .=  "WHERE producto.Id_Producto=entradas_de_producto.Id_Productoo ";
               $sql .=  "GROUP BY Id_Producto,Nombre_Usuarioo ";
              //var_dump($sql);               
             //  die($sql);
               return $conn->query($sql);
    }catch (Exception $e){
        echo "error!!". $e->getMessage() ."<br>";
        return false;
    }
   

}

//obtiene un producto toma el codigo

function obtenerProducto($id){

    include 'bd_conexion.php'; //abrir la conexion

    try{
        return $conn->query("SELECT Id_Producto, Nombre_Producto, Id_Tipo_Producto, Precio_Venta,Nombre_Usuario FROM producto WHERE Id_Producto = $id");
        
    }catch(Exception $e){
        echo "error!!". $e->getMessage() ."<br>";
        return false;
    }

}

function obtenerEmpleados(){
    include 'bd_conexion.php';

    try{
        return $conn->query("SELECT id_empleado, Cargo, Nombre, Cedula, Celular, Direccion FROM empleado");

    }catch (Exception $e){
        echo "Error!!". $e->getMessage() ."<br>";
        return false;
    }
}

function obtenerEmpleado($id){
    include 'bd_conexion.php';

    try{
        return $conn->query("SELECT id_empleado, Cargo, Nombre, Cedula, Celular, Direccion, passwd  FROM empleado WHERE id_empleado = $id");
        
    }catch (Exception $e){
        echo "Error!!". $e->getMessage() ."<br>";
        return false;
    }
}

function obtenerProveedores(){
    include 'bd_conexion.php';

    try{
        return $conn->query("SELECT Cedula_Proveedor, Nombre_proveedor, Telefono_proveedor, Ciudad_proveedor, creador FROM proveedor");
    }catch (Exception $e){
        echo "Error!!". $e->getMessage() ."<br>";
        return false;
    }

}

function obtenerProveedor($id){
    include 'bd_conexion.php';

    try{
        return $conn->query("SELECT Cedula_Proveedor, Nombre_proveedor, Telefono_proveedor, Ciudad_proveedor FROM proveedor WHERE cedula_Proveedor = $id");
    }catch(Exception $e){
        echo "error!!". $e->getMessage() ."<br>";
        return false;
    }
}

function obtenerAbonos(){
    include 'bd_conexion.php';
    try{
        return $conn->query("SELECT Id_Producto, Nombre_Producto, Id_Tipo_Producto, Precio_Venta, Nombre_Usuario FROM producto WHERE Id_Tipo_Producto = 'Abonos'");
    }catch (Exception $e){
        echo "Error!!". $e->getMessage() ."<br>";
        return false;
    }
}

function obtenerSemillas(){
    include 'bd_conexion.php';
    try{
        return $conn->query("SELECT Id_Producto, Nombre_Producto, Id_Tipo_Producto, Precio_Venta, Nombre_Usuario FROM producto WHERE Id_Tipo_Producto = 'Semillas'");
    }catch (Exception $e){
        echo "Error!!". $e->getMessage() ."<br>";
        return false;
    }
}

function obtenerCuidos(){
    include 'bd_conexion.php';
    try{
        return $conn->query("SELECT Id_Producto, Nombre_Producto, Id_Tipo_Producto, Precio_Venta, Nombre_Usuario FROM producto WHERE Id_Tipo_Producto = 'Cuidos'");
    }catch (Exception $e){
        echo "Error!!". $e->getMessage() ."<br>";
        return false;
    }
}

function obtenerInsecticida(){
    include 'bd_conexion.php';
    try{
        return $conn->query("SELECT Id_Producto, Nombre_Producto, Id_Tipo_Producto, Precio_Venta, Nombre_Usuario FROM producto WHERE Id_Tipo_Producto = 'Insecticida'");
    }catch (Exception $e){
        echo "Error!!". $e->getMessage() ."<br>";
        return false;
    }
}

?>