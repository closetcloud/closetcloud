<?php

            session_start();
            
            //guardo en arreglo lo que tenia una variable de session
            $arreglo = $_SESSION['carrito'];
            $total = 0;
            $numero = 0;
            for ($i = 0; $i < count($arreglo); $i++) {
                //verificamos
                //capturo el numero
                if ($arreglo[$i]['Id'] == $_POST['Id']) {
                    $numero = $i;
                }
            }
            
            //cantidad va ser igual a lo que aya mandado por el metodo post cantidad
            $arreglo[$numero]['Cantidad'] = $_POST['Cantidad'];
            for ($i = 0; $i < count($arreglo); $i++) {
                //calculamos el total el precio por la cantidad y lo sumamos a la variable total
                $total = ($arreglo[$i]['Precio'] * $arreglo[$i]['Cantidad']) + $total;
            }
            
            //guardamos el arreglo ya modificado en la variable de session
            $_SESSION['carrito'] = $arreglo;
            echo $total;
?>