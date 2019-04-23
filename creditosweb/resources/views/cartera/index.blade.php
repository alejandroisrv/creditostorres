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
            <h2 class="page-header">Cartera</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        		<label>Seleccione una Ruta</label>
        		<select id="ruta" name="ruta" class="form-control">
        			<option value="0">Seleccione una opción</option>
        			@foreach($rutas as $ruta)
        				<option value="{{$ruta->id}}">{{$ruta->comments}}</option>
        			@endforeach
        		</select>
        		<br>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<center><button type="button" class="btn btn-primary" onclick="consultar()">Consultar</button></center>
        	<br><br>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
    			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    			</div>
    			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" id="tablereporte">
    			</div>
    			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    			</div>
    	</div>
    </div>
</div>
<form id="frmdatos" name="frmdatos" method="post"></form>
<script type="text/javascript">
	function consultar()
	{
		if ($('#ruta').val() == 0)
		{
			mensajes('Se ha presentado un error','Se debe seleccionar una ruta','error');
		}else
		{
		  var ruta = $('#ruta').val();
		  var form = $('#frmdatos');
		  form.attr('action',"{{url('/cartera/reporte')}}");
		  var url = form.attr('action');
		  var token = "<?= csrf_token(); ?>";
		  $.ajax({
		    type: "POST",
		    url : url,
		    data: {ruta:ruta,_token:token},
		    success:function(result)
		    {
		    	var contador = 0;
		    	var tabla = '';
		    	for (var i = 0; i < result.length; i++) 
		    	{
		    		var articulos = '';
			    	$.each(result[i][1], function (e, item2) {
			    		articulos = articulos + item2.name + ',';
			    	});
			    	 tabla += '<table class="table table-bordered">';
			    	$.each(result[i][0], function (i, item) {
			    		tabla += '<tr>';
			    			tabla +=  '<td>Fecha</td>';
			    			tabla +=  '<td>'+item.created_at+'</td>';
			    			tabla +=  '<td>Articulo</td>';
			    			tabla +=  '<td>'+articulos+'</td>';
			    		tabla +=  '</tr>';
			    		tabla +=  '<tr>';
			    			tabla +=  '<td>Nombre</td>';
			    			tabla +=  '<td>'+item.nombrecompleto+'</td>';
			    			tabla +=  '<td>Vendedor</td>';
			    			tabla +=  '<td>'+item.nombrevendedor+'</td>';
			    		tabla += '</tr>';
			    		tabla += '<tr>';
			    			tabla +=  '<td>Dirección</td>';
			    			tabla +=  '<td>'+item.address+'</td>';
			    			tabla +=  '<td>Valor</td>';
			    			tabla +=  '<td>'+item.total+'</td>';
			    		tabla += '</tr>';
			    		tabla += '<tr>';
			    			tabla +=  '<td>Email</td>';
			    			tabla +=  '<td>'+item.email+'</td>';
			    			tabla +=  '<td>Celular</td>';
			    			tabla +=  '<td>'+item.telephone+'</td>';
			    		tabla += '</tr>';
						tabla += '<tr>';
							tabla +=  '<td>Código</td>';
							tabla +=  '<td>'+item.invoice+'</td>';
							tabla +=  '<td>#</td>';
							tabla +=  '<td>1</td>';
						tabla += '</tr>';
					});
						tabla += '<tr>';
							tabla +=  '<td class="active">Fecha</td>';
							tabla +=  '<td class="active">Abono</td>';
							tabla +=  '<td class="active">Saldo</td>';
							tabla +=  '<td class="active">&nbsp;</td>';
						tabla += '</tr>';
					$.each(result[i][2], function (a, item3) {
						tabla += '<tr>';
							tabla +=  '<td>'+item3.created_at+'</td>';
							tabla +=  '<td>'+item3.totalrecieve+'</td>';
							tabla +=  '<td>'+item3.finalpayment+'</td>';
							tabla +=  '<td>&nbsp;</td>';
						tabla += '</tr>';
					});
						tabla += '</table><br><br>';
		    	}
		          $('#tablereporte').html(tabla);
		          $('#tablereporte').show();
		    }
		  });
		}
	}

</script>


@endsection