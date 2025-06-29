<div id="kt_app_header" class="app-header" data-kt-sticky="true"
     data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
     data-kt-sticky-animation="false" data-kt-sticky-offset="{default: '0px', lg: '0px'}">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch flex-stack mt-lg-8"
         id="kt_app_header_container">
        <!--begin::Sidebar toggle-->
        <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-1"
                 id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
            <!--begin::Logo image-->
            <a href="index.html">
                <img alt="Logo" src="assets/media/logos/demo55-small.svg" class="h-25px theme-light-show"/>
                <img alt="Logo" src="assets/media/logos/demo55-small-dark.svg" class="h-25px theme-dark-show"/>
            </a>
            <!--end::Logo image-->
        </div>
        <!--end::Sidebar toggle-->
        <!--begin::Navbar-->
        <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
            <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-1 me-lg-0">
            </div>
            <!--begin::Activities-->
            <div class="app-navbar-item ms-1 ms-md-3">
                <!--begin::Menu- wrapper-->
                <div
                    class="btn btn-icon btn-custom btn-color-gray-500 btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px"
                    data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                    data-kt-menu-placement="bottom-end" id="kt_activities_toggle">
                    <i class="ki-outline ki-notification-on fs-2"></i>
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Activities-->
            <!--begin::Chat-->
            <div class="app-navbar-item ms-1 ms-md-3">
                <!--begin::Menu wrapper-->
                <div
                    class="btn btn-icon btn-custom btn-color-gray-500 btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative"
                    id="kt_drawer_chat_toggle">
                    <i class="ki-outline ki-messages fs-2"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge badge-circle badge-custom mt-1 ms-n1">5</span>
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Chat-->
            <!--begin::My apps links-->

            <!--end::My apps links-->

        </div>
        <!--end::Navbar-->
    </div>
    <!--end::Header container-->
</div>
