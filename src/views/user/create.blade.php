{{--
  |  User Create Page
  |
  |  @package views/user/create
  |
  |  @author Rahul Sharma <rahul.sharma@surmountsoft.in>
  |
  |  @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
  |
--}}

@extends('view::layouts.app')
@section('content')
    <!-- Content area -->
    <div class="content create-user-wrapper">
        <div class="card card-margin">
            {!! Form::open(['route' => 'users.store', 'method' => 'post', 'files' => true, 'id'=>'create-user']) !!}
            @csrf
            <div class="card-header header-elements-inline">
                <h5 class="card-title font-weight-semibold text-default">{{ trans('tran::views.add_attribute', ['attribute' => trans('tran::views.user')])}}</h5>
                <div class="header-elements">
                    <a href="{{url()->previous()}}" class="btn btn-danger btn-submit-cancel">{{trans('tran::views.cancel')}}</a>
                    <button type="submit" class="btn btn-primary ml-2 btn-submit-cancel">{{trans('tran::views.submit')}}</button>
                </div>
            </div>
            <div class="card-body">
             <div class="card">
                            <div class="card-header header-elements-inline">
                            </div>
                            <div class="card-body">
                                    <fieldset>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.attribute_name', ['attribute' => 'First'])}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.attribute_name', ['attribute' => 'First'])}}" class="form-control" name="first_name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.attribute_name', ['attribute' => 'Last'])}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.attribute_name', ['attribute' => 'Last'])}}" class="form-control" name="last_name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.email_address')}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.email_address')}}" class="form-control" name="email">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                            <div class="row">
                              <div class="col-md-4">
                                   <div class="form-group">
                                      <label class="font-weight-semibold text-default">{{trans('tran::views.user_role')}}<sup class="error">*</sup></label>
                                      {{ Form::select('user_role',
                                      $roles,
                                      null,
                                      ['id' => 'user_role', 'class' => 'form-control form-control-select2 activate-select2',
                                      'placeholder' => trans('tran::views.select_user_role')]) }}
                                   </div>
                                </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="font-weight-semibold text-default">{{trans('tran::views.attribute_number', ['attribute' => 'Mobile'])}}<sup class="error">*</sup></label>
                                      <input type="text" placeholder="{{trans('tran::views.mobile_number')}}" class="form-control" name="mobile_number">
                                  </div>
                              </div>
                               
                            </div>
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
{!! JsValidator::formRequest('CSoftech\Customer\Http\Requests\UserRequest', '#create-user') !!}
@endsection
