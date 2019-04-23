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
            <h1 class="page-header">Facturas <button type="button" class="btn btn-success" id="nuevo" name="nuevo" onclick="addFactura()"><i class="fa fa-plus" aria-hidden="true"></i></button></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <table class="table table-striped table-bordered table-hover" id="tableusuario">
            <thead>
            <th>Id Factura</th>
            <th>Vendedor</th>
            <th>Impuestos</th>
            <th>Subtotal</th>
            <th>Total</th>
            <th>Fecha Factura</th>
            <th>Detallado</th>
            </thead>
        </table>
    </div>
</div>
<div class="modal fade" id="addfactura" tabindex="-1" role="dialog" aria-labelledby="addfactura" aria-hidden="true">
        <form method="post" name="addfacturaform" id="addfacturaform">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" id="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Nueva factura
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Cliente</label><br>
                                    <select class='form-control' id='addCliente' name='addCliente[]' style="height: 38px;padding: 7px 12px;width:100%;">
                                        <option value='0'>Seleccione una opción</option>
                                         @foreach($clientes as $cliente)
                                         <option value='{{$cliente->id}}'>{{$cliente->name}} {{$cliente->lastname}}</option>
                                         @endforeach
                                     </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Numero de cuotas</label>
                                    <input type="text" class="form-control" id="cuotasAdd" name="vendedor">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Impuesto</label>
                                    <input type="text" class="form-control" id="impuestoAdd" name="impuesto">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Periodo</label>
                                    <select name="periodoAdd" id="peridoAdd" class="form-control">
                                        <option value='Semanal'>Semanal</option>
                                        <option value='Quincenal'>Quincenal</option>
                                        <option value='Mensual'>Mensual</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Descuento</label>
                                    <input type="text" class="form-control" id="descuentoAdd" name="total">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Subtotal</label>
                                    <input type="text" class="form-control" id="subtotalAdd" name="subtotal" value='0' readonly="readonly">
                                </div>
                                
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Comentario</label>
                                    <input type="text" class="form-control" id="comentarioAdd">
                                </div>
                            </div>
                        </div>
                        <br><br>
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
                                                        <select class='form-control' id='producto_1_' name='producto_[]' onchange='calcularSubtotal()'>
                                                            <option value='0'>Seleccione una opción</option>
                                                            @foreach($productos as $producto)
                                                                @if($producto->quantity>0)
                                                                    <option value='{{$producto->id}}'>{{$producto->name}} - {{$producto->descripcion}} - {{$producto->quantity}} Disponibles</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="col-md-2">
                                                        <input type="text" name="cantidad_[]" id="cantidad_1_" class="form-control" onkeyup='calcularSubtotal()' placeholder="Cantidad">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="newFactura()">Agregar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

<div class="modal fade" id="modalfacturadetalle" tabindex="-1" role="dialog" aria-labelledby="modalfacturadetalle" aria-hidden="true">
        <form method="post" name="frmfacturadetalle" id="frmfacturadetalle">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" id="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Factura Detallada
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <label>Número de Factura</label>
                                    <input type="text" class="form-control" id="nrofactura" name="nrofactura">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <label>Fecha de la Factura</label>
                                    <input type="text" class="form-control" id="fechafactura" name="fechafactura">
                                </div>
                                <div class="col-lg-3 col-md- col-sm-12 col-xs-12">
                                    <label>Cliente</label>
                                    <input type="text" class="form-control" id="cliente" name="cliente">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <label>Vendedor</label>
                                    <input type="text" class="form-control" id="vendedor" name="vendedor">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Impuesto</label>
                                    <input type="text" class="form-control" id="impuesto" name="impuesto">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Subtotal</label>
                                    <input type="text" class="form-control" id="subtotal" name="subtotal">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Total</label>
                                    <input type="text" class="form-control" id="total" name="total">
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="tabbable col-lg-12 col-md-12 col-sm-10 col-xs-10">
                                <ul class="nav nav-tabs">
                                    <li role="presentation" class="active"><a href="#tab1_ver" data-toggle="tab">Detalle de Factura</a></li>
                                </ul>
                            </div>
                            <div  class="tab-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="tab-pane active" id="tab1_ver">
                                    <br>
                                    <h3>Productos de la Factura</h3>
                                    <table class="table table-striped table-bordered table-hover" id="tabledetalle" style="width: 100%;">
                                        <thead>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Descuento</th>
                                        <th>Subtotal</th>
                                        <th>Total</th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

<script type="text/javascript">
    var productos = [];
    @foreach($productos as $producto)
        @if($producto->quantity>0)
         var producto = {'id': {{$producto->id}}, 'price':{{$producto->price}}};
         productos.push(producto);
        @endif
    @endforeach
    function addFactura(){
        $('#addfactura').modal('show');
    }
    $(document).on("click",".entregar_productos_eliminar",function(){
            var contador_restante3 = $('#cuenta_productos').val();
            var parent = $(this).parents().get(0);
            $(parent).remove();
            $('#cuenta_productos').val(contador_restante3-1);
        });
    $("#entregar_productos_agregar").on('click', function(){
            var numfilas = $("#entregar_productos_tabla tbody tr").length;
            var contador_de_productos = eval($('#cuenta_productos').val());
            $("#entregar_productos_tabla tbody tr:last").after("<tr>"
             +"<td><select class='form-control' id='producto_"+(contador_de_productos+1)+"_' name='producto_[]' onchange='calcularSubtotal()'><option value='0'>Seleccione una opción</option> @foreach($productos as $producto) @if($producto->quantity>0) <option value='{{$producto->id}}'>{{$producto->name}} - {{$producto->descripcion}} - {{$producto->quantity}} Disponibles</option> @endif @endforeach </select></td>"
             +"<td><input type='text' name='cantidad_[]'' id='cantidad_"+(contador_de_productos+1)+"_' class='form-control' onkeyup='calcularSubtotal()' placeholder='Cantidad'></td>"
             +"<td class='entregar_productos_eliminar'><button class='btn btn-danger' title='Eliminar'><i class='fa fa-times' aria-hidden='true'></i></button></td>"
             +"</tr>");
            $("#cuenta_productos").val(contador_de_productos+1);
            $('#form_entregar_producto select').select2({dropdownParent: $('#entregar_producto'), width: '100%'});
            });
    function calcularSubtotal(){
        
        var subtotal=0;
        var lista_producto = [], lista_cantida = [];
        for(var i = 1; i <= eval($('#cuenta_productos').val()) ; i++){
                lista_producto.push(eval($('#producto_'+i+'_').val()));
                lista_cantida.push(eval($('#cantidad_'+i+'_').val()));
        }
       for(var i=0; i<productos.length;i++){
           for(j=0; j<lista_producto.length;j++){
               if(productos[i]["id"]==lista_producto[j]){
                    subtotal+=productos[i]['price']*lista_cantida[j]
                }
           }
           
       }
       if(subtotal>0){
           $('#subtotalAdd').val(subtotal);
       }
       
       
    }
    
    function newFactura(){
        var lista_productos = [], lista_cantidad = [];
        for(var i = 1; i <= eval($('#cuenta_productos').val()) ; i++){
                lista_productos.push(eval($('#producto_'+i+'_').val()));
                lista_cantidad.push(eval($('#cantidad_'+i+'_').val()));
        }

            var token =  "<?= csrf_token(); ?>";
                $.ajax({
                type: "post",
                url : "{{ url('facturas/add') }}",
                data: { cliente:$('#addCliente').val(),
                        cuotasAdd:$('#cuotasAdd').val(),
                        impuestoAdd:$('#impuestoAdd').val(),
                        peridoAdd:$('#peridoAdd').val(),
                        descuentoAdd:$('#descuentoAdd').val(),
                        subtotalAdd:$('#subtotalAdd').val(),
                        comentarioAdd:$('#comentarioAdd').val(),
                        productos:lista_productos,
                        cantidades:lista_cantidad,
                        _token:token },
                success: function(result){
                    if (result==1) {
                         $('#addfactura').modal('hide');
                        swal({
                            title: 'Factura creada!',
                            text: '',
                            type: 'success',
                            confirmButtonText: 'OK'
                        }).then(function () {
                            window.location.reload();
                        });
                    
                    }else{
                        swal({
                            title: 'Error al crear factura!',
                            text: 'Por favor introduzca los datos correctamente',
                            type: 'error',
                            confirmButtonText: 'OK'
                        });
                    
                    }
                }
            });
    }
	$(document).ready(function(){
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
                        url: "{{url('/facturas/busqueda')}}",
                        method: 'POST'
                    },
                columns: [
                    {data: 'id', name: 'invoice.id'},
                    {data: 'username', name: 'users.name'},
                    {data: 'taxes', name: 'invoice.taxes'},
                    {data: 'subtotal', name: 'invoice.subtotal'},
                    {data: 'total', name: 'invoice.total'},
                    {data: 'created_at', name: 'invoice.created_at'},
                    {
                        sortable: false,
                        "render": function ( data, type, full, meta ) {
                            var buttonID = full.id;
                            return '<button class="btn btn-info" onclick=\'editar("'+buttonID+'");\' type="button" title="Detallado"><i class="fa fa-search" aria-hidden="true"><a href="#"></a></i></button>';
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
            
            $('#addCliente').select2({
                width: 'resolve'
            });
    });

    function editar(id)
    {
    	var form = $('#frmfacturadetalle');
        form.attr('action',"{{url('/facturas/detallado')}}");
        var url = form.attr('action');
        var token =  "<?= csrf_token(); ?>";
        var data = getFormData(form);
        $.ajax({
            type: "POST",
            url : url,
            data: {id:id,_token:token},
            success: function(result)
            {
            	$.each(result,function(i,item){
            		$('#nrofactura').val(item.invoice);
            		$('#fechafactura').val(item.created_at);
            		$('#cliente').val(item.nombrecliente);
            		$('#vendedor').val(item.nombrevendedor);
            		$('#impuesto').val(item.taxes);
            		$('#subtotal').val(item.subtotal);
            		$('#total').val(item.total);
            	});
            	$.ajaxSetup({
		            headers: {
		                'X-CSRF-TOKEN': "<?= csrf_token(); ?>"
		            }
		        });
		        $('#tabledetalle').DataTable(
		            {
		                destroy: true,
		                processing: true,
		                serverSide: true,
		                ajax:
		                    {
		                        url: '{{ url('/facturas/detalladotable')}}/'+id,
		                        method: 'POST'
		                    },
		                columns: [
		                    {data: 'nombreproducto', name: 'i.name'},
		                    {data: 'quantity', name: 'items_invoice.name'},
		                    {data: 'disccount', name: 'items_invoice.taxes'},
		                    {data: 'subtotal', name: 'items_invoice.subtotal'},
		                    {data: 'total', name: 'items_invoice.total'}
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
                $('#modalfacturadetalle').modal('show');

            }
        });
    	
    }
</script>
@endsection