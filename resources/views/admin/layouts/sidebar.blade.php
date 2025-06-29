<div id="kt_app_sidebar" class="app-sidebar flex-column mt-lg-4 ps-2 pe-2 ps-lg-7 pe-lg-4"
     data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
     data-kt-drawer-width="250px" data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <div class="app-sidebar-logo flex-shrink-0 d-none d-lg-flex flex-center align-items-center"
         id="kt_app_sidebar_logo">
        <a href="{{ url('/') }}">
            <img alt="Logo" src="{{ asset('logos/logo.png') }}"
                 class="h-75px d-none d-sm-inline app-sidebar-logo-default theme-light-show"/>
            <img alt="Logo" src="{{ asset('logos/white.png') }}" class="h-40px theme-dark-show"/>
        </a>
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-1"></i>
            </div>
        </div>
    </div>
    <div class="app-sidebar-menu flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="hover-scroll-overlay-y my-5" data-kt-scroll="true"
             data-kt-scroll-activate="true" data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
             data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
            <div class="menu menu-column menu-rounded menu-sub-indention fw-bold px-6"
                 id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click"
                     class="menu-item {{ request()->routeIs('admin.dashboard') ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-category fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active':'' }}"
                               href="{{ route('admin.dashboard') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Home</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click"
                     class="menu-item {{ request()->routeIs('admin.freelancers*') ? 'here show' : '' }} menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="ki-outline ki-profile-user fs-2"></i>
        </span>
        <span class="menu-title">FreeLancers</span>
        <span class="menu-arrow"></span>
    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.freelancers.request.index') ? 'active' : '' }}"
                               href="{{ route('admin.freelancers.request.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title ">Identity Checks</span>
{{--                                @if(IdentityRequestsCount() > 0)--}}
{{--                                    <span class="menu-badge  justify-content-end">--}}
{{--                                        <span class="badge badge-light-primary ms-2">--}}
{{--                                            {{ IdentityRequestsCount() }}--}}
{{--                                        </span>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
                            </a>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click"
                     class="menu-item {{ request()->routeIs('admin.management*') ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-setting fs-2"></i>
                        </span>
                        <span class="menu-title">Management</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">

                        <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion {{ request()->routeIs('admin.management.categories.*') || request()->routeIs('admin.management.subcategories.*') || request()->routeIs('admin.management.skills.*')? 'here show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Categories & Skills</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.management.categories.*') ? 'active': ''}} "
                                       href="{{ route('admin.management.categories.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Categories</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.management.subcategories.*') ? 'active': ''}}"
                                       href="{{ route('admin.management.subcategories.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Sub Categories</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.management.skills.*') ? 'active': ''}}"
                                       href="{{ route('admin.management.skills.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Skills</span>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.management.countries.*')? 'active' : '' }}"
                               href="{{ route('admin.management.countries.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Countries</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.management.educations.*')? 'active' : '' }}"
                               href="{{ route('admin.management.educations.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Educations Levels</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.management.socials.*')? 'active' : '' }}"
                               href="{{ route('admin.management.socials.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Social Media</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.management.badges.*')? 'active' : '' }}"
                               href="{{ route('admin.management.badges.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Badges</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.management.languages.*')? 'active' : '' }}"
                               href="{{ route('admin.management.languages.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Languages</span>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="menu-item {{ request()->routeIs('admin.contacts.*') ? 'here show' : '' }}">
                    <a class="menu-link {{ request()->routeIs('admin.contacts.*')? 'active':'' }}"
                       href="{{ route('admin.contacts.index') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-message-text-2 fs-2 {{ request()->routeIs('admin.contacts.*')? 'text-white':'' }}"></i>
                        </span>

                        <span
                            class="menu-title {{ request()->routeIs('admin.contacts.*')? 'text-white':'' }}">Contacts</span>
                        @if(unreadContactsCount()>0)
                            <span class="menu-badge">
                                <span class="badge badge-light-danger ms-2">
                                    {{unreadContactsCount()}}
                                </span>
                                @endif
                            </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-sidebar-footer d-flex align-items-center px-8 pb-10" id="kt_app_sidebar_footer">
        <div class="">
            <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                 data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
                <div class="d-flex flex-center cursor-pointer symbol symbol-circle symbol-40px">
                    <img src="{{ asset(auth('admin')->user()->getImageUrl()) }}" alt="image"/>
                </div>
                <div class="d-flex flex-column align-items-start justify-content-center ms-3">
                    <span class="text-gray-500 fs-8 fw-semibold">Hello</span>
                    <a href="{{ route('admin.profile') }}"
                       class="text-gray-800 fs-7 fw-bold text-hover-primary">{{ auth('admin')->user()->name }}</a>
                </div>
            </div>
            <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                data-kt-menu="true">
                <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                        <div class="symbol symbol-50px me-5">
                            <img alt="Logo" src="{{ asset(auth('admin')->user()->getImageUrl()) }}"/>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="fw-bold d-flex align-items-center fs-5">{{ auth('admin')->user()->name }}
                                @forelse(auth('admin')->user()->roles as $role)
                                    <span
                                        class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-1">{{ $role->display_name }}</span>
                                @empty
                                    <span class="text-muted fs-8">No roles assigned</span>
                                @endforelse
                            </div>
                            <a href="{{ auth('admin')->user()->email }}"
                               class="fw-semibold text-muted text-hover-primary fs-7">{{ auth('admin')->user()->email }}</a>
                        </div>
                    </div>
                </div>
                <div class="separator my-2"></div>
                <div class="menu-item px-5">
                    <a href="{{ route('admin.profile') }}" class="menu-link px-5">
                        <span class="menu-title position-relative">My Profile
                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                <i class="ki-outline ki-user theme-light-show fs-2"></i>
                                <i class="ki-outline ki-user theme-dark-show fs-2"></i>
                            </span>
                        </span>
                    </a>
                </div>
                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                     data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                    <a href="#" class="menu-link px-5">
                        <span class="menu-title position-relative">Mode
                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                            </span>
                        </span>
                    </a>
                    <div
                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon"><i
                                        class="ki-outline ki-night-day fs-2"></i></span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon"><i
                                        class="ki-outline ki-moon fs-2"></i></span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon"><i class="ki-outline ki-screen fs-2"></i></span>
                                <span class="menu-title">System</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="menu-item px-5">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="menu-link px-5 btn btn-active-light-danger w-100 text-start">
                            <span class="menu-title position-relative">Sign Out
                                <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                    <i class="ki-outline ki-exit-right theme-dark-show fs-2"></i>
                                    <i class="ki-outline ki-exit-right theme-light-show fs-2"></i>
                                </span>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
