
{{--
  |  user Edit Page
  |
  |  @package resources/views/admin/user/edit
  |
  |  @author Mohit Kumar <mohit.kumar@surmountsoft.in>
  |
  |  @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
  |
--}}

@extends('view::layouts.app')
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card card-margin">
           {{ Form::model($user, ['id'=>'edit-user','method' => 'PUT', 'files' => true, 'route' => ['users.update', $user->id]]) }}
            @csrf
            <div class="card-header header-elements-inline">
                <h5 class="card-title">{{trans('tran::views.edit_user')}}</h5>
                <div class="header-elements">
                    <a href="{{url()->previous()}}" class="btn btn-danger btn-submit-cancel">{{trans('tran::views.cancel')}}</a>
                   <button type="submit"   class="btn btn-primary ml-2 btn-custom-width">{{trans('tran::views.update')}}</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.attribute_name', ['attribute' => 'First'])}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.attribute_name', ['attribute' => 'First'])}}" class="form-control" name="first_name" value="{{$user->first_name}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.attribute_name', ['attribute' => 'Last'])}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.attribute_name', ['attribute' => 'Last'])}}" class="form-control" name="last_name" value="{{$user->last_name}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.email_address')}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.email_address')}}" class="form-control" name="email" readonly value="{{$user->email}}">
                                    </div>
                                </div>
                               
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="row">         
                               <div class="col-md-4">
                                   <div class="form-group">
                                      <label class="font-weight-semibold text-default">{{trans('tran::views.user_role')}}<sup class="error">*</sup></label>
                                      {{ Form::select('user_role',
                                      $roles,
                                      $user->user_role,
                                      ['id' => 'user_role', 'class' => 'form-control form-control-select2 activate-select2',
                                      'placeholder' => trans('tran::views.select_user')]) }}
                                   </div>
                                </div>
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.mobile_number')}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.mobile_number')}}" class="form-control" name="mobile_number" value="{{$user->mobile_number}}">
                                    </div>
                                </div>
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
{!! JsValidator::formRequest('CSoftech\Customer\Http\Requests\UserRequest', '#edit-user') !!}
@endsection
