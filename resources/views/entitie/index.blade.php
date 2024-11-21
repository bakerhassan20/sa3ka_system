@extends('layouts.base')

@section('content')

@can('الجهات')

 <!-- Modal-delete -->
    <div
      class="modal fade"
      id="modal-delete-entity"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">حذف جهه</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="{{ route('entities.destroy', "delete")  }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
          <div class="modal-body">
            <h6 class="text-center">هل انت متأكد من اجراء عملية الحذف!</h6>
            <input type="hidden" name="entity_id" id="entity_id" value="">
            <input class="form-control" name="entityname" id="entityname" type="text" readonly>
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
    <section class="main-section users">
      <div class="container">
        <h4 class="main-heading mt-5">الجهات</h4>
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('entities.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                    <label for="name">اسم الجهه</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                </div>


                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-primary">تصفية</button>
                    <a href="{{ route('entities.index') }}" class="btn btn-secondary">إعادة تعيين</a>
                </div>
            </div>
            </form>



        <form class="bg-white p-3 rounded-2 shadow">
          <div
            class="d-flex align-items-center flex-wrap justify-content-end mb-2"
          >
          <button
          type="button"
          data-bs-toggle="modal"
          data-bs-target="#modal-add-entity"
          class="btn-main-sm"
        >
          أضف جهه جديدة
          <i class="icon fa-solid fa-plus"></i>
        </button>
          </div>

          <div class="table-responsive">
            <table class="table main-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th> اسم الجهه </th>
                  <th> نوع الجهه </th>

                  <th class="text-center">التحكم</th>
                </tr>
              </thead>
              <tbody>

                @foreach ( $entities as $entity)
                 <tr>
                    <td>{{ ($entities->currentPage() - 1) * $entities->perPage() + $loop->iteration }}</td>
                    <td>{{ $entity->name }}</td>
                    <td>
                        @if($entity->type == 'internal')
                            داخلي
                        @else
                            خارجي
                        @endif
                    </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-center gap-1">

                        <div><a class="btn btn-sm btn-primary" href="{{route('entities.edit',$entity->id)}}">تعديل</a>
                      </div>
                      <div
                        class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-entity_id="{{ $entity->id }}" data-entityname="{{ $entity->name }}"
                        data-entity_type="{{ $entity->type }}"
                        data-bs-target="#modal-delete-entity"
                      >
                        حذف
                      </div>
                    </div>
                  </td>
                   </tr>
                @endforeach

              </tbody>
            </table>

            <div class="pagination">
                    {{ $entities->links() }}  <!-- This will render the pagination links -->
            </div>
          </div>
        </form>
      </div>
    </section>
<!-- Pagination Links -->

     @endcan
    @cannot('الجهات')
        <div class="col-md-offset-1 col-md-10 alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            ليس لديك صلاحية يرجي مراجعة المسؤول
        </div>
    @endcannot
@endsection


@section('scripts')
<script>
    $('#modal-edit-entity').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal

        // Get the data attributes from the button
        var entity_id = button.data('entity_id'); // Extract entity id
        var entityname = button.data('entityname'); // Extract entity name
        var entity_type = button.data('entity_type'); // Extract entity type (internal or external)

        var modal = $(this);

        // Set the entity_id and entityname input fields
        modal.find('.modal-body #entity_id').val(entity_id);
        modal.find('.modal-body #entityname').val(entityname);

        // Dynamically add options to the entitytype dropdown
        var entityTypeSelect = modal.find('.modal-body #entitytype');

        // Clear any previous options
        entityTypeSelect.empty();

        // Define the available options
        var options = [
            { value: 'internal', text: 'داخلي' },
            { value: 'external', text: 'خارجي' }
        ];

        // Append new options to the select dropdown
        options.forEach(function(option) {
            var newOption = $('<option>', {
                value: option.value,
                text: option.text
            });
            entityTypeSelect.append(newOption);
        });

        if (options.some(option => option.value === entity_type)) {
            entityTypeSelect.val(entity_type);
            console.log(entity_type)
        }
    });
</script>
<script>
    $('#modal-delete-entity').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var entity_id = button.data('entity_id')
        var entityname = button.data('entityname')
        var modal = $(this)

        modal.find('.modal-body #entity_id').val(entity_id);
        modal.find('.modal-body #entityname').val(entityname);
    })

</script>
@endsection
