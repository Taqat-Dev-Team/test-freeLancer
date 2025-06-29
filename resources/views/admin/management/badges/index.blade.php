@extends('admin.layouts.master', ['title' => 'Badges Management'])


@section('toolbarTitle', 'Badges Management')
@section('toolbarSubTitle', 'Management')
@section('toolbarPage', 'Badges')
@section('toolbarActions')
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal"
           data-bs-target="#addBadgeModal"><i class="ki-outline ki-plus"></i> Add Badge</a>

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
                               id="BadgeSearchInput" class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search Badges">
                    </div>
                    <!--end::Search-->
                </div>

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div id="badge" class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div id="badges" class="table-responsive">

                        <table id="badges_table" class="table table-row-bordered gy-5">
                            <thead>
                            <tr class="fw-semibold fs-6 text-muted">

                                <th class="">#</th>
                                <th>Icon</th>
                                <th>Name En</th>
                                <th>Description EN</th>
                                <th>Name Ar</th>
                                <th>Description Ar</th>
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



                {{--            datatable--}}
                <script>
                    $(document).ready(function () {
                        const table = $('#badges_table').DataTable({
                            processing: true,
                            serverSide: true,
                            order: [[0, 'desc']],

                            ajax: {
                                url: '{{ route('admin.management.badges.data') }}',
                                data: function (d) {
                                    d.search = $('#BadgeSearchInput').val();
                                }
                            },

                            columns: [

                                {data: 'DT_RowIndex', name: 'id'},
                                {data: 'icon', name: 'icon', orderable: false, searchable: false},

                                {data: 'name.en', name: 'name', orderable: true, searchable: true},
                                {data: 'description.en', name: 'description', orderable: true, searchable: true},
                                {data: 'name.ar', name: 'name', orderable: true, searchable: true},
                                {data: 'description.ar', name: 'description', orderable: true, searchable: true},

                                {data: 'actions', name: 'actions', orderable: false, searchable: false},
                            ],
                            drawCallback: function () {
                                // Re-init dropdowns after DataTable redraw
                                KTMenu.createInstances();
                                bindActionButtons();
                            }

                        });


                        // Search input event
                        $('#BadgeSearchInput').on('keyup', function () {
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




    @include('admin.management.badges.add')
    @include('admin.management.badges.edit')
    @endpush

@stop


