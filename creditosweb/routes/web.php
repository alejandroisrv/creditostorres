<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

//Auth::routes();

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {

Route::get('principal','PrincipalController@index');

Route::group(['middleware'=>['ability:,clientes']],function(){
	// clientes
	Route::get('clientes/inicio','ClienteController@index');
	Route::post('clientes/busqueda','ClienteController@busqueda');
	Route::post('clientes/addcliente','ClienteController@addcliente');
	Route::post('clientes/delcliente','ClienteController@delcliente');
	Route::post('clientes/vercliente','ClienteController@vercliente');
	Route::post('clientes/updatecliente','ClienteController@updatecliente');
	Route::get('clientes/clientes/{id}','ClienteController@buscar');
	// fin clientes
});

Route::group(['middleware'=>['ability:,productos']],function(){
	// productos
	Route::get('producto/inicio','ProductoController@index');
  	Route::post('producto/busqueda/{idbodega?}','ProductoController@busquedamejorada');
	Route::post('producto/addproducto','ProductoController@addproducto');
	Route::post('producto/delproducto','ProductoController@delproducto');
	Route::post('producto/verproducto','ProductoController@verproducto');
	Route::post('producto/updateproducto','ProductoController@updateproducto');
	// fin productos

	// entregar productos
  	Route::post('producto/apartar','ProductoController@apartar')->name('productos_apartar');
  	Route::get('producto/vendedores','ProductoController@vendedores')->name('producto.vendedores');
  	// fin entregar productos
});

Route::group(['middleware'=>['ability:,bodega']],function(){
	// Bodega
	Route::get('bodega/inicio','BodegaController@index');
	Route::post('bodega/busqueda','BodegaController@busqueda');
	Route::post('bodega/addbodega','BodegaController@addbodega');
	Route::post('bodega/delbodega','BodegaController@delbodega');
	Route::post('bodega/verbodega','BodegaController@verbodega');
	Route::post('bodegas/updatebodega','BodegaController@updatebodega');
	// fin bodega
});

Route::group(['middleware'=>['ability:,promociones']],function(){
	// promociones
	Route::get('promociones/inicio','PromocionController@index');
	Route::post('promociones/busqueda','PromocionController@busqueda');
	Route::post('promociones/addpromo','PromocionController@addpromo');
	Route::post('promociones/delpromo','PromocionController@delpromo');
	Route::post('promociones/verpromo','PromocionController@verpromo');
	Route::post('promociones/updatepromo','PromocionController@updatepromo');
	// fin promociones
});

Route::group(['middleware'=>['ability:,movimientos']],function(){
	// Movimientos
	Route::get('movimientoout/inicio','MovimientosController@indexout');
	Route::post('movimientoout/busqueda','MovimientosController@busqueda');
	Route::get('movimientoint/inicio','MovimientosController@indexin');
	Route::post('movimientoint/busquedain','MovimientosController@busquedain');
	// Fin de Movimientos
});

Route::group(['middleware'=>['ability:,facturas']],function(){
	// facturas
	Route::post('facturas/pagos','FacturaController@pagos');
	Route::get('facturas/inicio','FacturaController@index');
	Route::post('facturas/busqueda','FacturaController@busquedafacturas');
	Route::post('facturas/detallado','FacturaController@detalladofactura');
	Route::post('facturas/detalladotable/{id}','FacturaController@detalladotablefactura');
	Route::post('facturas/add','FacturaController@crearfactura');
	// fin de facturas
});

Route::group(['middleware'=>['ability:,nomina']],function(){
	// comisiones
	Route::get('comisiones/inicio','ComisionController@index');
	Route::post('comisiones/busqueda','ComisionController@busqueda');
	Route::post('comisiones/actualizar','ComisionController@actualizar');
	Route::get('comisionespagadas/inicio','ComisionController@indexcomisionespagadas');
	Route::post('comisionespagadas/busqueda','ComisionController@busquedacomisionespagadas');
	// fin de comisiones

	// Reportes
	Route::get('reporte/inicio','ReporteController@index');
	Route::post('reporte/busqueda','ReporteController@reportebusqueda');
	Route::post('reporte/cancelar','ReporteController@cancelarpago');
	Route::get('reportediario/inicio','ReporteController@reportediario');
	Route::post('reportediario/busqueda','ReporteController@reportebusquedadiario');
	// fin de reportes
});

Route::group(['middleware'=>['ability:,cobros']],function(){
	// cobros
	Route::get('cobros/inicio','CobroController@index');
	Route::post('cobros/busquedacobro','CobroController@busquedacobro');
	Route::get('acuerdo/inicio','CobroController@indexacuerdo');
	Route::post('acuerdo/busqueda','CobroController@busquedaacuerdos');
	// fin de cobros

	// Modulo de cartera
	Route::get('cartera/inicio','CarteraController@index');
	Route::post('cartera/reporte','CarteraController@reporte');
	Route::get('cartera/reportes/{ruta}','CarteraController@reportes');
	// fin de modulo de cartera

	// en Mora
	Route::get('mora/inicio','ClientemoraController@index');
	Route::post('mora/busqueda','ClientemoraController@busqueda');
	Route::post('mora/cambiarestado','ClientemoraController@cambiarestado');
	Route::get('mora/imprimir/{tipo}','PdfController@crear_reporte_remision');
	// fin de en mora
});

Route::group(['middleware'=>['ability:,devoluciones']],function(){
	// devoluciones
	Route::get('devoluciones/inicio','ClaimsController@index');
	Route::post('devoluciones/busqueda','ClaimsController@busqueda');
	Route::post('devoluciones/items/{id}','ClaimsController@itemsid');
	Route::post('devoluciones/add','ClaimsController@addclaims');
	Route::post('devoluciones/consulta','ClaimsController@consulta');
	Route::post('devoluciones/consultafactura','ClaimsController@consultafactura');
	Route::post('devoluciones/delete','ClaimsController@delete');
	// fin de devoluciones
});

Route::group(['middleware'=>['ability:,rutas']],function(){
	// rutas
	Route::get('rutas/inicio','RutaController@index');
	Route::post('rutas/busqueda','RutaController@busqueda');
	Route::post('rutas/busquedadestina/{id}','RutaController@busquedadestina');
	Route::post('rutas/addruta','RutaController@addruta');
	Route::post('rutas/busquedadireccion','RutaController@busquedadireccion');
	Route::post('rutas/delruta','RutaController@delruta');
	Route::get('rutas/reporte','RutaController@indexreporte');
	Route::post('rutas/reportedia','RutaController@reportedia');
	// fin de rutas
});

Route::group(['middleware'=>['ability:,generales']],function(){
	// sucursales
	Route::get('sucursales/inicio','SucursalController@index');
	Route::post('sucursales/busqueda','SucursalController@busqueda');
	Route::post('sucursales/addusuario','SucursalController@adduser');
	Route::post('sucursales/delsucursal','SucursalController@delsucursal');
	Route::post('sucursales/versucursal','SucursalController@versucursal');
	Route::post('sucursales/updatesucursal','SucursalController@updatesucursal');
	// fin sucursales

	// ciudad
	Route::get('ciudades/inicio','CiudadController@index');
	Route::post('ciudades/busqueda','CiudadController@busqueda');
	Route::post('ciudades/addciudad','CiudadController@addciudad');
	Route::post('ciudades/delciudad','CiudadController@delciudad');
	Route::post('ciudades/verciudad','CiudadController@verciudad');
	Route::post('ciudades/updateciudad','CiudadController@updateciudad');
	// fin de ciudad

	// tipo producto
	Route::get('tipoproducto/inicio','TipoProductoController@index');
	Route::post('tipoproducto/busqueda','TipoProductoController@busqueda');
	Route::post('tipoproducto/addtipo','TipoProductoController@addtipo');
	Route::post('tipoproducto/deltipo','TipoProductoController@deltipo');
	Route::post('tipoproducto/vertipo','TipoProductoController@vertipo');
	Route::post('tipoproducto/updatetipo','TipoProductoController@updatetipo');
	// fin tipo producto
});

Route::group(['middleware'=>['ability:,seguridad']],function(){
		// Seguridad permisos
		Route::get('seguridad/permisos','SeguridadController@index');
		Route::post('seguridad/busqueda/permiso','SeguridadController@busquedapermiso');
		// fin seguridad permisos

		// seguridad roles
		Route::get('seguridad/roles','SeguridadController@indexroles');
		Route::post('seguridad/busqueda/roles','SeguridadController@busquedaroles');
		Route::post('seguridad/roles/add','SeguridadController@addroles');
		Route::post('seguridad/roles/del','SeguridadController@delroles');
		Route::post('seguridad/roles/editar','SeguridadController@editarrol');
		Route::post('seguridad/roles/edit_rol','SeguridadController@editrol');
		// fin seguridad roles

		// seguridad usuarios
		Route::get('seguridad/usuarios','SeguridadController@indexusuario');
		Route::post('seguridad/busqueda/user','SeguridadController@busquedauser');
		Route::post('seguridad/busqueda/adduser','SeguridadController@adduser');
		Route::post('seguridad/usuarios/del','SeguridadController@deluser');
		Route::post('seguridad/usuarios/editar','SeguridadController@editaruser');
		Route::post('seguridad/usuarios/edit_user','SeguridadController@edituser');
		Route::post('seguridad/usuarios/sucursal/{id}','BodegaController@bodegas_por_sucursal');
		// fin seguridad usuarios

		// seguridad permisos x rol
		Route::resource('seguridad/permisosrol','PermissionRoleController');
		Route::get('seguridad/permisosrol/permisosroles/{id}','PermissionRoleController@permisoxrol');
		// fin seguridad permisos x rol
});

});

Route::get('api/productos','ApiController@apiproductos');
// rutas de vendedor
Route::get('api/listclient','ApiController@listclient');
Route::get('api/routeall','ApiController@routedate');
Route::get('api/schedules','ApiController@schedules');
Route::get('api/itemsinvoice','ApiController@items_invoice');
Route::get('api/productos/entregar','ApiController@entregar_productos');
Route::get('api/addclient/{municipio}/{cedula}/{name}/{lastname}/{telephone}/{address}/{email}/{comments}/{good}','ApiController@addclient');
Route::get('api/crearfactura/{user}/{subtotal_total}/{client}/{number_quota}/{period}/{acumulado}','ApiController@crearfactura');

Route::post('api/datosvendedor','ApiController@datosvendedor');

Route::get('api/detailuser','ApiController@listuser');
Route::get('api/clientlist','ApiController@clientlist');
Route::get('api/getClientBuys','ApiController@getClientBuys');
Route::get('api/updatecomment/{id}/{comments}','ApiController@updatecomment');
Route::get('api/promociones','ApiController@apipromocion');
Route::get('api/myPayments/{cliente}','ApiController@myPayments');
Route::get('api/myPaymentAgreement','ApiController@myPaymentAgreement');
Route::get('api/miscierres','ApiController@miscierres');
Route::get('api/cerrardia/{usuario}','ApiController@cerrardia');

Route::post('api/updatechekin','ApiController@updatechekin');
//Route::get('api/routeall/{empleado}','ApiController@routeall');

Route::get('api/addnewpayment/{invoice}/{valor}/{empleado}/{fecha}/{observacion}','ApiController@addnewpayment');

Route::get('api/creardetalle/{items}/{cantidad}/{descuento}/{subtotal}/{total}/{comments}/{dato_id}/{user}', 'ApiController@creardetalle');

Route::get('api/log/{id_usuario}/{origen}/{clase}/{mensaje}', 'ApiController@log');
// fin de rutas de apis

Route::any('{catchall}', function() {
  return Response::view('errors.403',array(),403);
})->where('catchall', '.*');

Route::any('{catchall}', function() {
  return Response::view('errors.404',array(),404);
})->where('catchall', '.*');
