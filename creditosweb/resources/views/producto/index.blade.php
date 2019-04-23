@extends('layout.index')
@section('contenido')
<!--script src="{{asset('vvendor/jquery/jquery-2.2.3.min.js')}}"></script-->
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
            <h1 class="page-header">Productos de la @if($sucursal_o_bodega['tipo']=="sucursal") sucursal "{{ $sucursal_o_bodega['valor'] }}" @else bodega "{{ $sucursal_o_bodega['valor'] }}" @endif&nbsp;<button type="button" class="btn btn-success" id="nuevo" name="nuevo" onclick="mostrar_modal_agregar_producto()"><i class="fa fa-plus" aria-hidden="true"></i></button></h1>
        </div>
         @if($sucursal_o_bodega['tipo']=="sucursal")
            <div class="col-lg-8" style="margin:15px 0px;">
                <from>
                    @csrf
                 <select name="idbodega" id='idbodega' class="form-control" onchange="actualizar_tabla_productos($(this).val())">
                     <option value='0'>Todas las bodegas</option>
                     @isset($bodegas)
                         @foreach($bodegas as $bodega)
                         <option value="{{$bodega->id}}"> {{$bodega->name}} </option>
                         @endforeach
                     @endisset
                 </select>
                </from>
            </div>
        
        @endif
    </div>
 
    <div class="row">
        
           <div class="col-lg-12">
                <table class="table table-striped table-bordered table-hover" id="tableusuario">
            <thead>
                <th>Imagen</th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Descrip.</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Precio revendedor</th>
                <th>Opciones</th>
            </thead>
        </table>
         </div>

    </div>
</div>

<!-- Modal agregar -->
<div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="modal_agregar" aria-hidden="true">
    <form method="post" name="agregar_producto" id="agregar_producto" enctype="multipart/form-data">
    {{ csrf_field() }}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-content">
                <div class="modal-header" style="background-color: #7ace4c !important;">
                    <h2><i class="fa fa-plus"></i> Agregar Producto</h2>
                </div>
                <div class="modal-body">
                    <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Tipo</label>
                                    <select class="form-control" name="tipo" id="tipo">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($tipos as $tipo)
                                            <option value="{{$tipo->id}}">{{$tipo->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Descripción</label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Precio Revendedor</label>
                                    <input type="number" class="form-control" id="revendedor" name="revendedor">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Porcentaje de Comisión</label>
                                    <input type="text" class="form-control" id="commision" name="commision" placeholder="0">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Comentarios</label>
                                    <input type="text" class="form-control" id="comentarios" name="comentarios">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Imagen del Producto</label>
                                    <input type="file" class="form-control" id="adjuntar_foto" name="adjuntar_foto" accept="image/x-png,image/gif,image/jpeg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="guardar_agregar_producto()">Agregar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Fin modal agregar -->

<!-- Modal editar -->
<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="modal_editar" aria-hidden="true">
    <form method="post" name="editar_producto" id="editar_producto" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-content">
                <div class="modal-header bg-warning">
                    <h2><i class="fa fa-edit"></i> Editar Producto</h2>
                </div>
                <div class="modal-body">
                    <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_item_edit" id="id_item_edit">
                                    <label for="recipient-name" class="form-control-label">Tipo</label>
                                    <select class="form-control" name="tipo_edit" id="tipo_edit">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($tipos as $tipo)
                                            <option value="{{$tipo->id}}">{{$tipo->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_edit" name="nombre_edit">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Descripción</label>
                                    <input type="text" class="form-control" id="descripcion_edit" name="descripcion_edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad_edit" name="cantidad_edit">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Precio</label>
                                    <input type="number" class="form-control" id="precio_edit" name="precio_edit">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Precio Revendedor</label>
                                    <input type="number" class="form-control" id="revendedor_edit" name="revendedor_edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Porcentaje de Comisión</label>
                                    <input type="text" class="form-control" id="commision_edit" name="commision_edit" placeholder="0">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Comentarios</label>
                                    <input type="text" class="form-control" id="comentarios_edit" name="comentarios_edit">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Imagen del Producto</label>
                                    <input type="file" class="form-control" id="adjuntar_foto_editar" name="adjuntar_foto_editar" accept="image/x-png,image/gif,image/jpeg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-warning" onclick="guardar_editar_producto()">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Fin modal editar -->

<!-- Modal entregar productos -->
<div class="modal fade" role="dialog" id="entregar_producto" aria-hidden="true">
    <form method="post" id="form_entregar_producto" autocomplete="off">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h2 class="modal-title"><i class="fa fa-plus"></i> Entregar Productos</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="entregar_productos_vendedor">Vendedor</label>
                                <select class="form-control"
                                    id="entregar_productos_vendedor" 
                                    name="entregar_productos_vendedor[]" multiple="multiple">
                                    <option>No ha creado ningún vendedor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="entregar_productos_comentarios" class="form-control-label">Comentarios</label>
                                <input type="text" class="form-control" name="entregar_productos_comentario" id="entregar_productos_comentario">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="tabbable col-lg-12 col-md-12 col-sm-10 col-xs-10">
                                <ul class="nav nav-tabs">
                                    <li role="presentation" class="active"><a href="#tab1" data-toggle="tab">Seleccionar Productos</a></li>
                                    <button type="button" class="btn btn-success" title="añadir" id="entregar_productos_agregar"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </ul>
                            </div>
                            <div class="tab-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="tab-pane active" id="tab1">
                                    <div id="tblmovimientodiv">
                                        <table class="table" id="entregar_productos_tabla">
                                            <thead>
                                                <tr class="fila-base4">
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="entregar_producto_fila_base">
                                                    <td class="col-md-10">
                                                        <select class='form-control' id='producto_1_' name='producto_[]'>
                                                            <option value='0'>Seleccione una opción</option>
                                                            @foreach($productos as $producto)
                                                                @if($producto->quantity>0)
                                                                    <option value='{{$producto->id}}'>{{$producto->name}} - {{$producto->descripcion}} - {{$producto->quantity}} Disponibles</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="col-md-2">
                                                        <input type="text" name="cantidad_[]" id="cantidad_1_" class="form-control" placeholder="Cantidad">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="cuenta_productos" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" onclick="document.getElementById('form_entregar_producto').reset();$('#entregar_producto').modal('hide');">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="entregar_productos()">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Fin Modal Entregar Productos -->

<script>
        var idbodega;
        $(document).on("click",".entregar_productos_eliminar",function(){
            
            var contador_restante3 = $('#cuenta_productos').val();
            var parent = $(this).parents().get(0);
            $(parent).remove();
            $('#cuenta_productos').val(contador_restante3-1);
        });

        // Entregar Productos
        function entregar_productos()
        {
            var lista_productos = [], lista_cantidad = [];
            for(var i = 1; i <= eval($('#cuenta_productos').val()) ; i++){
                lista_productos.push(eval($('#producto_'+i+'_').val()));
                lista_cantidad.push(eval($('#cantidad_'+i+'_').val()));
            }

            var token =  "<?= csrf_token(); ?>";
            $.ajax({
                type: "post",
                url : "{{ route('productos_apartar') }}",
                data: {v_vendedor:$('#entregar_productos_vendedor').val(), v_comentario:$('#entregar_productos_comentario').val(), productos:lista_productos,cantidades:lista_cantidad, _token:token },
                success: function(result){
                    if (result==1) {
                        swal({
                            title: 'Los productos han sido apartados con exito!',
                            text: '',
                            type: 'success',
                            confirmButtonText: 'OK'
                        }).then(function () {
                            window.location.reload();
                        });
                        actualizar_tabla_productos();
                        $('#entregar_producto').modal('hide');
                    }
                }
            });
        }

        // Mostrar Modal Agregar Producto
        function mostrar_modal_agregar_producto()
        {
            $('#modal_agregar').modal('show');
            $('#agregar_producto')[0].reset();
        }

        // Guardar Agregar Producto
        function guardar_agregar_producto()
        {   
            $('#agregar_producto').append("<input type='hidden' name='idbodega' value='"+$('#idbodega').val()+"' />");
            var form = $('#agregar_producto');
            
            form.attr('action', "{{ url('producto/addproducto') }}");
            setTimeout(function(){
                form.submit();
            });
        }

        // Mostrar Modal Editar Producto
        function mostrar_modal_editar_producto(id)
        {
            $('#editar_producto').append("<input type='hidden' name='idbodega' value='"+$('#idbodega').val()+"' />");
            var token =  "<?= csrf_token(); ?>";
            $.ajax({
                type: "POST",
                url : "{{ url('producto/verproducto') }}",
                data: {id:id,_token:token,idbodega:$('#idbodega').val()},
                success: function(result)
                {
                    $.each(result,function(i,item){
                        $('#id_item_edit').val(item.id);
                        $("#tipo_edit option[value="+ item.type +"]").attr("selected",true);
                        $('#nombre_edit').val(item.name);
                        $('#descripcion_edit').val(item.descripcion);
                        $('#cantidad_edit').val(item.quantity);
                        $('#precio_edit').val(item.price);
                        $('#revendedor_edit').val(item.reseller_price);
                        $('#commision_edit').val(item.commision);
                        $('#comentarios_edit').val(item.comments);
                    });
                    $('#modal_editar').modal('show');
                }
            });
        }

        // Editar Producto
        function guardar_editar_producto()
        {
            var form = $('#editar_producto');
            form.attr('action', "{{ url('producto/updateproducto') }}");
            setTimeout(function(){
                form.submit();
            });
        }

        // Eliminar Producto
        function eliminar(id)
        {
            swal({
                title: 'Desea eliminar este producto',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then(function () {
                $('#agregar_producto').append("<input type='hidden' name='idbodega' value='"+$('#idbodega').val()+"' />");
                var form = $('#agregar_producto');
                form.attr('action',"{{ url('producto/delproducto') }}");
                var url = form.attr('action');
                var token =  "<?= csrf_token(); ?>";
                $.ajax({
                    type: "POST",
                    url : url,
                    data: {id:id,_token:token,idbodega:$('#idbodega').val()},
                    success: function(result)
                    {
                        swal(
                            'Eliminado!',
                            'El producto ha sido eliminado con exito',
                            'success'
                        );
                        actualizar_tabla_productos();
                    }
                });
            });
        }

        // Refrescar Tabla Productos
        function actualizar_tabla_productos(idbodega)
        {
            
            var idbodega=idbodega;
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
                            url: "{{ url('/producto/busqueda') }}",
                            method: 'POST',
                            data:{idbodega:idbodega}
                        },
                    columns: [
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var data = full.adjunto;
                                return '<img src="data:image/jpeg;base64,'+ data + '" width="150px" height="100px">';
                            }
                        },
                        {data: 'tipo', name: 'item_type.name'},
                        {data: 'name', name: 'items.name'},
                        {data: 'descripcion', name: 'items.descripcion'},
                        {data: 'quantity', name: 'items.quantity'},
                        {data: 'price', name: 'items.price'},
                        {data: 'reseller_price', name: 'items.reseller_price'},
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var buttonID = full.id;
                                return '<button class="btn btn-warning" style="width: 50px; margin-right: 20px;" onclick=\'mostrar_modal_editar_producto("'+buttonID+'");\' type="button" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"><a href="#"></a></i></button>' +
                                       '<button class="btn btn-danger" style="width: 50px;" onclick=\'eliminar("'+buttonID+'");\' type="button" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>';
                            }
                        }
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

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        $(document).ready(function(){
            var message = getParameterByName('message');
            if(message == 1)
            {
                mensajes('Se Ha Registrado/Actualizado Correctamente','','success');
                history.pushState({data:true}, 'Titulo', '/producto/inicio');
            }else if(message == 2)
            {
                mensajes('Se Ha presentado un error vuelve a ingresar la información nuevamente','','error');
                history.pushState({data:true}, 'Titulo', '/producto/inicio');
            }
            
            actualizar_tabla_productos(0);
            $('#form_entregar_producto select').select2({dropdownParent: $('#entregar_producto'), width: '100%'});

            $("#entregar_productos_agregar").on('click', function(){
            var numfilas = $("#entregar_productos_tabla tbody tr").length;
            var contador_de_productos = eval($('#cuenta_productos').val());
            $("#entregar_productos_tabla tbody tr:last").after("<tr>"
             +"<td><select class='form-control' id='producto_"+(contador_de_productos+1)+"_' name='producto_[]'><option value='0'>Seleccione una opción</option> @foreach($productos as $producto) @if($producto->quantity>0) <option value='{{$producto->id}}'>{{$producto->name}} - {{$producto->descripcion}} - {{$producto->quantity}} Disponibles</option> @endif @endforeach </select></td>"
             +"<td><input type='text' name='cantidad_[]'' id='cantidad_"+(contador_de_productos+1)+"_' class='form-control' placeholder='Cantidad'></td>"
             +"<td class='entregar_productos_eliminar'><button class='btn btn-danger' title='Eliminar'><i class='fa fa-times' aria-hidden='true'></i></button></td>"
             +"</tr>");
            
            $("#cuenta_productos").val(contador_de_productos+1);
            $('#form_entregar_producto select').select2({dropdownParent: $('#entregar_producto'), width: '100%'});
            });
        });
    </script>
@endsection
