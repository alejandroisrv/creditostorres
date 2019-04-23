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
            <h2 class="page-header">Reporte de Rutas por Día</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        		<label>Seleccione un Personal</label>
        		<select id="personal" name="personal" class="form-control">
        			@foreach($empleados as $empleado)
        				<option value="{{$empleado->id}}">{{$empleado->name}}</option>
        			@endforeach
        		</select>
        	</div>
        	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        		<label>Día</label>
        		<select class="form-control" id="dia" name="dia">
                	<option value="0">Seleccione una opción</option>
                	<option value="1">Lunes</option>
                	<option value="2">Martes</option>
                	<option value="3">Miercoles</option>
                	<option value="4">Jueves</option>
                	<option value="5">Viernes</option>
                	<option value="6">Sábado</option>
                	<option value="7">Domingo</option>
                </select>
        	</div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<br><br><center><button type="button" class="btn btn-primary" onclick="consultar()">Consultar</button>&nbsp;&nbsp;</center>
        	<br><br>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="tablereporte">
    	</div>
    </div>
</div>
<form id="frmdatos" name="frmdatos" method="post"></form>
<script type="text/javascript">
	function consultar()
	{
		if ($('#dia').val() == '0')
		{
			mensajes('Se ha presentado un error','Se debe seleccionar un día','error');
		}else
		{
			  var dia = $('#dia').val();
			  var personal = $('#personal').val();
			  var form = $('#frmdatos');
			  form.attr('action',"{{url('/rutas/reportedia')}}");
			  var url = form.attr('action');
			  var token = "<?= csrf_token(); ?>";
			  $.ajax({
			    type: "POST",
			    url : url,
			    data: {personal:personal,dia:dia,_token:token},
			    success:function(result)
			    {
			        var costo = '';
			        var tabla = '<table class="table table-striped">';
			            tabla += '<thead class="thead-inverse">';
			            tabla += '<tr>';
			            tabla += "<th>Nro de Ruta</th>";
			            tabla += "<th>Fecha de Ruta</th>";
			            tabla += "<th>Cliente</th>";
			            tabla += "<th>Chekeado</th>";
			            tabla += "<th>Fecha de Chekeado</th>";
			            tabla += '</tr>';
			            tabla += '</thead>';
			            tabla += '<tbody>';
			            tr = '';
			          $.each(result, function (i, item) {

			              tr += '<tr>';
			                  tr += '<td>'+item.ruta+'</td>';
			                  tr += '<td>'+item.fecha+'</td>';
			                  tr += '<td>'+item.cliente+'</td>';
			                  tr += '<td>'+item.chekeado+'</td>';
			                  tr += '<td>'+item.chekeado_fecha+'</td>';
			              tr += '</tr>';
			              });
			          tabla += tr;
			          tabla += '</tbody></table>';
			          $('#tablereporte').html(tabla);
			          $('#tablereporte').show();
			          $('#pago').show();
			    }
			  });
		}
	}

</script>
@endsection