{{--
  |  Role Show Page
  |
  |  @package resources/views/admin/role/show
  |
  |  @author Rahul Sharma <rahul.sharma@surmountsoft.in>
  |
  |  @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
  |
--}}

@extends('view::layouts.app')
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card card-margin role-view-wrapper"> 
            <div class="card-header header-elements-inline">
                <h5 class="card-title">{{ trans('tran::views.view_role') }}</h5>
                <div class="header-elements">
                 <div class="text-right add-btn-wrapper">
                        <a href="{{url()->previous()}}" class="btn btn-primary btn-submit-cancel">{{ trans('tran::views.back') }}</a>
                        <a href="{{route('roles.edit', [$role->id])}}" class="btn btn-danger ml-2 btn-submit-cancel"> {{ trans('tran::views.edit') }}</a>
                    </div>
                    <div class="text-right">
                      
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block "><span class="font-weight-semibold">{{ trans('tran::views.role_name') }}: </span>{{ucfirst($role->name)}}
                                        </label>
                                    </div>
                                </div>
                        </fieldset>
                        <hr>
                        <fieldset class="custom-border">
                          <legend class="custom-border">{{ trans('tran::views.permissions') }}</legend>
                          <div class="row checkbox-parent">
                            <div class="col-md-12">
                              @foreach($permissions as $key => $permissionGroup)
                                  @if($permissionGroup->count() > 0)
                                      <div class="row view-full-wrapper">
                                          <div class="col-12 role-type-wrapper">
                                              <div class="role-type-txt">
                                                  <p>
                                              @if(isset($permissionsGroup[$key])) 
                                                  {{$permissionsGroup[$key] }}
                                                  
                                              @endif</p>
                                            </div>
                                          </div>
                                          <div class="form-group view-role-form">
                                              <?php 
                                                $sortedPermissionArray  = [];
                                                foreach ($permissionGroup as $key => $value) {
                                                    $sortedPermissionArray[$value->id] = $value;
                                                }
                                                ksort($sortedPermissionArray);
                                              ?>
                                             @foreach($sortedPermissionArray as $permission)
                                              <div class=" col-md-2 margin-bottom-10 view-role-wrapper">
                                                  <label class="form-check-label">
                                                      {{$permission->name}}
                                                  </label>
                                              </div>
                                            @endforeach
                                          </div>
                                      </div>
                                   @endif
                              @endforeach
                            </div>
                          </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
