@extends('layouts.base')

@section('content')
    <!-- Start Section -->
    <section class="main-section home h-100vh">
      <div class="container">
        <h4 class="main-heading">الرئيسية</h4>


        <div class="row row-gap-24 mb-4 boxes-info mt-5">
        @can('إدارة الارشيف')


          <div class="col-sm-6 col-md-3">
            <a href="{{ route('documents.index') }}">
              <div class="box-info blue">
                <i class="fas fa-coins bg-icon"></i>
                <div class="text">الارشيف</div>
                <div class="num">
                    @if(Auth::user()->entity_id == 10 || Auth::user()->entity_id == 16)
                       @php echo App\Models\Document::count(); @endphp
                    @else
                    @php
                    $query = App\Models\Document::query();
                    $doc =   $query->where(function ($q) {
                            $q->where('documents.branch_id', auth()->user()->entity_id)
                            ->orWhere('documents.entity_id', auth()->user()->entity_id);
                        });

                    echo $doc->count(); @endphp
                    @endif
                </div>
              </div>
            </a>
          </div>
        @endcan

            @can('الجهات')
              <div class="col-sm-6 col-md-3">
                <a href="{{ route('entities.index') }}">
                  <div class="box-info green">
                    <i class="fas fa-building-flag bg-icon"></i>
                    <div class="text">الجهات</div>
                    <div class="num">
                      {{  App\Models\Entitie::count(); }}
                    </div>
                  </div>
                </a>
              </div>
            @endcan

        @can('إدارة المسؤولين')
           <div class="col-sm-6 col-md-3">
            <a href="{{ route('users.index') }}">
              <div class="box-info red">
                <i class="fa-solid fa-users-gear bg-icon"></i>
                <div class="text">المستخدمين</div>
                <div class="num">{{ App\Models\User::count() }}</div>
              </div>
            </a>
          </div>
        @endcan
        </div>
      </div>
    </section>
    <!-- End Section -->
@endsection
