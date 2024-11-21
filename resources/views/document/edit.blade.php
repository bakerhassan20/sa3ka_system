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
        <h4 class="main-heading mt-5">تعديل الملف</h4>
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
            <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                  action="{{ route('documents.update', $doc->id) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              @method('PUT') <!-- Use the PUT method for updating an existing resource -->
              <div class="modal-body">
                <div class="row row-gap-24">
                  <div class="col-sm-6">
                    <label class="small-label" for="">رقم المكاتبة</label>
                    <input class="form-control" required type="text" name="name" value="{{ old('name', $doc->name) }}" />
                  </div>
                  <div class="col-sm-6">
                    <label class="small-label" for="">تارخ المكاتبة</label>
                    <input class="form-control" required type="date" name="date" value="{{ old('date', $doc->date) }}" />
                  </div>
                </div>


                <div class="row row-gap-24 mt-3">
                    <div class="col">
                      <label class="small-label" for=""> نوع المكاتبة</label>
                    <select name="type" class="form-control" id="entity_type">
                        <option value="1"  @if($doc->type == 1) selected @endif>صادر الي - داخلي </option>
                        <option value="2" @if($doc->type == 2) selected @endif>صادر الي - خارجي</option>
                        <option value="3"  @if($doc->type == 3) selected @endif>وارد من - داخلي</option>
                        <option value="4" @if($doc->type == 4) selected @endif>وارد من - خارجي</option>

                    </select>
                    </div>
                    <div class="col">
                        <label class="small-label" for="">الجهات</label>
                        <select required id="entites" name="entity_id" class="form-control">
                            <option value=""disabled >اختار الجهه</option>
                        @foreach ($entities as $entity)
                         <option value="{{ $entity->id }}" @if($doc->entity_id == $entity->id) selected @endif>{{ $entity->name }}</option>
                        @endforeach
                      </select>
                     </div>
                  </div>


                <!-- File Input for Multiple Files -->
                <div class="row row-gap-24">
                  <div class="col">
                    <label class="small-label" for="">الملفات</label>
                    <input class="form-control" type="file" name="photos[]" accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx" id="photos" multiple />
                    <output id="result" class="preview-container"></output> <!-- Use flexbox container here -->
                  </div>
                </div>

                <!-- Display existing files (if any) -->
                @if($doc->documentDetails->isNotEmpty())
                <div class="row row-gap-24">
                  <div class="col">
                    <hr>
                    <label class="small-label" for="">الملفات الحالية</label>
                    <div class="preview-container">
                      @foreach ($doc->documentDetails as $detail)
                      <div class="file-preview">
                        @if (in_array(pathinfo($detail->filename, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ asset('storage/'.$detail->path) }}" class="image-preview" alt="File Image">
                        @else
                        <span>📄</span> <!-- Placeholder icon for non-image files -->
                        @endif
                        <p>{{ $detail->filename }}</p>
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
                @endif

                <div class="row row-gap-24">
                  <div class="col">
                    <label class="small-label" for="">الموضوع</label>
                    <textarea class="form-control" name="nots">{{ old('nots', $doc->nots) }}</textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <a href="{{ route('documents.index') }}" type="button" class="btn btn-secondary" style="font-size: 12px" >
                    الغاء
                  </a>
                <button type="submit" class="btn-main-sm">تحديث</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to fetch entities based on selected entitytype
    function fetchEntities() {
      var entityType = $('#entity_type').val(); // Get selected entity type

      $.ajax({

        url: '/getEntities/' + entityType, // Send the entitytype value in the URL
        method: 'GET',
        dataType: 'json',
        success: function(response) {

          $('#entites').empty();
          $('#entites').append('<option value="">اختار الجهه</option>'); // Add default option

          // Loop through the response data and add options to the entites select
          $.each(response, function(index, entity) {
            $('#entites').append('<option value="' + entity.id + '">' + entity.name + '</option>');
          });
        },
        error: function(xhr, status, error) {
          console.log('Error:', error); // Handle errors
        }
      });
    }

    // Call fetchEntities function when the page loads
    $(document).ready(function() {

      // Fetch entities when the entitytype dropdown changes
      $('#entity_type').change(function() {
        fetchEntities(); // Fetch new entities based on selected entitytype
      });
    });



</script>
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
