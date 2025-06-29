<div class="modal fade" id="addSkillModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">

        <form id="addSkillForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Skill</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_ar" class="form-label">Arabic Name</label>
                        <input type="text" id="name_ar" name="name_ar" class="form-control"
                               placeholder="Enter Arabic Name">
                    </div>
                    <div class="mb-3">
                        <label for="name_en" class="form-label">English Name</label>
                        <input type="text" id="name_en" name="name_en" class="form-control"
                               placeholder="Enter English Name">
                    </div>


                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="category_id_add" data-control="select2"
                                data-placeholder="Select Category">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}">{{ $category->getTranslation('name', 'en') .' -- ' . $category->getTranslation('name', 'ar') }}</option>
                            @endforeach
                        </select>

                    </div>


                    <div class="mb-3">
                        <label for="icon" class="form-label">Skill Icon</label>
                        <input type="file" name="icon" id="icon" class="form-control" accept="image/*">
                    </div>


                    <div class="d-flex justify-content-center">
                        <div class="symbol symbol-circle symbol-75px overflow-hidden me-3">
                            <div class="symbol-label text-center justify-content-center">
                                <img src="{{ url('logos/favicon.png') }}" id="icon-preview" alt="icon"
                                     class="w-75 h-75 object-fit-cover">
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

        $('#category_id_add').select2({
            dropdownParent: $('#addSkillModal'),
            width: '100%'
        });
        // Clear form and validation errors when the modal is hidden
        $('#addSkillModal').on('hidden.bs.modal', function () {
            $('#addSkillForm')[0].reset(); // Reset form fields
            $('#icon-preview').attr('src', "{{ url('logos/favicon.png') }}"); // Reset image preview
            $('.is-invalid').removeClass('is-invalid'); // Remove invalid classes from inputs
            $('.invalid-feedback').remove(); // Remove error messages
        });

        // Image preview functionality for the icon
        $('#addSkillForm input[name="icon"]').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#icon-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                $('#icon-preview').attr('src', "{{ url('logos/favicon.png') }}");
            }
        });

        // Handle form submission
        $('#addSkillForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);
            const submitButton = $(this).find('button[type="submit"]');

            // Disable the button and show the spinner
            submitButton.attr('disabled', true);
            submitButton.find('.indicator-label').hide();
            submitButton.find('.indicator-progress').show();

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $.ajax({
                url: "{{ route('admin.management.skills.store') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#addSkillModal').modal('hide');
                    toastr.success(response.message || 'Skill added successfully!');
                    $('#skills_table').DataTable().ajax.reload();
                    $('#addSkillForm')[0].reset();
                    $('#icon-preview').attr('src', "{{ url('logos/favicon.png') }}");
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            let inputField = $('#addSkillForm').find(`[name="${key}"]`);
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
