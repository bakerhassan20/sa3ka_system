{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 --}}


 <!DOCTYPE html>
 <html lang="ar" dir="rtl">
   <head>
     <meta charset="UTF-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>تسجيل الدخول</title>
     <!-- Normalize -->

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
   </head>

   <body>
     <!-- Start Section -->
     <section class="loginPage py-5">
       <div class="container">
         <div class="row login_box shadow-lg">
           <div class="col-12 px-0">
             <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
               <div class="login_content">
                 <div
                   class="login_footer d-flex align-items-center justify-content-center"
                 >
                   <a href="https://www.const-tech.org/">
                     نظم المعلومات - قيادة قوات الصاعقة
                   <img
                       src="{{ asset('http://127.0.0.1:8000/assets/img/logo.png') }}"
                       width="100"
                       alt="logo_login"
                     />
                   </a>
                 </div>
                 <hr class="my-4" />
                 <h6 class="title">تسجيل الدخول</h6>
                 <div class="inp_holder">
                   <label for="" class="login-label">اسم المستخدم </label>
                   <input
                     type="text"
                     class="login-inp form-control"
                     name="name"value="{{ old('name') }}" required autocomplete="name" autofocus
                   />
                                 @error('name')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                 </div>
                 <div class="inp_holder">
                   <label for="" class="login-label">كلمة السر</label>
                   <input
                     type="password"
                     class="login-inp form-control"
                     name="password"
                     required autocomplete="current-password"
                   />
                     @error('password')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                     @enderror
                 </div>


                         <div class="row mb-3">
                             <div class="col-md-6 offset-md-4">
                                 <div class="form-check">
                                     <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                     <label class="form-check-label" for="remember">
                                         {{ __('Remember Me') }}
                                     </label>
                                 </div>
                             </div>
                         </div>



                 <div class="btn_holder">
                   <button class="btn login-btn">تسجيل الدخول</button>
                 </div>
               </div>
             </form>
           </div>
         </div>
       </div>
     </section>
     <!-- End Section -->
     <!-- Js Files -->
     <script src="{{URL::asset('assets/js/main.js')}}"></script>
     <script src="{{URL::asset('assets/js/bootstrap.bundle.min.js')}}"></script>
     <script src="{{URL::asset('assets/js/all.min.js')}}"></script>

   </body>
 </html>
