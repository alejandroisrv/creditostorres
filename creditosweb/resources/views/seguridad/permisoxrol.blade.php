@extends('layout.index')
@section('contenido')

    <style type="text/css">

        #cuadro1
        {
            height: 400px;
            overflow-y: auto;
        }
        #cuadro2
        {
            height: 400px;
            overflow-y: auto;
        }
        #sortable1, #sortable2 {
            width: 370px;
            min-height: 350px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: center;
            margin-right: 10px;
        }
        #sortable1 li, #sortable2 li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 370px;
        }
    </style>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <h3>Permisos por Rol</h3>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{url('seguridad/permisosrol')}}" method="POST" id="form_search" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label id="rol1_r" for="tipo" class="col-sm-1 control-label hor-form">Rol:</label>
                    <div class="col-sm-11">
                        <select id="rol" class="form-control" name="rol" onchange="permisos()">
                            <option value="0">Seleccione un rol</option>
                            @foreach($roles as $rol)
                                <option value="{{$rol->id}}">{{$rol->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <br>


        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{url('seguridad/permisosrol')}}" method="POST" id="roles" name="roles" class="form-horizontal" autocomplete="off">
                @csrf
                <center>
                    <button class="btn btn-primary" type="button" onclick="guardar()" title="Guardar">Guardar</button>
                    <br>
                    <br>
                    <input type="hidden" name="rol_id" id="rol_id">
                </center>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class = "panel panel-primary">
                        <div class = "panel-heading">
                            <h3 class = "panel-title ">Permisos por Rol</h3>
                        </div>
                        <div class="panel-body" id="cuadro1">
                            <center>
                                <div id="sortable1" class="connectedSortable">

                                </div>
                            </center>
                        </div>
                    </div>
                </div>
                </form>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class = "panel panel-primary" >
                        <div class = "panel-heading">
                            <h3 class = "panel-title">Permisos sin otorgar</h3>
                        </div>
                        <div class = "panel-body" id="cuadro2">
                            <center>
                                <div id="sortable2" class="connectedSortable">

                                </div>
                            </center>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Datatable-->
    <script>
        function guardar()
        {
            var rol = $('#rol').val();
            var form = $('#roles');
            var data = getFormData(form);;
            if(rol == 0)
            {
                mensajes('Se ha presentado un error','Se debe seleccionar al menos un rol','error');
            }else if(data['rolotorgado[]'] == undefined)
            {
                mensajes('Se ha presentado un error','Se debe pasar al menos un permiso','error');
            }else
            {
                $('#roles').submit();
            }
        }
        function permisos(){
            var rol = $("#rol").val();
            $('#rol_id').val(rol);
            var form = $("#form_search");
            var obj = 'sortable1';
            var obj2 = 'sortable2';
            var url = form.attr('action')+'/permisosroles/'+rol;
            $.ajax({'url': url, success: function(result){
                $('#sortable1').html('');
                $('#sortable2').html('');
                $.each(result[0], function(i, item){
                    $('#' + obj).append('<li class="btn btn-default ui-state-default"><input type="hidden" name="rolotorgado[]" value="'+item.permission_id+'">'+item.nombre_permiso+'</li>');
                });
                $.each(result[1], function(a, item2){
                    $('#' + obj2).append('<li class="btn btn-default ui-state-highlight" ><input type="hidden" name="rolotorgado[]" value="'+item2.id+'">'+item2.display_name+'</li>');
                });
            }});
        }
    </script>
@endsection

@section('javas')
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script>
        $( function() {
            $( "#sortable1, #sortable2" ).sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();
        } );
    </script>
@endsection