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
            <h1 class="page-header">Comisiones Pagadas</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <table class="table table-striped table-bordered table-hover" id="tableusuario">
            <thead>
            <th>Empleado</th>
            <th>Cargo</th>
            <th>Factura</th>
            <th>Comisión</th>
            <th>Estado</th>
            <th>Fecha Comisión</th>
            </thead>
        </table>
    </div>
</div>
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
                        url: "{{url('comisionespagadas/busqueda')}}",
                        method: 'POST'
                    },
                columns: [
                    {data: 'nombreempleado', name: 'users.name'},
                    {data: 'nombrerol', name: 'roles.name'},
                    {data: 'invoice', name: 'sale_commision.invoice'},
                    {data: 'total', name: 'sale_commision.total'},
                    {data: 'state', name: 'sale_commision.state'},
                    {data: 'created_at', name: 'sale_commision.created_at'}
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