<div class="modal fade" id="editSubCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editSubCategoryForm" >
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_subcategory_id" name="id">

                    <div class="mb-3">
                        <label for="edit_name_ar" class="form-label">Arabic Name</label>
                        <input type="text" id="edit_name_ar" name="name_ar" class="form-control"
                               placeholder="Arabic Name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_name_en" class="form-label">English Name</label>
                        <input type="text" id="edit_name_en" name="name_en" class="form-control"
                               placeholder="English Name">
                    </div>

                    <div class="mb-3">
                        <label for="edit_category_id" class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="edit_category_id" data-control="select2"
                                data-placeholder="Select Category">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->getTranslation('name', 'en') .' -- ' . $category->getTranslation('name', 'ar') }}</option>
                            @endforeach
                        </select>

                    </div>


                    <div class=" modal-footer">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <span class="indicator-label">Save changes</span>
                            <span class="indicator-progress">Please wait...
                                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    </div>


                </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#edit_category_id').select2({
            dropdownParent: $('#editSubCategoryModal'),
            width: '100%'
        });
        // Event listener for opening the edit modal and populating data
        $(document).on('click', '.edit-subcategory', function (e) {
            e.preventDefault();
            const id = $(this).data('id');

            // Clear previous validation errors before fetching data
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $.ajax({
                url: `/admin/subcategories/${id}/show`, // Use your existing show route
                type: 'GET',
                success: function (response) {
                    // Populate the form fields
                    $('#edit_subcategory_id').val(response.id);
                    $('#edit_category_id').val(response.category_id).trigger('change'); // Set category and trigger change for select2
                    // Access name_en and name_ar directly from response
                    $('#edit_name_en').val(response.name_en || '');
                    $('#edit_name_ar').val(response.name_ar || '');
                    $('#editSubCategoryModal').modal('show');
                },
                error: function (xhr) {
                    toastr.error('Error fetching category details.');
                }
            });
        });



        // Submit handler for the edit form (remains largely the same, but review error mapping for translatable fields)
        $('#editSubCategoryForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            const id = $('#edit_subcategory_id').val();
            formData.append('_method', 'PUT'); // For PUT request with FormData

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            const submitButton = $(this).find('button[type="submit"]');

            // Disable the button and show the spinner
            submitButton.attr('disabled', true);
            submitButton.find('.indicator-label').hide();
            submitButton.find('.indicator-progress').show();


            $.ajax({
                url: `/admin/subcategories/${id}`, // RESTful route for 'update'
                type: 'POST', // Method must be POST for FormData with _method override
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    toastr.success(response.message || 'Sub Category updated successfully!');
                    $('#editSubCategoryModal').modal('hide');
                    $('#sub_categories_table').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 422) { // Laravel validation errors
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            let inputField = $(`#editSubCategoryForm [name="${key}"]`);
                            if (inputField.length === 0) {
                                let fieldName = key.replace('.', '_');
                                inputField = $(`#editSubCategoryForm [name="${fieldName}"]`);
                            }

                            inputField.addClass('is-invalid');
                            let errorMessage = `<div class="invalid-feedback d-block">${value[0]}</div>`;
                            inputField.after(errorMessage);
                        });
                        toastr.error('Please correct the errors in the form.');
                    } else {
                        toastr.error('An unexpected error occurred. Please try again.');
                    }
                },
                complete: function () {
                    // Re-enable the button and hide the spinner
                    submitButton.attr('disabled', false);
                    submitButton.find('.indicator-label').show();
                    submitButton.find('.indicator-progress').hide();
                }
            });
        });
    });
</script>
