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
            <h1 class="page-header">Clientes Morosos&nbsp;&nbsp;<a href="{{asset('/mora/imprimir/1')}}" target="_blank"><button class="btn btn-primary" title="Imprimir"><i class="fa fa-print" aria-hidden="true"></i></button></a></h1>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <table class="table table-striped table-bordered table-hover" id="tableusuario">
            <thead>
            <th>Cliente</th>
            <th>Acuerdo de Pago</th>
            <th>Estado</th>
            <th>Comentarios</th>
            <th>Fecha</th>
            <th>Cambiar Estado</th>
            </thead>
        </table>
    </div>
</div>
<form method="post" id="frmdatos" name="frmdatos"></form>
<script type="text/javascript">
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
                        url: "{{url('/mora/busqueda')}}",
                        method: 'POST'
                    },
                columns: [
                    {data: 'nombrecliente', name: 'clients.name'},
                    {data: 'payment_agreement', name: 'delinquent_client.payment_agreement'},
                    {data: 'state', name: 'delinquent_client.state'},
                    {data: 'comments', name: 'delinquent_client.comments'},
                    {data: 'created_at', name: 'delinquent_client.created_at'},
                    {
                    	sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var buttonID = full.id;
                                return '<button class="btn btn-info" onclick=\'editar("'+buttonID+'");\' type="button" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"><a href="#"></a></i></button>';
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
                        url: "{{url('/mora/busqueda')}}",
                        method: 'POST'
                    },
                columns: [
                    {data: 'nombrecliente', name: 'clients.name'},
                    {data: 'payment_agreement', name: 'delinquent_client.payment_agreement'},
                    {data: 'state', name: 'delinquent_client.state'},
                    {data: 'comments', name: 'delinquent_client.comments'},
                    {data: 'created_at', name: 'delinquent_client.created_at'},
                    {
                    	sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var buttonID = full.id;
                                return '<button class="btn btn-info" onclick=\'editar("'+buttonID+'");\' type="button" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"><a href="#"></a></i></button>';
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
    function editar(id)
    {
		swal({
                title: 'Cambiar de Estado de Moroso a no Moroso',
                text: "",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then(function () {
                var form = $('#frmdatos');
                form.attr('action',"{{url('/mora/cambiarestado')}}");
                var url = form.attr('action');
                var token =  "<?= csrf_token(); ?>";
                $.ajax({
                    type: "POST",
                    url : url,
                    data: {id:id,_token:token},
                    success: function(result){
                        swal(
                            'Exitoso!',
                            'El estado del cliente ha sido actualizado',
                            'success'
                        );
                        actualizartable();
                    }
                });
            });
    }

</script>
@endsection