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
        <h4 class="main-heading mt-5">اضافة ملف جديد</h4>
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
                  action="{{route('documents.store','test')}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="modal-body">
                <div class="row row-gap-24">
                  <div class="col-sm-6">
                    <label class="small-label" for=""> رقم المكاتبة</label>
                    <input class="form-control" type="number" required value="{{old('name')}}" name="name" placeholder="" />
                  </div>

                  <div class="col-sm-6">
                    <label class="small-label" for="">تاريخ المكاتبة</label>
                    <input class="form-control" type="date" required value="{{old('date')}}"name="date" placeholder="" />
                  </div>
                </div>

                <div class="row row-gap-24 mt-2">
                    <div class="col-sm-6">
                      <label class="small-label" for="">نوع المكاتبة</label>
                      <select required   id="entity_type"  name="type" class="form-control">
                        <option value="1">صادر الي - داخلي</option>
                        <option value="2">صادر الي - خارجي</option>
                        <option value="3">وارد من - داخلي </option>
                        <option value="4">وارد من - خارجي </option>
                    </select>
                   </div>
                    <div class="col">
                        <label class="small-label" for="">الجهات</label>
                        <select id="entites" name="entity_id" class="form-control">
                          <option disabled>اختار نوع المكاتبة اولا</option>


                      </select>
                     </div>
                  </div>

                <!-- File Input for Multiple Files -->
                <div class="row row-gap-24 mt-2">
                  <div class="col">
                    <label class="small-label" for="">الملفات</label>
                    <input class="form-control" type="file" required name="photos[]" accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx" id="photos" multiple />
                    <output id="result" class="preview-container"></output> <!-- Use flexbox container here -->
                  </div>
                </div>

                <div class="row row-gap-24 mt-2">
                  <div class="col">
                    <label class="small-label" for="">الموضوع</label>
                    <textarea class="form-control" name="nots">{{old('nots')}}</textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <a href="{{ route('documents.index') }}" type="button" class="btn btn-secondary" style="font-size: 12px" >
                  الغاء
                </a>
                <button type="submit" class="btn-main-sm">حفظ</button>
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
      fetchEntities(); // Fetch entities based on the initial selection

      // Fetch entities when the entitytype dropdown changes
      $('#entity_type').change(function() {
        fetchEntities(); // Fetch new entities based on selected entitytype
      });
    });



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

@push('scripts')

@endpush
