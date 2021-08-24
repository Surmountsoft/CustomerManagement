<?php
/**
 * Role controller
 *
 * @package CSoftech\Customer\Http\Controllers
 *
 * @class RoleController
 *
 * @author Rahul Sharma <rahul.sharma@surmountsoft.in>
 *
 * @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
 */

namespace CSoftech\Customer\Http\Controllers;

use CSoftech\Customer\Models\Role;
use CSoftech\Customer\Models\Permission;
use Illuminate\Http\Request;
use CSoftech\Customer\Http\Requests\RoleRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('view::role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = [];
        $permissions = Permission::get()->sortBy('parent')->groupBy('parent');   
        $permissionsGroup = \Config::get('permissionGroup.PERMISSIONS_GROUP'); 
        return view('view::role.create',compact('permissions','permissionsGroup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try{
            \DB::BeginTransaction();
            $role = Role::create([
                'name' => $request->name
                ]);
            $role->permissions()->attach($request->permissions);
            \DB::commit();
            return redirect()->route('roles.index')->with('success', trans('tran::messages.attribute_action_successfully',['attribute' => trans('tran::views.role'), 'action' => 'added']));
        } catch(\Exception $e) {
        \DB::rollback();
            return redirect()->back()->with('error', trans('tran::messages.internal_server_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Softech\Role\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::whereId($id)->first();
        $permissions = [];
        $role->with('permissions');
        if(!is_null($role))
        $permissions = $role->permissions->sortBy('parent')->groupBy('parent');
        $permissionsGroup = \Config::get('permissionGroup.PERMISSIONS_GROUP');

        return view('view::role.show', compact('role','permissions','permissionsGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::whereId($id)->first();
        $permissions = Permission::get()->sortBy('parent')->groupBy('parent');    
        $role = $role->with('permissions')->whereId($role->id)->first();
        $rolePermissions = $role->permissions()->pluck('id')->toArray();
        $permissionsGroup = \Config::get('constants.PERMISSIONS_GROUP');

        return view('view::role.edit',compact('permissions', 'role','permissionsGroup','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::whereId($id)->first();
        try {
            \DB::BeginTransaction();
            $role->update([
                'name' => $request->name
                ]);
            $role->permissions()->sync($request->permissions);
            \DB::commit();
            return redirect()->route('roles.index')->with('success', trans('tran::messages.attribute_action_successfully',['attribute' => trans('tran::views.role'), 'action' => 'updated']));
        } catch (\Exception $error) {
            \DB::rollback();
            return redirect()->back()->withInput($request->input())->with('error', trans('tran::messages.internal_server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::whereId($id)->first();
        if (is_null($role)) {
            return response()->json(['error' => trans('tran::messages.attribute_does_not_exists', [
                'attribute' => trans('tran::views.role')
            ])], 404);
        }
        try {
            $role->permissions()->detach();
            $role->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => trans('tran::messages.internal_server_error')], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rolesData()
    {
        $roles = Role::query();
        return DataTables::eloquent($roles)
            ->editColumn('name', function ($role) {
                  return $role->name;   
            })
            ->addColumn('status', function ($role) {
                $disabled = '';
                $title = '';
                $action = trans('tran::views.activate');
                if ($role->is_active == 1) {
                    $class = 'btn bg-danger toggle-role-status active-inactive-width active';
                    $action = trans('tran::views.deactivate');
                } else {
                    $class = 'btn bg-success toggle-role-status active-inactive-width inactive';
                }
                return '<button href ="javascript:void(0)" '.$disabled.'  class="' . $class . '" data-status-route =' . route("role.toggle.status", ["id" => $role->id]) .' data-role-id = ' . $role->id . ' title="'.$title.'">' . $action . '</button>';
            })
            ->addColumn('actions', function ($role) {
                $str = '';
                $title = '';
                $disabledClass = '';
                $class = "delete-role";
                $str .='<a href="'.route('roles.show', ['role' => $role->id]).'" class="mr-2"><i class="far fa-eye mr-1 action-icon-size"></i></a>';
                $str .='<a href="' . route('roles.edit', [$role->id]) . '" class="mr-2"><i class="fas fa-edit mr-1 action-icon-size"></i></a>';
                $str .='<a href="JavaScript:void(0);" data-destroy-route="' .route("roles.destroy", ['role' => $role->id]) . '" data-role-id="' . $role->id . '" class="'.$class.'" title="'.$title.'"><i class="fas fa-trash mr-3 action-icon-size '.$disabledClass.'" style="color:red"></i></a>';
                
                return $str;
             })
             ->editColumn('id', function ($role) {
                  return $role->id;   
            })
            ->rawColumns(['name','status','actions','id'])
            ->make(true);
    }

    /**
     * toggle role status
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(Request $request)
    {
        $role = Role::whereId($request->id)->first(); 
        $status = 'success';
        $statusCode = 200;
        if (!is_null($role)) {
            $role->is_active = $role->is_active == 1 ? 0 : 1;
            $role->save();
            if ($role->is_active == 1) {
                $message = trans('tran::messages.attribute_action_successfully',
                    ['attribute' => trans('tran::views.role'), 'action' => 'activated']);
            } else {
                $message = trans('tran::messages.attribute_action_successfully',
                    ['attribute' => trans('tran::views.role'), 'action' => 'deactivated']);
            }
        } else {
            $status = 'error';
            $statusCode = 404;
            $message = trans('tran::messages.attribute_does_not_exists', ['attribute' => trans('tran::views.role')]);
        }
        return response()->json([$status => $message], $statusCode);
    }

}
