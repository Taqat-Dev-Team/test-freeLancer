<div class="modal fade" id="editSkillModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editSkillForm" enctype="multipart/form-data">
            @csrf
            {{-- @method('PUT') is handled via formData.append('_method', 'PUT') in JS for AJAX --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Skill</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_skill_id" name="id">

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
                                <option
                                    value="{{ $category->id }}">{{ $category->getTranslation('name', 'en') .' -- ' . $category->getTranslation('name', 'ar') }}</option>
                            @endforeach
                        </select>

                        <div class="mb-3">
                            <label for="edit_icon_file" class="form-label">Skill Icon</label>
                            <input type="file" name="icon" id="edit_icon_file" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Leave empty to keep current icon.</small>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="symbol symbol-circle symbol-75px overflow-hidden me-3">
                                <div class="symbol-label text-center justify-content-center">
                                    {{-- The 'data-original-src' stores the current icon path for fallback --}}
                                    <img src="" id="edit-icon-preview" alt="Category Icon"
                                         class="w-75 h-75 object-fit-cover" data-original-src="">
                                </div>
                            </div>
                        </div>

                    </div>
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

        // Event listener for opening the edit modal and populating data
        $(document).on('click', '.edit-skill', function (e) {
            e.preventDefault();
            const id = $(this).data('id');

            // Clear previous validation errors before fetching data
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $.ajax({
                url: `/admin/skills/${id}/show`, // Use your existing show route
                type: 'GET',
                success: function (response) {
                    // Populate the form fields
                    $('#edit_skill_id').val(response.id);
                    $('#edit_category_id').val(response.category_id).trigger('change'); // Set category and trigger change for select2
                    $('#edit_name_en').val(response.name_en || '');
                    $('#edit_name_ar').val(response.name_ar || '');
                    $('#edit_icon_file').val('');
                    const currentIconUrl = response.icon ? response.icon : '{{ url('logos/favicon.png') }}'; // Use response.icon directly
                    $('#edit-icon-preview').attr('src', currentIconUrl);
                    $('#edit-icon-preview').data('original-src', currentIconUrl); // Store for resetting preview
                    $('#editSkillModal').modal('show');
                },
                error: function (xhr) {
                    toastr.error('Error fetching Skill details.');
                }
            });
        });

        // Icon preview for edit form (remains the same)
        $('#edit_icon_file').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#edit-icon-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                // If no new file is selected, revert to the current stored icon or default
                const currentIconUrl = $('#edit-icon-preview').data('original-src') || '{{ url('logos/favicon.png') }}';
                $('#edit-icon-preview').attr('src', currentIconUrl);
            }
        });

        // Submit handler for the edit form (remains largely the same, but review error mapping for translatable fields)
        $('#editSkillForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            const id = $('#edit_skill_id').val();
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
                url: `/admin/skills/${id}`, // RESTful route for 'update'
                type: 'POST', // Method must be POST for FormData with _method override
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    toastr.success(response.message || 'Skill updated successfully!');
                    $('#editSkillModal').modal('hide');
                    $('#skills_table').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 422) { // Laravel validation errors
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            let inputField = $(`#editSkillForm [name="${key}"]`);
                            if (inputField.length === 0) {
                                let fieldName = key.replace('.', '_');
                                inputField = $(`#editSkillForm [name="${fieldName}"]`);
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
