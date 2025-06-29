<div class="modal fade" id="ViewRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Identity Verification Request</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <div class="modal-body">

                <div class="mb-5 text-center">
                    <img src="" id="view-photo-preview" alt="Freelancer photo"
                         class="rounded-circle border shadow-sm"
                         style="width: 100px; height: 100px; object-fit: cover;">
                </div>

                <div class="row m-2">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control form-control-solid" id="view-name" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="text" class="form-control form-control-solid" id="view-email" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Mobile</label>
                        <input type="text" class="form-control form-control-solid" id="view-mobile" readonly>
                    </div>
                </div>


                <div class="row m-2">

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Joined Date</label>
                        <input type="text" class="form-control form-control-solid" id="view-joined-date" readonly>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Verification Request Date</label>
                        <input type="text" class="form-control form-control-solid" id="view-request-date" readonly>
                    </div>
                </div>


                <div class="row m-2">

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">First Name</label>
                        <input class="form-control form-control-solid" id="view-request-first_name" readonly>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Father Name</label>
                        <input type="text" class="form-control form-control-solid" id="view-request-father_name"
                               readonly>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Grandfather Name</label>
                        <input type="text" class="form-control form-control-solid" id="view-request-grandfather_name"
                               readonly>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Family Name</label>
                        <input type="text" class="form-control form-control-solid" id="view-request-family_name"
                               readonly>
                    </div>
                </div>

                <div class="row m-2">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">ID Number</label>
                        <input type="text" class="form-control form-control-solid" id="view-request-id_number" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Full Address</label>
                        <input type="text" class="form-control form-control-solid" id="view-request-full_address"
                               readonly>
                    </div>
                </div>


                <div class="row m-2">
                    <div class="mb-5 text-center mt-5">
                        <label class="form-label fw-semibold">ID Image</label>
                        <div>
                            <a href="" id="id-link" target="_blank">
                                <img src="" id="view-id-image-preview" alt="ID Image"
                                     class="border shadow-sm rounded"
                                     style="width: 200px; height: 130px; object-fit: cover;">
                            </a>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary verify-action-btn"
                                data-id="" data-action="accept">
                            <span class="indicator-label">Accept</span>
                            <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
                        </button>

                        <button type="button" class="btn btn-light-warning verify-action-btn"
                                data-id="" data-action="reject">
                            <span class="indicator-label">Reject</span>
                            <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
                        </button>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </div>

            </div>
        </div>
    </div>


</div>

<script>
    $(document).ready(function () {

        // عند الضغط على زر عرض الطلب
        $(document).on('click', '.view-request', function (e) {

            $('#ViewRequestModal').modal({
                backdrop: 'static',
                keyboard: false,
                focus: false // 👈 هنا المفتاح
            });

            e.preventDefault();

            const id = $(this).data('id');

            // تنظيف المودال من البيانات السابقة
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $.ajax({
                url: `/admin/freelancer/verification-request/${id}/show`,
                type: 'GET',
                success: function (response) {

                    // بيانات المستخدم
                    $('#view-photo-preview').attr('src', response.user.photo || '');
                    $('#view-photo-preview').attr('data-original-src', response.user.photo || '');
                    $('#view-name').val(response.user.name || '');
                    $('#view-email').val(response.user.email || '');
                    $('#view-mobile').val(response.user.mobile || '');
                    $('#view-joined-date').val(response.user.created_at || '');

                    // بيانات التحقق
                    $('#view-verification-status').val(response.identity_verification.status || '');
                    $('#view-request-date').val(response.identity_verification.created_at || '');
                    $('#view-request-first_name').val(response.identity_verification.first_name || '');
                    $('#view-request-father_name').val(response.identity_verification.father_name || '');
                    $('#view-request-grandfather_name').val(response.identity_verification.grandfather_name || '');
                    $('#view-request-family_name').val(response.identity_verification.family_name || '');
                    $('#view-request-id_number').val(response.identity_verification.id_number || '');
                    $('#view-request-full_address').val(response.identity_verification.full_address || '');

                    // صورة الهوية
                    $('#view-id-image-preview').attr('src', response.identity_verification.id_image || '');
                    $('#view-id-image-preview').attr('data-original-src', response.identity_verification.id_image || '');

                    $('#id-link').attr('href', response.identity_verification.id_image || '');
                    $('.verify-action-btn').attr('data-id', id);
                    // عرض المودال
                    $('#ViewRequestModal').modal('show');

                },
                error: function (xhr) {
                    toastr.error('Error fetching verification request details.');
                }
            });
        });


    });
</script>

<script>
    $(document).on('click', '.verify-action-btn', function () {
        const id = $(this).data('id');
        const action = $(this).data('action');
        const button = $(this);

        if (action === 'reject') {
            Swal.fire({
                title: 'Reject Verification',
                input: 'textarea',
                inputLabel: 'Rejection Reason',
                inputPlaceholder: 'Enter the reason for rejection...',
                inputAttributes: {
                    'aria-label': 'Rejection Reason'
                },
                showCancelButton: true,
                confirmButtonText: 'Reject',
                cancelButtonText: 'Cancel',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Please enter a rejection reason');
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    sendVerificationAction(id, action, result.value, button);
                }
            });
        } else {
            sendVerificationAction(id, action, null, button);
        }
    });

    function sendVerificationAction(id, action, reason, button) {
        button.attr('disabled', true);
        button.find('.indicator-label').hide();
        button.find('.indicator-progress').show();
        $('#ViewRequestModal').modal('hide');

        $.ajax({
            url: `/admin/freelancer/verification-request/${id}/${action}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                reason: reason
            },

            beforeSend: function () {
                Swal.fire({
                    icon: 'info',
                    title: 'Processing Request',
                    text: 'Please wait while we process your request...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },

            success: function (response) {
                Swal.close(); // <-- إغلاق السويت ألرت بعد النجاح
                toastr.success(response.message || 'Action completed successfully.');
                $('#ViewRequestModal').modal('hide');
            },
            error: function () {
                Swal.close(); // <-- إغلاق السويت ألرت في حال الخطأ أيضًا
                toastr.error('An error occurred while performing the action.');
            },
            complete: function () {
                button.attr('disabled', false);
                button.find('.indicator-label').show();
                button.find('.indicator-progress').hide();
                $('#freelancers_table').DataTable().ajax.reload();
            }
        });
    }
</script>
