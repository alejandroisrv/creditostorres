@extends('layout.index')
@section('contenido')
    <style type="text/css">
    </style>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Permisos</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <table class="table table-striped table-bordered table-hover" id="tableciudad">
                <thead>
                <th>Nombre</th>
                <th>Descripción</th>
                </thead>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "<?= csrf_token(); ?>"
                }
            });
            $('#tableciudad').DataTable(
                {
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    ajax:
                        {
                            url: "{{url('/seguridad/busqueda/permiso')}}",
                            method: 'POST'
                        },
                    columns: [
                        {data: 'display_name', name: 'permissions.display_name'},
                        {data: 'description', name: 'permissions.description'}
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