<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pr Master') }}</title>
    <link rel="icon" type="image/png" href="{{asset('assets/admin/global_assets/images/favicon-16x16.ico')}}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{asset('assets/admin/assets/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/assets/css/responsive.css')}}" rel="stylesheet">

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/global_assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/assets/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/global_assets/css/jquery.timepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/global_assets/css/extras/animate.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/global_assets/css/datetimepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/global_assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{asset('assets/admin/global_assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/global_assets/css/magicsuggest.css')}}" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/fav/32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/fav/16x16.png')}}">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{asset('assets/admin/global_assets/js/main/jquery.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->


    <!-- Theme JS files -->
    <script src="{{asset('assets/admin/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
<!--    <script src="{{asset('assets/admin/global_assets/js/plugins/visualization/d3/d3.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>-->
    <script src="{{asset('assets/admin/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/forms/inputs/maxlength.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/forms/inputs/tokenfield.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/ui/prism.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js')}}"></script>
    <script src="{{asset('assets/admin/assets/js/app.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/demo_pages/form_select2.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/forms/inputs/touchspin.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/forms/inputs/inputmask.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/demo_pages/layout_fixed_sidebar_custom.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/demo_pages/datatables_basic.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('js/jsvalidation/js/jsvalidation.js')}}"></script>

<script type="text/javascript">
     window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
    ]) !!};
        </script>
    </head>
@include('view::layouts.notification')
            <div class="page-content login-page-background">



<!-- /main sidebar -->

    <!-- Main content -->
    <div class="content-wrapper">
         <div class="page-header">
            <div class="page-header-content header-elements-md-inline custom-header-padding">
                {{--<div class="page-title d-flex">--}}
                {{--</div>--}}
            </div>
        </div>
        <!-- Content section area -->
    @yield('content')

       
    </div>
    <!-- /main content -->

</div>
<!-- /page content -->
@yield('scripts')
</body>
</html>
