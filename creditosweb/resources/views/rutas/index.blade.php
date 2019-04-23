@extends('layout.index')
@section('contenido')
<style type="text/css">
    @media (min-width: 768px) {
        #modal-content {
            -webkit-box-shadow: 0 2px 3px rgba(0, 0, 0, 0.125);
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.125);
            width: 111%;
            top: 5%;
            left: -6%;
        }
    }
</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Rutas&nbsp;&nbsp;<button type="button" class="btn btn-success" id="nuevo" name="nuevo" onclick="agregardevo()"><i class="fa fa-plus" aria-hidden="true"></i></button></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <table class="table table-striped table-bordered table-hover" id="tableusuario">
            <thead>
            <th>Nro de Ruta</th>
            <th>Empleado</th>
            <th>Asignado Por</th>
            <th>Estado</th>
            <th>Comentarios</th>
            <th>Fecha</th>
            <th>Opciones</th>
            </thead>
        </table>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Destinatario por Ruta</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <table class="table table-striped table-bordered table-hover" id="tableitems">
            <thead>
            <th>Cliente</th>
            <th>Dirección</th>
            <th>Nro Ruta</th>
            <th>Comentarios</th>
            <th>Estado</th>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="modal_agregar" aria-hidden="true">
        <form method="post" name="adduser" id="adduser">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Ruta
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </h5>
                </div>
                <div class="modal-body">
                    <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Empleado</label>
                                    <select class="form-control" id="empleado" name="empleado">
                                    	<option value="0">Seleccione una opción</option>
                                    	@foreach($users as $user)
                                    		<option value="{{$user->id}}">{{$user->name}}</option>
                                    	@endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Comentarios</label>
                                    <input type="text" class="form-control" id="comentarios" name="comentarios">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Día</label>
                                    <select class="form-control" id="dia" name="dia">
                                    	<option value="0">Seleccione una opción</option>
                                    	<option value="1">Lunes</option>
                                    	<option value="2">Martes</option>
                                    	<option value="3">Miercoles</option>
                                    	<option value="4">Jueves</option>
                                    	<option value="5">Viernes</option>
                                    	<option value="6">Sábado</option>
                                    	<option value="7">Domingo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Fecha</label>
                                    <input type="text" class="form-control fecha" id="fecha" name="fecha">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="tabbable col-lg-12 col-md-12 col-sm-10 col-xs-10">
                                    <ul class="nav nav-tabs">
                                        <li role="presentation" class="active"><a href="#tab1" data-toggle="tab">Destinos por Ruta</a></li>
                                    </ul>
                                </div>
                                <div  class="tab-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="tab-pane active" id="tab1">
                                        <br>
                                        <center><button type="button" class="btn btn-success" title="añadir" id="agregar4"><i class="fa fa-plus" aria-hidden="true"></i></button></center>
                                        <div id="tblmovimientodiv">
                                            <table class="table" id="tabla4">
                                                <thead>
                                                <tr class="fila-base4">
                                                    <th>Cliente</th>
                                                    <th>Dirección</th>
                                                    <th>Comentarios</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="fila-base4">
                                                    <td scope="row">
                                                        <select class="form-control" id="cliente_1_" name="cliente_[]" onchange="busqueda(1)">
                                                            <option value="0">Seleccione una opción</option>
						                                    	@foreach($clients as $client)
						                                    		<option value="{{$client->id}}">{{$client->name}}</option>
						                                    	@endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="direccion_[]" id="direccion_1_" class="form-control" placeholder="Dirección"  readonly="readonly">
                                                        <input type="hidden" name="latitud_[]" id="latitud_1_" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="comentario_[]" id="comentario_1_" class="form-control" placeholder="Comentarios">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <input type="hidden" name="numLaboral" id="laboral" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="agregarrutas()">Agregar</button>
                </div>
            </div>
        </div>
        </form>
    </div>
<script type="text/javascript">

     $("#agregar4").on('click', function(){
             var numfilas = $("#tabla4 tbody tr").length;
             var contador_laboral = $('#laboral').val();
             $("#tabla4 tbody tr:last").after("<tr class=''>"
             	+"<td scope='row'><select class='form-control' id='cliente_"+(parseFloat(contador_laboral)+1)+"_' name='cliente_[]' onchange='busqueda("+(parseFloat(contador_laboral)+1)+")'><option value='0'>Seleccione una opción</option>@foreach($clients as $client)<option value='{{$client->id}}'>{{$client->name}}</option>@endforeach</select></td>"
             	+"<td><input type='text' name='direccion_[]' id='direccion_"+(parseFloat(contador_laboral)+1)+"_' class='form-control' placeholder='Dirección'  readonly='readonly'><input type='hidden' name='latitud_[]' id='latitud_"+(parseFloat(contador_laboral)+1)+"_' value=''></td>"
             	+"<td><input type='text' name='comentario_[]' id='comentario_"+(parseFloat(contador_laboral)+1)+"_' class='form-control' placeholder='Comentarios'></td>"
                 +"<td class='eliminar4'><button class='btn btn-danger' title='Eliminar'><i class='fa fa-times' aria-hidden='true'></i></button></td>"
                 +"</tr>");
             $("input[name=numLaboral]").val(parseFloat(contador_laboral)+1);
         });
     $(document).on("click",".eliminar4",function(){
         var contador_restante3 = $('#laboral').val();
         var parent = $(this).parents().get(0);
         $(parent).remove();
         $('#laboral').val(contador_restante3-1);
     });

     function busquedadireccion(num)
     {
        var token =  "<?= csrf_token(); ?>";
        var cliente = $('#cliente_'+num+'_').val();
        var form = $('#adduser');
        form.attr('action',"{{url('/rutas/busquedadireccion')}}");
        var url = form.attr('action');
        var resultado = "";
        $.ajax({
            async: false,
            type: "POST",
            url : url,
            data: {cliente:cliente,_token:token},
            success: function(result)
            {
                resultado = result;
            }
        });
        return resultado;
     }


     function busqueda(num)
     {

        var direccion = busquedadireccion(num);
        $('#direccion_'+num+'_').val(direccion);
    	var direccion_v = direccion.split(" ").join("+");
    	var key = 'AIzaSyBsJoRcPmT3miNiUavioKb44EYC56aZJjc';
    	var token =  "<?= csrf_token(); ?>";
		var url = "https://maps.googleapis.com/maps/api/geocode/json?address="+direccion_v+"&key="+key+"";
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
		    if (this.readyState == 4 && this.status == 200) {
		        var myArr = JSON.parse(this.responseText);

                $('#latitud_'+num+'_').val(myArr.results[0].geometry.location.lat+' '+myArr.results[0].geometry.location.lng);
                console.log(myArr.results[0].formatted_address);

		       	/*swal({
					  title: 'Confirmar Dirección',
					  text: "La dirección "+myArr.results[0].formatted_address+" es correcta?",
					  type: 'info',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Si, si es',
					  cancelButtonText: 'No, no es!',
					  confirmButtonClass: 'btn btn-primary',
					  cancelButtonClass: 'btn btn-default',
					  buttonsStyling: false,
					  reverseButtons: true
					}).then((result) => {
						if(result == true){
							$('#latitud_'+num+'_').val(myArr.results[0].geometry.location.lat+' '+myArr.results[0].geometry.location.lng);
						}
					}).catch(() =>{
						mensajes('Ingresar nuevamente la dirección','','info');
						$('#latitud_'+num+'_').val('');
						$('#direccion_'+num+'_').val('');
					});*/
		    }
		};
		xhttp.open("GET", url, true);
		xhttp.send();
     }

     function agregardevo()
     {
         $('#modal_agregar').modal('show');
         $('#adduser')[0].reset();
         eliminaFilas();
     }

     function eliminaFilas()
     {
         //OBTIENE EL NÚMERO DE FILAS DE LA TABLA
         var n=0;
         $("#tabla4 tbody tr").each(function ()
         {
             n++;
         });
         //BORRA LAS n-1 FILAS VISIBLES DE LA TABLA
         //LAS BORRA DE LA ULTIMA FILA HASTA LA SEGUNDA
         //DEJANDO LA PRIMERA FILA VISIBLE, MÁS LA FILA PLANTILLA OCULTA
         for(i=n-1;i>0;i--)
         {
             $("#tabla4 tbody tr:eq('"+i+"')").remove();
         }
         $('#laboral').val(1);
     }

     function agregarrutas()
     {
	     	if($('#empleado').val() == '0' || $('#comentarios').val() == '' || $('#dia').val() == '0' || $('#fecha').val() == '')
	     	{
	     		mensajes('Se ha presentado un error','Los campos Empleado, Comentarios, Día y Fecha deben ser diligencias','error');
	     	}else
	     	{
	     		var clientes = [];
	            for(var i = 1; i<= $('#laboral').val(); i++)
	            {
	                clientes.push($('#cliente_'+i+'_').val());
	            }
	            var direccion = $("input[name='direccion_[]'");
	            var address = [];
	            $.each(direccion,function(indice,elemento){
	                address.push($(elemento).val());
	            });
	            var latitud = $("input[name='latitud_[]'");
	            var coordinates = [];
	            $.each(latitud,function(indice,elemento){
	                coordinates.push($(elemento).val());
	            });
	            var comentario = $("input[name='comentario_[]'");
	            var comments = [];
	            $.each(comentario,function(indice,elemento){
	                comments.push($(elemento).val());
	            });
	            var form = $('#adduser');
	            form.attr('action',"{{url('/rutas/addruta')}}");
	            var url = form.attr('action');
	            var token =  "<?= csrf_token(); ?>";
	            var data = getFormData(form);
	            $.ajax({
	                type: "POST",
	                url : url,
	                data: {data:data,clientes:clientes,address:address,coordinates:coordinates,comments:comments,_token:token},
	                success: function(result)
	                {
	                    $('#modal_agregar').modal('hide');
	                    mensajes('Se ha agregado satisfactoriamente la ruta','','success');
	                    actualizartables();
	                }
	            });
	     	}
     }

     function actualizartables()
     {
	        $('#tableitems').DataTable(
		            {
	                    destroy: true,
		                "language": {
		                    "sProcessing":     "Procesando..",
		                    "sLengthMenu":     "Mostrar _MENU_ registros",
		                    "sZeroRecords":    "No se encontraron resultados",
		                    "sEmptyTable":     "Ningun dato disponible en la tabla",
		                    "sInfo":           "Mostrando registros del  _START_ al _END_ de un total de _TOTAL_ registros",
		                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
		                    "sInfoFiltered":   "(Filtrando de un total de _MAX_ registros)",
		                    "sInfoPostFix":    "",
		                    "sSearch":         "Buscar:",
		                    "sUrl":            "",
		                    "sInfoThousands":  ",",
		                    "sLoadingRecords": "Cargando..",
		                    "oPaginate": {
		                        "sFirst":    "Primero",
		                        "sLast":     "Ultimo",
		                        "sNext":     "Siguiente",
		                        "sPrevious": "Anterior"
		                    },
		                    "oAria": {
		                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		                    }
		                }
		            });
	        $.ajaxSetup({
	            headers: {
	                'X-CSRF-TOKEN': "<?= csrf_token(); ?>"
	            }
	        });
	        $('#tableusuario').DataTable(
	         {
	                destroy: true,
	                processing: true,
	                serverSide: true,
	                ajax:
	                    {
	                        url: "{{url('/rutas/busqueda')}}",
	                        method: 'POST'
	                    },
	                columns: [
	                    {data: 'id', name: 'routes.id'},
	                    {data: 'nombreempleado', name: 'a.name'},
	                    {data: 'nombreasignado', name: 'b.name'},
	                    {data: 'state', name: 'routes.state'},
	                    {data: 'comments', name: 'routes.comments'},
	                    {data: 'created_at', name: 'routes.created_at'},
	                    {
	                            sortable: false,
	                            "render": function ( data, type, full, meta ) {
	                                var buttonID = full.id;
	                                return '<button class="btn btn-danger" onclick=\'eliminar("'+buttonID+'");\' type="button" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>';
	                            }
	                        }
	                ],
	                "columnDefs": [
	                    { "searchable": false, "targets": 6 }
	                ],
	                "language": {
	                    "sProcessing":     "Procesando..",
	                    "sLengthMenu":     "Mostrar _MENU_ registros",
	                    "sZeroRecords":    "No se encontraron resultados",
	                    "sEmptyTable":     "Ningun dato disponible en la tabla",
	                    "sInfo":           "Mostrando registros del  _START_ al _END_ de un total de _TOTAL_ registros",
	                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	                    "sInfoFiltered":   "(Filtrando de un total de _MAX_ registros)",
	                    "sInfoPostFix":    "",
	                    "sSearch":         "Buscar:",
	                    "sUrl":            "",
	                    "sInfoThousands":  ",",
	                    "sLoadingRecords": "Cargando..",
	                    "oPaginate": {
	                        "sFirst":    "Primero",
	                        "sLast":     "Ultimo",
	                        "sNext":     "Siguiente",
	                        "sPrevious": "Anterior"
	                    },
	                    "oAria": {
	                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	                    }
	                }
	         });
     }

     function eliminar(id)
     {
            swal({
                    title: 'Desea eliminar esta ruta',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then(function () {
                    var form = $('#adduser');
                    form.attr('action',"{{url('/rutas/delruta')}}");
                    var url = form.attr('action');
                    var token =  "<?= csrf_token(); ?>";
                    $.ajax({
                        type: "POST",
                        url : url,
                        data: {id:id,_token:token},
                        success: function(result)
                        {
                            swal(
                                'Eliminado!',
                                'La ruta ha sido eliminada con exito',
                                'success'
                            );
                            actualizartables();
                        }
                    });

                })
     }

	 $(document).ready(function(){
		$('#tableitems').DataTable(
	            {
                    destroy: true,
	                "language": {
	                    "sProcessing":     "Procesando..",
	                    "sLengthMenu":     "Mostrar _MENU_ registros",
	                    "sZeroRecords":    "No se encontraron resultados",
	                    "sEmptyTable":     "Ningun dato disponible en la tabla",
	                    "sInfo":           "Mostrando registros del  _START_ al _END_ de un total de _TOTAL_ registros",
	                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	                    "sInfoFiltered":   "(Filtrando de un total de _MAX_ registros)",
	                    "sInfoPostFix":    "",
	                    "sSearch":         "Buscar:",
	                    "sUrl":            "",
	                    "sInfoThousands":  ",",
	                    "sLoadingRecords": "Cargando..",
	                    "oPaginate": {
	                        "sFirst":    "Primero",
	                        "sLast":     "Ultimo",
	                        "sNext":     "Siguiente",
	                        "sPrevious": "Anterior"
	                    },
	                    "oAria": {
	                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	                    }
	                }
	            });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "<?= csrf_token(); ?>"
            }
        });
        $('#tableusuario').DataTable(
            {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:
                    {
                        url: "{{url('/rutas/busqueda')}}",
                        method: 'POST'
                    },
                columns: [
                    {data: 'id', name: 'routes.id'},
                    {data: 'nombreempleado', name: 'a.name'},
                    {data: 'nombreasignado', name: 'b.name'},
                    {data: 'state', name: 'routes.state'},
                    {data: 'comments', name: 'routes.comments'},
                    {data: 'created_at', name: 'routes.created_at'},
                    {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var buttonID = full.id;
                                return '<button class="btn btn-danger" onclick=\'eliminar("'+buttonID+'");\' type="button" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>';
                            }
                        }
                ],
                "columnDefs": [
                    { "searchable": false, "targets": 6 }
                ],
                "language": {
                    "sProcessing":     "Procesando..",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningun dato disponible en la tabla",
                    "sInfo":           "Mostrando registros del  _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(Filtrando de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando..",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Ultimo",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        var Anterior = 0;
        $('#tableusuario tbody').on('click', 'tr', function ()
    	{
	        var id = $('td', this).eq(0).text();
			if(Anterior!==0){$(Anterior).css("color","#000000");}
			$('td', this).css("color", "#58ACFA");
			Anterior = $('td', this);
			$.ajaxSetup({
	            headers: {
	                'X-CSRF-TOKEN': "<?= csrf_token(); ?>"
	            }
	        });
	        $('#tableitems').DataTable(
	            {
	                destroy: true,
	                processing: true,
	                serverSide: true,
	                ajax:
	                    {
	                        url: "{{url('/rutas/busquedadestina')}}/"+id,
	                        method: 'POST'
	                    },
	                columns: [
	                    {data: 'nombrecliente', name: 'clients.name'},
	                    {data: 'address', name: 'routes_destination.address'},
	                    {data: 'route', name: 'routes_destination.route'},
	                    {data: 'comments', name: 'routes_destination.comments'},
	                    {data: 'state', name: 'routes_destination.state'}
	                ],
	                "language": {
	                    "sProcessing":     "Procesando..",
	                    "sLengthMenu":     "Mostrar _MENU_ registros",
	                    "sZeroRecords":    "No se encontraron resultados",
	                    "sEmptyTable":     "Ningun dato disponible en la tabla",
	                    "sInfo":           "Mostrando registros del  _START_ al _END_ de un total de _TOTAL_ registros",
	                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	                    "sInfoFiltered":   "(Filtrando de un total de _MAX_ registros)",
	                    "sInfoPostFix":    "",
	                    "sSearch":         "Buscar:",
	                    "sUrl":            "",
	                    "sInfoThousands":  ",",
	                    "sLoadingRecords": "Cargando..",
	                    "oPaginate": {
	                        "sFirst":    "Primero",
	                        "sLast":     "Ultimo",
	                        "sNext":     "Siguiente",
	                        "sPrevious": "Anterior"
	                    },
	                    "oAria": {
	                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	                    }
	                }
	            });
	    });
     });
</script>
@endsection
