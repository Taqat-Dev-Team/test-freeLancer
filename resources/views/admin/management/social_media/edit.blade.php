<div class="modal fade" id="editSocialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editSocialForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Social Media</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_social_id" name="id">

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
                            <div id="edit-icon-show" class="my-2"></div>
                        </div>

                        <div class="mb-3">
                            <label for="edit-icon" class="form-label">Social Media Icon (SVG Code)</label>
                            <textarea id="edit-icon" name="icon" class="form-control" rows="5" placeholder="Paste SVG code here..."></textarea>
                            <div class="form-text">
                                You can paste full SVG code directly (e.g., <code>&lt;svg&gt;...&lt;/svg&gt;</code>

                            </div>
                        </div>

                </div>

                <div class="modal-footer">
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
    // عرض أيقونة SVG في div
    function previewSvgIcon(svgCode, targetSelector) {
        const previewBox = $(targetSelector);
        if (svgCode.trim().startsWith('<svg')) {
            previewBox.html(svgCode);
        } else {
            previewBox.empty();
        }
    }

    // عند الضغط على زر التعديل
    $(document).on('click', '.edit-social', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        // إزالة الأخطاء القديمة
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // جلب البيانات من السيرفر
        $.ajax({
            url: `/admin/socials/${id}/show`,
            type: 'GET',
            success: function (response) {
                $('#edit_social_id').val(response.id);
                $('#edit_name_en').val(response.name_en || '');
                $('#edit_name_ar').val(response.name_ar || '');
                $('#edit-icon').val(response.icon || '');

                // عرض الأيقونة القديمة عند فتح المودال
                previewSvgIcon(response.icon || '', '#edit-icon-show');

                $('#editSocialModal').modal('show');
            },
            error: function () {
                toastr.error('Error fetching social media details.');
            }
        });
    });

    // عند الكتابة داخل textarea يتم عرض الأيقونة المحدثة
    $(document).on('input', '#edit-icon', function () {
        const svgCode = $(this).val().trim();
        previewSvgIcon(svgCode, '#edit-icon-show');
    });

    // عند إرسال الفورم
    $('#editSocialForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        const id = $('#edit_social_id').val();
        formData.append('_method', 'PUT');

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        const submitButton = $(this).find('button[type="submit"]');
        submitButton.attr('disabled', true);
        submitButton.find('.indicator-label').hide();
        submitButton.find('.indicator-progress').show();

        $.ajax({
            url: `/admin/socials/${id}`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                toastr.success(response.message || 'Social Media updated successfully!');
                $('#editSocialModal').modal('hide');
                $('#socials_table').DataTable().ajax.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        let inputField = $(`#editSocialForm [name="${key}"]`);
                        if (inputField.length === 0) {
                            let fieldName = key.replace('.', '_');
                            inputField = $(`#editSocialForm [name="${fieldName}"]`);
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
                submitButton.attr('disabled', false);
                submitButton.find('.indicator-label').show();
                submitButton.find('.indicator-progress').hide();
            }
        });
    });
</script>

