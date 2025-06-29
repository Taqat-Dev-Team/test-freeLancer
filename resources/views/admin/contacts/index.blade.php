@extends('admin.layouts.master', ['title' => 'Contacts'])


@section('toolbarTitle', 'Contacts  Management')
@section('toolbarSubTitle', 'Contacts')
@section('toolbarPage', 'All Contacts')

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
                               id="ContactSearchInput" class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search Contact">
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

                                <th>Subject</th>
                                <th>Name </th>
                                <th>Email</th>
                                <th>phone</th>
                                <th>Message</th>
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




                {{--            datatable--}}
                <script>
                    $(document).ready(function () {
                        const table = $('#countries_table').DataTable({
                            processing: true,
                            serverSide: true,
                            order: [[6, 'desc']],

                            ajax: {
                                url: '{{ route('admin.contacts.data') }}',
                                data: function (d) {
                                    d.search = $('#ContactSearchInput').val();
                                }
                            },

                            columns: [

                                {data: 'DT_RowIndex', name: 'id'},

                                {data: 'title', name: 'title', orderable: true, searchable: true},
                                {data: 'name', name: 'name', orderable: true, searchable: true},
                                {data: 'email', name: 'email', orderable: true, searchable: true},
                                {data: 'phone', name: 'phone', orderable: true, searchable: true},
                                {data: 'message', name: 'message', orderable: true, searchable: true},
                                {data: 'status', name: 'status', orderable: true, searchable: true},
                                {data: 'actions', name: 'actions', orderable: false, searchable: false},
                            ],
                            drawCallback: function () {
                                // Re-init dropdowns after DataTable redraw
                                KTMenu.createInstances();
                                bindActionButtons();
                            }

                        });


                        // Search input event
                        $('#ContactSearchInput').on('keyup', function () {
                            table.search(this.value).draw();
                        });


                        function bindActionButtons() {
                            $('.delete-contact').off('click').on('click', function (e) {
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
                                            url: '/admin/contacts/' + id,
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


    @endpush

@stop


