
<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <meta charset="utf-8" />
    <title>Mobile Patrol</title>
    <meta name="description" content="Mobile Patrol" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{URL::asset('assets/css/pages/login/login-3.css?v=7.0.3')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{URL::asset('assets/plugins/global/plugins.bundle.css?v=7.0.3')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.3')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/style.bundle.css?v=7.0.3')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{URL::asset('assets/css/themes/layout/header/base/light.css?v=7.0.3')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/themes/layout/header/menu/light.css?v=7.0.3')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/themes/layout/brand/dark.css?v=7.0.3')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/themes/layout/aside/dark.css?v=7.0.3')}}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->

    <link rel="shortcut icon" href="{{ asset('assets/frontend/images/favicon.png') }}" type="image/png">
</head>
<!--end::Head-->
<style>
    .c-card {
        padding: 2.4rem 1.6rem;
        border: 1px solid #e3e8ee;
        background: #ffffff;
        border-radius: 0.8rem;
        display: block;
        box-shadow: 0 1px 2px rgba(50, 50, 93, 0.1);
    }
</style>
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->

    <!--begin::Login-->
@yield('content')
<!--end::Login-->

<!--end::Main-->
<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{URL::asset('assets/plugins/global/plugins.bundle.js?v=7.0.3')}}"></script>
<script src="{{URL::asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.3')}}"></script>
<script src="{{URL::asset('assets/js/scripts.bundle.js?v=7.0.3')}}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{URL::asset('assets/js/pages/custom/login/login-3.js?v=7.0.3')}}"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>