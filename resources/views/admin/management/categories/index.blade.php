@extends('admin.layouts.master', ['title' => 'Categories Management'])


@section('toolbarTitle', 'Categories Management')
@section('toolbarSubTitle', 'Management')
@section('toolbarPage', 'All Categories')
@section('toolbarActions')
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal"
           data-bs-target="#addCategoryModal"><i class="ki-outline ki-plus"></i> Add Category</a>

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
                               id="categorySearchInput" class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search Category">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                {{--                <!--begin::Card toolbar-->--}}
                {{--                <div class="card-toolbar">--}}
                {{--                    <!--begin::Toolbar-->--}}
                {{--                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">--}}
                {{--                        <!--begin::Filter-->--}}
                {{--                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"--}}
                {{--                                data-kt-menu-placement="bottom-end">--}}
                {{--                            <i class="ki-outline ki-filter fs-2"></i>Filter--}}
                {{--                        </button>--}}
                {{--                        <!--begin::Menu 1-->--}}
                {{--                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">--}}
                {{--                            <!--begin::Header-->--}}
                {{--                            <div class="px-7 py-5">--}}
                {{--                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>--}}
                {{--                            </div>--}}
                {{--                            <!--end::Header-->--}}
                {{--                            <!--begin::Separator-->--}}
                {{--                            <div class="separator border-gray-200"></div>--}}
                {{--                            <!--end::Separator-->--}}
                {{--                            <!--begin::Content-->--}}
                {{--                            <div class="px-7 py-5" data-kt-user-table-filter="form">--}}
                {{--                                <!--begin::Input group-->--}}
                {{--                                <div class="mb-10">--}}
                {{--                                    <label class="form-label fs-6 fw-semibold">Role:</label>--}}
                {{--                                    <select class="form-select form-select-solid fw-bold select2-hidden-accessible"--}}
                {{--                                            data-kt-select2="true" data-placeholder="Select option"--}}
                {{--                                            data-allow-clear="true" data-kt-user-table-filter="role"--}}
                {{--                                            data-hide-search="true" data-select2-id="select2-data-7-wp6w" tabindex="-1"--}}
                {{--                                            aria-hidden="true" data-kt-initialized="1">--}}
                {{--                                        <option data-select2-id="select2-data-9-n51m"></option>--}}
                {{--                                        <option value="Administrator">Administrator</option>--}}
                {{--                                        <option value="Analyst">Analyst</option>--}}
                {{--                                        <option value="Developer">Developer</option>--}}
                {{--                                        <option value="Support">Support</option>--}}
                {{--                                        <option value="Trial">Trial</option>--}}
                {{--                                    </select><span class="select2 select2-container select2-container--bootstrap5"--}}
                {{--                                                   dir="ltr" data-select2-id="select2-data-8-bti2" style="width: 100%;"><span--}}
                {{--                                            class="selection"><span--}}
                {{--                                                class="select2-selection select2-selection--single form-select form-select-solid fw-bold"--}}
                {{--                                                role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"--}}
                {{--                                                aria-disabled="false" aria-labelledby="select2-1ovu-container"--}}
                {{--                                                aria-controls="select2-1ovu-container"><span--}}
                {{--                                                    class="select2-selection__rendered" id="select2-1ovu-container"--}}
                {{--                                                    role="textbox" aria-readonly="true" title="Select option"><span--}}
                {{--                                                        class="select2-selection__placeholder">Select option</span></span><span--}}
                {{--                                                    class="select2-selection__arrow" role="presentation"><b--}}
                {{--                                                        role="presentation"></b></span></span></span><span--}}
                {{--                                            class="dropdown-wrapper" aria-hidden="true"></span></span>--}}
                {{--                                </div>--}}
                {{--                                <!--end::Input group-->--}}
                {{--                                <!--begin::Input group-->--}}
                {{--                                <div class="mb-10">--}}
                {{--                                    <label class="form-label fs-6 fw-semibold">Two Step Verification:</label>--}}
                {{--                                    <select class="form-select form-select-solid fw-bold select2-hidden-accessible"--}}
                {{--                                            data-kt-select2="true" data-placeholder="Select option"--}}
                {{--                                            data-allow-clear="true" data-kt-user-table-filter="two-step"--}}
                {{--                                            data-hide-search="true" data-select2-id="select2-data-10-hj6e" tabindex="-1"--}}
                {{--                                            aria-hidden="true" data-kt-initialized="1">--}}
                {{--                                        <option data-select2-id="select2-data-12-unv5"></option>--}}
                {{--                                        <option value="Enabled">Enabled</option>--}}
                {{--                                    </select><span class="select2 select2-container select2-container--bootstrap5"--}}
                {{--                                                   dir="ltr" data-select2-id="select2-data-11-oo6r"--}}
                {{--                                                   style="width: 100%;"><span class="selection"><span--}}
                {{--                                                class="select2-selection select2-selection--single form-select form-select-solid fw-bold"--}}
                {{--                                                role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"--}}
                {{--                                                aria-disabled="false" aria-labelledby="select2-ukb1-container"--}}
                {{--                                                aria-controls="select2-ukb1-container"><span--}}
                {{--                                                    class="select2-selection__rendered" id="select2-ukb1-container"--}}
                {{--                                                    role="textbox" aria-readonly="true" title="Select option"><span--}}
                {{--                                                        class="select2-selection__placeholder">Select option</span></span><span--}}
                {{--                                                    class="select2-selection__arrow" role="presentation"><b--}}
                {{--                                                        role="presentation"></b></span></span></span><span--}}
                {{--                                            class="dropdown-wrapper" aria-hidden="true"></span></span>--}}
                {{--                                </div>--}}
                {{--                                <!--end::Input group-->--}}
                {{--                                <!--begin::Actions-->--}}
                {{--                                <div class="d-flex justify-content-end">--}}
                {{--                                    <button type="reset"--}}
                {{--                                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"--}}
                {{--                                            data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset--}}
                {{--                                    </button>--}}
                {{--                                    <button type="submit" class="btn btn-primary fw-semibold px-6"--}}
                {{--                                            data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply--}}
                {{--                                    </button>--}}
                {{--                                </div>--}}
                {{--                                <!--end::Actions-->--}}
                {{--                            </div>--}}
                {{--                            <!--end::Content-->--}}
                {{--                        </div>--}}
                {{--                        <!--end::Menu 1-->--}}
                {{--                        <!--end::Filter-->--}}
                {{--                    </div>--}}
                {{--                    <!--end::Toolbar-->--}}
                {{--                    <!--begin::Group actions-->--}}
                {{--                    <div class="d-flex justify-content-end align-items-center d-none"--}}
                {{--                         data-kt-user-table-toolbar="selected">--}}
                {{--                        <div class="fw-bold me-5">--}}
                {{--                            <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected--}}
                {{--                        </div>--}}
                {{--                        <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete--}}
                {{--                            Selected--}}
                {{--                        </button>--}}
                {{--                    </div>--}}
                {{--                    <!--end::Group actions-->--}}


                {{--                </div>--}}
                {{--                <!--end::Card toolbar-->--}}
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div id="categories" class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div id="" class="table-responsive">

                        <table id="categories_table" class="table table-row-bordered gy-5">
                            <thead>
                            <tr class="fw-semibold fs-6 text-muted">


                                <th class="">
                                   #
                                </th>
                                <th>Icon</th>

                                <th>Name En</th>
                                <th>Name Ar</th>

                                <th class="text-center">Sub Categories Count</th>
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
                        const table = $('#categories_table').DataTable({
                            processing: true,
                            serverSide: true,
                            order: [[0, 'desc']],

                            ajax: {
                                url: '{{ route('admin.management.categories.data') }}',
                                data: function (d) {
                                    d.search = $('#categorySearchInput').val();
                                }
                            },

                            columns: [

                                {data: 'DT_RowIndex', name: 'id' },

                                {data: 'icon', name: 'icon', orderable: true, searchable: false},
                                {data: 'name.en', name: 'name', orderable: false, searchable: true},
                                {data: 'name.ar', name: 'name'},
                                {
                                    data: 'sub_categories_count',
                                    class: 'text-center',
                                    name: 'sub_categories_count',
                                    orderable: true,
                                    searchable: true
                                },
                                {data: 'actions', name: 'actions', orderable: false, searchable: false},
                            ],
                            drawCallback: function () {


                                // Re-init dropdowns after DataTable redraw
                                KTMenu.createInstances();


                                // Bind delete and edit button events
                                bindActionButtons();


                            }


                        });


                        // Search input event

                        $('#categorySearchInput').on('keyup', function () {
                            table.search(this.value).draw();
                        });

                        function bindActionButtons() {
                            $('.delete-category').off('click').on('click', function (e) {
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
                                            url: '/admin/categories/' + id,
                                            type: 'DELETE',
                                            data: {
                                                _token: '{{ csrf_token() }}'
                                            },
                                            success: function (response) {
                                                toastr.success('Category deleted successfully');
                                                $('#categories_table').DataTable().ajax.reload();
                                            },
                                            error: function (xhr) {
                                                toastr.error('Error deleting category', xhr.responseJSON.message || 'An error occurred');
                                            }
                                        });
                                    }
                                });
                            });
                        }
                    });


                </script>


                @include('admin.management.categories.add')
                @include('admin.management.categories.edit')
            @endpush


@stop


