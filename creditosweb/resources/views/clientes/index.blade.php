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
            <div class="col-md-8">
                <h1>Clientes &nbsp;<button type="button" class="btn btn-success" id="nuevo" name="nuevo" onclick="agregaruser()"><i class="fa fa-plus" aria-hidden="true"></i></button></h1>
            </div>
            <div class="col-md-3 form-inline pull-right text-center" style="margin-top: 15px">
                <label>Mostrar por municipio</label>
                <select class="form-control" id="clientes_por_municipio" name="clientes_por_municipio" onchange="actualizartablePorMunicipio()" style="margin-left: 20px;"><option value="0">Seleccione el municipio</option>@foreach($municipios as $municipio)<option value="{{$municipio->id}}">{{$municipio->name}}</option>@endforeach</select>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <br>
        <!-- /.row -->
        <div class="row">
            <table class="table table-striped table-bordered table-hover" id="tableusuario">
                <thead>
                <th>Municipio</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Email</th>
                <th>Descuento</th>
                <th>Comentarios</th>
                <th>Buen Cliente</th>
                <th>Opciones</th>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal agregar -->
    <div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="modal_agregar" aria-hidden="true">
        <form method="post" name="adduser" id="adduser">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Clientes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Municipio</label>
                                    <input type="text" class="form-control" id="municipio" name="municipio">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Cedula/Nit</label>
                                    <input type="text" class="form-control" id="nit_cedula" name="nit_cedula">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                              <div class="form-group">
                                  <label for="recipient-name" class="form-control-label">Nombre</label>
                                  <input type="text" class="form-control" id="nombre" name="nombre">
                              </div>
                          </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                              <div class="form-group">
                                  <label for="recipient-name" class="form-control-label">Teléfono</label>
                                  <input type="text" class="form-control" id="telefono" name="telefono">
                              </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Descuento</label>
                                    <input type="email" class="form-control" id="descuento" name="descuento">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Buen Cliente</label>
                                    <select class="form-control" id="good_customer" name="good_customer">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Comentarios</label>
                                    <input type="email" class="form-control" id="comentarios" name="comentarios">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                        <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div  class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Municipio</label>
                                    <input type="text" class="form-control" id="municipio_edit" name="municipio_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Cedula/Nit</label>
                                    <input type="text" class="form-control" id="nit_cedula_editar" name="nit_cedula_editar">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_clients" id="id_clients">
                                    <label for="recipient-name" class="form-control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_edit" name="nombre_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido_edit" name="apellido_edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono_edit" name="telefono_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion_edit" name="direccion_edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Email</label>
                                    <input type="email" class="form-control" id="email_edit" name="email_edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Descuento</label>
                                    <input type="email" class="form-control" id="descuento_edit" name="descuento_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Comentarios</label>
                                    <input type="email" class="form-control" id="comentarios_edit" name="comentarios_edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Buen Cliente</label>
                                    <select class="form-control" id="good_customer_edit" name="good_customer_edit">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
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
            form.attr('action',"{{url('/clientes/addcliente')}}");
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
        
        function eliminar(id)
        {
            swal({
                title: 'Desea eliminar este cliente',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then(function () {
                var form = $('#adduser');
                form.attr('action',"{{url('/clientes/delcliente')}}");
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
                            'El cliente ha sido eliminado con exito',
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
            form.attr('action',"{{url('/clientes/vercliente')}}");
            var url = form.attr('action');
            var token =  "<?= csrf_token(); ?>";
            $.ajax({
                type: "POST",
                url : url,
                data: {id:id,_token:token},
                success: function(result)
                {
                    $.each(result,function(i,item){
                        $('#id_clients').val(item.id);
                        $('#municipio_edit').val(item.municipio);
                        $('#nombre_edit').val(item.name);
                        $('#apellido_edit').val(item.lastname);
                        $('#telefono_edit').val(item.telephone);
                        $('#direccion_edit').val(item.address);
                        $("#estado_edit option[value="+ item.state +"]").attr("selected",true);
                        $('#email_edit').val(item.email);
                        $('#comentarios_edit').val(item.comments);
                        $('#descuento_edit').val(item.discount);
                        $('#good_customer_edit').val(item.good_customer);
                        $('#nit_cedula_editar').val(item.cedula);

                    });
                    $('#modal_editar').modal('show');
                }
            });
        }

        function edituser()
        {
            var form = $('#edit_user');
            form.attr('action',"{{url('/clientes/updatecliente')}}");
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
            actualizartablePorMunicipio() 
        });

       function actualizartablePorMunicipio() {
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
                            url: "{{ url('clientes/clientes') }}/"+$('#clientes_por_municipio').val(),
                            method: 'GET'
                        },
                    columns: [
                        {data: 'municipio', name: 'municipio'},
                        {data: 'name', name: 'clients.name'},
                        {data: 'lastname', name: 'clients.lastname'},
                        {data: 'telephone', name: 'clients.telephone'},
                        {data: 'address', name: 'clients.address'},
                        {data: 'state', name: 'clients.state'},
                        {data: 'email', name: 'clients.email'},
                        {data: 'discount', name: 'clients.discount'},
                        {data: 'comments', name: 'clients.comments'},
                        {data: 'good_customer', name: 'clients.good_customer'},
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
    </script>
@endsection
