@extends('admin.layouts.master', ['title' => 'Countries Management'])


@section('toolbarTitle', 'Countries Management')
@section('toolbarSubTitle', 'Management')
@section('toolbarPage', 'All Countries')
@section('toolbarActions')
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal"
           data-bs-target="#addCountryModal"><i class="ki-outline ki-plus"></i> Add Country</a>

    </div>
@stop

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid mt-5">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text"
                               id="CountrySearchInput" class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search Country">
                    </div>
                    <!--end::Search-->
                </div>

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div id="countries" class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div id="" class="table-responsive">

                        <table id="countries_table" class="table table-row-bordered gy-5">
                            <thead>
                            <tr class="fw-semibold fs-6 text-muted">

                                <th class="">
                                    #
                                </th>


                                <th>Flag</th>
                                <th>Name En</th>
                                <th>Name Ar</th>
                                <th>Coder</th>
                                <th>Number Code</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                            </thead>

                        </table>


                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            </div>

    </div>

            @push('js')

                <link href="{{url('admin/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
                      type="text/css"/>
                <script src="{{url('admin/plugins/custom/datatables/datatables.bundle.js')}}"></script>



                <script>
                    $(document).on('change', '.toggle-status', function () {
                        let status = $(this).is(':checked') ? 1 : 0;
                        let id = $(this).data('id');

                        $.ajax({
                            url: '{{route('admin.management.countries.changeStatus')}}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                status: status
                            },
                            success: function (response) {
                                toastr.success(response.message)
                                $('#countries_table').DataTable().ajax.reload();


                            },
                            error: function () {
                                toastr.error('Something went wrong. Please try again.');
                            }
                        });
                    });
                </script>

                {{--            datatable--}}
                <script>
                    $(document).ready(function () {
                        const table = $('#countries_table').DataTable({
                            processing: true,
                            serverSide: true,
                            order: [[6, 'desc']],

                            ajax: {
                                url: '{{ route('admin.management.countries.data') }}',
                                data: function (d) {
                                    d.search = $('#CountrySearchInput').val();
                                    // d.category_id = $('#category_id').val();
                                }
                            },

                            columns: [

                                {data: 'DT_RowIndex', name: 'id'},

                                {data: 'flag', name: 'flag', orderable: true, searchable: false},
                                {data: 'name.en', name: 'name', orderable: true, searchable: true},
                                {data: 'name.ar', name: 'name', orderable: true, searchable: true},
                                {data: 'code', name: 'code', orderable: true, searchable: true},
                                {data: 'number_code', name: 'number_code', orderable: true, searchable: true},
                                {data: 'status', name: 'status', orderable: true, searchable: true},
                                // {
                                //     data: 'category',
                                //     class: 'text-center',
                                //     name: 'category',
                                //     orderable: true,
                                //     searchable: true
                                // },
                                {data: 'actions', name: 'actions', orderable: false, searchable: false},
                            ],
                            drawCallback: function () {
                                // Re-init dropdowns after DataTable redraw
                                KTMenu.createInstances();
                                bindActionButtons();
                            }

                        });


                        // Search input event
                        $('#CountrySearchInput').on('keyup', function () {
                            table.search(this.value).draw();
                        });


                        function bindActionButtons() {
                            $('.delete-country').off('click').on('click', function (e) {
                                e.preventDefault();
                                const id = $(this).data('id');
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            url: '/admin/countries/' + id,
                                            type: 'DELETE',
                                            data: {
                                                _token: '{{ csrf_token() }}'
                                            },
                                            success: function (response) {
                                                toastr.success('Country deleted successfully');
                                                $('#countries_table').DataTable().ajax.reload();
                                            },
                                            error: function (xhr) {
                                                toastr.error('Error deleting Country', xhr.responseJSON.message || 'An error occurred');
                                            }
                                        });
                                    }
                                });
                            });
                        }
                    });


                </script>


    @include('admin.management.countries.add')
    @include('admin.management.countries.edit')
    @endpush

@stop


