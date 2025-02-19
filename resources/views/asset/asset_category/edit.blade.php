@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Edit Asset
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Assets</li>
                        <li class="breadcrumb-item"> <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                            <script>
                              function goBack() {
                                window.history.back();
                              }
                            </script></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

        <div class="tab-pane ml-3" id="bank" role="tabpanel" style="width:50%">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('asset.update', $asset->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label> Category Type</label>
                            <select name="category_type" class="form-control custom-select" required>
                                <option>Select category</option>
                                <option value="ASSETS" {{ $asset->category_type === 'ASSETS' ? 'Selected' : '' }}>Assets
                                </option>
                                <option value="LOGISTIC" {{ $asset->category_type === 'LOGISTIC' ? 'Selected' : '' }}>
                                    Logistice</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Category Name</label>
                            <input type="text" name="category_name" value="{{ $asset->category_name }}"
                                class="form-control form-control-line" placeholder="Bank Name" minlength="5" required>
                        </div>


                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i>update </button>
                </div>
                <?= csrf_field() ?>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
