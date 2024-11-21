



<?php
$roles =Spatie\Permission\Models\Role::pluck('name','name')->all();
$branches = App\Models\Entitie::where('type','internal')->get();
?>

     <!-- Modal-add-admin -->
  <div
      class="modal fade"
      id="modal-add-admin"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
         <form class="parsley-style-1" id="selectForm4" autocomplete="off" name="selectForm2"
                    action="{{route('users.store','test')}}" method="post">
                    {{csrf_field()}}
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">أضف مسؤال جديد</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>


          <div class="modal-body">
            <div class="row row-gap-24">
              <div class="col-sm-4">
                <label class="small-label" for="">اسم المستخدم </label>
                <input class="form-control" type="text" name="name" required="" placeholder="" />
              </div>
              <div class="col-sm-4">
                <label class="small-label" for="">الرقم السري </label>
                <input class="form-control" name="password" required="" type="password" />
              </div>
              <div class="col-sm-4">
                <label class="small-label" for="">تاكيد الرقم السري</label>
                <input class="form-control"   name="confirm-password" required="" type="password" />
              </div>
              <div class="col-sm-4">
                <label class="small-label" for="">رقم الهاتف </label>
                <input class="form-control" type="number"name="phone" required=""  placeholder="" />
              </div>
            <div class="col-sm-4">
                <label class="small-label" for=""> البريد الاكتروني</label>
                <input class="form-control" type="email" name="email" required="" />
              </div>
            <div class="col-sm-4">
                <label class="small-label" for=""> الصلاحيه</label>
                {!! Form::select('roles_name[]', $roles,[], array('class' => 'form-control')) !!}
              </div>
              <div class="col-sm-6">
                    <label class="small-label" for="">الفرع</label>
                  <select class="form-control" name="entity_id" required>
                     @foreach($branches as $branch)
                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                     @endforeach
                  </select>
                  </div>
            </div>
          </div>

          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              style="font-size: 12px"
              data-bs-dismiss="modal"
            >
              الغاء
            </button>
            <button type="submit" class="btn-main-sm">حفظ</button>
          </div>
              </form>
        </div>
      </div>
  </div>



    <!-- Modal-edit -->
<div
      class="modal fade"
      id="modal-edit"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
              تعديل حساب العامل
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row row-gap-24">
              <div class="col-sm-6">
                <label class="small-label" for="">اسم الحساب </label>
                <input class="form-control" type="text" placeholder="" />
              </div>
              <div class="col-sm-6">
                <label class="small-label" for="">رقم السري </label>
                <input class="form-control" type="text" placeholder="" />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              style="font-size: 12px"
              data-bs-dismiss="modal"
            >
              الغاء
            </button>
            <button type="button" class="btn-main-sm">حفظ</button>
          </div>
        </div>
      </div>
</div>




    <!-- Modal-delete -->
    <div
      class="modal fade"
      id="modal-delete"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">حذف مستخدم</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="{{ route('users.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
          <div class="modal-body">
            <h6 class="text-center">هل انت متأكد من اجراء عملية الحذف!</h6>
            <input type="hidden" name="user_id" id="user_id" value="">
            <input class="form-control" name="username" id="username" type="text" readonly>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              style="font-size: 12px"
              data-bs-dismiss="modal"
            >
              الغاء
            </button>
            <button type="submit" class="btn-main-sm">نعم</button>
          </div>
        </form>
        </div>
      </div>
    </div>





    <!-- Modal-edit-employ -->
  <div
  class="modal fade"
  id="modal-edit-entity"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  tabindex="-1"
  aria-labelledby="staticBackdropLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
     <form class="parsley-style-1" id="selectForm1" autocomplete="off" name="selectForm2"
                action="{{route('entities.update','update')}}" method="post">
                @method('PATCH')

                {{csrf_field()}}

      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">تعديل عميل </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>

         <div class="modal-body">
        <div class="row row-gap-24">
          <div class="col-sm-12 col-md-6">
             <input type="hidden" name="entity_id" id="entity_id" value="">
            <label class="small-label" for="">اسم الجهه </label>
            <input class="form-control" type="text" id="entityname" name="name" required="" placeholder="" />
          </div>
          <div class="col-sm-12 col-md-6">
            <label class="small-label" for="">نوع الجهه </label>
            <select id="entitytype" name="entity_type" class="form-control">

            </select>

          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-secondary"
          style="font-size: 12px"
          data-bs-dismiss="modal"
        >
          الغاء
        </button>
        <button type="submit" class="btn-main-sm">حفظ</button>
      </div>
          </form>
    </div>
  </div>
</div>






    <!-- Modal-add-entity -->
    <div
    class="modal fade"
    id="modal-add-entity"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
       <form class="parsley-style-1" id="selectForm3" autocomplete="off" name="selectForm2"
                  action="{{route('entities.store','add')}}" method="post">
                  {{csrf_field()}}
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">أضف جهه جديد</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>

           <div class="modal-body">
          <div class="row row-gap-24">
            <div class="col-sm-12 col-md-6">
              <label class="small-label" for=""> اسم الجهه </label>
              <input class="form-control" type="text" name="name" required="" placeholder="" />
            </div>
            <div class="col-sm-12 col-md-6">
              <label class="small-label" for=""> نوع الجهه </label>
            <select name="type" class="form-control">
                <option value="internal">داخلي</option>
                <option value="external">خارجي</option>
            </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            style="font-size: 12px"
            data-bs-dismiss="modal"
          >
            الغاء
          </button>
          <button type="submit" class="btn-main-sm">حفظ</button>
        </div>
            </form>
      </div>
    </div>
</div>
