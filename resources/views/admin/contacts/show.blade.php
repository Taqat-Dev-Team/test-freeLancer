@extends('admin.layouts.master', ['title' => 'Contacts'])


@section('toolbarTitle', 'Contacts  Management')
@section('toolbarSubTitle', 'Show')
@section('toolbarPage',$contact->title)

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid mt-5">
        <!--begin::Card-->
        <div class="card">

            <div class="card-body">
                <!--begin::Title-->
                <div class="d-flex flex-wrap gap-2 justify-content-between mb-8">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <!--begin::Heading-->
                        <h2 class="fw-semibold me-3 my-1">{{$contact->title}}</h2>
                        <!--begin::Heading-->
                        <!--begin::Badges-->
                        @if($contact->status==1)
                            <span class="badge badge-light-success my-1 me-2">Read</span>
                        @elseif($contact->status==0)
                            <span class="badge badge-light-danger my-1 me-2">New</span>
                        @else
                            <span class="badge badge-light-info my-1">Replied</span>
                        @endif

                        <!--end::Badges-->
                    </div>

                </div>
                <!--end::Title-->
                <!--begin::Message accordion-->
                <div data-kt-inbox-message="message_wrapper">
                    <!--begin::Message header-->
                    <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                        <!--begin::Author-->
                        <div class="d-flex align-items-center">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50 me-4">
                                <span class="symbol-label"
                                      style="background-image:url({{url('logos/favicon.png')}});"></span>
                            </div>
                            <!--end::Avatar-->
                            <div class="pe-5">
                                <!--begin::Author details-->
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    <a href="#" class="fw-bold text-gray-900 text-hover-primary">{{$contact->name}}</a>
                                    {{--                                    <i class="ki-outline ki-abstract-8 fs-7 text-success mx-3"></i>--}}
                                    <span class="text-muted fw-bold  mx-3">{{$contact->email}}</span>
                                    <span class="text-muted fw-bold">{{$contact->created_at->diffForHumans()}}</span>
                                </div>
                                <!--end::Author details-->
                                <!--begin::Message details-->
                                <div data-kt-inbox-message="details">
                                    <span class="text-muted fw-semibold">to me</span>
                                    <!--begin::Menu toggle-->
                                    <a href="#" class="me-1" data-kt-menu-trigger="click"
                                       data-kt-menu-placement="bottom-start">
                                        <i class="ki-outline ki-down fs-5 m-0"></i>
                                    </a>
                                    <!--end::Menu toggle-->
                                    <!--begin::Menu-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4"
                                        data-kt-menu="true">
                                        <!--begin::Table-->
                                        <table class="table mb-0">
                                            <tbody>
                                            <tr>
                                                <td class="w-75px text-muted">From</td>
                                                <td>{{$contact->name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Date</td>
                                                <td>{{$contact->created_at->format('d M Y , h:i a')}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Subject</td>
                                                <td>{{$contact->title}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Reply-to</td>
                                                <td>{{$contact->email}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Message details-->
                                <!--begin::Preview message-->
                                <div class="text-muted fw-semibold mw-450px d-none" data-kt-inbox-message="preview">
                                    {{\Illuminate\Support\Str::limit($contact->message,80)}}
                                </div>
                                <!--end::Preview message-->
                            </div>
                        </div>
                        <!--end::Author-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <!--begin::Date-->
                            <span
                                class="fw-semibold text-muted text-end me-3">{{$contact->created_at->format('d M Y , h:i a')}}</span>

                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Message header-->
                    <!--begin::Message content-->
                    <div class="collapse fade show" data-kt-inbox-message="message">
                        <div class="py-5">

                            <p>
                                {!! $contact->message !!}
                            </p>
                        </div>
                    </div>
                    <!--end::Message content-->
                </div>
                <!--end::Message accordion-->
                <div class="separator my-6"></div>

                @if($contact->reply)
                    <!--begin::Message accordion-->
                    <div data-kt-inbox-message="message_wrapper">
                        <!--begin::Message header-->
                        <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                            <!--begin::Author-->
                            <div class="d-flex align-items-center">
                                <!--begin::Avatar-->

                                <!--end::Avatar-->
                                <div class="pe-5">
                                    <!--begin::Author details-->
                                    <div class="d-flex align-items-center flex-wrap gap-1">
                                        <a href="#" class="fw-bold text-gray-900 text-hover-primary">Reply</a>
                                        <i class="ki-duotone ki-abstract-8 fs-7 text-success mx-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <span
                                            class="text-muted fw-bold">{{$contact->reply->created_at->diffForHumans()}}</span>

                                    </div>
                                    <!--end::Author details-->
                                    <!--begin::Message details-->
                                    <div class="d-none" data-kt-inbox-message="details">
                                        <span class="text-muted fw-semibold">to me</span>
                                        <!--begin::Menu toggle-->
                                        <a href="#" class="me-1" data-kt-menu-trigger="click"
                                           data-kt-menu-placement="bottom-start">
                                            <i class="ki-duotone ki-down fs-5 m-0"></i>
                                        </a>
                                        <!--end::Menu toggle-->

                                    </div>
                                    <!--end::Message details-->
                                    <!--begin::Preview message-->
                                    <div class="text-muted fw-semibold mw-1000px p-5" data-kt-inbox-message="preview">
                                        {!! $contact->reply->text!!}
                                    </div>
                                    <!--end::Preview message-->
                                </div>
                            </div>
                            <!--end::Author-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <!--begin::Date-->
                                <span class="fw-semibold text-muted text-end me-3">20 Dec 2025, 11:05 am</span>
                                <!--end::Date-->

                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Message header-->
                    </div>
                    <!--end::Message accordion-->

                @else

                    <form id="replyForm" method="post" action="{{ route('admin.contacts.reply', $contact->id) }}">
                        @csrf
                    </form>

                    <div id="kt_docs_quill_autosave" style="height: 200px;"></div>

                    <div class="modal-footer p-2">
                        <button type="button" id="sendReplyBtn" class="btn btn-primary">
                            <span class="indicator-label">Send</span>
                            <span class="indicator-progress d-none">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
                        </button>
                    </div>
                @endif


            </div>

        </div>
    </div>
    @push('js')

        <script>
            $('#sendReplyBtn').on('click', function (e) {
                e.preventDefault();

                let btn = $(this);
                let form = $('#replyForm');
                let url = form.attr('action');
                let token = $('input[name="_token"]').val();
                let content = quill.root.innerHTML;
                let plainText = quill.getText().trim();

                // تحقق من أن النص ليس فارغًا
                if (plainText.length === 0) {
                    Swal.fire('Alert', 'Please write a reply before sending', 'warning');
                    return;
                }

                // Show loading
                btn.prop('disabled', true);
                btn.find('.indicator-label').addClass('d-none');
                btn.find('.indicator-progress').removeClass('d-none');

                btn.find('.indicator-progress').show();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _token: token,
                        reply: content,
                    },
                    success: function (response) {
                        Swal.fire('Sent', 'Reply sent successfully', 'success');
        setTimeout(function() { location.reload(); }, 1000);
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'An error occurred while sending', 'error');
                    },
                    complete: function () {
                        // Reset button state
                        btn.prop('disabled', false);
                        btn.find('.indicator-label').removeClass('d-none');
                        btn.find('.indicator-progress').addClass('d-none');
                    }
                });
            });
        </script>

        <script>

            var Delta = Quill.import('delta');
            var quill = new Quill('#kt_docs_quill_autosave', {
                modules: {
                    toolbar: [
                        [{'size': ['small', false, 'large', 'huge']}],
                        [{'header': [1, 2, 3, false]}],
                        [{'color': []}, {'background': []}], //
                        ['bold', 'italic', 'underline', 'strike'],
                        [{'list': 'ordered'}, {'list': 'bullet'}],
                        [{'align': []}],
                        ['link', 'image'],
                        ['clean']
                    ]
                },
                placeholder: 'Type your reply...',
                theme: 'snow',
            });


            quill.on('text-change', function (delta) {
                change = change.compose(delta);
            });
            setInterval(function () {
                if (change.length() > 0) {
                    console.log('Saving changes', change);
                    change = new Delta();
                }
            }, 5 * 1000);
            window.onbeforeunload = function () {
                if (change.length() > 0) {
                    return 'There are unsaved changes. Are you sure you want to leave?';
                }
            }


        </script>

    @endpush

@stop


