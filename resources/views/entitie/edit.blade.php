
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

    <div class="row">
      <div class="col-6">
        <h4 class="main-heading mt-"5>تعديل جهه</h4>
      </div>
      <div class="col-6" style="text-align: end; margin-top: 40px;">
        <a class="btn btn-primary btn-sm" href="{{ route('entities.index') }}">رجوع</a>
      </div>
    </div>

    <!-- Form row -->
    <div class="row">
      <div class="col-md-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                  action="{{ route('entities.update', $entity->id) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              @method('PUT')
              <div class="modal-body">
                <div class="row row-gap-24">
                  <div class="col-sm-6">
                    <label class="small-label" for=""> اسم الجهه</label>
                    <input class="form-control" required type="text" name="name" value="{{ old('name', $entity->name) }}" />
                  </div>
                  <div class="col-sm-6">
                    <label class="small-label" for=""> نوع الجهه</label>
                    <select id="entitytype" name="type" class="form-control">
                        <option value="internal" @if($entity->type == 'internal') selected @endif>داخلي</option>
                        <option value="external" @if($entity->type == 'external') selected @endif>خارجي</option>
               </select>
                  </div>
                </div>
              </div>


              <div class="modal-footer">

                <button type="submit" class="btn-main-sm">تحديث</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Preview selected files before uploading
  const fileInput = document.getElementById('photos');
  const resultContainer = document.getElementById('result');

  fileInput.addEventListener('change', function () {
    resultContainer.innerHTML = ''; // Clear previous previews
    const files = fileInput.files;

    // Loop through selected files and display preview
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();

      reader.onload = function (e) {
        const filePreview = document.createElement('div');
        filePreview.classList.add('file-preview');

        if (file.type.startsWith('image/')) {
          // For images, display as img tag
          const img = document.createElement('img');
          img.src = e.target.result;
          img.alt = file.name;
          img.classList.add('image-preview');
          filePreview.appendChild(img);
        } else {
          // For non-image files, display file name or file icon
          const fileName = document.createElement('p');
          fileName.textContent = file.name;

          // If you want to show an icon instead of the file name, you can include this part
          const fileIcon = document.createElement('span');
          fileIcon.textContent = "📄";  // You can replace it with an icon or image
          fileName.insertBefore(fileIcon, fileName.firstChild);

          filePreview.appendChild(fileName);
        }

        resultContainer.appendChild(filePreview);
      };

      reader.readAsDataURL(file); // Read the file as data URL for image preview
    }
  });
</script>

@endsection
