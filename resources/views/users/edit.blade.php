
@extends('layouts.base')

@section('content')

@can('إدارة المسؤولين')
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
                <h4 class="main-heading mt-5">تعديل مستخدم </h4>
        <!-- row -->
            <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="al">
                        <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">رجوع</a>
                    </div>
                </div><br>

                {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                <div class="">

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <label>اسم المستخدم: <span class="tx-danger">*</span></label>
                            {!! Form::text('name', null, array('class' => 'form-control','required')) !!}
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                            {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                        </div>
                    </div>

                </div><br>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>كلمة المرور: <span class="tx-danger">*</span></label>
                        {!! Form::password('password', array('class' => 'form-control')) !!}
                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label> تاكيد كلمة المرور: <span class="tx-danger">*</span></label>
                        {!! Form::password('confirm-password', array('class' => 'form-control')) !!}
                    </div>
                </div><br>

                <div class="row mg-b-20">
                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">

                          <label>  <strong>نوع المستخدم :</strong><span class="tx-danger">*</span></label>

                            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control'))
                            !!}

                    </div>
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label> الهاتف: <span class="tx-danger">*</span></label>
                            {!! Form::number('phone', null, array('class' => 'form-control','required')) !!}
                        </div>
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0 mt-3" id="lnWrapper">
                            <label> <strong>الفرع: </strong><span class="tx-danger">*</span></label>
                            <select name="entity_id" class="form-control" required>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        @if($branch->id == $user->entity->id) selected @endif>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                </div><br><br>
                <div class="mg-t-30 text-center">
                    <button class="btn btn-primary pd-x-20" type="submit">تحديث</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        </div>
      </div>
    </section>
    @endcan
@endsection
