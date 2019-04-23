<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Role;

use App\Models\Permission;

use Auth;

use DB;

use Illuminate\Support\Facades\Redirect;

class PermissionRoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permisos = Permission::all();
        return view('seguridad.permisoxrol')->with('roles',$roles)->with('permisos',$permisos);
    }

    public function permisoxrol($id)
    {
        $datapermi=[];

        $id_version = '';
        $id_usuario = Auth::User()->id;


        $permisosotorgados = DB::table('permission_role')
            ->select('permissions.display_name as nombre_permiso','permission_role.role_id','permission_role.permission_id')
            ->leftjoin('permissions','permissions.id','=','permission_role.permission_id')
            ->where('permission_role.role_id','=',$id)
            ->get();

        $permisossinotorgar = DB::select(DB::raw('SELECT id, name, display_name, description from permissions WHERE id not in (SELECT permission_id FROM permission_role where role_id='.$id.')'));

        array_push($datapermi, $permisosotorgados,$permisossinotorgar);
        return $datapermi;
    }

    public function store(Request $request)
    {
        try
        {

            $rolotorgado = $request->get('rolotorgado');

            $rol_id = $request->get('rol_id');

            $rol = Role::where('id','=',$rol_id)->first();
            //$rol->attachPermissions($rolotorgado);
            $rol->perms()->sync($rolotorgado);
            //dd($rol);
            //Flash('Se Actualizó Correctamente','success');
            return Redirect::to('seguridad/permisosrol');

        }
        catch(\Exception $e)
        {
            return $e;
            //return Redirect::to('seguridad/permisosrol');

        }
    }
}
