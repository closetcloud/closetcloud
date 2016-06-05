<?php

session_start();

include '../modelo/conexion.php';
//guardo lo que tenga en mi varible de session arreglo
$arreglo = $_SESSION['carrito'];

    for ($i = 0; $i < count($arreglo); $i++) {
        //que si el arreglo en la posicion i es diferente que lo que le mande por el metodo POST
        //si es diferente lo incluye
        if($arreglo[$i]['Id']!=$_POST['Id']){
            //creo un arreglo
            $datosNuevos[] = array(
                'Id' =>$arreglo[$i]['Id'],
                'Nombre' =>$arreglo[$i]['Nombre'],
                'Precio' =>$arreglo[$i]['Precio'],
                'Imagen' =>$arreglo[$i]['Imagen'],
                'Cantidad' =>$arreglo[$i]['Cantidad'],                            
            );
        }
        
        //si existe mi varible datos nuevos
        if (isset($datosNuevos)){
            //guardar en la varible de session los datos nuevos
                $_SESSION['carrito']=$datosNuevos;                
        }else{
            //destruyo la variable de session de carrito.
            unset($_SESSION['carrito']);
            //para saber si el arreglo esta vacio
            echo '0';
        }
}
