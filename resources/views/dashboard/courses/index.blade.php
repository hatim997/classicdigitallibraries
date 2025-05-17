@extends('layouts.master')

@section('title', __('Courses'))

@section('css')
    <style>
        .edit-loader {
            width: 100%;
        }

        .edit-loader .sk-chase {
            display: block;
            margin: 0 auto;
        }

        .modal-card {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
    </style>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Courses') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Courses List Table -->
        <div class="card">
            <div class="card-header">
                @canany(['create course'])
                    <a href="{{route('dashboard.courses.create')}}" class="add-new btn btn-primary waves-effect waves-light">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                            class="d-none d-sm-inline-block">{{ __('Add New Course') }}</span>
                    </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-json-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Created Date') }}</th>
                            @canany(['delete course', 'update course'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
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
                        url: "{{ route('courses.json') }}",
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
                        { data: 'name', name: 'name' },
                        { data: 'image', name: 'image', orderable: false, searchable: false },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
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
            // var dtTable = $('.custom-json-datatables'),
            //     dt;
            // if (dtTable.length) {
            //     dt = dtTable.DataTable({
            //         dom: '<"row"' +
            //             '<"col-md-2"<l>>' +
            //             '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0"fB>>' +
            //             '>t' +
            //             '<"row"' +
            //             '<"col-sm-12 col-md-6"i>' +
            //             '<"col-sm-12 col-md-6"p>' +
            //             '>',
            //         paging: false, // Disable DataTables pagination
            //         info: false,
            //         language: {
            //             sLengthMenu: 'Show _MENU_',
            //             search: '',
            //             searchPlaceholder: 'Search...',
            //             paginate: {
            //                 next: '<i class="ti ti-chevron-right ti-sm"></i>',
            //                 previous: '<i class="ti ti-chevron-left ti-sm"></i>'
            //             }
            //         },
            //         buttons: [{
            //             extend: 'collection',
            //             className: 'btn btn-label-secondary dropdown-toggle me-4 waves-effect waves-light border-left-0 border-right-0 rounded',
            //             text: '<i class="ti ti-upload ti-xs me-sm-1 align-text-bottom"></i> <span class="d-none d-sm-inline-block">{{__("Export")}}</span>',
            //             buttons: [{
            //                     extend: 'print',
            //                     text: '<i class="ti ti-printer me-1"></i>{{__("Print")}}',
            //                     className: 'dropdown-item',
            //                     exportOptions: {
            //                         columns: ':not(:last-child)' // Exclude the last column (Actions)
            //                     }
            //                 },
            //                 {
            //                     extend: 'csv',
            //                     text: '<i class="ti ti-file-text me-1"></i>{{__("Csv")}}',
            //                     className: 'dropdown-item',
            //                     exportOptions: {
            //                         columns: ':not(:last-child)' // Exclude the last column (Actions)
            //                     }
            //                 },
            //                 {
            //                     extend: 'excel',
            //                     text: '<i class="ti ti-file-spreadsheet me-1"></i>{{__("Excel")}}',
            //                     className: 'dropdown-item',
            //                     exportOptions: {
            //                         columns: ':not(:last-child)' // Exclude the last column (Actions)
            //                     }
            //                 },
            //                 {
            //                     extend: 'pdf',
            //                     text: '<i class="ti ti-file-description me-1"></i>{{__("Pdf")}}',
            //                     className: 'dropdown-item',
            //                     exportOptions: {
            //                         columns: ':not(:last-child)' // Exclude the last column (Actions)
            //                     }
            //                 },
            //                 {
            //                     extend: 'copy',
            //                     text: '<i class="ti ti-copy me-1"></i>{{__("Copy")}}',
            //                     className: 'dropdown-item',
            //                     exportOptions: {
            //                         columns: ':not(:last-child)' // Exclude the last column (Actions)
            //                     }
            //                 }
            //             ]
            //         }],

            //     });
            // }
        });
    </script>
@endsection
