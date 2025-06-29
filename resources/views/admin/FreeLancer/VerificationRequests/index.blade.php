@extends('admin.layouts.master', ['title' => 'Freelancer Verification Requests'])


@section('toolbarTitle', 'Freelancer Verification Requests')
@section('toolbarSubTitle', 'Freelancers ')
@section('toolbarPage', 'Freelancer Verification Requests')

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
                               id="FreelancerSearchInput" class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search Freelancer">
                    </div>
                    <!--end::Search-->
                </div>

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div id="" class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div id="freelancers" class="table-responsive">

                        <table id="freelancers_table" class="table table-row-bordered gy-5">
                            <thead>
                            <tr class="fw-semibold fs-6 text-muted">

                                <th class="">#</th>
                                <th class="min-w-125px">photo</th>
                                <th  class="min-w-125px">name</th>
                                <th  class="min-w-125px">email</th>
                                <th  class="min-w-125px">mobile</th>
                                <th  class="">Joined Date</th>
                                <th  class="min-w-125px">Options</th>
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



        {{--            datatable--}}
        <script>
            $(document).ready(function () {
                const table = $('#freelancers_table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],

                    ajax: {
                        url: '{{ route('admin.freelancers.request.data') }}',
                        data: function (d) {
                            d.search = $('#FreelancerSearchInput').val();
                        }
                    },

                    columns: [

                        {data: 'DT_RowIndex', name: 'id'},
                        {data: 'photo', name: 'photo', orderable: false, searchable: false},

                        {data: 'name', name: 'user.name', orderable: true, searchable: true},
                        {data: 'email', name: 'user.email', orderable: true, searchable: true},
                        {data: 'mobile', name: 'user.mobile', orderable: true, searchable: true},
                        {data: 'date', name: 'user.created_at', orderable: true, searchable: false},
                        {data: 'actions', name: 'user.actions', orderable: false, searchable: false},
                    ],
                    drawCallback: function () {
                        // Re-init dropdowns after DataTable redraw
                        KTMenu.createInstances();
                        bindActionButtons();
                    }

                });


                // Search input event
                $('#FreelancerSearchInput').on('keyup', function () {
                    table.search(this.value).draw();
                });


                function bindActionButtons() {
                    $('.delete-badge').off('click').on('click', function (e) {
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
                                    url: '/admin/badges/' + id,
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                        toastr.success('Badge deleted successfully');
                                        $('#badges_table').DataTable().ajax.reload();
                                    },
                                    error: function (xhr) {
                                        toastr.error('Error deleting Badge', xhr.responseJSON.message || 'An error occurred');
                                    }
                                });
                            }
                        });
                    });
                }
            });


        </script>

        @include('admin.FreeLancer.VerificationRequests.view')

    @endpush


@stop


