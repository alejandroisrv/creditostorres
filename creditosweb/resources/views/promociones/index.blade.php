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
                <h1 class="page-header">Promociones &nbsp;<button type="button" class="btn btn-success" id="nuevo" name="nuevo" onclick="agregaruser()"><i class="fa fa-plus" aria-hidden="true"></i></button></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <table class="table table-striped table-bordered table-hover" id="tableusuario">
                <thead>
                <th>Producto</th>
                <th>Usuario</th>
                <th>Porcentaje</th>
                <th>Valor Promoción</th>
                <th>Estado</th>
                <th>Creado</th>
                <th>Fecha Expe.</th>
                <th>Opciones</th>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal agregar -->
    <div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="modal_agregar" aria-hidden="true">
        <form method="post" name="adduser" id="adduser">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Promoción</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">Producto</label>
                                <select class="form-control" name="producto" id="producto">
                                    <option value="0">Seleccione una opcion</option>
                                    @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">Porcentaje</label>
                                <input type="text" class="form-control enter" id="porcentaje" name="porcentaje" maxlength="2">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Estado</label>
                                    <select class="form-control" name="estado" id="estado">
                                        <option value="0">Seleccione una opcion</option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Fecha Expiración</label>
                                    <input type="text" name="fechaexp" id="fechaexp" class="form-control fecha" readonly="readonly">
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="alusuario()">Agregar</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    <!-- Fin modal agregar -->

    <!-- Modal editar -->
    <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="modal_agregar" aria-hidden="true">
        <form method="post" name="edit_user" id="edit_user">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Sucursales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input type="hidden" name="id_promo" id="id_promo">
                                <label for="recipient-name" class="form-control-label">Producto</label>
                                <select class="form-control" name="producto_edit" id="producto_edit">
                                    <option value="0">Seleccione una opcion</option>
                                    @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">Porcentaje</label>
                                <input type="text" class="form-control enter" id="porcentaje_edit" name="porcentaje_edit" maxlength="2">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Estado</label>
                                    <select class="form-control" name="estado_edit" id="estado_edit">
                                        <option value="0">Seleccione una opcion</option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                        </div>  
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Fecha Expiración</label>
                                    <input type="text" name="fechaexp_edit" id="fechaexp_edit" class="form-control fecha" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="edituser()">Agregar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Fin modal editar -->

    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('.enter').keypress(function(tecla) {
                if( tecla.charCode == 13 ){
                  return false;
                } 
            });
        });

    	function agregaruser()
        {
            $('#modal_agregar').modal('show');
            $('#adduser')[0].reset();
        }

        function alusuario()
        {
        	var form = $('#adduser');
            form.attr('action',"{{url('/promociones/addpromo')}}");
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            var data = getFormData(form);
            $.ajax({
                type: "POST",
                url : url,
                data: {data:data,_token:token},
                success: function(result)
                {
                    $('#modal_agregar').modal('hide');
                    actualizartable();
                    mensajes('Se ha registrado existosamente','','success');
                }
            });
        }

        function  actualizartable()
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
                            url: "{{url('/promociones/busqueda')}}",
                            method: 'POST'
                        },
                    columns: [
                        {data: 'itemname', name: 'items.name'},
                        {data: 'username', name: 'users.name'},
                        {data: 'porcentage', name: 'promotion.porcentage'},
                        {data: 'promotionvalue', name: 'promotion.promotionvalue'},
                        {data: 'state', name: 'promotion.state'},
                        {data: 'created_at', name: 'promotion.created_at'},
                        {data: 'dateexpiration', name: 'promotion.dateexpiration'},
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var buttonID = full.id;
                                return '<button class="btn btn-info" onclick=\'editar("'+buttonID+'");\' type="button" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"><a href="#"></a></i></button>' +
                                       '<button class="btn btn-danger" onclick=\'eliminar("'+buttonID+'");\' type="button" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>';
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
        }

        function eliminar(id)
        {
            swal({
                title: 'Desea eliminar esta promoción',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then(function () {
                var form = $('#adduser');
                form.attr('action',"{{url('/promociones/delpromo')}}");
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
                            'La promoción ha sido eliminado con exito',
                            'success'
                        );
                        actualizartable();
                    }
                });

            })
        }

        function editar(id)
        {
            var form = $('#edit_user');
            form.attr('action',"{{url('/promociones/verpromo')}}");
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            $.ajax({
                type: "POST",
                url : url,
                data: {id:id,_token:token},
                success: function(result)
                {
                    $.each(result,function(i,item){
                        $('#id_promo').val(item.id);
                        $("#producto_edit option[value="+ item.id_item +"]").attr("selected",true);
                        $('#porcentaje_edit').val(item.porcentage);
                        $('#fechaexp_edit').val(item.fechaexp);
                        $("#estado_edit option[value="+ item.state +"]").attr("selected",true);
                    });
                    $('#modal_editar').modal('show');
                }
            });
        }

        function edituser()
        {
            var form = $('#edit_user');
            form.attr('action',"{{url('/promociones/updatepromo')}}");
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            var data = getFormData(form);
            $.ajax({
                type: "POST",
                url : url,
                data: {data:data,_token:token},
                success: function(result)
                {
                    $('#modal_editar').modal('hide');
                    actualizartable();
                    mensajes('Se ha actualizado existosamente','','success');
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
                            url: "{{url('/promociones/busqueda')}}",
                            method: 'POST'
                        },
                    columns: [
                        {data: 'itemname', name: 'items.name'},
                        {data: 'username', name: 'users.name'},
                        {data: 'porcentage', name: 'promotion.porcentage'},
                        {data: 'promotionvalue', name: 'promotion.promotionvalue'},
                        {data: 'state', name: 'promotion.state'},
                        {data: 'created_at', name: 'promotion.created_at'},
                        {data: 'dateexpiration', name: 'promotion.dateexpiration'},
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var buttonID = full.id;
                                return '<button class="btn btn-info" onclick=\'editar("'+buttonID+'");\' type="button" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"><a href="#"></a></i></button>' +
                                       '<button class="btn btn-danger" onclick=\'eliminar("'+buttonID+'");\' type="button" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>';
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
        });
    </script>
@endsection