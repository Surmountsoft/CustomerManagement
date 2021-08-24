{{--
  |  User Index Page
  |
  |  @package views/user/index
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
                    <h5 class="card-title">{{trans('tran::views.users')}}</h5>
                    <div class="header-elements">
                         <div class="text-right add-btn-wrapper">
                            <a href="{{route('users.create')}}" 
                               class="btn btn-primary create-user">{{trans('tran::views.add_attribute', ['attribute' => trans('tran::views.user')])}}</a>
                        </div> 
                    </div>
                </div>
                <table class="table table-responsive" id="users-table">
                    <thead>
                        <tr>
                            <th>{{trans('tran::views.attribute_name',['attribute' => trans('tran::views.first')])}}</th>
                            <th>{{trans('tran::views.attribute_name',['attribute' => trans('tran::views.last')])}}</th>
                            <th>{{trans('tran::views.email')}}</th>
                            <th>{{trans('tran::views.mobile_number')}}</th>
                            <th>{{trans('tran::views.user_role')}}</th>
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

