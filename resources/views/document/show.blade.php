@extends('layouts.base')

@section('content')
<style>

</style>
<section class="main-section users">
  <div class="container">
    <div class="row">
      <div class="col-6">
        <h4 class="main-heading mt-5">{{$doc->name}}</h4>
      </div>
      <div class="col-6" style="text-align: end; margin-top: 40px;">
        <a class="btn btn-primary btn-sm" href="{{ route('documents.index') }}">رجوع</a>
      </div>
    </div>

    <!-- Form row -->
    <div class="row">
      <div class="col-md-12">
        <div class="card mg-b-20">
          <div class="card-body">
              <div class="modal-body">
                <div class="row row-gap-24">
                  <div class="col">
                    <label class="small-label" for=""> رقم المكاتبة</label>
                    <input class="form-control" disabled  value="{{$doc->name}}" type="text" name="name" placeholder="" />
                  </div>
                  <div class="col">
                    <label class="small-label" for="">تاريخ المكاتبة</label>
                    <input class="form-control" style="text-alen" disabled value="{{$doc->date }}" type="date" name="date" placeholder="" />
                  </div>
                  @if(Auth::user()->branch_id == 10 || Auth::user()->branch_id == 16)
                  <div class="col">
                    <label class="small-label" for=""> الفرع</label>
                    <input class="form-control" style="text-alen" disabled value="{{$doc->branch->name }}" type="text" placeholder="" />
                  </div>
                  @endif
                </div>


                <div class="row row-gap-24 mt-3">
                    <div class="col">
                      <label class="small-label" for=""> نوع المكاتبة</label>
                      <input class="form-control" disabled
                      value="@if($doc->type == 1)صادر الي - داخلي@elseif ($doc->type == 2)صادر الي - خارجي@elseif($doc->type == 3)وارد من - داخلي@else وارد من - خارجي@endif"
                       type="text" name="name" placeholder="" />
                    </div>
                    <div class="col">
                      <label class="small-label" for="">جهه المكاتبة</label>
                      <input class="form-control" style="text-alen" disabled value="{{$doc->entity->name }}" type="text" name="date" placeholder="" />
                    </div>
                  </div>

                <!-- File Input for Multiple Files -->
                <div class="row row-img  row-gap-24">
                  @php
                  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                  @endphp
                        @if ($doc->documentDetails->isNotEmpty())
                        <div class="preview-container">
                        @foreach ($doc->documentDetails as $detail)

                          @if(in_array(pathinfo($detail->filename, PATHINFO_EXTENSION), $allowedExtensions))
                          <a href="{{ asset('storage/'.$detail->path) }}" target="_blank">
                    <img
                        src="{{ asset('storage/'.$detail->path) }}"
                        class="mt-3 preview-image"
                        width="80px"
                        height="80px"
                        alt="{{ $detail->filename }}">
                </a>
                          @else
                          <div class="file-preview m-3">
                              <p>
                              <span>📄</span>
                              <a href="{{ asset('storage/'.$detail->path) }}" target="_blank">{{ $detail->filename }}</a>
                          </p>
                          </div>

                          @endif
                        @endforeach
                        @else
                            <p>No document details available.</p>
                        </div>
                        @endif
                </div>

                <div class="row row-gap-24">
                  <div class="col">
                    <label class="small-label" for="">الموضوع</label>
                    <textarea class="form-control" disabled name="nots">{{$doc->nots}}</textarea>
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
    // JavaScript to open image in modal when clicked
    document.querySelectorAll('.preview-image').forEach(function(image) {
        image.addEventListener('click', function() {
            var fullImageUrl = image.getAttribute('data-fullimage');
            document.getElementById('fullImage').src = fullImageUrl;
            // Open the modal
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        });
    });
</script>

@endpush
