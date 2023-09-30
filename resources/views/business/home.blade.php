@extends('business.layouts.master')
@section('title', 'İşletme | Anasayfa')
@section('links')

@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar ">

            <!--begin::Toolbar container-->
            <div class="d-flex flex-stack flex-row-fluid">
                <!--begin::Toolbar wrapper-->
                <div class="d-flex flex-column flex-row-fluid">

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-3">

                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
                            <a href="index.html" class="text-white text-hover-primary">
                                <i class="ki-duotone ki-home text-gray-500 fs-2"></i>                                                    </a>
                        </li>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i>                </li>
                        <!--end::Item-->


                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
                            Dashboards                                    </li>
                        <!--end::Item-->


                    </ul>
                    <!--end::Breadcrumb-->



                    <!--begin::Page title-->
                    <div class="page-title d-flex align-items-center me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-dark fw-bolder fs-1 flex-column justify-content-center my-0">
                            HizliAppy Anasayfa
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Toolbar wrapper-->

                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-3 gap-lg-5">
                    <!--begin::Secondary button-->
                    <div class="m-0">
                        <!--begin::Menu-->
                        <a href="#" class="btn btn-flex btn-sm h-35px h-md-40px btn-light fw-bold px-6" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            History
                        </a>



                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_64f9fd0e45483">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">Filter Options</div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Menu separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Menu separator-->


                            <!--begin::Form-->
                            <div class="px-7 py-5">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-semibold">Status:</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <div>
                                        <select class="form-select form-select-solid" multiple="" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_64f9fd0e45483" data-allow-clear="true">
                                            <option></option>
                                            <option value="1">Approved</option>
                                            <option value="2">Pending</option>
                                            <option value="2">In Process</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-semibold">Member Type:</label>
                                    <!--end::Label-->

                                    <!--begin::Options-->
                                    <div class="d-flex">
                                        <!--begin::Options-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="checkbox" value="1">
                                            <span class="form-check-label">
                                                            Author
                                                        </span>
                                        </label>
                                        <!--end::Options-->

                                        <!--begin::Options-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="2" checked="checked">
                                            <span class="form-check-label">
                                                            Customer
                                                        </span>
                                        </label>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Options-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-semibold">Notifications:</label>
                                    <!--end::Label-->

                                    <!--begin::Switch-->
                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="" name="notifications" checked="">
                                        <label class="form-check-label">
                                            Enabled
                                        </label>
                                    </div>
                                    <!--end::Switch-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>

                                    <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Form-->
                        </div>
                        <!--end::Menu 1-->		<!--end::Menu-->
                    </div>
                    <!--end::Secondary button-->

                    <!--begin::Primary button-->
                    <a href="#" class="btn btn-flex btn-center bg-gray-600 btn-color-white h-35px h-md-40px btn-active-dark btn-sm px-6" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                        <i class="ki-duotone ki-plus-square fs-2 p-0 m-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>		<span class="ms-2">Invite</span>
                    </a>
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->    </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content ">

            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                <!--begin::Col-->
                <div class="col-xxl-6 mb-md-5 mb-xl-10">
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-10">
                        <!--begin::Col-->
                        <div class="col-md-6 col-xl-6 mb-xxl-10">
                            <!--begin::Card widget 8-->
                            <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                                <!--begin::Card body-->
                                <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                    <!--begin::Statistics-->
                                    <div class="mb-4 px-9">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Currency-->
                                            <span class="fs-4 fw-semibold text-gray-400 align-self-start me-1>">$</span>
                                            <!--end::Currency-->


                                            <!--begin::Value-->
                                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1">69,700</span>
                                            <!--end::Value-->

                                            <!--begin::Label-->
                                            <span class="badge badge-light-success fs-base">
                                                                <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                                                2.2%                    </span>

                                            <!--end::Label-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Description-->
                                        <span class="fs-6 fw-semibold text-gray-400">Total Online Sales</span>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Statistics-->

                                    <!--begin::Chart-->
                                    <div id="kt_card_widget_8_chart" class="min-h-auto" style="height: 125px"></div>
                                    <!--end::Chart-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 8-->

                            <!--begin::Card widget 5-->
                            <div class="card card-flush h-md-50 mb-xl-10">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">1,836</span>
                                            <!--end::Amount-->

                                            <!--begin::Badge-->
                                            <span class="badge badge-light-danger fs-base">
                                                            <i class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                                            2.2%
                                                        </span>
                                            <!--end::Badge-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Subtitle-->
                                        <span class="text-gray-400 pt-1 fw-semibold fs-6">Total Sales</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->

                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end pt-0">
                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                            <span class="fw-bolder fs-6 text-dark">1,048 to Goal</span>
                                            <span class="fw-bold fs-6 text-gray-400">62%</span>
                                        </div>

                                        <div class="h-8px mx-3 w-100 bg-light-success rounded">
                                            <div class="bg-success rounded h-8px" role="progressbar" style="width: 62%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 5-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6 col-xl-6 mb-xxl-10">

                            <!--begin::Card widget 9-->
                            <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                                <!--begin::Card body-->
                                <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                    <!--begin::Statistics-->
                                    <div class="mb-4 px-9">
                                        <!--begin::Statistics-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Value-->
                                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1">29,420</span>
                                            <!--end::Value-->

                                            <!--begin::Label-->
                                            <span class="badge badge-light-success fs-base">
                                                                <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                                                2.6%                    </span>

                                            <!--end::Label-->
                                        </div>
                                        <!--end::Statistics-->

                                        <!--begin::Description-->
                                        <span class="fs-6 fw-semibold text-gray-400">Total Online Visitors</span>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Statistics-->

                                    <!--begin::Chart-->
                                    <div id="kt_card_widget_9_chart" class="min-h-auto" style="height: 125px"></div>
                                    <!--end::Chart-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 9-->




                            <!--begin::Card widget 7-->
                            <div class="card card-flush h-md-50 mb-xl-10">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">6.3k</span>
                                        <!--end::Amount-->

                                        <!--begin::Subtitle-->
                                        <span class="text-gray-400 pt-1 fw-semibold fs-6">Total New Customers</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->

                                <!--begin::Card body-->
                                <div class="card-body d-flex flex-column justify-content-end pe-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Today’s Heroes</span>
                                    <!--end::Title-->

                                    <!--begin::Users group-->
                                    <div class="symbol-group symbol-hover flex-nowrap">
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                                            <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                                        </div>
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
                                            <img alt="Pic" src="assets/media/avatars/300-11.jpg">
                                        </div>
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                                            <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                                        </div>
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
                                            <img alt="Pic" src="assets/media/avatars/300-2.jpg">
                                        </div>
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
                                            <span class="symbol-label bg-danger text-inverse-danger fw-bold">P</span>
                                        </div>
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Barry Walter">
                                            <img alt="Pic" src="assets/media/avatars/300-12.jpg">
                                        </div>
                                        <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                                            <span class="symbol-label bg-light text-gray-400 fs-8 fw-bold">+42</span>
                                        </a>
                                    </div>
                                    <!--end::Users group-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 7-->            </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-xxl-6 mb-5 mb-xl-10">
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">Randevu Takvimi</h2>

                                <div class="fs-6 fw-semibold text-muted">2 yaklaşan randevu</div>
                            </div>
                            <!--end::Card title-->

                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body p-9 pt-4">
                            <!--begin::Dates-->
                            <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2">

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_0">

                                        <span class="opacity-50 fs-7 fw-semibold">Su</span>
                                        <span class="fs-6 fw-bolder">21</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary active" data-bs-toggle="tab" href="#kt_schedule_day_1">

                                        <span class="opacity-50 fs-7 fw-semibold">Mo</span>
                                        <span class="fs-6 fw-bolder">22</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_2">

                                        <span class="opacity-50 fs-7 fw-semibold">Tu</span>
                                        <span class="fs-6 fw-bolder">23</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_3">

                                        <span class="opacity-50 fs-7 fw-semibold">We</span>
                                        <span class="fs-6 fw-bolder">24</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_4">

                                        <span class="opacity-50 fs-7 fw-semibold">Th</span>
                                        <span class="fs-6 fw-bolder">25</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_5">

                                        <span class="opacity-50 fs-7 fw-semibold">Fr</span>
                                        <span class="fs-6 fw-bolder">26</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_6">

                                        <span class="opacity-50 fs-7 fw-semibold">Sa</span>
                                        <span class="fs-6 fw-bolder">27</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_7">

                                        <span class="opacity-50 fs-7 fw-semibold">Su</span>
                                        <span class="fs-6 fw-bolder">28</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_8">

                                        <span class="opacity-50 fs-7 fw-semibold">Mo</span>
                                        <span class="fs-6 fw-bolder">29</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_9">

                                        <span class="opacity-50 fs-7 fw-semibold">Tu</span>
                                        <span class="fs-6 fw-bolder">30</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary " data-bs-toggle="tab" href="#kt_schedule_day_10">

                                        <span class="opacity-50 fs-7 fw-semibold">We</span>
                                        <span class="fs-6 fw-bolder">31</span>
                                    </a>
                                </li>
                                <!--end::Date-->
                            </ul>
                            <!--end::Dates-->

                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Day-->
                                <div id="kt_schedule_day_0" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Development Team Capacity Review                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Karina Clarke</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Project Review & Testing                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Yannis Gloverson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Committee Review Approvals                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Caleb Donaldson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Committee Review Approvals                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Sean Bean</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_1" class="tab-pane fade show active">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                16:30 - 17:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Dashboard UI/UX Design Review                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Mark Randall</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                9 Degree Project Estimation Meeting                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Kendell Trevor</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Marketing Campaign Discussion                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Sean Bean</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Project Review & Testing                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Peter Marcus</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                9 Degree Project Estimation Meeting                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Mark Randall</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_2" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Committee Review Approvals                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Yannis Gloverson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Lunch & Learn Catch Up                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">David Stevenson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Project Review & Testing                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Bob Harris</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_3" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Development Team Capacity Review                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Mark Randall</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                9 Degree Project Estimation Meeting                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Terry Robins</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Team Backlog Grooming Session                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Caleb Donaldson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_4" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Marketing Campaign Discussion                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Kendell Trevor</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Project Review & Testing                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Sean Bean</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Committee Review Approvals                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Development Team Capacity Review                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">David Stevenson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_5" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Sales Pitch Proposal                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Dashboard UI/UX Design Review                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">David Stevenson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Dashboard UI/UX Design Review                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Bob Harris</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Weekly Team Stand-Up                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Kendell Trevor</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_6" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Weekly Team Stand-Up                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Project Review & Testing                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">David Stevenson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Committee Review Approvals                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Karina Clarke</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                16:30 - 17:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Creative Content Initiative                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Terry Robins</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Project Review & Testing                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_7" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                16:30 - 17:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Lunch & Learn Catch Up                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Bob Harris</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Development Team Capacity Review                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Mark Randall</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                16:30 - 17:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Marketing Campaign Discussion                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Walter White</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_8" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Weekly Team Stand-Up                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Walter White</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Dashboard UI/UX Design Review                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Caleb Donaldson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                9 Degree Project Estimation Meeting                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Peter Marcus</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Creative Content Initiative                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Bob Harris</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_9" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Lunch & Learn Catch Up                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Bob Harris</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Marketing Campaign Discussion                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Kendell Trevor</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Lunch & Learn Catch Up                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Caleb Donaldson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Project Review & Testing                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Walter White</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_10" class="tab-pane fade show ">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Development Team Capacity Review                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Karina Clarke</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Team Backlog Grooming Session                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Walter White</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        pm                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Team Backlog Grooming Session                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">David Stevenson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Team Backlog Grooming Session                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Terry Robins</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                        am                                    </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                                Lunch & Learn Catch Up                                </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Peter Marcus</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                        <!--end::Card body-->
                    </div>

                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <div class="row">
                <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 align-items-center">
                    <a href="https://apptest.hizlirandevu.com.tr/business/appointment">
                        <div class="widget-stat card ">
                            <div class="card-body rounded p-15" style="background-color: #6a23ff">
                                <h1 class="text-white"><i class="fa fa-calendar-check" style="color:white;font-size: 30px"></i> Randevular</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                    <a href="https://apptest.hizlirandevu.com.tr/business/customer">
                        <div class="widget-stat card">
                            <div class="card-body rounded p-15" style="background-color: #9568ff">
                                <h1 class="text-white"><i class="fa fa-user-circle" style="color:white;font-size: 30px"></i> Müşteriler</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                    <a href="https://apptest.hizlirandevu.com.tr/business/personel">
                        <div class="widget-stat card">
                            <div class="card-body rounded bg-warning p-15">
                                <h1 class="text-white"><i class="fa fa-person" style="color:white;font-size: 30px"></i> Personeller</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                    <a href="https://apptest.hizlirandevu.com.tr/business/businessService">
                        <div class="widget-stat card">
                            <div class="card-body rounded bg-primary p-15">
                                <h1 class="text-white"><i class="fa fa-gear" style="color:white;font-size: 30px"></i> Hizmetler</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                    <a href="https://apptest.hizlirandevu.com.tr/business/product">
                        <div class="widget-stat card">
                            <div class="card-body rounded bg-black p-15">
                                <h1 class="text-white"><i class="fa fa-box-open" style="color:white;font-size: 30px"></i> Ürünler</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                    <a href="https://apptest.hizlirandevu.com.tr/business/gallery">
                        <div class="widget-stat card">
                            <div class="card-body rounded bg-info p-15">
                                <h1 class="text-white"><i class="fa fa-image" style="color:white;font-size: 30px"></i> Galeri</h1>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="card mt-3">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>                <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <div class="card-toolbar">
                                                   <span class="btn" style="background-color: #6a23ff">
                                                        <h3 class="text-white pt-2">Yeni müşterileriniz</h3>
                                                   </span>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-4">

                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1">
                                </div>
                            </th>
                            <th class="min-w-125px">User</th>
                            <th class="min-w-125px">Role</th>
                            <th class="min-w-125px">Last login</th>
                            <th class="min-w-125px">Joined Date</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="view.html">
                                        <div class="symbol-label">
                                            <img src="../../../assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100">
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::User details-->
                                <div class="d-flex flex-column">
                                    <a href="view.html" class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
                                    <span>smith@kpmg.com</span>
                                </div>
                                <!--begin::User details-->
                            </td>
                            <td>
                                Administrator                </td>
                            <td>
                                <div class="badge badge-light fw-bold">Yesterday</div>
                            </td>
                            <td>
                            </td>
                            <td>
                                05 May 2023, 10:30 am                </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i>                    </a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="view.html" class="menu-link px-3">
                                            Edit
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">
                                            Delete
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="view.html">
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">
                                            M                                </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::User details-->
                                <div class="d-flex flex-column">
                                    <a href="view.html" class="text-gray-800 text-hover-primary mb-1">Melody Macy</a>
                                    <span>melody@altbox.com</span>
                                </div>
                                <!--begin::User details-->
                            </td>
                            <td>
                                Analyst                </td>
                            <td>
                                <div class="badge badge-light fw-bold">20 mins ago</div>
                            </td>
                            <td>
                                <div class="badge badge-light-success fw-bold">Enabled</div>
                            </td>
                            <td>
                                22 Sep 2023, 10:30 am                </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i>                    </a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="view.html" class="menu-link px-3">
                                            Edit
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">
                                            Delete
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <!--end::Table-->    </div>
                <!--end::Card body-->
            </div>
        </div>
        <!--end::Content-->

    </div>
@endsection
@section('scripts')

@endsection
