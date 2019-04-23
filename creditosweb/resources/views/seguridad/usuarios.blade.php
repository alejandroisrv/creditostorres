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
                <h1 class="page-header">Usuarios &nbsp;<button type="button" class="btn btn-success" id="nuevo" name="nuevo" onclick="agregaruser()"><i class="fa fa-plus" aria-hidden="true"></i></button></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <table class="table table-striped table-bordered table-hover" id="tableusuario">
                <thead>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Rol</th>
                <th>Opciones</th>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal agregar -->
    <div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="modal_agregar" aria-hidden="true">
        <form method="post" name="adduser" id="adduser" action="{{url('/seguridad/busqueda/adduser')}}">
            @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nameuser" name="nameuser">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Identificación</label>
                                    <input type="text" name="identificacion" id="identificacion" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Municipio</label>
                                    <select class="form-control" name="municipio" id="municipio">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($municipios as $municipio)
                                            <option value="{{$municipio->id}}">{{$municipio->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Teléfono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Sucursal</label>
                                    <select class="form-control" name="sucursal" id="sucursal" onchange="buscar_bodega()">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Rol</label>
                                    <select class="form-control" name="rol" id="rol">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($roles as $rol)
                                            <option value="{{$rol->id}}">{{$rol->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Bodega</label>
                                    <select class="form-control" name="bodega" id="bodega">
                                        <option value="0">Seleccione una opcion</option>
                                        {{--@foreach($bodegas as $bodega)
                                            <option value="{{$bodega->id}}">{{$bodega->name}}</option>
                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Usuarios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div  class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="hidden" name="id_usuario" id="id_usuario">
                                        <label for="recipient-name" class="form-control-label">Usuario</label>
                                        <input type="text" class="form-control" id="usuario_edit" name="usuario_edit">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="form-control-label">Nombre</label>
                                        <input type="text" class="form-control" id="nameuser_edit" name="nameuser_edit">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Identificación</label>
                                        <input type="text" name="identificacion_edit" id="identificacion_edit" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="form-control-label">Teléfono</label>
                                        <input type="text" name="telefono_edit" id="telefono_edit" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="form-control-label">Sucursal</label>
                                        <select class="form-control" name="sucursal_edit" id="sucursal_edit" onchange="buscar_bodega_edit()">
                                            <option value="0">Seleccione una opcion</option>
                                            @foreach($sucursales as $sucursal)
                                                <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Rol</label>
                                    <select class="form-control" name="rol_edit" id="rol_edit">
                                        <option value="0">Seleccione una opcion</option>
                                        @foreach($roles as $rol)
                                            <option value="{{$rol->id}}">{{$rol->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="form-control-label">Bodega</label>
                                        <select class="form-control" name="bodega_edit" id="bodega_edit">
                                            <option value="0">Seleccione una opcion</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email_edit" id="email_edit" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
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
                        <button type="button" class="btn btn-primary" onclick="edituser()">Actualizar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Fin modal editar -->

    <script>
        function agregaruser()
        {
          document.getElementById("adduser").reset();
            $('#modal_agregar').modal('show');
            $('#adduser')[0].reset();
        }

        function actualizartable()
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
                            url: "{{url('/seguridad/busqueda/user')}}",
                            method: 'POST'
                        },
                    columns:[
                        {data: 'usuario', name: 'users.usuario'},
                        {data: 'name', name: 'users.name'},
                        {data: 'telefono', name: 'users.telefono'},
                        {data: 'nombrerol', name: 'roles.name'},
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var id_usuario = full.id;
                                return '<button class="btn btn-info" onclick=\'editar("'+id_usuario+'");\' type="button" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"><a href="#"></a></i></button>' +
                                       '<button class="btn btn-danger" onclick=\'eliminar("'+id_usuario+'");\' type="button" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>';
                            }
                        }
                    ],
                    "columnDefs": [
                        { "searchable": false, "targets": 4 }
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
        
        // $('#adduser').on('submit',function(e){
        //     var form = $('#adduser');
        //     alert(getFormData(form));
        //     e.preventDefault();
        //     $.ajax({
        //         type: "POST",
        //         url : "{{url('/seguridad/busqueda/adduser')}}",
        //         data: {data:getFormData(form)},
        //         beforeSend: function(){
        //             $('#modal_agregar .modal-body').html("<img src='https://inv.donjuerguero.com/assets/img/gif-load.gif' style='margin-left:40%;margin-top:30px;width:110px;' />");
        //         },
        //         success: function(result)
        //         {   
        //             $('#modal_agregar .modal-body').html(result);
                    
        //         }
        //     });
        //     return false;
        // });

        function alusuario()
        {
            var form = $('#adduser');
            form.attr('action',"{{url('/seguridad/busqueda/adduser')}}");
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            var data = getFormData(form);
            $.ajax({
                type: "POST",
                url : url,
                data: {data:data,_token:token},
                success: function(result)
                {
                    // $('#modal_agregar .modal-body').html(result);
                    $('#modal_agregar').modal('hide');
                    actualizartable();
                    mensajes('Se ha registrado exitosamente','','success');
                }
            });
        }

        function eliminar(id)
        {
            swal({
                title: 'Desea eliminar este usuario',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then(function () {
                var form = $('#adduser');
                form.attr('action',"{{url('/seguridad/usuarios/del')}}");
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
                            'El usuario ha sido eliminado con exito',
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
            form.attr('action',"{{url('/seguridad/usuarios/editar')}}");
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            $.ajax({
                type: "POST",
                url : url,
                data: {id:id,_token:token},
                success: function(result)
                {
                  document.getElementById("edit_user").reset();
                  $("#estado_edit option[value='0']").attr("selected",true);
                  $("#rol_edit option[value='0']").attr("selected",true);
                  $("#sucursal_edit option[value='0']").attr("selected",true);
                  $("#bodega_edit option[value='0']").attr("selected",true);
                    $.each(result,function(i,item){
                        $('#id_usuario').val(item.id);
                        $('#usuario_edit').val(item.usuario);
                        $('#nameuser_edit').val(item.name);
                        $('#identificacion_edit').val(item.identificacion);
                        $('#telefono_edit').val(item.telefono);
                        $('#email_edit').val(item.email);
                        $("#estado_edit option[value="+ item.state +"]").attr("selected",true);
                        $("#rol_edit option[value="+ item.id_rol +"]").attr("selected",true);
                        $("#sucursal_edit option[value="+ item.id_branch +"]").attr("selected",true);
                        buscar_bodega_edit();
                        $("#bodega_edit option[value="+ item.id_warehouse +"]").attr("selected",true);
                    });
                    $('#modal_editar').modal('show');
                }
            });
        }

        function edituser()
        {
            var form = $('#edit_user');
            form.attr('action',"{{url('/seguridad/usuarios/edit_user')}}");
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
                    mensajes('Se ha actualizado exitosamente','','success');
                }
            });
        }

        function buscar_bodega(){
            var token =  "<?= csrf_token(); ?>";
            $.ajax({
                type: "POST",
                url : "{{url('seguridad/usuarios/sucursal')}}/"+$('#sucursal').val(),
                data: {_token:token},
                success: function(result)
                {
                    var bodegas = '<option value="0">Seleccione una opcion</option>';
                    $.each(result,function(i,item){
                        bodegas += '<option value='+ item.id +'>'+ item.name +'</option>';
                    });
                    $('#bodega').html(bodegas);
                }
            });
        }

        function buscar_bodega_edit(){
            var token =  "<?= csrf_token(); ?>";
            $.ajax({
                type: "POST",
                url : "{{url('seguridad/usuarios/sucursal')}}/"+$('#sucursal_edit').val(),
                data: {_token:token},
                success: function(result)
                {
                    var bodegas = '<option value="0">Seleccione una opcion</option>';
                    $.each(result,function(i,item){
                        bodegas += '<option value='+ item.id +'>'+ item.name +'</option>';
                    });
                    $('#bodega_edit').html(bodegas);
                }
            });
        }

        $(document).ready(function(){
            actualizartable();
        });
    </script>
@endsection
