@extends('layouts.master')

@section('title', __('Users'))

@section('css')
    <style>
        .edit-loader {
            width: 100%;
        }

        .edit-loader .sk-chase {
            display: block;
            margin: 0 auto;
        }

        .modal-card{
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
        .col-20 {
            width: 20% !important;
            word-wrap: break-word;
        }
    </style>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Users') }}</li>
@endsection
{{-- @dd($totalArchivedUsers) --}}
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6 mb-6">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-heading">{{ __('Users') }}</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2">{{ $totalUsers }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Total Users') }}</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-users ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-heading">{{ __('Deactivated Users') }}</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2">
                                        {{ $totalDeactivatedUsers }}
                                    </h4>
                                </div>
                                <small class="mb-0">{{ __('Total Deactive Users') }} </small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="ti ti-user-off ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-heading">{{ __('Active Users') }}</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2">{{ $totalActiveUsers }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Total Active Users') }}</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-user-check ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-heading">{{ __('Archived Users') }}</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2">{{ $totalArchivedUsers }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Total Archived Users') }}</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="ti ti-archive ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header">
                @canany(['create user'])
                    <button class="add-new btn btn-primary waves-effect waves-light" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAddUser">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">{{ __('Add New User') }}</span>
                    </button>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-json-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            {{-- <th>{{ __('Role') }}</th> --}}
                            <th>{{ __('Expiry Date') }}</th>
                            <th>{{ __('Status') }}</th>
                            @canany(['delete user', 'update user', 'view user'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Offcanvas to add new user -->
            @include('dashboard.users.sections.add-offcanvas')
            <!-- Offcanvas to edit user -->
            @include('dashboard.users.sections.edit-offcanvas')
        </div>
    </div>
    <!-- Modal to view user details -->
    @can(['view user'])
        @include('dashboard.users.sections.view-modal')
    @endcan
@endsection

@section('script')
    {{-- <script src="{{asset('assets/js/app-user-list.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            $(function () {
                $('.custom-json-datatables').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('users.json') }}",
                        type: 'GET',
                        xhrFields: {
                            withCredentials: true
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'name', name: 'name' , className: 'col-20'},
                        { data: 'email', name: 'email' , className: 'col-20'},
                        // { data: 'role', name: 'role'},
                        { data: 'expiry_date', name: 'expiry_date'},
                        { data: 'status', name: 'status'},
                        { data: 'action', name: 'action', orderable: false, searchable: false , className: 'col-20'},
                    ],
                    language: {
                        searchPlaceholder: 'Search...',
                        paginate: {
                            next: '<i class="ti ti-chevron-right ti-sm"></i>',
                            previous: '<i class="ti ti-chevron-left ti-sm"></i>'
                        }
                    },
                    dom: 'Bfrtip',
                    dom: '<"row"' +
                        '<"col-md-2"<l>>' +
                        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0"fB>>' +
                        '>t' +
                        '<"row"' +
                        '<"col-sm-12 col-md-6"i>' +
                        '<"col-sm-12 col-md-6"p>' +
                        '>',
                    buttons: [{
                        extend: 'collection',
                        className: 'btn btn-label-secondary dropdown-toggle me-4 waves-effect waves-light border-left-0 border-right-0 rounded',
                        text: '<i class="ti ti-upload ti-xs me-sm-1 align-text-bottom"></i> <span class="d-none d-sm-inline-block">{{__("Export")}}</span>',
                        buttons: [{
                                extend: 'print',
                                text: '<i class="ti ti-printer me-1"></i>{{__("Print")}}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="ti ti-file-text me-1"></i>{{__("Csv")}}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            },
                            {
                                extend: 'excel',
                                text: '<i class="ti ti-file-spreadsheet me-1"></i>{{__("Excel")}}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="ti ti-file-description me-1"></i>{{__("Pdf")}}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            },
                            {
                                extend: 'copy',
                                text: '<i class="ti ti-copy me-1"></i>{{__("Copy")}}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            }
                        ]
                    }],
                });
            });
            $('.edit-loader').hide();
            $('#editUserForm').show();
            // Event listener for edit modal opening
            $('#offcanvasEditUser').on('show.bs.offcanvas', function(event) {
                $('.edit-loader').show();
                $('#editUserForm').hide();
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                fetchUserData(userId);
            });
            $('#modalCenter').on('show.bs.modal', function(event) {
                $('.edit-loader').show();
                $('#user-info').hide();
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                fetchUserData(userId);
            });
            var editUserRoute = "{{ route('dashboard.user.edit', ':userId') }}";
            var updateUserRoute = "{{ route('dashboard.user.update', ':userId') }}";

            function fetchUserData(userId) {
                var url = editUserRoute.replace(':userId', userId);
                $.ajax({
                    url: url, // Adjust API URL as necessary
                    type: 'GET',
                    success: function(data) {
                        if (data.success) {
                            var user = data.user;
                            // Check if it's the edit offcanvas or the view modal
                            var isEdit = $('#offcanvasEditUser').hasClass('show');
                            var isModal = $('#modalCenter').hasClass('show');
                            if (isEdit) {
                                $('#edit_first_name').val(user.first_name);
                                $('#edit_last_name').val(user.last_name);
                                $('#edit_email').val(user.email);
                                $('#edit_expiry_date').val(user.expiry_date);
                                $('#edit-user-role').val(user.role).trigger('change');

                                $('.edit-loader').hide();
                                $('#editUserForm').show();
                                // ✅ Set form action dynamically using the route variable
                                var updateUrl = updateUserRoute.replace(':userId', user.id);
                                $('#editUserForm').attr('action', updateUrl);
                            }
                            if (isModal) {
                                // ✅ Update Modal User Info
                                var profileImage = user.profile_image
                                    ? '{{ asset("") }}' + user.profile_image
                                    : '{{ asset("assets/img/default/user.png") }}';
                                $('#user-info img').attr('src', profileImage);
                                $('#user-info .user-info h5').text(user.full_name ? user.full_name :
                                    'N/A');
                                $('#user-info .user-info span.badge').text(user.role ? user.role.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) :
                                    'N/A');

                                var userDetails = `
                                    <li class="mb-2"><span class="h6">{{ __('Username') }}:</span> <span>${user.username ? user.username : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Email') }}:</span> <span>${user.email ? user.email : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Expiry') }}:</span> <span>${user.expiry_date ? new Date(user.expiry_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: '2-digit' }) : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Status') }}:</span> <span>${user.is_active ? user.is_active.replace(/\b\w/g, c => c.toUpperCase()) : 'Inactive'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Designation') }}:</span> <span>${user.designation ? user.designation : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Contact') }}:</span> <span>${user.phone_number ? user.phone_number : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Language') }}:</span> <span>${user.language ? user.language : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Country') }}:</span> <span>${user.country ? user.country : 'N/A'}</span></li>
                                    `;
                                $('#user-info .info-container ul').html(userDetails);

                                // Update Social Media Links
                                var socialLinks = '';
                                if (user.facebook_url) {
                                    socialLinks += `<a href="${user.facebook_url}" target="_blank" style="color: inherit;"><i class="fab fa-facebook fa-lg"></i></a>`;
                                }
                                if (user.linkedin_url) {
                                    socialLinks += `<a href="${user.linkedin_url}" target="_blank" style="color: inherit;"><i class="fab fa-linkedin fa-lg"></i></a>`;
                                }
                                if (user.skype_url) {
                                    socialLinks += `<a href="${user.skype_url}" target="_blank" style="color: inherit;"><i class="fab fa-skype fa-lg"></i></a>`;
                                }
                                if (user.instagram_url) {
                                    socialLinks += `<a href="${user.instagram_url}" target="_blank" style="color: inherit;"><i class="fab fa-instagram fa-lg"></i></a>`;
                                }
                                if (user.github_url) {
                                    socialLinks += `<a href="${user.github_url}" target="_blank" style="color: inherit;"><i class="fab fa-github fa-lg"></i></a>`;
                                }

                                $('#modalSocialIcons').html(socialLinks); // Update social icons container

                                $('.edit-loader').hide();
                                $('#user-info').show();
                            }

                        }
                    },
                    error: function(xhr, status, error) {
                        $('.edit-loader').hide();
                        $('#editUserForm').show();
                        $('#user-info').show();
                        console.error('Error fetching user data:', error);
                    }
                });
            }

            $("#addNewUserForm").on("submit", function() {
                $("#addUserBtn").prop("disabled", true); // Disable button
                $("#addUserLoader").removeClass("d-none"); // Show spinner
            });

            $("#editUserForm").on("submit", function() {
                $("#editUserBtn").prop("disabled", true); // Disable button
                $("#editUserLoader").removeClass("d-none"); // Show spinner
            });
        });
    </script>
@endsection
