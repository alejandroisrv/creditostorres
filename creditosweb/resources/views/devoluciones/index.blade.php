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
            <h1 class="page-header">Devoluciones&nbsp;&nbsp;<button type="button" class="btn btn-success" id="nuevo" name="nuevo" onclick="agregardevo()"><i class="fa fa-plus" aria-hidden="true"></i></button></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <table class="table table-striped table-bordered table-hover" id="tableusuario">
            <thead>
            <th>Id Devolución</th>
            <th>Factura</th>
            <th>Vendedor</th>
            <th>Comentarios</th>
            <th>Fecha</th>
            <th>Autorizado Por</th>
            <th>Valor Comisión</th>
            <th>Opciones</th>
            </thead>
        </table>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Productos por Devolución</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <table class="table table-striped table-bordered table-hover" id="tableitems">
            <thead>
            <th>Número Devolución</th>
            <th>Producto</th>
            <th>Comentarios</th>
            <th>Fecha</th>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="modal_agregar" aria-hidden="true">
        <form method="post" name="adduser" id="adduser">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Devolución
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </h5>
                </div>
                <div class="modal-body">
                    <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Número de Factura</label>
                                    <input type="text" class="form-control" id="invoice" name="invoice" onchange="cambiodefactura()">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Vendedor</label>
                                    <input type="text" class="form-control" id="vendedor" name="vendedor" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Comentarios</label>
                                    <input type="text" class="form-control" id="comments" name="comments">
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="tabbable col-lg-12 col-md-12 col-sm-10 col-xs-10">
                                    <ul class="nav nav-tabs">
                                        <li role="presentation" class="active"><a href="#tab1" data-toggle="tab">Productos a Devolver</a></li>
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
                                                    <th>Producto</th>
                                                    <th>Comentario</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="fila-base4">
                                                    <td scope="row">
                                                        <select class="form-control" id="producto_1_" name="producto_[]" onchange="cambiodeproducto(1)">
                                                            <option value="0">Seleccione una opción</option>
                                                            @foreach($items as $item)
                                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
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
                    <button type="button" class="btn btn-primary" onclick="agregardevolucion()">Agregar</button>
                </div>
            </div>
        </div>
        </form>
    </div>
<script type="text/javascript">

    $("#agregar4").on('click', function(){
             var numfilas = $("#tabla4 tbody tr").length;
             var contador_laboral = $('#laboral').val();
             $("#tabla4 tbody tr:last").after("<tr class=''><td scope='row'><select class='form-control' id='producto_"+(parseFloat(contador_laboral)+1)+"_' name='producto_[]' onchange='cambiodeproducto("+(parseFloat(contador_laboral)+1)+")'><option value='0'>Seleccione una opción</option>@foreach($items as $item)<option value='{{$item->id}}'>{{$item->name}}</option>@endforeach"
                 +"</select></td>"
                 +"<td><input id='comentario_"+(parseFloat(contador_laboral)+1)+"_' type='text' class='form-control' placeholder='Comentarios' name='comentario_[]'></td>"
                 +"<td class='eliminar4'><button class='btn btn-danger' title='Eliminar'><i class='fa fa-times' aria-hidden='true'></i></button></td>"
                 +"   </tr>");
             $("input[name=numLaboral]").val(parseFloat(contador_laboral)+1);
         });
     $(document).on("click",".eliminar4",function(){
         var contador_restante3 = $('#laboral').val();
         var parent = $(this).parents().get(0);
         $(parent).remove();
         $('#laboral').val(contador_restante3-1);
     });

     function cambiodeproducto(num)
     {
            var form = $('#adduser');
            form.attr('action',"{{url('/devoluciones/consulta')}}");
            var producto = $('#producto_'+num+'_').val();
            var invoice = $('#invoice').val();
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            var data = getFormData(form);
            $.ajax({
                type: "POST",
                url : url,
                data: {producto:producto,invoice:invoice,_token:token},
                success: function(result)
                {
                    if(result == 'noesta')
                    {
                        mensajes('Se ha producido un error','El producto seleccionado no está en la factura','error');
                        $("#producto_"+num+"_ option[value='0']").attr("selected",true);
                    }else if(result == 'yaesta')
                    {
                        mensajes('Se ha producido un error','El producto seleccionado ya se ha realizado la devolución','error');
                        $("#producto_"+num+"_ option[value='0']").attr("selected",true);
                    }
                } 
            });
     }

     function cambiodefactura()
     {
            var form = $('#adduser');
            form.attr('action',"{{url('/devoluciones/consultafactura')}}");
            var invoice = $('#invoice').val();
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            var data = getFormData(form);
            $.ajax({
                type: "POST",
                url : url,
                data: {invoice:invoice,_token:token},
                success: function(result)
                {
                    if(result == 'noesta')
                    {
                        mensajes('Se ha producido un error','La Factura no se encuentra registrada','error');
                        $('#invoice').val('');
                    }else
                    {
                        $('#vendedor').val(result);
                    }
                } 
            }); 
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

     function agregardevolucion()
     {
            var comentario = $("input[name='comentario_[]'");
            var items = [];
            var commentsitem = [];
            for(var i = 1; i<= $('#laboral').val(); i++)
            {
                items.push($('#producto_'+i+'_').val());
            }
            $.each(comentario,function(indice,elemento){
                commentsitem.push($(elemento).val());
            });
            var invoice = $('#invoice').val();
            var comments = $('#comments').val();
            var form = $('#adduser');
            form.attr('action',"{{url('/devoluciones/add')}}");
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            var data = getFormData(form);
            $.ajax({
                type: "POST",
                url : url,
                data: {data:data,items:items,commentsitem:commentsitem,invoice:invoice,comments:comments,_token:token},
                success: function(result)
                {
                    $('#modal_agregar').modal('hide');
                    mensajes('Se ha realizado la devolucion satisfactoriamente','','success');
                    actualizartables();
                } 
            }); 
     }

     function actualizartables()
     {
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
                                        url: "{{url('/devoluciones/busqueda')}}",
                                        method: 'POST'
                                    },
                                columns: [
                                    {data: 'id', name: 'claims.id'},
                                    {data: 'invoice', name: 'claims.invoice'},
                                    {data: 'nombreusuario', name: 'a.name'},
                                    {data: 'comments', name: 'claims.comments'},
                                    {data: 'created_at', name: 'claims.created_at'},
                                    {data: 'nombreautorizador', name: 'b.name'},
                                    {data: 'commisionvalue', name: 'claims.commisionvalue'},
                                    {
                                            sortable: false,
                                            "render": function ( data, type, full, meta ) {
                                                var buttonID = full.id;
                                                return '<button class="btn btn-danger" onclick=\'eliminar("'+buttonID+'");\' type="button" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>';
                                            }
                                        }
                                ],
                                "columnDefs": [
                                    { "searchable": false, "targets": 7 }
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
     }

     function eliminar(id)
     {
            swal({
                    title: 'Desea eliminar esta devolucion',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then(function () {
                    var form = $('#adduser');
                    form.attr('action',"{{url('/devoluciones/delete')}}");
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
                                'La devolución ha sido eliminada con exito',
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
                        url: "{{url('/devoluciones/busqueda')}}",
                        method: 'POST'
                    },
                columns: [
                    {data: 'id', name: 'claims.id'},
                    {data: 'invoice', name: 'claims.invoice'},
                    {data: 'nombreusuario', name: 'a.name'},
                    {data: 'comments', name: 'claims.comments'},
                    {data: 'created_at', name: 'claims.created_at'},
                    {data: 'nombreautorizador', name: 'b.name'},
                    {data: 'commisionvalue', name: 'claims.commisionvalue'},
                    {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var buttonID = full.id;
                                return '<button class="btn btn-danger" onclick=\'eliminar("'+buttonID+'");\' type="button" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>';
                            }
                        }
                ],
                "columnDefs": [
                    { "searchable": false, "targets": 7 }
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
	                        url: "{{url('/devoluciones/items/')}}"+id,
	                        method: 'POST'
	                    },
	                columns: [
	                    {data: 'claims', name: 'items_claims.claims'},
	                    {data: 'nombreitem', name: 'items.name'},
	                    {data: 'comments', name: 'items_claims.comments'},
	                    {data: 'created_at', name: 'items_claims.created_at'}
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