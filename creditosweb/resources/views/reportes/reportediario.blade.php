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
            <h2 class="page-header">Reporte Comisiones por Día</h2>
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
        		<label>Fecha</label>
        		<input type="text" name="fechai" id="fechai" class="form-control fecha">
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
		if ($('#fechai').val() == '')
		{
			mensajes('Se ha presentado un error','Se debe ingresar una fecha','error');
		}else
		{
			  var fechai = $('#fechai').val();
			  var personal = $('#personal').val();
			  var form = $('#frmdatos');
			  form.attr('action',"{{url('reportediario/busqueda')}}");
			  var url = form.attr('action');
			  var token = "<?= csrf_token(); ?>";
			  $.ajax({
			    type: "POST",
			    url : url,
			    data: {personal:personal,fechai:fechai,_token:token},
			    success:function(result)
			    {
			        var costo = '';
			        var tabla = '<table class="table table-striped">';
			            tabla += '<thead class="thead-inverse">';
			            tabla += '<tr>';
			            tabla += "<th>Fecha Comisión</th>";
			            tabla += "<th>Total Comisión</th>";
			            tabla += '</tr>';
			            tabla += '</thead>';
			            tabla += '<tbody>';
			            tr = '';
			          var acumulado = 0;
			          $.each(result, function (i, item) {

			              tr += '<tr>';
			                  tr += '<td>'+item.created_at+'</td>';
			                  tr += '<td>'+item.totalcomision+'</td>';                  
			              tr += '</tr>';
			                  acumulado = parseFloat(acumulado) + parseFloat(item.totalcomision);
			              });
			              tr += '<tr><td align="right"><b>Total</b></td>';
			              tr += '<td>'+acumulado+'</td>'
			              tr += '</tr>'
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