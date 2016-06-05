<?php

//indicarle a php que vamos a usar las variables de ssesion
session_start();
include '../modelo/conexion.php';

//verifico que existe la varible de session
if (isset($_SESSION['carrito'])) {  
    //verificamos si exite 
    if (isset($_GET['id'])) {
        //guardamos la varieble de session en el arreglo
        $arreglo = $_SESSION['carrito'];
        $encontro = false;
        $numero = 0;
        //creacion de un ciclo for
        for ($i = 0; $i < count($arreglo); $i++) {
            //si el arreglo en su posion i es igual a lo que trae la URL
            if ($arreglo[$i]['Id'] == $_GET['id']) {
                //lo encontro
                $encontro = true;
                //capturo i para saber la posicion del arreglo
                $numero = $i;
            }
        }
        //si es igual a tru le incremeneto 1 a la cantidad
        if ($encontro == true) {
            $arreglo[$numero]['Cantidad'] = $arreglo[$numero]['Cantidad'] + 1;
            $_SESSION['carrito'] = $arreglo;
            //si no esta el arreglo creo uno nuevo
        } else {
            $nombre = "";
            $precio = 0;
            $imagen = "";
            //creamos una consulta seleccionamos todos los productos y concatenamos lo que traiga por la URL
            $re = mysql_query("select * from t_producto where idProducto=" . $_GET['id']);
            //guardo todo lo de la base de datos y lo guardo en la variable f
            while ($f = mysql_fetch_array($re)) {
                //capturo el nombre, precio , imagen
                $nombre = $f['nomProducto'];
                $precio = $f['precioProducto'];
                $imagen = $f['imagenProducto'];
            }
            //creamos un arreglo de un solo registro
            $datosNuevos = array('Id' => $_GET['id'],
                'Nombre' => $nombre,
                'Precio' => $precio,
                'Imagen' => $imagen,
                'Cantidad' => 1);
            
            //
            array_push($arreglo, $datosNuevos);
            //una ves creado el arreglo lo guardamos en la varible de session
            $_SESSION['carrito'] = $arreglo;
        }
    }
} else {
    if (isset($_GET['id'])) {
        $nombre = "";
        $precio = 0;
        $imagen = "";
        //creamos una consulta seleccionamos todos los productos y concatenamos lo que traiga por la URL
        $re = mysql_query("select * from t_producto where idProducto=" . $_GET['id']);
        //guardo todo lo de la base de datos y lo guardo en la variable f
        while ($f = mysql_fetch_array($re)) {
            $nombre = $f['nomProducto'];
            $precio = $f['precioProducto'];
            $imagen = $f['imagenProducto'];
        }
        //creamos un arreglo para guardarlo en la variable de session
        $arreglo[] = array('Id' => $_GET['id'],
            'Nombre' => $nombre,
            'Precio' => $precio,
            'Imagen' => $imagen,
            //como es la primera vez por defecto le coloco 1
            'Cantidad' => 1);
        //una ves creado el arreglo lo guardamos en la varible de session
        $_SESSION['carrito'] = $arreglo;
    }
}


?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Carrito de compras</title>
        <link rel="stylesheet" href="css/foundation.min.css">
        <link rel="stylesheet" href="css/foundation-icons/foundation-icons.css"/>
        <link rel="stylesheet" href="css/css.css">
        <link rel="stylesheet" href="css/cssIconosSociales.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="icon" type="image/png" href="imagenes/favicon.ico" />
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
    </head>
    <body>
        <header>
            <h1>Mi Bolsa</h1>
        </header>
        <section>
<?php
$total = 0;
if (isset($_SESSION['carrito'])) {
    $datos = $_SESSION['carrito'];

    $total = 0;
    for ($i = 0; $i < count($datos); $i++) {
    ?>
        <div class="producto">
            <center>
                <img src="<?php echo $datos[$i]['Imagen']; ?>"><br>
                <span><?php echo $datos[$i]['Nombre']; ?></span><br>
                <span>Precio: <?php echo $datos[$i]['Precio']; ?></span><br>
                <span>Cantidad: 
                    <input type="text" value="<?php echo $datos[$i]['Cantidad']; ?>"
                        data-precio="<?php echo $datos[$i]['Precio']; ?>"
                        data-id="<?php echo $datos[$i]['Id']; ?>"
                        class="cantidad">        
                </span><br>
                <span class="subtotal">Subtotal:<?php echo $datos[$i]['Cantidad'] * $datos[$i]['Precio']; ?></span><br>
                <a href="#" class="eliminar" data-id="<?php echo $datos[$i]['Id']?>">Eliminar</a>
            </center>
        </div>
            <?php
                    $total = ($datos[$i]['Cantidad'] * $datos[$i]['Precio']) + $total;
                }
            } else {
                echo '<center><h2>No has añadido ningun producto</h2></center>';
            }
            echo '<center><h2 id="total">Total: ' . $total . '</h2></center>';          
            if($total!=0){
                //echo '<center><a href="./ventas.php" class="aceptar">Comprar</a></center>;';
                
            ?>
            
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="formulario">
                <!--vamos a enviar los items manualmente o sueltos cambiar el _xclick por _cart-->
		<input type="hidden" name="cmd" value="_cart">
		<input type="hidden" name="upload" value="1">
		<input type="hidden" name="business" value="sheloues@hotmail.com">
                <!--la moneda que vamos a manejar nostros-->
		<input type="hidden" name="currency_code" value="EUR">
                
                <!--dinamico-->
            <?php 
                //
		for($i=0;$i<count($datos);$i++){
		?>
                    <!--Añadimos los item que vamos a comprar-->
                    <!--colocamos lo que traiga mi variable i  como $i comienza de 0 entonces le coloco 1-->
                    <input type="hidden" name="item_name_<?php echo $i+1;?>" value="<?php echo $datos[$i]['Nombre'];?>">
                    <input type="hidden" name="amount_<?php echo $i+1;?>" value="<?php echo $datos[$i]['Precio'];?>">
                    <input type="hidden" name="quantity_<?php echo $i+1;?>" value="<?php echo $datos[$i]['Cantidad'];?>">
                    
		<?php 
                }
		?>
                        <!--creacion del botom comprar-->
                        <center><input type="submit" value="comprar" class="aceptar" style="width:200px"></center>
            </form>
                <?php
		}
			
		?>
                                      
            <center><a href="inici.php">Ver catalogo</a></center>
        </section>
    </body>
</html>