<?php

session_start();

include '../modelo/conexion.php';
    
		$arreglo=$_SESSION['carrito'];
                
/*//colocamos una varible con el numero de ventas
		$numeroventa=0;
                //hacemos una consulta que me lo ordene desendente y que me seleccione 1
		$re=mysql_query("select * from t_venta order by numeroVenta DESC limit 1") or die(mysql_error());	
		while (	$f=mysql_fetch_array($re)) {
                    //guardo el numero de venta
					$numeroventa=$f['numeroVenta'];	
		}
		if($numeroventa==0){
			$numeroventa=1;
		}else{
                    //numero de venta le sumo 1
			$numeroventa=$numeroventa+1;
		}
		for($i=0; $i<count($arreglo);$i++){
                    //creamos una consulta donde insertamos todo
			mysql_query("insert into t_venta (numeroventa, imagen,nombre,precio,cantidad,subtotal) values(
				".$numeroventa.",
				'".$arreglo[$i]['Imagen']."',
				'".$arreglo[$i]['Nombre']."',	
				'".$arreglo[$i]['Precio']."',
				'".$arreglo[$i]['Cantidad']."',
				'".($arreglo[$i]['Precio']*$arreglo[$i]['Cantidad'])."'
				)")or die(mysql_error());
		}
                //destruimos la variable de session
		unset($_SESSION['carrito']);
		header("Location: ../admin.php");
*/
                
              $total=0;
		$tabla='<table border="1">
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>';
                //recorro mi arreglo
		for($i=0;$i<count($arreglo);$i++){
			$tabla=$tabla.'<tr>
				<td>'.$arreglo[$i]['Nombre'].'</td>
				<td>'.$arreglo[$i]['Cantidad'].'</td>
				<td>'.$arreglo[$i]['Precio'].'</td>
				<td>'.$arreglo[$i]['Cantidad']*$arreglo[$i]['Precio'].'</td>
				</tr>
			';
			$total=$total+($arreglo[$i]['Cantidad']*$arreglo[$i]['Precio']);
		}
                
                //configuracion de nuestros parametros de nuestro correo
		$tabla=$tabla.'</table>';
		//echo $tabla;
		$nombre="Fabiani Blanco Rodriguez";
		$fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$asunto="Compra en X dominio";
		$desde="www.tupagina.com";
		$correo="closetcloud.sa@gmail.com";
		$comentario='closetcloud
			<div style="
				border:1px solid #d6d2d2;
				border-radius:5px;
				padding:10px;
				width:800px;
				heigth:300px;
			">
			<center>
				<img src="https://scontent-mad1-1.xx.fbcdn.net/v/t1.0-9/13310388_135550470194672_3328376450022218841_n.jpg?oh=198bc1124a882148ba61a5ed8b8304b5&oe=57C4A0A7" width="300px" heigth="250px">
				<h1>Muchas gracias por comprar en mi carrito de compras</h1>
			</center>
			<p>Hola '.$nombre.' muchas gracias por comprar aquí te mando los detalles de tu compra</p>
			<p>Lista de Artículos<br>
				'.$tabla.'
				<br>
				Total del pago es: '.$total.'

			</p>
			</div>

		';

		//echo $comentario;
                //enviamos el email en formato html
		$headers="MIME-Version: 1.0\r\n";
		$headers.="Content-type: text/html; charset=utf8\r\n";
		$headers.="From: Remitente\r\n";
		mail($correo,$asunto,$comentario,$headers);
		//unset($_SESSION['carrito']);
		//header("Location: ../admin.php");  

?>
