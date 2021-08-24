
{{--
  |  Customer Index Page
  |
  |  @package resourses/views/admin/customer/index
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
    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">
            <!-- Users -->
            <div class="card user-wrapper">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">{{trans('tran::views.customers')}}</h5>
                    <div class="header-elements">
                        <div class="text-right add-btn-wrapper">
                            <a href="{{route('customers.create')}}" 
                               class="btn btn-primary create-user">{{trans('tran::views.add_customer')}}</a>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive" id="customers-table">
                    <thead>
                        <tr>
                            <th>{{trans('tran::views.attribute_name',['attribute' => trans('tran::views.company')])}}</th>
                            <th>{{trans('tran::views.attribute_name',['attribute' => trans('tran::views.first')])}}</th>
                            <th>{{trans('tran::views.attribute_name',['attribute' => trans('tran::views.last')])}}</th>
                            <th>{{trans('tran::views.email')}}</th>
                            <th>{{trans('tran::views.phone_number')}}</th>
                            <th>{{trans('tran::views.action')}}</th>  
                        </tr>
                    </thead>

                </table>
            </div>
            <!-- /Users -->

        </div>
    </div>
    <!-- /dashboard content -->

</div>
<!-- /content area -->
@endsection
@section('scripts')
@include('view::scripts.common')
@endsection