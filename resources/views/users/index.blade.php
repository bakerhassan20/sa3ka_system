@extends('layouts.base')

@section('content')
@can('إدارة المسؤولين')
    <section class="main-section users">
      <div class="container">
        <h4 class="main-heading mt-5">ادارة المسؤولين</h4>
        <form class="bg-white p-3 rounded-2 shadow">
          <div
            class="d-flex align-items-center flex-wrap justify-content-end mb-2"
          >
            <button
              type="button"
              data-bs-toggle="modal"
              data-bs-target="#modal-add-admin"
              class="btn-main-sm"
            >
              أضف مسؤول
              <i class="icon fa-solid fa-plus"></i>
            </button>
          </div>

          <div class="table-responsive">
            <table class="table main-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>اسم المستخدم</th>
                  <th>الفرع</th>
                  <th> الصلاحيه</th>
                  <th>رقم الهاتف</th>
                  <th>البريد </th>
                  <th class="text-center">التحكم</th>
                </tr>
              </thead>
              <tbody>

                @foreach ( $data as $user)
                 <tr>

                  <td></td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->entity->name }}</td>
                    <td>@if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $v)
                              {{ $v }}
                            @endforeach
                         @endif
                    </td>
                  <td>{{ $user->phone }}</td>
                   <td>{{ $user->email }}</td>
                  <td>
                    <div
                      class="d-flex align-items-center justify-content-center gap-1"
                    >

                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                      <div
                        class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-user_id="{{ $user->id }}" data-username="{{ $user->name }}"
                        data-bs-target="#modal-delete"
                      >
                        حذف
                      </div>
                    </div>
                  </td>
                   </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </form>
      </div>
    </section>
    @endcan
    @cannot('إدارة المسؤولين')
    <div class="canalert" style="height: 475px;">
    <div class="col-md-offset-1 col-md-10 alert alert-danger mt-5 mb-30"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        ليس لديك صلاحية يرجي مراجعة المسؤول
    </div>0
</div>
@endcannot
@endsection


@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"
  type="text/javascript"></script>
  <script>
    $('#modal-delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var user_id = button.data('user_id')
        var username = button.data('username')
        var modal = $(this)
        modal.find('.modal-body #user_id').val(user_id);
        modal.find('.modal-body #username').val(username);
    })

</script>
@endsection
