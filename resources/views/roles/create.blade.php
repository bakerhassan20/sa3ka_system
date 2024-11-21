
@extends('layouts.base')

@section('content')


    <section class="main-section users">
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
        <h4 class="main-heading mt-5">تعديل صلاحيه </h4>
<!-- row -->

{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="">
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}">رجوع</a>
                    </div>
                </div>


                    <br/><br/>    <div class="form-group">
                            <p>اسم الصلاحية :</p>
                            {!! Form::text('name', null, array('class' => 'form-control')) !!}

                    </div><br/><br/>
                           <div class="row">
                            @foreach($permission as $value)
                               <div class="col-4">
                            <label style="font-size: 16px;">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                {{ $value->name }}</label>
                                        <br/>
                                          </div>
                            @endforeach
                                </div>


                      <br/>   <br/> <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                    </div>



            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
      </div>
    </section>
@endsection
