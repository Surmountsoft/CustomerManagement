{{--
  |  Role Edit Page
  |
  |  @package resources/views/admin/role/edit
  |
  |  @author Rahul Sharma <rahul.sharma@surmountsoft.in>
  |
  |  @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
  |
--}}

@extends('view::layouts.app')
@section('content')
    <!-- Content area -->
    <div class="content edit-new-wrapper">
        <div class="card card-margin">
            {{ Form::model($role, ['id'=>'edit-role','method' => 'PUT', 'route' => ['roles.update', $role->id]]) }}
            {{csrf_field()}}
            <div class="card-header header-elements-inline">
                <h5 class="card-title">{{ trans('tran::views.edit_role') }}</h5>
                 <div class="header-elements">
                            <a href="{{route('roles.index')}}" class="btn btn-danger btn-custom-width">{{ trans('tran::views.cancel') }}</a>
                            <button type="submit" class="btn btn-primary ml-2 btn-custom-width">{{ trans('tran::views.update') }}</button>
             </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{ trans('tran::views.role_name') }}</label>
                                        <input type="text" placeholder="{{ trans('tran::views.role_name') }}" class="form-control"
                                               name="name" value="{{$role->name}}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <fieldset class="custom-border">
                            <legend class="custom-border">{{ trans('tran::views.permissions') }}</legend>
                            <div class="row checkbox-parent">
                                <div class="form-group mb-12 mb-md-12">
                                    <div class="form-check form-check-inline select-all-wrapper">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input-styled select-all" data-fouc>
                                            {{ trans('tran::views.check_all') }}
                                        </label>
                                    </div>
                                </div>
                                    <div class="col-md-12">
                                           @foreach($permissions as $key => $permissionGroup)
                                                @if($permissionGroup->count() > 0)
                                                <div class="row edit-full-wrapper">
                                                    <div class="col-12 role-type-wrapper">
                                                        <div class="role-type-txt">
                                                        <p>
                                                            @if(isset($permissionsGroup[$key])) 
                                                                {{$permissionsGroup[$key] }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                    </div>
                                                <div class="form-group edit-role-form">
                                                    <?php 
                                                      $sortedPermissionArray  = [];
                                                      foreach ($permissionGroup as $key => $value) {
                                                          $sortedPermissionArray[$value->id] = $value;
                                                      }
                                                      ksort($sortedPermissionArray);
                                                    ?>
                                                @foreach($sortedPermissionArray as $permission)
                                                <div class="col-md-2 margin-bottom-10 form-check form-check-inline col-2 role-edit-wrapper">
                                                    <input type="checkbox" class="form-check-input-styled checkbox"
                                                           name="permissions[]"
                                                            @if(in_array($permission->id, $rolePermissions)) checked
                                                           @endif value="{{ $permission->id}}" data-fouc>
                                                    {{$permission->name}}

                                                </div>
                                            @endforeach
                                            </div>
                                            </div>
                                                @endif
                                             @endforeach
                                <label class="form-check-label"></label>
                            </div>
                        </fieldset>
                    </div>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- /content area -->
@endsection
@section('scripts')
    @include('view::scripts.common')
    {!! JsValidator::formRequest('CSoftech\Customer\Http\Requests\RoleRequest', '#edit-role') !!}
@endsection