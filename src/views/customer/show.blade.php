{{--
  |  Customer Show Page
  |
  |  @package resources/views/admin/customer/show
  |
  |  @author Rahul Sharma <rahul.sharma@surmountsoft.in>
  |
  |  @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
  |
--}}

@extends('view::layouts.app')
@section('content')
    <!-- Content area -->
    <div class="content view-detail-page client-details">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">{{trans('tran::views.view_attribute', ['attribute' => trans('tran::views.customer')])}}</h5>
                <div class="header-elements">
                    <div class="text-right add-btn-wrapper">
                        <a href="{{route('customers.index', [$customer->id])}}" class="btn btn-primary btn-submit-cancel">{{trans('tran::views.back')}}</a>
                        <a href="{{route('customers.edit', [$customer->id])}}" class="btn ml-2 btn-danger btn-submit-cancel"> {{trans('tran::views.edit')}}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-margin">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold">{{trans('tran::views.attribute_name', ['attribute' => 'Company'])}}</label>
                                                        <p>{{!is_null($customer) && !is_null($customer->company_name) ? $customer->company_name : '-'}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold">{{trans('tran::views.attribute_name', ['attribute' => 'First'])}}</label>
                                                        <p>{{!is_null($customer) && !is_null($customer->first_name) ? $customer->first_name : '-'}}</p>
                                                    </div>
                                                </div>
                                                 <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold">{{trans('tran::views.attribute_name', ['attribute' => 'Last'])}}</label>
                                                        <p>{{!is_null($customer) && !is_null($customer->last_name) ? $customer->last_name : '-'}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold">{{trans('tran::views.email')}}</label>
                                                        <p>{{!is_null($customer) && !is_null($customer->email) ? $customer->email : '-'}}</p>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </fieldset> 
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold">{{trans('tran::views.phone_number')}}</label>
                                                        <p>{{!is_null($customer) && !is_null($customer->phone_number) ? $customer->phone_number : '-'}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>                                      
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                       <label class="font-weight-semibold">{{trans('tran::views.address_line_1')}}</label>
                                                        <p>{{(!is_null($customer) && !is_null($customer->address) && !is_null($customer->address->address_line_one)) ? $customer->address->address_line_one : '-'}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                       <label class="font-weight-semibold">{{trans('tran::views.address_line_2')}}</label>
                                                        <p>{{(!is_null($customer) && !is_null($customer->address) && !is_null($customer->address->address_line_two)) ? $customer->address->address_line_two : '-'}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold">{{trans('tran::views.country')}}</label>
                                                        <p>{{(!is_null($customer) && !is_null($customer->address) && !is_null($customer->address->country_id)) ? $countries[$customer->address->country_id] : '-'}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold">{{trans('tran::views.state')}}</label>
                                                        <p>{{(!is_null($customer) && !is_null($customer->address) && !is_null($customer->address->state_id)) ? $states[$customer->address->state_id] : '-'}}</p>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="row">
                                                 <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold">{{trans('tran::views.city')}}</label>
                                                        <p>{{(!is_null($customer) && !is_null($customer->address) && !is_null($customer->address->city_id)) ? $cities[$customer->address->city_id] : '-'}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 custom-form-width">
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold">{{trans('tran::views.pincode')}}</label>
                                                        <p>{{(!is_null($customer) && !is_null($customer->address) && !is_null($customer->address->pincode)) ? $customer->address->pincode : '-'}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /content area -->

@endsection
@section('scripts')
@include('view::scripts.common')
@endsection
