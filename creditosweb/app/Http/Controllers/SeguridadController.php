<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DataTables;

use App\Models\Role;

use App\User;

use Carbon\Carbon;

use Auth;

use App\Models\role_user;

class SeguridadController extends Controller
{
    // seguridad permisos
    public function index()
    {
        return view('seguridad.permisos');
    }

    public function busquedapermiso()
    {
        $permisos = DB::table('permissions')
            ->select('display_name','description');

        return DataTables::of($permisos)->make(true);
    }

    // seguridad roles

    public function indexroles()
    {
        return view('seguridad.roles');
    }

    public function busquedaroles()
    {
        $roles = DB::table('roles')
            ->select('id','name','description');

        return DataTables::of($roles)->make(true);
    }

    public function addroles(request $request)
    {
        $data = $request->get('data');
        try
        {
            $add = new Role;
            $add->name = $data['nombre_rol'];
            $add->description = $data['descripcion_rol'];
            $add->save();

            return 'hecho';
        }
        catch(\Exception $e)
        {
            return 'error';
        }
    }

    public function delroles(request $request)
    {
        $id = $request->get('id');
        try
        {
            $eliminar = Role::where('id',$id)->delete();

            return 'hecho';
        }catch (\Exception $e)
        {
            return 'error';
        }
    }

    public function editarrol(request $request)
    {
        $id = $request->get('id');

        $roles = DB::table('roles')
            ->select('name','description','id')
            ->where('id',$id)
            ->get();

        return $roles;
    }

    public function editrol(request $request)
    {
        $data = $request->get('data');
        try
        {
            $edit = DB::table('roles')->where('id',$data['id_rol'])->update(['name'=>$data['name_edit'],'description' => $data['description_edit']]);

            return 'hecho';
        }catch (\Exception $e)
        {
            return 'error';
        }
    }

    // seguridad usuarios

    public function indexusuario()
    {
        $roles = DB::table('roles')->select('id','name')->get();
        $sucursal = DB::table('branches')->select('id','name')->get();
        $municipios = DB::table('cities')->where('state', 'Activo')->get();
        return view('seguridad.usuarios')->with('roles',$roles)->with('sucursales',$sucursal)->with('municipios', $municipios);
    }

    public function busquedauser()
    {
        $usuarios = DB::table('users')
            ->select(DB::raw("users.id, users.usuario, users.name, users.telefono, users.id_rol, roles.name as nombrerol"))
            ->leftjoin('roles','roles.id','=','users.id_rol');

        return DataTables::of($usuarios)->make(true);
    }

    public function adduser(request $request)
    {
        $data = $request->get('data');
        $localtime = Carbon::now()->format('Y-m-d h:m:s');
        try
        {
            $add = new User;
            $add->id_branch = $data['sucursal'];
            $add->id_warehouse = $data['bodega'];
            $add->id_rol = $data['rol'];
            $add->identificacion = $data['identificacion'];
            $add->name = $data['nameuser'];
            $add->telefono = $data['telefono'];
            $add->email = $data['email'];
            $add->usuario = $data['usuario'];
            $add->password = bcrypt('cobranza');
            $add->state = $data['estado'];
            $add->created_at = $localtime;
            $add->pass = 'cobranza';
            $add->save();

            $add->attachRole($data['rol']);
            
            return 'hecho';
            
        }
        catch(\Exception $e)
        {
            return 'error'. $e->getMessage();
        }
        
        
    }

    public function deluser(request $request)
    {
        $id = $request->get('id');
        try
        {
            $role_user = role_user::where('user_id', $id)->delete();
            $eliminar = User::where('id',$id)->delete();

            return 'hecho';
        }catch (\Exception $e)
        {
            return 'error';
        }
    }

    public function editaruser(request $request)
    {
        $id = $request->get('id');

        $user = DB::table('users')->where('id',$id)->get();

        return $user;
    }

    public function edituser(request $request)
    {
        $data = $request->get('data');
        $localtime = Carbon::now()->format('Y-m-d h:m:s');
        try
        {
            $edit = DB::table('users')->where('id',$data['id_usuario'])->update([
                'id_branch'=>$data['sucursal_edit'],
                'id_warehouse'=>$data['bodega_edit'],
                'id_rol'=>$data['rol_edit'],
                'identificacion'=>$data['identificacion_edit'],
                'name'=>$data['nameuser_edit'],
                'telefono'=>$data['telefono_edit'],
                'email'=>$data['email_edit'],
                'usuario'=>$data['usuario_edit'], 
                'state'=>$data['estado_edit'],
                'updated_at'=>$localtime]);

            $role_user = role_user::findOrFail($data['id_usuario']);
            $role_user->role_id=$data['rol_edit'];
            $role_user->update();

            return 'hecho';
        }catch (\Exception $e)
        {
            return 'error';
        }
    }

}
