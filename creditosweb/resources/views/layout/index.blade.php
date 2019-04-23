<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>Cobranza</title>
    <link href="{{asset('vendor/bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/bower_components/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    <!-- morris CSS -->
    <!--link href="{{asset('plugins/bower_components/morrisjs/morris.css')}}" rel="stylesheet">
    <!-- chartist CSS -->
    <!--link href="{{asset('plugins/bower_components/chartist-js/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet"-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/datatables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/datatables/css/dataTables.bootstrap.min.css')}}">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/stilos.css')}}" rel="stylesheet">
    <link href="{{asset('css/colors/default.css')}}" id="theme" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/css/select2.css')}}">
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
</head>

<body class="fix-header" id="bodypoint">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <a class="logo" href="{{ url('principal') }}">
                        <img src="{{asset('plugins/images/admin-logo.png')}}" alt="home" class="dark-logo" />
                        <img src="{{asset('plugins/images/admin-logo-dark.png')}}" alt="home" class="light-logo" />
                        <span class="hidden-xs" style="color: black;">Cobranza</span>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"><i
                                    class="fas fa-bars"></i></i></a></li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="profile-pic" href="#"><b class="hidden-xs">Bienvenido(a) {{Auth::User()->name}}</b></a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="fa fa-sign-out fa-fw"></i> Salir</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="fa fa-close"></i><i class="ti-close ti-menu"></i></span>
                        <span class="hide-menu">Cobranza</span></h3>
                </div>
                <ul class="nav" id="side-menu" style="margin-top: 70px;">
                    @if(Auth::User()->can('clientes'))
                    <li>
                        <a href="{{url('clientes/inicio')}}" class="waves-effect"><i class="fa fa-users fa-fw"
                                aria-hidden="true"></i>Clientes</a>
                    </li>
                    @endif
                    @if(Auth::User()->can('productos'))
                    <li>
                        <a href="#"><i class="fas fa-box-open"></i>
                        Inventario<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('producto/inicio')}}">Productos</a>
                            </li>
                            <li>
                                <a onclick="click_entregar_producto()" >Entregar Productos</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::User()->can('bodega'))
                    <li>
                        <a href="{{url('bodega/inicio')}}" class="waves-effect"><i class="fas fa-warehouse"></i>   Bodega</a>
                    </li>
                    @endif
                    @if(Auth::User()->can('promociones'))
                    <li>
                        <a href="{{url('promociones/inicio')}}" class="waves-effect"><i class="far fa-calendar-alt"></i>
                         Promociones</a>
                    </li>
                    @endif
                    @if(Auth::User()->can('movimientos'))
                    <li>
                        <a href="#"><i class="fas fa-truck-loading"></i> Movimientos<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('movimientoout/inicio')}}">Movimientos Salientes</a>
                            </li>
                            <li>
                                <a href="{{url('movimientoint/inicio')}}">Movimientos Entrantes</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::User()->can('facturas'))
                    <li>
                        <a href="{{url('facturas/inicio')}}" class="waves-effect"><i class="fa fa-book fa-fw"
                                aria-hidden="true"></i>Facturas</a>
                    </li>
                    @endif
                    @if(Auth::User()->can('nomina'))
                    <li>
                        <a href="#"><i class="fas fa-clipboard-list"></i>
                         Nomina<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('comisiones/inicio')}}">Comisiones</a>
                            </li>
                            <li>
                                <a href="{{url('comisionespagadas/inicio')}}">Comisiones Pagadas</a>
                            </li>
                            <li>
                                <a href="{{url('reporte/inicio')}}">Reporte</a>
                            </li>
                            <li>
                                <a href="{{url('reportediario/inicio')}}">Reporte por Día</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::User()->can('cobros'))
                    <li>
                        <a href="#"><i class="far fa-money-bill-alt"></i> Cobros<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('cobros/inicio')}}">Cobros</a>
                            </li>
                            <li>
                                <a href="{{url('acuerdo/inicio')}}">Acuerdos de Pago</a>
                            </li>
                            <li>
                                <a href="{{url('mora/inicio')}}">Mora</a>
                            </li>
                            <li>
                                <a href="{{url('cartera/inicio')}}">Cartera</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::User()->can('devoluciones'))
                    <li>
                        <a href="{{url('devoluciones/inicio')}}" class="waves-effect"><i class="fas fa-undo-alt"></i> Devoluciones</a>
                    </li>
                    @endif
                    @if(Auth::User()->can('rutas'))
                    <li>
                        <a href="#"><i class="fas fa-route"></i> Rutas<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('rutas/inicio')}}">Ruta</a>
                            </li>
                            <li>
                                <a href="{{url('rutas/reporte')}}">Reporte</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::User()->can('generales'))
                    <li>
                        <a href="#"><i class="fa fa-cogs"></i> Generales<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('sucursales/inicio')}}">Sucursales</a>
                            </li>
                            <li>
                                <a href="{{url('ciudades/inicio')}}">Ciudades</a>
                            </li>
                            <li>
                                <a href="{{url('tipoproducto/inicio')}}">Tipo Producto</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::User()->can('seguridad'))
                    <li>
                        <a href="#"><i class="fa fa-lock"></i> Seguridad<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('seguridad/usuarios')}}">Usuarios</a>
                            </li>
                            <li>
                                <a href="{{url('seguridad/permisos')}}">Permisos</a>
                            </li>
                            <li>
                                <a href="{{url('seguridad/roles')}}">Roles</a>
                            </li>
                            <li>
                                <a href="{{url('seguridad/permisosrol')}}">Permisos por Rol</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Plataforma Cobranza</h4>
                    </div>
                    @yield('contenido')
                </div>
            </div>
            <footer class="footer text-center"> 2018 &copy; CreditoTorres </footer>
        </div>
    </div>

    <script src="{{asset('vendor/bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')}}"></script>
    <script src="{{asset('js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('js/waves.js')}}"></script>
    <script src="{{asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js')}}"></script>
    <script src="{{asset('plugins/bower_components/counterup/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('plugins/bower_components/chartist-js/dist/chartist.min.js')}}"></script>
    <script src="{{asset('plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js')}}"></script>
    <script src="{{asset('plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/dashboard1.js')}}"></script>
    <script src="{{asset('plugins/bower_components/toast-master/js/jquery.toast.js')}}"></script>
    <script src="{{asset('js/sweetalert2.all.js')}}"></script>
    <script src="{{asset('vendor/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('vendor/datepicker/bootstrap-datepicker.es.js')}}"></script>
    <script src="{{asset('vendor/select2/js/select2.min.js')}}"></script>

    @yield('javas')

    <script>
        function mensajes(msj, cont, tipo) {
            swal(msj, cont, tipo);
        }

        function getFormData($form) {
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};
            $(unindexed_array).each(function (ind, obj) {
                indexed_array[obj.name] = obj.value;
            });

            return indexed_array;
        }

        $(function () {
            $('.fecha').datepicker({
                language: 'es',
                format: 'yyyy-mm-dd'
            });
        });

        function click_entregar_producto() {
            vendedores();
            $('#entregar_productos_vendedor').select2({
                dropdownParent: $('#entregar_producto'),
                width: '100%'
            });
            $('#entregar_producto').modal('show');
        }

        function vendedores() {
            $.get('{{ route('producto.vendedores') }}',
                function (data, status) {
                    var vendedores;
                    data.forEach(function (currentValue) {
                        vendedores += ('<option value="' + currentValue.id + '">' + currentValue.name +
                            '</option>');
                    });
                    $("#entregar_productos_vendedor").html(vendedores);
                });
        }

        </script>
    </body>
</html>