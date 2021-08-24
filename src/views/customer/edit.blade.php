{{--
  |  Customer Edit Page
  |
  |  @package resources/views/admin/customer/edit
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
            {{ Form::model($customer, ['id'=>'edit-customer','method' => 'PUT', 'route' => ['customers.update', $customer->id]]) }}
            @csrf
            <div class="card-header header-elements-inline">
                <h5 class="card-title">{{trans('tran::views.edit_customer')}}</h5>
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
                              <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-semibold text-default">{{trans('tran::views.attribute_name', ['attribute' => 'Company'])}}<sup class="error">*</sup></label>
                                    <input type="text" placeholder="{{trans('tran::views.attribute_name', ['attribute' => 'Company'])}}" class="form-control" name="company_name" value="{{ $customer->company_name }}">
                                </div>
                            </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.attribute_name', ['attribute' => 'First'])}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.attribute_name', ['attribute' => 'First'])}}" class="form-control" name="first_name" value="{{ $customer->first_name }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.attribute_name', ['attribute' => 'Last'])}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.attribute_name', ['attribute' => 'Last'])}}" class="form-control" name="last_name" value="{{ $customer->last_name }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.email')}}<sup class="error">*</sup></label>
                                        <input type="text" placeholder="{{trans('tran::views.email')}}" class="form-control" name="email" value="{{ $customer->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.phone_number')}}</label>
                                        <input type="text" placeholder="{{trans('tran::views.phone_number')}}" class="form-control" name="phone_number" value="{{ $customer->phone_number }}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.address_line_1')}}</label>
                                        <input type="text" placeholder="{{trans('tran::views.address_line_1')}}" class="form-control" name="address_line_1" value="{{(!is_null($customer) && !is_null($customer->address)) ? $customer->address->address_line_one : null}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">{{trans('tran::views.address_line_2')}}</label>
                                        <input type="text" placeholder="{{trans('tran::views.address_line_2')}}" class="form-control" name="address_line_2" value="{{(!is_null($customer) && !is_null($customer->address)) ? $customer->address->address_line_two : null}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('country', trans('tran::views.country'), ['class'=>"font-weight-semibold text-default"]) }}
                                        <?php $countries = ["" => trans('tran::views.select_attribute', ['attribute' => trans('tran::views.country')])]+$countries ;?>
                                        {{ Form::select('country_id', $countries, (!is_null($customer) && !is_null($customer->address)) ? $customer->address->country_id : null,
                                         ['class' => 'form-control form-control-select2 activate-select2', 'id' => 'country_id']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('state', trans('tran::views.state'), ['class'=>"font-weight-semibold text-default"]) }}
                                        {{ Form::select('state_id', ['' => trans('tran::views.select_attribute', ['attribute' => trans('tran::views.state')])]+$states, (!is_null($customer) && !is_null($customer->address)) ? $customer->address->state_id : null,
                                         ['class' => 'form-control form-control-select2 activate-select2', 'data-live-search'=>'true', 'id' => 'state_id']) }}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('city', trans('tran::views.city'), ['class'=>"font-weight-semibold text-default"]) }}
                                        {{ Form::select('city_id', ['' => trans('tran::views.select_attribute', ['attribute' => trans('tran::views.city')])]+$cities, (!is_null($customer) && !is_null($customer->address)) ? $customer->address->city_id : null,
                                         ['class' => 'form-control form-control-select2 activate-select2', 'id' => 'city_id']) }}
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('pincode', trans('tran::views.pincode'), ['class'=>"font-weight-semibold text-default"]) }}
                                        {{ Form::text('pincode', (!is_null($customer) && !is_null($customer->address)) ? $customer->address->pincode : null, ['class' => 'form-control',
                                            'placeholder' => trans('tran::views.pincode')]) }}
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
{!! JsValidator::formRequest('CSoftech\Customer\Http\Requests\CustomerRequest', '#edit-customer') !!}
@endsection
