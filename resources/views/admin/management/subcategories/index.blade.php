@extends('admin.layouts.master', ['title' => 'Sub Categories Management'])


@section('toolbarTitle', 'Sub Categories Management')
@section('toolbarSubTitle', 'Management')
@section('toolbarPage', 'All Sub Categories')
@section('toolbarActions')
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal"
           data-bs-target="#addSubCategoryModal"><i class="ki-outline ki-plus"></i> Add Sub Category</a>

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
                               id="SubcategorySearchInput" class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search Sub Category">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-filter fs-2"></i>Filter
                        </button>
                        <!--begin::Menu 1-->
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true"
                             id="filterMenu">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                            </div>
                            <!--end::Header-->
                            <div class="separator border-gray-200"></div>
                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Category:</label>
                                    <select multiple name="category_id[]" id="category_id"
                                            class="form-select"
                                            data-control="select2"
                                            data-placeholder="Select an option">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="resetFilters"
                                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                            data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">
                                        Reset
                                    </button>

                                    <button type="button" id="applyFilters"
                                            class="btn btn-primary fw-semibold px-6"
                                            data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">
                                        Apply
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Menu 1-->

                        <!--end::Menu 1-->
                        <!--end::Filter-->
                    </div>
                    <!--end::Toolbar-->

                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div id="Subcategories" class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div id="" class="table-responsive">

                        <table id="sub_categories_table" class="table table-row-bordered gy-5">
                            <thead>
                            <tr class="fw-semibold fs-6 text-muted">


                                <th class="">
                                    #
                                </th>

                                <th>Name En</th>
                                <th>Name Ar</th>

                                <th class="text-center">Category</th>
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
                        const table = $('#sub_categories_table').DataTable({
                            processing: true,
                            serverSide: true,
                            order: [[0, 'desc']],
                            ajax: {
                                url: '{{ route('admin.management.subcategories.data') }}',
                                data: function (d) {
                                    d.search = $('#SubcategorySearchInput').val();
                                    d.category_id = $('#category_id').val();
                                }
                            },



                            columns: [
                                {data: 'DT_RowIndex', name: 'id'},
                                {data: 'name.en', name: 'name', orderable: true, searchable: true},
                                {data: 'name.ar', name: 'name'},
                                {
                                    data: 'category',
                                    class: 'text-center',
                                    name: 'category',
                                    orderable: false,
                                    searchable: true
                                },
                                {data: 'actions', name: 'actions', orderable: false, searchable: false},
                            ],
                            drawCallback: function () {
                                // Re-init dropdowns after DataTable redraw
                                KTMenu.createInstances();
                                bindActionButtons();
                            }

                        });

                        // Apply Filter
                        $('#applyFilters').on('click', function () {
                            $('#sub_categories_table').DataTable().ajax.reload();
                        });

// Reset Filter
                        $('#resetFilters').on('click', function () {
                            $('#category_id').val([]).trigger('change'); // تعيين مصفوفة فارغة بدلاً من null
                            $('#sub_categories_table').DataTable().ajax.reload();
                        });


                        // Search input event
                        $('#SubcategorySearchInput').on('keyup', function () {
                            table.search(this.value).draw();
                        });


                        function bindActionButtons() {
                            $('.delete-subcategory').off('click').on('click', function (e) {
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
                                            url: '/admin/subcategories/' + id,
                                            type: 'DELETE',
                                            data: {
                                                _token: '{{ csrf_token() }}'
                                            },
                                            success: function (response) {
                                                toastr.success('Sub Category deleted successfully');
                                                $('#sub_categories_table').DataTable().ajax.reload();
                                            },
                                            error: function (xhr) {
                                                toastr.error('Error deleting Sub category', xhr.responseJSON.message || 'An error occurred');
                                            }
                                        });
                                    }
                                });
                            });
                        }
                    });


                </script>


    @include('admin.management.subcategories.add')
    @include('admin.management.subcategories.edit')
    @endpush

@stop


