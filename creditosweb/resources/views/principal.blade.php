@extends('layout.index')
@section('contenido')

<script src="{{ asset('vendor/chart/Chart.min.js') }}"></script>
<link href="{{asset('css/dashboard.css')}}" rel="stylesheet">
<div class="dashboard">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="row">
    		<center><h2 style="margin:15px 0px;">Dashboard</h2></center>
    	</div>
    </div>
    
<div class="row justify-content-between">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <a href="{{url('seguridad/usuarios')}}">
                
           
            <div class="col-lg-12 col-md-12 col-sm-11 col-xs-11 bg-info text-white cuadrado">
                           <h2 style="font-weight:500;">{{ $empleados }}</h2>
            <h2>Empleados</h2>
            <h2 class="text-right"><i class="fas fa-people-carry"></i></h2> 
            </div>
             </a>
        </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                     <a href="{{url('clientes/inicio')}}">
            <div class="col-lg-12 col-md-12 col-sm-11 col-xs-11 bg-light text-black  cuadrado">
                           <h2 style="font-weight:500;">{{ $clientes }}</h2>
            <h2>Clientes</h2>
            <h2 class="text-right"><i class="fa fa-users"></i></h2> 
            </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <a href="{{url('producto/inicio')}}">
                <div class="col-lg-12 col-md-12 col-sm-11 col-xs-11 bg-danger text-white cuadrado">
                    <h2 style="font-weight:500;">{{ $productos }}</h2>
                    <h2>Productos</h2>
                    <h2 class="text-right"><i class="fas fa-box-open"></i></h2> 
                </div>
            </a>
        </div>
        
    </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-11 col-xs-11 bg-warning text-white cuadrado">
                <h2 style="font-weight:500;">{{ $cartera }}</h2>
                <h2>Cartera</h2>
                <h2 class="text-right"><i class="fa fa-users"></i></h2> 
            </div>
        </div>
        <a href="{{url('producto/inicio')}}">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <a href="{{url('bodega/inicio')}}" style="color:inherit;">
                    <div class="col-lg-12 col-md-12 col-sm-11 col-xs-11 bg-dark text-black cuadrado">
                        <h2 style="font-weight:500;">{{ $bodegas }}</h2>
                        <h2>Bodegas</h2>
                        <h2 class="text-right"><i class="fas fa-warehouse"></i></h2> 
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <a href="{{url('rutas/inicio')}}">
                <div class="col-lg-12 col-md-12 col-sm-11 col-xs-11 bg-primary text-white  cuadrado">
                    <h2 style="font-weight:500;">{{ $rutas }}</h2>
                    <h2>Rutas</h2>
                    <h2 class="text-right"><i class="fas fa-route"></i></h2> 
                </div>
                </a>
        </div>
        
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-primary">
		  <div class="panel-body">
		    {!! $chartjs->render() !!}
		  </div>
		  <div class="panel-footer">Gráfica Ventas por Mes</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-primary">
		  <div class="panel-body">
		    {!! $chartround->render() !!}
		  </div>
		  <div class="panel-footer">Gráfica Movimientos Entrantes vs Movimientos Salientes</div>
		</div>
	</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-primary">
		  <div class="panel-body">
		    {!! $chartpie->render() !!}
		  </div>
		  <div class="panel-footer">Gráfica Ventas Vs Devoluciones</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-primary">
		  <div class="panel-body">
		    {!! $chartlist->render() !!}
		  </div>
		  <div class="panel-footer">Gráfica de saldo facturado</div>
		</div>
	</div>
</div>
</div>
@endsection