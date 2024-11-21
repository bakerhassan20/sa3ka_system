
@extends('layouts.base')

@section('content')
    <section class="main-section users">
      <div class="container">
        <h4 class="main-heading mt-5"> عرض صلاحيه</h4>
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="">
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}">رجوع</a>
                    </div>
                </div>


                          <br> <li>{{ $role->name }}</li><br>

                                    @if(!empty($rolePermissions))
                                      <div class="row">
                                    @foreach($rolePermissions as $v)

                                        <div class="col-4">
                                          {{ $v->name }}
                                        </div>

                                    @endforeach
                                         </div>
                                    @endif



            </div>
        </div>
    </div>
</div>
      </div>
    </section>
@endsection
