<?php
/**
 * User controller
 *
 * @package CSoftech\Customer\Http\Controllers
 *
 * @class UserController
 *
 * @author Rahul Sharma <rahul.sharma@surmountsoft.in>
 *
 * @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
 */

namespace CSoftech\Customer\Http\Controllers;

use CSoftech\Customer\Models\User;
use CSoftech\Customer\Models\Role;
use Illuminate\Http\Request;
use CSoftech\Customer\Http\Requests\UserRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('view::user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $roles = Role::pluck('name', 'id')->toArray();
        return view('view::user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try{
            \DB::BeginTransaction();
            $request->password = Str::random(8); 
                $request->verification_code = encrypt(Str::random(8));
                $user = User::create([
                   'name' => $request->first_name.' '.$request->last_name,
                   'first_name' => $request->first_name,
                   'last_name' => $request->last_name,
                   'email' => $request->email,
                   'mobile_number' => $request->mobile_number,
                   'user_role' => $request->user_role,
                   'password' => Hash::make($request->password),
                   'verification_code' => $request->verification_code,
                ]);

                $data['name'] = $request->first_name;
                $data['email'] = $request->email;
                $data['password'] = $request->password;
                $data['verification_code'] = $request->verification_code;
                $data['subject'] = trans('tran::messages.user_registered');

                Mail::send('user::emails.user-register', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'], $data['name'])
                        ->subject($data["subject"]);
                });
            \DB::commit();
            return redirect()->route('users.index')->with('success', trans('tran::messages.attribute_action_successfully',['attribute' => trans('tran::views.user'), 'action' => 'added']));
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
        $user = User::whereId($id)->first();
        return view('view::user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::whereId($id)->first();
        $roles = Role::pluck('name', 'id')->toArray();
        return view('view::user.edit',compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::whereId($id)->first();
        try {
            \DB::BeginTransaction();
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'user_role' => $request->user_role,
            ]);
            \DB::commit();
            return redirect()->route('users.index')->with('success', trans('tran::messages.attribute_action_successfully',['attribute' => trans('tran::views.user'), 'action' => 'updated']));
        } catch (\Exception $error) {
            \DB::rollback();
            return redirect()->back()->withInput($request->input())->with('error', trans('tran::messages.internal_server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::whereId($id)->first();
        if (is_null($user)) {
            return response()->json(['error' => trans('tran::messages.attribute_does_not_exists', [
                'attribute' => trans('tran::views.user')])], 404);
        }
        try {
            \DB::BeginTransaction();
            $user->delete();
            \DB::commit();
        } catch (\Exception $error) {
            \DB::rollback();
            return response()->json(['error' => trans('tran::messages.internal_server_error')], 500);
        }
        return response()->json(null, 204);
    }

    /**
     * customer listing
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function usersData(Request $request)
    {
        $users = User::query();
        $search = $request->search['value'];
        if (!is_null($search)) {
          
        $users = $users->where(function($query) use($search) {
            return $query->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhere(\DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', "%" . $search . "%")
                ->orWhere('email', 'LIKE', '%' . $search . '%');
                });
        }
        //filling the table with client information
        return DataTables::eloquent($users)
            ->editColumn('first_name', function ($user) {
                return !is_null($user->first_name)? ucwords($user->first_name) :'-';
                })
            ->editColumn('last_name', function ($user) {
            return !is_null($user->last_name)? ucwords($user->last_name) :'-';
            })
            ->editColumn('email', function ($user) {
                return !is_null($user->email) ? $user->email :'-';
            })
            ->editColumn('mobile_number', function ($user) {
                return !is_null($user->mobile_number) ? $user->mobile_number :'-';
            })
            ->editColumn('user_role', function ($user) {
                return !is_null($user) && !is_null($user->role) ? $user->role->name : '-';
            })
           ->addColumn('actions', function ($user) {
              $str = '';
                $str .= ' <a class="btn btn-link"  href="' . route('users.show', [$user->id]) . '"> <i class="far fa-eye mr-1 action-icon-size"></i></a>';      

                $str .= '<a href="' . route('users.edit', [$user->id]) . '"> <i class="fas fa-edit mr-1 action-icon-size"></i></a>';
                 if($user->is_active) {
                     $str .= '<a href="JavaScript:void(0);" data-action="unblock" data-block-route="' . route("users.block-unblock", ['user' => $user->id]) . '" data-user-id="' . $user->id . '" class="block-unblock-user btn btn-link"><i class="fas fa-ban mr-1 action-icon-size" style="color:red"></i></a>';
                 } else { 
                     $str .= '<a href="JavaScript:void(0);" data-action="block" data-block-route="' . route("users.block-unblock", ['user' => $user->id]) . '" data-user-id="' . $user->id . '" class="block-unblock-user btn btn-link"><i class="fas fa-ban mr-1 action-icon-size"></i></a>';
                 }

                $str .= '<a href="JavaScript:void(0);" data-destroy-route="' . route("users.destroy", ['user' => $user->id]) . '" data-user-id="' . $user->id . '" class="delete-user btn del-user btn-link"><i class="fas fa-trash  mr-3 action-icon-size" style="color:red"></i></a>';
               return $str;
           })
           ->editColumn('id', function($user){
              return  $user->id;
           })
            ->rawColumns(['first_name', 'last_name', 'email','mobile_number','user_role',  'actions','id'])
            ->make(true);
    }

    /**
     * Block unblock the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockUnblock($id)
    {
        $user = User::whereId($id)->first();
        if (is_null($user)) {
            return response()->json(['error' => trans('tran::messages.attribute_does_not_exists', [
                'attribute' => trans('tran::views.user')])], 404);
        }
        try {
            \DB::BeginTransaction();
            $user->update([
                'is_active' => $user->is_active == 1 ? 0 : 1
            ]);
            if ($user->is_active) {
               $data['subject'] = trans('tran::messages.block_user');
               $data['is_active'] = $user->is_active;
            } else {
               $data['subject'] = trans('tran::messages.unblock_user');
               $data['is_active'] = $user->is_active;
            }
            \DB::commit();
        } catch (\Exception $error) {
            \DB::rollback();
            return response()->json(['error' => $error->getMessage()], 500);
        }
        return response()->json(['status' => $user->is_active], 200);
    }

}
