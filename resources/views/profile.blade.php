@extends('layouts.base')

@section('content')
     <section class="main-section py-5">
      <div class="container">
      @if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>خطا</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
        <div class="card card-register h-100">
          <form action="{{ route('profile.update') }}" method="POST">
             @csrf

            <div class="card-body shadow">
              <div class="row gutters g-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <h6 class="mb-2 text-primary">اعدادات الحساب العامه</h6>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="eMail" class="mb-2 small-label"
                      >  الاسم
                    </label>
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      id="eMail"
                    value="{{ Auth::user()->name }}"

                    />
                  </div>
                </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="eMail" class="mb-2 small-label"
                      > البريد الاليكتروني
                    </label>
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      id="eMail"
                    value="{{ Auth::user()->email }}"

                    />
                  </div>
                </div>

             <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="eMail" class="mb-2 small-label"
                      > الهاتف
                    </label>
                    <input
                      type="text"
                      name="phone"
                      class="form-control"
                      id="eMail"
                      value="{{ auth::user()->phone }}"
                    />
                  </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="d-flex gap-2 mt-3 justify-content-center">
                    <div class="text-center">
                      <button
                        type="submit"
                        id="submit"
                        class="btn btn-sm btn-primary"
                      >
                        حفظ
                      </button>
                    </div>
                    <div class="text-center">
                      <a
                        href="{{ route('home') }}"
                        id="submit"
                        class="btn btn-sm btn-danger"
                      >
                        الغاء
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div><br><br>
        <div class="card card-register h-100">
          <form action="{{route('profile.update-password')}}" method="POST">
             @csrf
            <div class="card-body shadow">
              <div class="row gutters g-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <h6 class="mb-2 text-primary"> كلمه المرور</h6>
                </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="password" class="small-label mb-2"
                      >     كلمة المرور الحالية</label
                    >
                    <input
                      type="password"
                      name="old_password"
                      class="form-control"
                      id="password"
                    />
                  </div>
                </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="password" class="small-label mb-2"
                      >          كلمة المرور الجديدة</label
                    >
                    <input
                      type="password"
                      name="password"
                      class="form-control"
                      id="password"
                    />
                  </div>
                </div>

                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="password" class="small-label mb-2"
                      >    تأكيد المرور الجديدة</label
                    >
                    <input
                      type="password"
                      name="password_confirmation"
                      class="form-control"
                      id="password"
                    />
                  </div>
                </div>


                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="d-flex gap-2 mt-3 justify-content-center">
                    <div class="text-center">
                      <button
                        type="submit"
                        id="submit"
                        class="btn btn-sm btn-primary"
                      >
                        حفظ
                      </button>
                    </div>
                    <div class="text-center">
                      <a
                        href="{{ route('home') }}"
                        id="submit"
                        class="btn btn-sm btn-danger"
                      >
                        الغاء
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
@endsection
