<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <title>HizliAppy</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <link rel="canonical" href="">
    <link rel="shortcut icon" href="">

    <link href="/business_admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css">
    <link href="/business_admin/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css">

    <link href="/business_admin/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">
    <link href="/business_admin/assets/css/style.bundle.css" rel="stylesheet" type="text/css">
    <link href="/business_admin/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.14.1/dist/sweetalert2.min.css">
    <style>
        .swal2-popup{
            font-size: 1.2rem;
            font-weight: 600;
        }
        .swal2-popup.swal2-toast .swal2-title {
            flex-grow: 1;
            justify-content: flex-start;
            margin: 0 0.6em;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .swal2-popup.swal2-toast {
            border-radius: 15px;
            box-sizing: border-box;
            grid-column: 1/4!important;
            grid-row: 1/4!important;
            grid-template-columns: min-content auto min-content;
            padding: 1em;
            overflow-y: hidden;
            background: #fff;
            box-shadow: 0 0 1px hsla(0,0%,0%,.075), 0 1px 2px hsla(0,0%,0%,.075), 1px 2px 4px hsla(0,0%,0%,.075), 1px 3px 8px hsla(0,0%,0%,.075), 2px 4px 16px hsla(0,0%,0%,.075);
            pointer-events: all;
        }
    </style>
</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
<!--begin::Theme mode-->
<script>
    var defaultThemeMode = "light";
    var themeMode;

    if ( document.documentElement ) {
        if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if ( localStorage.getItem("data-bs-theme") !== null ) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }

        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }

        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>
<!--end::Theme mode -->
<!--begin::Page-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url('/business_admin/assets/media/auth/bg10.jpeg');
        }

        [data-bs-theme="dark"] body {
            background-image: url('/business_admin/assets/media/auth/bg10-dark.jpeg');
        }
    </style>
    <!--end::Page bg image-->

    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <!--begin::Body-->
        <div class="d-flex flex-column-fluid w-lg-50 flex-lg-row-auto justify-content-center justify-content-lg-center p-12 order-2">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">

                        <!--begin::Form-->
                        <form class="form w-100" method="post" novalidate="novalidate" id="kt_sign_in_form" action="{{route('business.register')}}">
                            <!--begin::Heading-->
                            @csrf
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">
                                    {{__('profile.register')}}
                                </h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">
                                    @lang('profile.loginText')
                                </div>
                                <!--end::Subtitle--->
                            </div>
                            <!--begin::Heading-->

                            <!--begin::Separator-->
                            <div class="separator separator-content my-14">
                                <span class="w-250px text-gray-500 fw-semibold fs-7">@lang('profile.newRegister')</span>
                            </div>
                            <!--end::Separator-->
                            <!--begin::Input group--->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="@lang('profile.nameAndSurname')" name="name" id="name" value="{{old("name")}}" autocomplete="off" class="form-control bg-transparent">
                                <!--end::Email-->
                            </div>
                            <!--begin::Input group--->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="@lang('profile.business_name')" name="business_name" id="businessName" value="{{old("business_name")}}" autocomplete="off" class="form-control bg-transparent">
                                <!--end::Email-->
                            </div>
                            <!--begin::Input group--->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="@lang('profile.phone')" name="phone" id="phone" value="{{old("phone") ?? "05"}}" autocomplete="off" class="form-control bg-transparent">
                                <!--end::Email-->
                            </div>

                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">

                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">@lang('profile.register')</span>
                                    <!--end::Indicator label-->

                                </button>
                            </div>
                            <!--end::Submit button-->

                            <!--begin::Sign up-->
                            <div class="text-gray-500 text-center fw-semibold fs-6">
                                @lang('profile.haveRegister')

                                <a href="{{route('business.login')}}" class="link-primary">
                                    @lang('profile.login')
                                </a>
                            </div>
                            <!--end::Sign up-->
                        </form>
                        <!--end::Form-->

                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Footer-->
                    <div class=" d-flex flex-stack">
                        <!--begin::Languages-->
                        <div class="me-10">
                            <!--begin::Toggle-->
                            <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="/business_admin/assets/media/flags/tr.svg" alt="">

                                <span data-kt-element="current-lang-name" class="me-1">Dil</span>

                                <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                            </button>
                            <!--end::Toggle-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                                <!--begin::Menu item-->
                                @foreach(["tr" => "Turkey", 'en' => 'English', 'es' => 'Spanish', 'de' => 'German', 'it' => 'Italian', 'fr' => 'French'] as $locale => $langName)
                                    <div class="menu-item px-3">
                                        <a href="{{ route('language', ['locale' => $locale]) }}" class="menu-link d-flex px-5" data-kt-lang="{{ ucfirst($locale) }}">
                                            <span class="symbol symbol-20px me-4">
                                                <img data-kt-element="lang-flag" class="rounded-1" src="/business_admin/assets/media/flags/{{ $locale }}.svg" alt="">
                                            </span>
                                            <span data-kt-element="lang-name">{{ $langName }}</span>
                                        </a>
                                    </div>
                                @endforeach
                                <!--end::Menu item-->

                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Languages-->

                        <!--begin::Links-->
                        <div class="d-flex fw-semibold text-primary fs-base gap-5">
                            <a href="../../../pages/team.html" target="_blank">@lang('profile.terms')</a>

                            <a href="../../../pages/contact.html" target="_blank">@lang('profile.contact')</a>
                        </div>
                        <!--end::Links-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
        <!--begin::Aside-->
        <div class="d-flex flex-column-fluid w-lg-50 bgi-size-cover bgi-position-center order-1" style="background-image: url(/business_admin/assets/media/misc/auth-bg.png)">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <!--begin::Logo-->
                <a href="../../../index.html" class="mb-0 mb-lg-12">
                    <img alt="Logo" src="/business_admin/assets/media/logos/custom-1.png" class="h-60px h-lg-75px">
                </a>
                <!--end::Logo-->

                <!--begin::Image-->
                <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="/business_admin/assets/media/misc/auth-screens.png" alt="">
                <!--end::Image-->

                <!--begin::Title-->
                <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                    Fast, Efficient and Productive
                </h1>
                <!--end::Title-->

                <!--begin::Text-->
                <div class="d-none d-lg-block text-white fs-base text-center">
                    In this kind of post, <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>

                    introduces a person they’ve interviewed <br> and provides some background information about

                    <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>
                    and their <br> work following this is a transcript of the interview.
                </div>
                <!--end::Text-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Aside-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
@include('layouts.modals.packet')
<!--end::Page-->
<!--begin::Javascript-->
<script>
    var hostUrl = "/metronic8/demo46/assets/";
</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="/business_admin/assets/plugins/global/plugins.bundle.js"></script>
<script src="/business_admin/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->

<script src="/business_admin/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
<!--end::Custom Javascript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.14.1/dist/sweetalert2.min.js"></script>

<script>
    $(function () {
        $("#phone").inputmask({"mask": "9(999)-999-9999"});
    });
</script>
@include('business.layouts.component.alert')
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>