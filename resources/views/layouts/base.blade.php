<!DOCTYPE html>

<html>
<!-- BEGIN: Head -->

<head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="{{URL::asset('assets/css/normalize.css')}}">
    <!-- Bootstrap -->

    <link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.min.css')}}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/all.min.css')}}">

    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/main.css')}}">
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@500;600;700;800&display=swap"
      rel="stylesheet"
    />

    @yield('head')

    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body dir="rtl">

    @include('layouts.top-menu')
    @yield('content')
    @include('layouts.models')


     <div class="footer-bottom py-3">
      <div class="container">
        <div
          class="d-flex flex-wrap align-items-center justify-content-between gap-3">
          <p>جميع الحقوق محفوظة © لـ 2024</p>
          <p> فرع نظم المعلومات  -  قيادة قوات الصاعقة </p>
        </div>
      </div>
    </div>

  <!-- Js Files -->
  <script src="{{URL::asset('assets/js/ajax.js')}}"></script>
    @yield('scripts')
    <script src="{{URL::asset('assets/js/main.js')}}"></script>
    <script src="{{URL::asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/all.min.js')}}"></script>
    <!-- END: Pages, layouts, components JS Assets-->
</body>

</html>
