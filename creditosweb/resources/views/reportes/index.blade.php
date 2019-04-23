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
            <h2 class="page-header">Reporte Comisiones</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        		<label>Seleccione un Personal</label>
        		<select id="personal" name="personal" class="form-control">
        			@foreach($empleados as $empleado)
        				<option value="{{$empleado->id}}">{{$empleado->name}}</option>
        			@endforeach
        		</select>
        	</div>
        	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        		<label>Fecha Inicio</label>
        		<input type="text" name="fechai" id="fechai" class="form-control fecha">
        	</div>
        	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        		<label>Fecha Final</label>
        		<input type="text" name="fechaf" id="fechaf" class="form-control fecha">
        		<br><br>
        	</div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<center><button type="button" class="btn btn-primary" onclick="consultar()">Consultar</button>&nbsp;&nbsp;<button type="button" class="btn btn-primary" onclick="pagar()" style="display: none;" id="pago">Cancelar</button></center>
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
		if ($('#fechai').val() == '' || $('#fechaf').val() == '')
		{
			mensajes('Se ha presentado un error','Se debe ingresar una fecha incial y final','error');
		}else
		{
			if($('#fechai').val() > $('#fechaf').val())
			{
				mensajes('Se ha presentado un error','La fecha inicial debe ser menor a la fecha final','error');
			}
			else
			{
			  var fechai = $('#fechai').val();
			  var fechaf = $('#fechaf').val();
			  var personal = $('#personal').val();
			  var form = $('#frmdatos');
			  form.attr('action',"{{url('reporte/busqueda')}}");
			  var url = form.attr('action');
			  var token = "<?= csrf_token(); ?>";
			  $.ajax({
			    type: "POST",
			    url : url,
			    data: {personal:personal,fechai:fechai,fechaf:fechaf,_token:token},
			    success:function(result)
			    {
			        var costo = '';
			        var tabla = '<table class="table table-striped">';
			            tabla += '<thead class="thead-inverse">';
			            tabla += '<tr>';
			            tabla += "<th>Nro de Factura</th>";
			            tabla += "<th>Fecha Comisión</th>";
			            tabla += "<th>Total Comisión</th>";
			            tabla += '</tr>';
			            tabla += '</thead>';
			            tabla += '<tbody>';
			            tr = '';
			          var acumulado = 0;
			          $.each(result[0], function (i, item) {

			              tr += '<tr>';
			                  tr += '<td>'+item.invoice+'</td>';  
			                  tr += '<td>'+item.created_at+'</td>';
			                  tr += '<td>'+item.total+'</td>';                  
			              tr += '</tr>';
			                  acumulado = acumulado + item.total;
			              });
			          var totales = acumulado - result[1];
			          	  tr += '<tr><td colspan="2" align="right"><b>Subtotal</b></td>';
			              tr += '<td>'+acumulado+'</td>'
			              tr += '</tr>'
			          	  tr += '<tr><td colspan="2" align="right"><b>Deducciones</b></td>';
			              tr += '<td>'+result[1]+'</td>'
			              tr += '</tr>'
			              tr += '<tr><td colspan="2" align="right"><b>Total</b></td>';
			              tr += '<td>'+totales+'</td>'
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
	}

	function pagar()
	{
		var fechai = $('#fechai').val();
		var fechaf = $('#fechaf').val();
		var personal = $('#personal').val();
		swal({
                title: 'Se realizó el pago de la comisión',
                text: "",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then(function () {
                var form = $('#frmdatos');
                form.attr('action',"{{url('reporte/cancelar')}}");
                var url = form.attr('action');
                var token =  "<?= csrf_token(); ?>";
                $.ajax({
                    type: "POST",
                    url : url,
                    data: {fechai:fechai,fechaf:fechaf,personal:personal,_token:token},
                    success: function(result){
                        swal(
                            'Exitoso!',
                            'El estado de las Comisiones han sido actualizadas,',
                            'success'
                        );
                        actualizartable();
                    }
                });
            });
	}
</script>
@endsection