{{--
  |  User Show Page
  |
  |  @package views/user/show
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
        <div class="card card-margin">       
            <div class="card-header header-elements-inline">
                <h5 class="card-title">{{trans('tran::views.view_user')}}</h5>
                <div class="header-elements">
                    <a href="{{url()->previous()}}" class="btn btn-danger btn-submit-cancel">{{trans('tran::views.cancel')}}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group">
                                       <label class="font-weight-semibold">{{trans('tran::views.attribute_name', ['attribute' => 'First'])}}</label>
                                       <p>{{!is_null($user) && !is_null($user->first_name) ? $user->first_name : '-'}}</p>
                                   </div>
                               </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.attribute_name', ['attribute' => 'Last'])}}</label>
                                        <p>{{!is_null($user) && !is_null($user->last_name) ? $user->last_name : '-'}}</p>
                                    </div>
                                </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="font-weight-semibold">{{trans('tran::views.email')}}</label>
                                      <p>{{!is_null($user) && !is_null($user->email)  ? $user->email: '-'}}</p>
                                  </div>
                              </div>
                               
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="row">  
                              <div class="col-md-4">
                                   <div class="form-group">
                                       <label class="font-weight-semibold">{{trans('tran::views.mobile_number')}}</label>
                                       <p>{{!is_null($user) && !is_null($user->mobile_number ) ? $user->mobile_number : '-'}}</p>
                                   </div>
                               </div>       
                               <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="font-weight-semibold">{{trans('tran::views.user_role')}}</label>
                                      <p>{{ !is_null($user) && !is_null($user->role) ? $user->role->name : '-'}}</p>
                                      
                                  </div>
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
@section('scripts')
@includetrans('view::scripts.common')
@endsection
