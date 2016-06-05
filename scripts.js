
var inicio=function () {
    //cuando el cliente deje de oprimir una tecla are esto
    //esta function recibira un parametro que sera el evento del teclado
	$(".cantidad").keyup(function(e){
            //valido si el canto donde escribo esta vacio o no
            //utilizo this al que esta interactuando al usuario
		if($(this).val()!=''){
                        //canpturo la tecla enter
			if(e.keyCode==13){
                            //creacion de unas variables donde capturare los atributos de html5
				var id=$(this).attr('data-id');
				var precio=$(this).attr('data-precio');
                                //navegados por el DOM
                                //obtenemos el vamos de cantidad
				var cantidad=$(this).val();
                                //con this me refiero a cantidad
                                //navego hasta producto div
                                //del producto me busque el obtejo subtotal y que cambie su contenido por el nuevo subtotal
				$(this).parentsUntil('.producto').find('.subtotal').text('Subtotal: '+(precio*cantidad));
                                //por medio de ajax creamos el metodo post
                                //le mandos unos parametros
				$.post('./js/modificarDatos.php',{
                                    //le pasamos el id, precio y cantidad
					Id:id,
					Precio:precio,
					Cantidad:cantidad
                                        //capturamos la variable total
				},function(e){
						$("#total").text('Total: '+e);
				});
			}
		}
	});
        
        //cuando le de a la clase eliminar
        $(".eliminar").click(function(e){
            //e.preventDeafult();
            //evita recargar la pagina
            //capturamos el atributo id
            //this al que se le dio click
            var id =$(this).attr('data-id');
            //recorrera el dom para eliminar
            $(this).parentsUntil('.producto').remove();
            //por medio de ajax lo enviare por el post
            $.post('./js/eliminar.php',{
                 Id:id
            },function (a){
                location.href="./carritodecompras.php";
               //if(a=='0'){
                 //  location.href="./carritodecompras.php";
               //}
            });        
        });
        
        //que el elemento formulario cuado le de el submit recibo un evento
        $("#formulario").submit(function(evento){
		//alert("se omitio el evento");
		$.get('./ventas.php',function(e){
			alert("");
		}).fail(function (){
                    //prevenir el elemento por default
			evento.preventDefault();	
		});
	});

}
$(document).on('ready',inicio);


