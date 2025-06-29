
@if( !request()->routeIs('admin.dashboard') )
<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
    <!--begin::Page title-->
    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">@yield('toolbarTitle')</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Home</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">@yield('toolbarSubTitle')</li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">@yield('toolbarPage')</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->


    <!--begin::Actions-->
    @yield('toolbarActions')


    <!--end::Actions-->
</div>

@endif
