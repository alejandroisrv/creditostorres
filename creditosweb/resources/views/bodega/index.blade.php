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
                <h1 class="page-header">Bodegas &nbsp;<button type="button" class="btn btn-success" id="nuevo" name="nuevo" onclick="agregaruser()"><i class="fa fa-plus" aria-hidden="true"></i></button></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row table-responsive">
          <table class="table table-bordered table-hover dataTable" id="tableusuario" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Sucursal</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Encargado</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>

              @foreach($sucursales as $sucursal)
                <tr>
                  <td>{{ $sucursal->id }}</td>
                  <td>{{ $sucursal->name }}</td>
                  <td>{{ $sucursal->address }}</td>
                  <td>{{ $sucursal->telephone }}</td>
                  <td>{{ $sucursal->owner_name }}</td>
                  <td>
                    <button class="btn btn-info" onclick="editar({{ $sucursal->id }});" type="button" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"><a href="#"></a></i></button>
                    <button class="btn btn-danger" onclick="eliminar({{ $sucursal->id }});" type="button" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>
                  </td>
                </tr>
              @endforeach

            </tbody>
          </table>
        </div>
    </div>
    <!-- Modal agregar -->
    <div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="modal_agregar" aria-hidden="true">
        <form method="post" name="adduser" id="adduser">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Sucursales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Sucursal</label>
                                    <select class="form-control" name="sucursal" id="sucursal">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Encargado</label>
                                    <select class="form-control" name="encargado" id="encargado">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($usuario as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Estado</label>
                                    <select class="form-control" name="estado" id="estado">
                                        <option value="0">Seleccione una opcion</option>
                                        <option value="A">Activo</option>
                                        <option value="R">Inactivo</option>
                                    </select>
                                </div>
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
                        <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_warehouse" id="id_warehouse">
                                    <label for="recipient-name" class="form-control-label">Sucursal</label>
                                    <select class="form-control" name="sucursal_edit" id="sucursal_edit">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_edit" name="nombre_edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion_edit" name="direccion_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono_edit" name="telefono_edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Encargado</label>
                                    <select class="form-control" name="encargado_edit" id="encargado_edit">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($usuario as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Estado</label>
                                    <select class="form-control" name="estado_edit" id="estado_edit">
                                        <option value="0">Seleccione una opcion</option>
                                        <option value="A">Activo</option>
                                        <option value="R">Inactivo</option>
                                    </select>
                                </div>
                            </div>
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

    	function agregaruser()
        {
            $('#modal_agregar').modal('show');
            $('#adduser')[0].reset();
        }

        function alusuario()
        {
        	var form = $('#adduser');
            form.attr('action',"{{url('/bodega/addbodega')}}");
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
                            url: "{{url('/bodega/busqueda')}}",
                            method: 'POST'
                        },
                    columns: [
                        {data: 'nombresucursal', name: 'branches.name'},
                        {data: 'name', name: 'warehouse.name'},
                        {data: 'address', name: 'warehouse.address'},
                        {data: 'telephone', name: 'warehouse.telephone'},
                        {data: 'nombreencargado', name: 'users.name'},
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
                        { "searchable": false, "targets": 5 }
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
                title: 'Desea eliminar esta bodega',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then(function () {
                var form = $('#adduser');
                form.attr('action',"{{url('/bodega/delbodega')}}");
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
                            'La bodega ha sido eliminado con exito',
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
            form.attr('action',"{{url('/bodega/verbodega')}}");
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            $.ajax({
                type: "POST",
                url : url,
                data: {id:id,_token:token},
                success: function(result)
                {
                    $.each(result,function(i,item){
                        $('#id_warehouse').val(item.id);
                        $("#sucursal_edit option[value="+ item.branch +"]").attr("selected",true);
                        $('#nombre_edit').val(item.name);
                        $('#direccion_edit').val(item.address);
                        $("#estado_edit option[value="+ item.state +"]").attr("selected",true);
                        $('#telefono_edit').val(item.telephone);
                        $("#encargado_edit option[value="+ item.incharge +"]").attr("selected",true);
                    });
                    $('#modal_editar').modal('show');
                }
            });
        }

        function edituser()
        {
            var form = $('#edit_user');
            form.attr('action',"{{url('/bodegas/updatebodega')}}");
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
                            url: "{{url('/bodega/busqueda')}}",
                            method: 'POST'
                        },
                    columns: [
                        {data: 'nombresucursal', name: 'branches.name'},
                        {data: 'name', name: 'warehouse.name'},
                        {data: 'address', name: 'warehouse.address'},
                        {data: 'telephone', name: 'warehouse.telephone'},
                        {data: 'nombreencargado', name: 'users.name'},
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
                        { "searchable": false, "targets": 5 }
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
