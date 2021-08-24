<script type="text/javascript">


    	$(function () {
        // Defaults
	        var swalInit = swal.mixin({
	            buttonsStyling: false,
	            confirmButtonClass: 'btn btn-primary',
	            cancelButtonClass: 'btn btn-light'
	        });
            $('.fileinput-remove-button').hide();
            $('.fileinput-upload-button').hide();
            $('.file-upload-indicator').hide();
            $('.kv-file-upload').hide();
	        var message = '';
            var url = window.location.href;
            var lastPart = url.split("/").pop();
	        var cards = null;
	        var chart = null;
	        var amountChart = null;
	        var app = {
	            init: function () {
                    app.activateSelect2();
                    app.getCountryStates();
                    app.getStateCities();
                    app.rolesData();
                    app.deleteRole();
                    app.toggleRoleStatus();
                    app.checkBoxShow();
                    app.componentUniform();
                    app.selectAllCheckbox();
                    app.handleResponse();
                    app.usersData();
                    app.blockUnblockUser();
                    app.deleteUser();
                    app.customersData();
                    app.deleteCustomer();
                    app.blockUnblockCustomer();
	            },


            /**
            * activating select2 box
            * */
            activateSelect2: function () {
                $('.activate-select2').select2();
            },

            /*
             * get states belongs to country
             * */
            getCountryStates: function () {
                $(document).on('change', '#country_id', function (e) {
                    $.get("{{ url('/country-states')}}",
                            {id: $(this).val()},
                            function (data) {
                                $('#state_id').empty().append("<option value=''>{{trans('tran::views.select_attribute', ['attribute' => trans('tran::views.state')])}}</option>");
                                $.each(data.states, function (key, element) {
                                    $('#state_id').append("<option value='" + key + "'>" + element + "</option>");
                                });
                                $('#city_id').empty().append("<option value=''>{{trans('tran::views.select_attribute', ['attribute' => trans('tran::views.city')])}}</option>");
                            });
                });
                @if (isset($errors) && count($errors) > 0)
                    if ($('#country_id').val() != '') {
                        $.get("{{ url('/country-states')}}",
                                {id: $('#country_id').val()},
                                function (data) {
                                    $('#state_id').empty().append("<option value=''>{{trans('tran::views.select_attribute', ['attribute' => trans('tran::views.state')])}}</option>");
                                    $.each(data.states, function (key, element) {
                                        $('#state_id').append("<option value='" + key + "'>" + element + "</option>");
                                    });
                                    $('#city_id').empty().append("<option value=''>{{trans('tran::views.select_attribute', ['attribute' => trans('tran::views.city')])}}</option>");
                                    $('#state_id option[value="' + {{ old('state_id') }} +'"]').prop('selected', true).change();
                                    setTimeout(function() {
                                        $('#city_id option[value="' + {{ old('city_id') }} +'"]').prop('selected', true).change();
                                    }, 500);
                                });
                    }
                @endif
            },

            /*
             * get cities belongs to state
             * */
            getStateCities: function () {
                $(document).on('change', '#state_id', function (e) {
                    $.get("{{ url('/state-cities')}}",
                            {
                                country_id: $("#country_id").val(),
                                state_id: $(this).val()
                            },
                            function (data) {
                                $('#city_id').empty().append("<option value=''>{{trans('tran::views.select_attribute', ['attribute' => trans('tran::views.city')])}}</option>");
                                $.each(data.cities, function (key, element) {
                                    $('#city_id').append("<option value='" + key + "'>" + element + "</option>");
                                });
                            });
                });
            },
	        /**
             * Handle status response
             * */
            handleResponse: function (response, message, statusCode) {
                let notification = {};
                switch (statusCode) {
                    case 200:
                        notification.title = 'Success';
                        notification.text = message;
                        notification.addclass = 'bg-success border-success';
                        break;
                    case 201:
                        notification.title = 'Success';
                        notification.text = message;
                        notification.addclass = 'bg-success border-success';
                        break;
                    case 204:
                        notification.title = 'Success';
                        notification.text = message;
                        notification.addclass = 'bg-success border-success';
                        break;
                    case 404:
                        notification.title = 'Error';
                        notification.text = response.responseJSON.error;
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    case 409:
                        notification.title = 'Error';
                        notification.text = message;
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    case 422:
                        notification.title = 'Error';
                        notification.text = response.responseJSON.error;
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    case 500:
                        notification.title = 'Error';
                        notification.text = response.responseJSON.error;
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    case 598: // Network read timeout error
                        notification.title = 'Error';
                        notification.text = 'Please check your internet connection';
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    default:

                }
                if (!$.isEmptyObject(notification)) {
                    notification.delay = 1500;
                    new PNotify(notification);
                }
            },

	        /*
             * roles list
             * */
            rolesData: function () {

                $('#roles-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bDestroy: true,
                    bInfo: false,
                    // order: [[1, "id"]],
                    order: [[0, "desc"]],
                    language: {
                        sSearch: "Search ",
                        searchPlaceholder: 'Search {{ trans("tran::views.role")}}',
                    },
                    order:['3','desc'],
                   columnDefs: [         // see https://datatables.net/reference/option/columns.searchable
                        {
                            'searchable': false,
                            'orderable': false,
                            'targets': [1,2],
                        },
                        {
                            'visible':false,
                            'targets': [3],
                        },
                         {className: "dt-center", targets: [0,1,2]}
                    ],

                    ajax: {
                        url: '{{ route('roles.data') }}',

                    },
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'status', name: 'status'},
                        {data: 'actions', name: 'actions'},
                        {data: 'id', name: 'id'},
                    ],
                    "drawCallback": function() {
                        if (this.fnSettings().fnRecordsTotal() < 11) {
                            $('.dataTables_paginate').hide();
                        }
                    },
                });
            },
            /**
             * delete role
             * */

            deleteRole: function (id) {
                $(document).on('click', '.delete-role', function (e) {
                    var id = $(this).data("role-id");
                    var destroyRoute = $(this).data("destroy-route");
                    var message = '';
                    swalInit({
                        title: "{{trans('tran::messages.are_you_sure')}}",
                        text: "{{trans('tran::messages.you_are_going_to_action_this_attribute', ['action' => 'delete', 'attribute' => 'role'])}}",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-danger',
                        confirmButtonText: '{{trans('tran::views.delete')}}',
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            $.ajax({
                                url: destroyRoute,
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                processData: false,
                                contentType: false,
                                type: 'DELETE',
                                statusCode: {
                                    204: function (data) {
                                        app.rolesData();
                                        message = '{{trans('tran::messages.attribute_action_successfully',['attribute' => trans('tran::views.role'), 'action' => 'deleted'])}}';
                                        app.handleResponse(data, message, 204);
                                    },
                                    404: function (data) {
                                        app.handleResponse(data, message, 404);
                                    },
                                    500: function (data) {
                                        app.handleResponse(data, message, 500);
                                    }
                                }
                            });
                        }
                    })
                });
            },

            /**
             * for checkbox and radio button
             * */
            componentUniform: function () {
                $('.form-check-input-styled').uniform();

                $('.form-input-styled').uniform({
                    fileButtonClass: 'action btn bg-pink-400'
                });

                $('.form-control-uniform-custom').uniform({
                    fileButtonClass: 'action btn bg-blue',
                    selectClass: 'uniform-select bg-pink-400 border-pink-400'
                });
            },

            checkBoxShow:function () {
                $(document).on('click', '.date-range-checkbox', function (e) {
                    if ( $('.date-range-checkbox').is(':checked') ) {
                        $('#select-date').val('true');
                        $('#date-calender').show();
                        $('#date-calender-text').show();
                    } else {
                        $('#select-date').val('');
                        $('#date-calender').hide();
                        $('#date-calender-text').hide();
                    }
                });

            },

            /*
             * select/un-select permission checkboxes
             * */
            selectAllCheckbox: function () {
                $(document).on('click', '.select-all', function () {
                    if ($(this).is(':checked')) {
                        $(this).parents('.checkbox-parent').find('.checkbox').each(function () {
                            $(this).parents(".uniform-checker").find("span").addClass('checked');
                            $(this).prop('checked', true);
                        });
                    } else {
                        $(this).parents('.checkbox-parent').find('.checkbox').each(function () {
                            $(this).parents(".uniform-checker").find("span").removeClass('checked');
                            $(this).prop('checked', false);
                        });
                    }
                });
            },

            /*
             * activate/deactivate the role status
             * */
            toggleRoleStatus: function () {
                $(document).on('click', '.toggle-role-status', function (e) {
                    var id = $(this).data("role-id");
                    var statusRoute = $(this).data("status-route");
                    var message = $(this).hasClass('inactive') ? '{{ trans("tran::messages.attribute_action_successfully", ["attribute" => "Role", "action" => "activated"])}}' : '{{ trans("tran::messages.attribute_action_successfully", ["attribute" => "Role", "action" => "deactivated"])}}';
                    var text = $(this).hasClass('active') ? '{{ trans('tran::messages.you_are_going_to_action_this_attribute',['action' => 'deactivate', 'attribute' => 'role'])}}' : '{{ trans('tran::messages.you_are_going_to_action_this_attribute',['action' => 'activate', 'attribute' => 'role'])}}';
                    var btnTxt = $(this).hasClass('active') ? '{{ trans('tran::views.deactivate')}}' : '{{ trans('tran::views.activate')}}';
                    var confirmButtonClass = $(this).hasClass('active') ? 'btn btn-danger' : 'btn btn-success';
                    swalInit({
                        title: '{{ trans('tran::messages.are_you_sure')}}',
                        text: text,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: confirmButtonClass,
                        confirmButtonText: btnTxt,
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            $.ajax({
                                url: statusRoute,
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                processData: false,
                                contentType: false,
                                type: 'POST',
                                statusCode: {
                                    200: function (data) {
                                        app.rolesData();
                                        app.handleResponse(data, message, 200);
                                    },
                                    404: function (data) {
                                        app.handleResponse(data, message, 404);
                                    },
                                    500: function (data) {
                                        app.handleResponse(data, message, 500);
                                    }
                                }
                            });
                        }
                    })
                })
            },

            /*
             * users list
             * */
            usersData: function () {
                console.log("here");
                $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bDestroy: true,
                    order: [6, 'desc'],
                    bInfo: false,
                    language: {
                        sSearch: "Search ",
                        searchPlaceholder: 'Search {{trans("tran::views.user")}}',
                        loadingRecords: '&nbsp;',
                        processing: 'Loading...'
                    },
                    ajax: "{{ route('users.data') }}",
                    columns: [
                     
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'email', name: 'email'},
                        {data: 'mobile_number', name: 'mobile_number'},
                        {data: 'user_role', name: 'user_role'},
                        {data: 'actions', name: 'actions'},
                        {data: 'id', name: 'id'},
                    ],
                    columnDefs: [         // see https://datatables.net/reference/option/columns.searchable
                        {
                            orderable: false, targets: [5]
                        },
                        {
                            visible:false, targets: [6]
                        },

                        // {className: "dt-left", targets: [3]},
                        {className: "dt-center45", targets: [0,1,2,3,4,5]}


                    ],
                    "drawCallback": function() {
                        if (this.fnSettings().fnRecordsTotal() < 11) {
                            $('.dataTables_paginate').hide();
                        }
                    },
                });
            },

             /**
             * delete User
             * */
            deleteUser: function (id) {
                $(document).on('click', '.delete-user', function (e) {
                    var id = $(this).data("user-id");
                    var destroyRoute = $(this).data("destroy-route");
                    swalInit({
                        title: '{{trans('tran::messages.are_you_sure')}}',
                        text: '{{trans('tran::messages.you_are_going_to_action_this_attribute', ['action' => 'delete', 'attribute' => 'user'])}}',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-danger',
                        confirmButtonText: '{{trans('tran::views.delete')}}',
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            $.ajax({
                                url: destroyRoute,
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                processData: false,
                                contentType: false,
                                type: 'DELETE',
                                statusCode: {
                                    204: function (data) {
                                        app.usersData();
                                        message = '{{trans('tran::messages.attribute_action_successfully', ['attribute' => trans('tran::views.user'), 'action' => 'deleted'])}}';
                                        app.handleResponse(data, message, 204);
                                    },
                                    404: function (data) {
                                        app.handleResponse(data, message, 404);
                                    },
                                    500: function (data) {
                                        app.handleResponse(data, message, 500);
                                    }
                                }
                            });
                        }
                    })
                });
            },

            blockUnblockUser: function (id) {
                $(document).on('click', '.block-unblock-user', function (e) {
                    var id = $(this).data("user-id");
                    var destroyRoute = $(this).data("block-route");
                    var action = $(this).data("action");
                    swalInit({
                        title: '{{trans('tran::messages.are_you_sure')}}',
                        text: action == 'block' ? "{{trans('tran::messages.you_are_going_to_action_this_attribute', ['action' => 'block', 'attribute' => 'customer'])}}" : "{{trans('tran::messages.you_are_going_to_action_this_attribute', ['action' => 'unblock', 'attribute' => 'customer'])}}",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: (action == 'unblock') ? 'btn btn-primary' : 'btn btn-danger' ,
                        confirmButtonText: (action == 'unblock') ? '{{trans('tran::views.unblock')}}' : '{{trans('tran::views.block')}}',
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            $.ajax({
                                url: destroyRoute,
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                processData: false,
                                contentType: false,
                                type: 'PUT',
                                statusCode: {
                                    200: function (data) {
                                        app.usersData();
                                        if(data.status == 1)
                                        message = '{{trans('tran::messages.attribute_action_successfully', ['attribute' => trans('tran::views.user'), 'action' => 'blocked'])}}';
                                        else
                                        message = '{{trans('tran::messages.attribute_action_successfully', ['attribute' => trans('tran::views.user'), 'action' => 'unblocked'])}}';
                                        app.handleResponse(data, message, 200);
                                    },
                                    404: function (data) {
                                        app.handleResponse(data, message, 404);
                                    },
                                    500: function (data) {
                                        app.handleResponse(data, message, 500);
                                    }
                                }
                            });
                        }
                    })
                });
            },

             /*
             * customers list
             * */
            customersData: function () {
                $('#customers-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bDestroy: true,
                    order: [6, 'desc'],
                    bInfo: false,
                    language: {
                        sSearch: "Search ",
                        searchPlaceholder: 'Search {{trans("tran::views.customer")}}',
                        loadingRecords: '&nbsp;',
                        processing: 'Loading...'
                    },
                    ajax: "{{ route('customers.data') }}",
                    columns: [
                        {data: 'company_name', name: 'company_name'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'email', name: 'email'},
                        {data: 'phone_number', name: 'phone_number'},
                        {data: 'actions', name: 'actions'},
                        {data: 'id', name: 'id'},
                    ],
                    columnDefs: [         // see https://datatables.net/reference/option/columns.searchable
                        {
                            orderable: false, targets: [5]
                        },
                        {
                            visible:false, targets: [6]
                        },
                        {className: "dt-center", targets: [5]},
                        {className: "dt-center45", targets: [0,1,2,3,4]}
                    ],
                    "drawCallback": function() {
                        if (this.fnSettings().fnRecordsTotal() < 11) {
                            $('.dataTables_paginate').hide();
                        }
                    },
                });
            },

            /**
             * delete client
             * */
            deleteCustomer: function (id) {
                $(document).on('click', '.delete-customer', function (e) {
                    var id = $(this).data("customer-id");
                    var destroyRoute = $(this).data("destroy-route");
                    swalInit({
                        title: '{{trans('tran::messages.are_you_sure')}}',
                        text: '{{trans('tran::messages.you_are_going_to_action_this_attribute', ['action' => 'delete', 'attribute' => 'customer'])}}',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-danger',
                        confirmButtonText: '{{trans('tran::views.delete')}}',
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            $.ajax({
                                url: destroyRoute,
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                processData: false,
                                contentType: false,
                                type: 'DELETE',
                                statusCode: {
                                    204: function (data) {
                                        app.customersData();
                                        message = '{{trans('tran::messages.attribute_action_successfully', ['attribute' => trans('tran::views.customer'), 'action' => 'deleted'])}}';
                                        app.handleResponse(data, message, 204);
                                    },
                                    404: function (data) {
                                        app.handleResponse(data, message, 404);
                                    },
                                    500: function (data) {
                                        app.handleResponse(data, message, 500);
                                    }
                                }
                            });
                        }
                    })
                });
            },

            /**
             * block unblock customer
             * */
            blockUnblockCustomer: function (id) {
                $(document).on('click', '.block-unblock-customer', function (e) {
                    var id = $(this).data("customer-id");
                    var destroyRoute = $(this).data("block-route");
                    var action = $(this).data("action");
                    swalInit({
                        title: '{{trans('tran::messages.are_you_sure')}}',
                        text: (action == 'unblock') ? '{{trans('tran::messages.you_are_going_to_action_this_attribute', ['action' => "unblock", 'attribute' => 'customer'])}}' : '{{trans('tran::messages.you_are_going_to_action_this_attribute', ['action' => "block", 'attribute' => 'customer'])}}',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: (action == 'unblock') ? 'btn btn-primary' : 'btn btn-danger' ,
                        confirmButtonText: (action == 'unblock') ? '{{trans('tran::views.unblock')}}' : '{{trans('tran::views.block')}}',
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            $.ajax({
                                url: destroyRoute,
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                processData: false,
                                contentType: false,
                                type: 'PUT',
                                statusCode: {
                                    200: function (data) {
                                        app.customersData();
                                        if(data.status == 1)
                                        message = '{{trans('tran::messages.attribute_action_successfully', ['attribute' => trans('tran::views.customer'), 'action' => 'blocked'])}}';
                                        else
                                        message = '{{trans('tran::messages.attribute_action_successfully', ['attribute' => trans('tran::views.customer'), 'action' => 'unblocked'])}}';
                                        app.handleResponse(data, message, 200);
                                    },
                                    404: function (data) {
                                        app.handleResponse(data, message, 404);
                                    },
                                    500: function (data) {
                                        app.handleResponse(data, message, 500);
                                    }
                                }
                            });
                        }
                    })
                });
            },

	    };
        app.init();
    });

</script>