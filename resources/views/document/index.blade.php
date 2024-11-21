@extends('layouts.base')

@section('content')

@can('إدارة الارشيف')

 <!-- Modal-delete -->
    <div
      class="modal fade"
      id="modal-delete-product"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">حذف مكاتبة</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="{{ route('documents.destroy', 'test3') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
          <div class="modal-body">
            <h6 class="text-center">هل انت متأكد من اجراء عملية الحذف!</h6>
            <input type="hidden" name="document_id" id="product_id" value="">
            <input class="form-control" name="productname" id="productname" type="text" readonly>
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
      <div class="container filter">
        <h4 class="main-heading mt-5"> الارشيف</h4>
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('documents.index') }}">
            <div class="row  mb-3">
                <div class="col-6">
                    <label for="name">رقم المكاتبة</label>
                    <input type="number" name="name" id="name" class="form-control" value="{{ request('name') }}">
                </div>
                <div class="col-6">
                    <label for="date">تاريخ المكاتبة</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                </div>
            </div>

            <div class="row  mb-3">
                <div class="col-6">
                    <label for="name">نوع المكاتبة</label>
                    <select name="type" class="form-control">
                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>اختر النوع</option>
                        <option value="1"{{ request('type') == 1 ? 'selected' : '' }} >صادر الي - داخلي </option>
                        <option value="2"{{ request('type') == 2 ? 'selected' : '' }}>صادر الي - خارجي</option>
                        <option value="3" {{ request('type') == 3 ? 'selected' : '' }}>وارد من - داخلي</option>
                        <option value="4"{{ request('type') == 4 ? 'selected' : '' }}>وارد من - خارجي</option>
                    </select>
              </div>

                <div class="col-6">
                    <label for="entity">الجهه</label>
                    <select class="form-control" name="entity_id">
                        <option disabled>اختر الجهه</option>
                        <option value="all">جميع الجهات</option>
                        @foreach($entities as $entity)
                        <option value="{{ $entity->id }}"
                            {{ request('entity_id') == $entity->id ? 'selected' : '' }}>
                        {{ $entity->name }}
                    </option>
                    @endforeach
                     </select>
                    </div>
                </div>


      {{--   <input type="text" name="entity" id="entity" class="form-control" value="{{ request('entity') }}"> --}}



            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                    <label for="date">الموضوع</label>
                    <input type="text" name="nots"  class="form-control" value="{{ request('nots') }}">
                </div>




                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-primary">تصفية</button>
                    <a href="{{ route('documents.index') }}" class="btn btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>

        <form class="bg-white p-3 rounded-2 shadow">
          <div
            class="d-flex align-items-center flex-wrap justify-content-end mb-2"
          >
            <a
              type="button"

              class="btn-main-sm"
              href="{{route('documents.create')}}"
            >
              أضف مكاتبة
              <i class="icon fa-solid fa-plus"></i>
</a>
          </div>

          <div class="table-responsive">
            <table class="table main-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>رقم المكاتبة </th>
                  <th>نوع المكاتبة </th>
                  <th>الجهه الصادر اليها</th>
                  <th> الجهه الوارد منها </th>
                  <th>تاريخ المكاتبة </th>
                  <th>الموضوع</th>
                  <th class="text-center">التحكم</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($docs as $doc)
        {{--         @if ($doc->branch_id != auth()->user()->entity_id && $doc->entity_id != auth()->user()->entity_id)
                    @continue
                @endif --}}
                <tr>
                    <td>{{ ($docs->currentPage() - 1) * $docs->perPage() + $loop->iteration }}</td>
                    <td>{{ $doc->name }}</td>
                    <td>
                        @if ($doc->type == 1)
                            صادر الي - داخلي
                        @elseif ($doc->type == 2)
                            صادر الي - خارجي
                        @elseif ($doc->type == 3)
                            وارد من - داخلي
                        @else
                            وارد من - خارجي
                        @endif
                    </td>
                    @if ($doc->type == 1 || $doc->type == 2)
                        <td>{{ $doc->entity->name ?? 'N/A' }}</td>
                        <td>{{ $doc->branch->name ?? 'N/A' }}</td>
                    @else
                        <td>{{ $doc->branch->name ?? 'N/A' }}</td>
                        <td>{{ $doc->entity->name ?? 'N/A' }}</td>
                    @endif
                    <td>{{ $doc->date }}</td>
                    <td>{{ $doc->nots }}</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center gap-1">
                            <div>
                                <a class="btn btn-sm btn-success" href="{{ route('documents.show', $doc->id) }}">عرض</a>
                            </div>
                            <div>
                                <a class="btn btn-sm btn-primary" href="{{ route('documents.edit', $doc->id) }}">تعديل</a>
                            </div>
                            <div
                                class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-product_id="{{ $doc->id }}"
                                data-productname="{{ $doc->name }}"
                                data-bs-target="#modal-delete-product"
                            >
                                حذف
                            </div>
                            <div>
                                <a class="btn btn-sm btn-warning" href="{{ route('documents.download', $doc->id) }}">تحميل</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach


              </tbody>
            </table>

            <div class="pagination">
                    {{ $docs->links() }}  <!-- This will render the pagination links -->
            </div>
          </div>
        </form>
      </div>
    </section>
<!-- Pagination Links -->

     @endcan
    @cannot('إدارة الارشيف')
        <div class="col-md-offset-1 col-md-10 alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            ليس لديك صلاحية يرجي مراجعة المسؤول
        </div>
    @endcannot
@endsection


@section('scripts')
  <script>
    $('#modal-delete-product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var product_id = button.data('product_id')
        var productname = button.data('productname')
        var modal = $(this)
        modal.find('.modal-body #product_id').val(product_id);
        modal.find('.modal-body #productname').val(productname);
    })

</script>
@endsection
